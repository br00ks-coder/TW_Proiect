<?php
session_start();

// Check if the session is active and the user is authenticated
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require_once 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);

if (!$validationResult) {
    header("Location: login.php");
}

$userId = getUserFromJwt($jwtToken, $secretKey)['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/GeneralStyle.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="https://kit.fontawesome.com/fb7068e0f1.js" crossorigin="anonymous"></script>
    <!--used for icons-->
    <title>Web Gardening</title>
</head>

<body>
<!-- Image for background -->
<div id="background"
     style="
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: fixed;
    background-image: url('resources/background_lavender.jpeg');
    background-size: cover;
    filter: blur(4px);
    z-index: -1;
    ">
    >
</div>
<!-- Declared here to load as fast as possible -->
<?php
include_once './view/Header.php';
require_once 'php/2fa.php';

?>

<main class="mainProfile" style="display: flex;margin-top: 10%;">

    <section>
        <form id="profileForm" action="php/profileFunc.php" method="POST" style="left: 50%;">
            <label for="username">Username: <span id="username">
                    <?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?>
                </span></label>

            <br>

            <input type="hidden" name="username"
                   value="<?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?>">
            <label for="oldPwd">Current password:</label>

            <br>

            <input type="password" id="oldPwd" name="oldPwd" placeholder="current password"><br><br>
            <label for="newPwd">New Password:</label>

            <br>

            <input type="password" id="newPwd" name="newPwd" placeholder="new password"><br><br>
            <label for="newPwdCon">Confirm new password:</label>

            <br>

            <input type="password" id="newPwdCon" name="newPwdCon" placeholder="confirm password"><br><br>
            <button id="changePwdBtn" type="submit">Change Password</button>

            <?php if (getUserFromJwt($jwtToken, $secretKey)['username'] == 'admin'): ?>
                <a href="admin.php">
                    <i class="fa-solid fa-screwdriver-wrench" style="display: inline-block; padding-top: 100%;"></i>
                </a>
            <?php endif; ?>
        </form>
    </section>

    <section>
        <form method="POST" action="php/2fa.php">
            <input type="hidden" name="userid" value="<?php echo getUserFromJwt($jwtToken, $secretKey)['user_id']; ?>">

            <label for="enable-2fa">Enable Two-Factor Authentication:</label>
            <input type="checkbox" id="enable-2fa"
                   name="enable-2fa" <?php echo userChecked($userId) ? 'checked' : ''; ?>>

            <button type="submit">Submit</button>
            <?php if (userCheckedDiv($userId) == 'true') : ?>
                <div style="margin-right: 0;">
                    <p>Secret Key:</p>
                    <?php echo getSecretKey($userId); ?>
                </div>
            <?php endif; ?>
        </form>
    </section>
</main>
<?php
include_once './view/Footer.php';
?>

<script>
    document.getElementById("changePwdBtn").addEventListener("click", function () {
        const username = "<?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?>";
        const oldPwd = document.getElementById("oldPwd").value;
        const newPwd = document.getElementById("newPwd").value;
        const newPwdCon = document.getElementById("newPwdCon").value;

        // Create an XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open("POST", "php/profileFunc.php", true);

        // Set the response type
        xhr.responseType = "json";

        // Set up the event handler for the AJAX response
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Successful response
                let response = xhr.response;
                // Handle the response as needed
                console.log(response);
            } else {
                // Error handling
                console.error("Request failed. Status: " + xhr.status);
            }
        };

        // Create the request payload
        let payload = {
            username: username,
            oldPwd: oldPwd,
            newPwd: newPwd,
            newPwdCon: newPwdCon
        };

        // Convert the payload to JSON
        let payloadJson = JSON.stringify(payload);

        // Set the appropriate request headers
        xhr.setRequestHeader("Content-Type", "application/json");

        // Send the request with the payload
        xhr.send(payloadJson);
    });
</script>
</body>


</html>

