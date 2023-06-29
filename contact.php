<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/GeneralStyle.css" />
    <link rel="stylesheet" href="css/style.css" />

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

<main style="height: 75vh;">

<div class="contact-div">
  <h2>Contact Us</h2>
  <form style="position: relative; left: 1px;" method="post" action="php/process_contact.php" id="">
  <label for="name">Name:</label>
      <input type="text" id="name" name="name" >
      <label for="email">Email:</label>
  <input type="email" id="email" name="email">
  <label for="message">Message:</label>
  <textarea id="message" name="message"></textarea>
  <button type="submit">Send</button>
</form>
</div>



</main>



  <?php
  include_once './view/Footer.php';
  ?>

</body>

</html>
