<?php
session_start();

// Check if the session is active and the user is authenticated
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require_once 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/help.css" />
    <script src="https://kit.fontawesome.com/fb7068e0f1.js" crossorigin="anonymous"></script>
    <!--used for icons-->
    <title>Web Gardening</title>
</head>

<body>
<!-- Image for background -->
<div id="background"
    style ="
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: fixed;
    background-image: url('resources/help.jpg');
    background-size: cover;
    filter: blur(4px);
    z-index: -1;
    ">
</div>
<!-- Declared here to load as fast as possible -->

<?php include_once "./view/Header.php"; ?>

<main>
    <section class="help-section">
        <h2 class="help-heading">Instructions</h2>
        <ul class="help-instructions">
            <li class="help-instruction">
                <h3 class="help-instruction-title"> Creating an Account</h3>
                <p>
                    To access all features of our home gardening site, create
                    an account by clicking on the "Register" button and filling
                    out the required information.
                </p>
            </li>
            <li class="help-instruction">
                <h3 class="help-instruction-title"> Browsing Plants</h3>
                <p>
                    Use the Buy Flowers page in order to check all the flowers
                    that are on sale, or create an account and hold your own harvest.
                </p>
            </li>
            <li class="help-instruction">
                <h3 class="help-instruction-title"> Placing an Order</h3>
                <p>
                    Once you've found the desired plant, add it to your cart
                    and proceed to checkout. Provide the necessary details and
                    complete the payment process to place your order.
                </p>
            </li>
        </ul>
    </section>

    <section class="help-section">
        <h2 class="help-heading">Categories</h2>
        <ul class="help-categories">
            <li class="help-category">
                <h3 class="help-category-title">Getting Started</h3>
                <p>
                    Learn the basics of using our home gardening site and get
                    started on your gardening journey.
                </p>
            </li>
            <li class="help-category">
                <h3 class="help-category-title">Plant Care</h3>
                <p>
                    Discover tips and techniques for caring for your plants to
                    ensure their health and growth.
                </p>
            </li>
            <li class="help-category">
                <h3 class="help-category-title">Gardening Tools</h3>
                <p>
                    Explore the essential gardening tools you'll need to
                    maintain your garden and achieve successful results.
                </p>
            </li>
        </ul>
    </section>
</main>

<?php include_once './view/Footer.php'; ?>
</body>
</html>
