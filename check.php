<?php
session_start();

$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require_once 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if ($validationResult == 0) {
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/GeneralStyle.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/buy.css"/>

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
    <h2>My Flowers</h2>
    <section class="flowers">
        <?php include_once "php/checkFunc.php" ?>

    </section>
    <section>
        <script>
            function setFlowerImages() {
                let nameInput = document.getElementById("name");
                let flowerImagesInput = document.getElementById("flower_images");
                flowerImagesInput.value = nameInput.value;

                // Create a new XMLHttpRequest object
                let xhr = new XMLHttpRequest();

                // Define the API endpoint URL
                let apiUrl = 'http://localhost/flowersEP.php/flowers/add';

                // Create the request body data
                let requestBody = {
                    name: nameInput.value,
                    description: document.getElementById("description").value,
                    price: document.getElementById("price").value,
                    available_quantity: document.getElementById("available_quantity").value,
                    difficulty: document.getElementById("difficulty").value
                };

                // Set up the request
                xhr.open("POST", apiUrl, true);
                xhr.setRequestHeader("Content-Type", "application/json");

                // Send the request
                xhr.send(JSON.stringify(requestBody));

                // Handle the response
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Request was successful
                        let response = JSON.parse(xhr.responseText);
                        console.log(response);
                        alert("Flower added successfully");
                    } else {
                        // Request failed
                        alert("Failed to add flower: " + xhr.responseText);
                    }
                };
            }
        </script>
        <form id="add-flowers">
            <h2>Add Flower</h2>
            <label for="name">Name:</label>
            <select id="name" name="name" required>
                <option value="rose">Rose</option>
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

            <label for="userId"></label>
            <input style="display: none;" name="userId" id="userId" value="<?php echo $userId ?>">

            <label for="flower_images"></label>
            <input type="text" id="flower_images" name="flower_images" style="display: none;">

            <input type="submit" value="Add Flower" onclick="setFlowerImages();">
        </form>
    </section>
</main>

<?php
include_once './view/Footer.php';
?>
</body>
</html>
