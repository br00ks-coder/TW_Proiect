<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if($validationResult)
{
    header("Location: profile.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/GeneralStyle.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/help.css" />

    <script
      src="https://kit.fontawesome.com/fb7068e0f1.js"
      crossorigin="anonymous"
    ></script>
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
  ?>

<main style="height: fit-content; margin-top: 10%;">
    <script>
        function showForgotPasswordForm(event) {
            event.preventDefault();
            var forgotPasswordForm = document.getElementById("forgot-password");
            if (forgotPasswordForm.style.display === "block") {
                forgotPasswordForm.style.display = "none";
            } else {
                forgotPasswordForm.style.display = "block";
            }
        }
    </script>
    <style>
        #reset-password-button {
            display: inline-block;
            padding: 0;
            margin: 0;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
    <style>
        .form-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: flex-end;
            flex-direction: column;
        }
    </style>
    <div class="form-container">
    <form method="POST" action="php/loginFunc.php">
        <h2>Member login</h2>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Login</button>
        <button id="reset-password-button" onclick="showForgotPasswordForm(event)">Forgot Password?</button>

        <div id="message" style="z-index: 2;"></div>
    </form>

    <div >
        <form id="forgot-password" style="display: none;" method="POST" action="php/resetPassword.php">
            <h2>Reset Password</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <button type="submit" >Reset</button>
        </form>
    </div>
    </div>



</main>

  <?php
  include_once './view/Footer.php';
  ?>

  </body>

</html>
