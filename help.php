<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);

// C

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/GeneralStyle.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/buy.css" />
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

<?php include_once "./view/Header.php"; ?>

<main style="height: fit-content">
    <section class="help-section">
        <h2 class="help-heading">Categories</h2>
        <ul class="help-categories">
            <li class="help-category">
                <h3 class="help-category-title">Getting Started</h3>
                <p class="help-category-description">
                    Learn the basics of using our home gardening site and get
                    started on your gardening journey.
                </p>
            </li>
            <li class="help-category">
                <h3 class="help-category-title">Plant Care</h3>
                <p class="help-category-description">
                    Discover tips and techniques for caring for your plants to
                    ensure their health and growth.
                </p>
            </li>
            <li class="help-category">
                <h3 class="help-category-title">Gardening Tools</h3>
                <p class="help-category-description">
                    Explore the essential gardening tools you'll need to
                    maintain your garden and achieve successful results.
                </p>
            </li>
        </ul>
    </section>

    <section class="help-section">
        <h2 class="help-heading">Instructions</h2>
        <ul class="help-instructions">
            <li class="help-instruction">
                <h3 class="help-instruction-title">1. Creating an Account</h3>
                <p class="help-instruction-description">
                    To access all features of our home gardening site, create
                    an account by clicking on the "Sign Up" button and filling
                    out the required information.
                </p>
            </li>
            <li class="help-instruction">
                <h3 class="help-instruction-title">2. Browsing Plants</h3>
                <p class="help-instruction-description">
                    Use the navigation menu or search bar to browse and explore
                    various plants available on our site. Click on a plant to
                    view detailed information, pricing, and more.
                </p>
            </li>
            <li class="help-instruction">
                <h3 class="help-instruction-title">3. Placing an Order</h3>
                <p class="help-instruction-description">
                    Once you've found the desired plant, add it to your cart
                    and proceed to checkout. Provide the necessary details and
                    complete the payment process to place your order.
                </p>
            </li>
        </ul>
    </section>




</main>

<?php
include_once './view/Footer.php';
?>

</body>

</html>
