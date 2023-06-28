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
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/GeneralStyle.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="login.js"></script>
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

    <div class="about-us">
        <h2>About Us</h2>
        <p>
            We are passionate about helping you create your very own green paradise right at home. Whether you're an
            experienced gardener or just starting out, our goal is to provide you with the knowledge, inspiration, and
            tools you need to nurture beautiful plants and create stunning outdoor spaces.
            <br>
            With years of experience in the gardening industry, our team of experts is dedicated to sharing their
            expertise and helping you unleash your gardening potential. We understand that gardening is more than just a
            hobby—it's a way to connect with nature, find solace in the beauty of plants, and create a harmonious
            environment.
        </p>
    </div>
    <div class="flower-div" style="z-index: 2;">
    </div>


</main>

<?php
include_once './view/Footer.php';
?>

</body>

</html>
