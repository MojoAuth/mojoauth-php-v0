<?php
require_once(__DIR__ . "/config.php");
if (!isset($_SESSION["mj_user_profile"]) || empty($_SESSION["mj_user_profile"])) {
    header("Location: index.php");
} else if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header("Location: index.php");
} else {
    echo '<pre>';
    var_dump(json_decode($_SESSION["mj_user_profile"]));
    echo '</pre>';
    ?><button id="logout">Logout</button>
    <script>
        document.getElementById('logout').addEventListener('click', function () {
            window.location.href = window.location.href+"?logout=true";
        });
    </script>
    <?php
}