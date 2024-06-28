<?php

require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../src/mojoAuthAPI.php");
if (isset($_POST['access_token']) && !empty($_POST['access_token'])) {
    $access_token = $_POST['access_token'];

    // mojoauth apikey replace at "MOJOAUTH_APIKEY"
    $mojoAuth = new mojoAuthAPI(MOJOAUTH_APIKEY);

    //Step 1 Get Public Key / Certificate from MojoAuth Server

    $result = $mojoAuth->getPublicKey();
    $publicKey = json_decode($result['response']);
    if (isset($publicKey->data) && !empty($publicKey->data)) {
        //Step 2 Pass JWT token and publickey to verify user
        $userProfileData = $mojoAuth->getUserProfileData($access_token, $publicKey->data);
        if (isset($userProfileData->identifier) && !empty($userProfileData->identifier)) {
            $_SESSION["mj_user_profile"] = json_encode($userProfileData);
            echo json_encode(array('status' => 'success', 'message' => 'login success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'an error occurred.'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Mojoauth APIKey unable to get publicKey.'));
    }
} else if (isset($_GET['state_id']) && !empty($_GET['state_id'])) {
    $state_id = $_GET['state_id'];

    // mojoauth apikey replace at "MOJOAUTH_APIKEY"
    $mojoAuth = new mojoAuthAPI(MOJOAUTH_APIKEY);
    $response = $mojoAuth->checkLoginStatus($state_id);
    $userProfileData = json_decode($response['response']);
    if (isset($userProfileData->user->identifier) && !empty($userProfileData->user->identifier)) {
        $_SESSION["mj_user_profile"] = json_encode($userProfileData->user);
        echo json_encode(array('status' => 'success', 'message' => 'login success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'an error occurred.'));
    }
    header("Location: " . MOJOAUTH_REDIRECTION_URL);
} else {
    header("Location: index.php");
}