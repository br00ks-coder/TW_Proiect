<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if($validationResult)
{
    header("Location: index.php");
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

<main style="height: 50vh;">



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
        <div class="form-group">
            <label for="2fa">2FA active?</label>
            <input type="checkbox" id="2fa" name="2fa">
        </div>
        <div class="form-group" id="code-container" style="display: none;">
            <label for="code">Enter 6-Digit Code:</label>
            <input type="text" id="code" name="code">
        </div>
        <button type="submit">Login</button>
        <div id="message" style="z-index: 2;"></div>

        <script>
            document.getElementById("2fa").addEventListener("change", function() {
                var codeContainer = document.getElementById("code-container");
                codeContainer.style.display = this.checked ? "block" : "none";
            });
        </script>
    </form>



</main>

  <?php
  include_once './view/Footer.php';
  ?>

  </body>

</html>
