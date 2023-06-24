<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);

$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if (isset($_POST['water_flowers'])) {
    // Perform the update query to change the humidity to 100%
    $updateQuery = "UPDATE flowers_humidity SET humidity = 100";
    pg_query($dbconn, $updateQuery);
}

$query = "select flowers.name, flowers.available_quantity, flowers.flowers_images, flowers_humidity.humidity from flowers join flowers_humidity on flowers.id = flowers_humidity.id;";
$result = pg_query($dbconn, $query);
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
    <h2>Featured Flowers</h2>
    <section class="flowers">
        <?php
        while ($row = pg_fetch_assoc($result)) {
            $flowerName = $row['name'];
            $flowerAvailableQ = $row['available_quantity'];
            $flowerImg = $row['flower_images'];
            $flowerHumidity = $row['humidity'];

            echo '<div class="flower">';
            echo '<h3>' . $flowerName . '</h3>';
            echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
            echo '<p>Humidity: ' . $flowerHumidity . '</p>';

            echo '<img class="flower-image" src="' . $flowerImg . '.jpg" >';
            echo '</div>';
        }
        ?>
    </section>

    <div>
        <form method="POST">
            <button type="submit" name="water_flowers">Water Flowers</button>
        </form>
    </div>


</main>

<?php
include_once './view/Footer.php';
?>

</body>

</html>
