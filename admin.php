<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if (!$validationResult) {
    header("Location: login.php");
}
// C
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}
include('php/flowers_admin.php');
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/GeneralStyle.css"/>
    <link rel="stylesheet" href="css/admin.css"/>

    <script
            src="https://kit.fontawesome.com/fb7068e0f1.js"
            crossorigin="anonymous"
    ></script>
    <!--used for icons-->
    <title>Web Gardening</title>
</head>

<body>
<!-- Image for background -->

<!-- Declared here to load as fast as possible -->

<nav class="nav_bar">
    <ul class="login_list">
        <!-- HTML code -->
        <a href="php/logout.php">
            <li class="logout">Log out</li>
        </a>


    </ul>
</nav>
<?php
include_once './view/Header.php';
?>

<main id="main">


    <section>
        <h2>USERS:</h2>
        <div id="user-container">
            <!-- User data will be loaded dynamically here -->
        </div>

    </section>

    <section>
        <h2>FLOWER ADMINISTRATION:</h2>

        <?php
        // Display the generated <div> elements
        generateDivs($flowers);
        ?>


    </section>


    <section>
        <h2>Add Flower</h2>
        <form method="post" action="">
            <label for="flowerName">Flower Name:</label>
            <input type="text" id="flowerName" name="flowerName" required>

            <label for="availableQuantity">Available Quantity:</label>
            <input type="number" id="availableQuantity" name="availableQuantity" required>

            <label for="priceAdd">Price:</label>
            <input type="number" id="priceAdd" name="priceAdd" required>
            <br>
            <label for="description">Description:</label>
            <input type="text" id="decription" name="description" required>

            <label for="difficulty">Difficulty:</label>
            <input type="text" id="difficulty" name="difficulty" required>
            <br>
            <input type="submit" name="add" value="Add Flower">
        </form>

        <br>
        <h2>EXPORT DB:</h2>

        <form id="export-json" action="php/export.php" method="POST">
            <button type="submit" name="export">Export Database</button>
        </form>
    </section>

    <script src="js/admin.js"></script>


</main>

<?php
include_once './view/Footer.php';
?>

</body>

</html>
