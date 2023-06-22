<?php
// Start the session
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

$query = "SELECT * FROM flowers";
$result = pg_query($dbconn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content goes here -->
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
<!-- Body content goes here -->

<?php include_once "./view/Header.php"; ?>

<main style="height: fit-content">
    <h2>Featured Flowers</h2>
    <section class="flowers">
        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        while ($row = pg_fetch_assoc($result)) {
            $flowerName = $row['name'];
            $flowerAvailableQ = $row['available_quantity'];
            $flowerImg = $row['flower_images'];

            echo '<div class="flower">';
            echo '<h3>' . $flowerName . '</h3>';
            echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
            echo '<img class="flower-image" src="' . $flowerImg . '.jpg">';
            echo '</div>';
        }
        ?>
    </section>
</main>

<?php include_once './view/Footer.php'; ?>

</body>

</html>
