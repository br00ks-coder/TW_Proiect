<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);

if($validationResult==0)
{
    header("Location: index.php");
}



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
    <h2>Planted Flowers</h2>
    <section class="flowers">
        <?php include_once "php/humFunc.php"            ?>
    </section>

    <script>
        function setFlowerImages() {
            var nameInput = document.getElementById("name");
            var flowerImagesInput = document.getElementById("flower_images");
            flowerImagesInput.value = nameInput.value;
        }
    </script>

    <form id="add-flowers" method="POST" action="php/addOwnFlower.php">
        <h2>Add Flower</h2>
        <label for="name">Name:</label>
        <select id="name" name="name" required>
            <option value="rosee">Rose</option>
            <option value="tulip">Tulip</option>
            <option value="lily">Lily</option>
            <option value="orchid">Orchid</option>
            <option value="daisy">Daisy</option>
            <option value="carnation">Carnation</option>
            <option value="daffodil">Daffodil</option>
            <option value="hydrangea">Hydrangea</option>
            <option value="peony">Peony</option>
        </select>


    <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="available_quantity">Available Quantity:</label>
        <input type="number" id="available_quantity" name="available_quantity" required>

        <label for="difficulty">Difficulty:</label>
        <select id="difficulty" name="difficulty" required>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>

        <label for="humidity">Humidity:</label>
        <input type="number" id="humidity" name="humidity" required>

        <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
<br>
        <input type="text" id="flower_images" name="flower_images" style="display: none;">
        <input type="submit" value="Add Flower" onclick="setFlowerImages()">

    </form>
</main>

<?php include_once './view/Footer.php'; ?>

</body>

</html>
