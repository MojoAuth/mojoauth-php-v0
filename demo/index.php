<?php
require_once(__DIR__ . "/config.php");
if (isset($_SESSION["mj_user_profile"]) && !empty($_SESSION["mj_user_profile"])) {
    header("Location: ".MOJOAUTH_REDIRECTION_URL);
} else {
    ?>
    <html>
        <head>
            <script
                src="https://cdn.mojoauth.com/js/mojoauth.min.js"
                type="text/javascript"
            ></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        </head>
        <body>
            <div id="mojoauth-passwordless-form"></div>
            <script>
                const mojoauth = new MojoAuth("<?php echo MOJOAUTH_APIKEY ?>", {
					language: "<?php echo MOJOAUTH_LANG ?>",
					redirect_url: "<?php echo MOJOAUTH_TOKEN_HANDLER ?>",
                    source: [{type: "email", feature: "magiclink"}, {type: "phone", feature: "otp"}],
                })
                mojoauth.signIn().then((response) => {
                    if (response.authenticated == true) {
                        postTokenAtServer(response.oauth.access_token, function (data) {
                            if (data.status = "success") {
                                window.location.href = "<?php echo MOJOAUTH_REDIRECTION_URL ?>";
                            } else {
                                $('body').html(data.message);
                            }
                        });
                    }
                });
                function postTokenAtServer(access_token, callback) {
                    $.post("tokenhandler.php", {
                        access_token: access_token
                    },
                            function (data, status) {
                                callback(data);
                            });
                }
            </script>
        </body>
    </html>
    <?php
}