<?php

use Firebase\JWT\JWT;

class mojoAuthAPI
{
    public $apiurl;
    public $apikey;

    public function __construct($apikey)
    {
        $apiurl = "https://api.mojoauth.com/";
        $this->setApiurl($apiurl);
        $this->setApikey($apikey);
    }
    /**
     * Get API URL
     */
    public function getApiurl()
    {
        return $this->apiurl;
    }
    /**
     * Set API URL
     */
    public function setApiurl($url)
    {
        return $this->apiurl = $url;
    }
    /**
     * Get API key
     */
    public function getApikey()
    {
        return $this->apikey;
    }
    /**
     * Set API key
     */
    public function setApikey($apikey)
    {
        return $this->apikey = $apikey;
    }
    /**
     * Send Link on Email
     */
    public function sendLinkOnEmail($email, $language = "", $redirect_url = "")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        if (!empty($redirect_url)) {
            $query["redirect_url"] = $redirect_url;
        }
        return $this->request("users/magiclink", array(
            "method"     => "POST",
            "query" => $query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("email" => $email)
        ));
    }
    /**
     * resend MagicLink
     */
    public function resendMagicLink($state_id, $language = "", $redirect_url = "")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        if (!empty($redirect_url)) {
            $query["redirect_url"] = $redirect_url;
        }
        return $this->request("users/magiclink/resend", array(
            "method"     => "POST",
            "query" => $query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("state_id" => $state_id)
        ));
    }
    /**
     * Check Login Status
     */
    public function checkLoginStatus($state_id)
    {
        return $this->request("users/status", array(
            "method"     => "GET",
            "query" => array("state_id" => $state_id),
            "headers" => array("X-API-Key" => $this->getApikey())
        ));
    }
    /**
     * Send Email OTP
     */
    public function sendEmailOTP($email, $language = "")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        return $this->request("users/emailotp", array(
            "method"     => "POST",
            "query" => $query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("email" => $email)
        ));
    }
    /**
     * Verify Email OTP
     */
    public function verifyEmailOTP($state_id, $otp)
    {
        return $this->request("users/emailotp/verify", array(
            "method"     => "POST",
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("state_id" => $state_id, "otp" => $otp)
        ));
    }
    /**
     * resend Email OTP
     */
    public function resendEmailOTP($state_id, $language="")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        return $this->request("users/emailotp/resend", array(
            "method"     => "POST",
            "query"=>$query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("state_id" => $state_id)
        ));
    }
    /**
     * Send Phone OTP
     */
    public function sendPhoneOTP($phone, $language = "")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        return $this->request("users/phone", array(
            "method"     => "POST",
            "query" => $query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("phone" => $phone)
        ));
    }
    /**
     * Verify Phone OTP
     */
    public function verifyPhoneOTP($state_id, $otp)
    {
        return $this->request("users/phone/verify", array(
            "method"     => "POST",
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("state_id" => $state_id, "otp" => $otp)
        ));
    }
    /**
     * Resend Phone OTP
     */
    public function resendPhoneOTP($state_id, $language = "")
    {
        $query = [];
        if (!empty($language)) {
            $query["language"] = $language;
        }
        return $this->request("users/phone/resend", array(
            "method"     => "POST",
            "query" => $query,
            "headers" => array(
                "X-API-Key" => $this->getApikey(),
                'Content-Type' => 'application/json; charset=utf-8'
            ),
            "body" => array("state_id" => $state_id)
        ));
    }
    /**
     * Get JWKS
     */
    public function JWKS()
    {
        return $this->request("token/jwks", array(
            "method"     => "GET",
            "headers" => array("X-API-Key" => $this->getApikey())
        ));
    }
    /**
     * Get Public Key / Certificate from MojoAuth Server
     */
    public function getPublicKey()
    {
        return $this->request("token/public_key", array(
            "method"     => "GET",
            "query" => array("api_key" => $this->getApikey())
        ));
    }
    /**
     * Decode UserProfile From AccessToken
     */
    public function getUserProfileData($access_token, $publicKey)
    {
        return JWT::decode($access_token, $publicKey, array('RS256'));
    }
    /**
     * build QueryString from Array in request
     */
    private function buildQueryString($query)
    {
        $query_array = array();
        foreach ($query as $key => $key_value) {
            $query_array[] = urlencode($key) . '=' . urlencode($key_value);
        }
        return (count($query_array) > 0) ? '?' . implode('&', $query_array) : '';
    }
    /**
     * parser function to get formatted headers (with response code) while using fsockopenApiMethod
     */

    private function parseHeaders($headers)
    {
        $head = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1]))
                $head[trim($t[0])] = trim($t[1]);
            else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out))
                    $head['response_code'] = intval($out[1]);
            }
        }
        return $head;
    }
    /**
     * http request from cURL and FSOCKOPEN
     */
    public function request($endPointPath, $args = array())
    {
        if (in_array('curl', get_loaded_extensions())) {
            $response = $this->curlRequest($endPointPath, $args);
        } elseif (ini_get('allow_url_fopen')) {
            $response = $this->fsockopenRequest($endPointPath, $args);
        } else {
            $response = array("status_code" => 500, "message" => 'cURL or FSOCKOPEN is not enabled, enable cURL or FSOCKOPEN to get response from mojoAuth API.');
        }
        return $response;
    }
    /**
     * http request from FSOCKOPEN
     */
    private function fsockopenRequest($endPointPath, $options)
    {
        $method = isset($options['method']) ? strtoupper($options['method']) : 'GET';
        $data = isset($options['body']) ? json_encode($options['body']) : array();
        $query = isset($options['query']) ? $options['query'] : array();

        $optionsArray = array(
            'http' =>
            array(
                'method' => strtoupper($method),
                'timeout' => 50,
                'ignore_errors' => true
            ),
            "ssl" => array(
                "verify_peer" => false
            )
        );
        if (!empty($data) || $data === true) {
            $optionsArray['http']['content'] = $data;
        }

        foreach ($options['headers'] as $k => $val) {
            $optionsArray['http']['header'] .= "\r\n" . $k . ":" . $val;
        }

        $context = stream_context_create($optionsArray);
        $jsonResponse['response'] = file_get_contents($this->getApiurl() . $endPointPath . $this->buildQueryString($query), false, $context);
        $parseHeaders = $this->parseHeaders($http_response_header);
        if (isset($parseHeaders['Content-Encoding']) && $parseHeaders['Content-Encoding'] == 'gzip') {
            $jsonResponse['response'] = gzdecode($jsonResponse['response']);
        }
        $jsonResponse['status_code'] = $parseHeaders['response_code'];

        return $jsonResponse;
    }
    /**
     * http request from cURL
     */
    private function curlRequest($endPointPath, $options)
    {
        $method = isset($options['method']) ? strtoupper($options['method']) : 'GET';
        $data = isset($options['body']) ? json_encode($options['body']) : array();
        $query = isset($options['query']) ? $options['query'] : array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getApiurl() . $endPointPath . $this->buildQueryString($query));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $headerArray = array();
        if (isset($options['headers']) && !empty($options['headers'])) {
            foreach ($options['headers'] as $k => $val) {
                $headerArray[] = $k . ":" . $val;
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);

        if (in_array($method, array('POST'))) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = array();
        $output['response'] = curl_exec($ch);
        $output['status_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_error($ch)) {
            $output['response'] = curl_error($ch);
        }
        curl_close($ch);

        return $output;
    }
}
