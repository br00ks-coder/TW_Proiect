<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availableQuantity = $_POST['available_quantity'];
    $difficulty = $_POST['difficulty'];
    $flowerImages = $_POST['flower_images'];
    $userId = $_POST['userId']; // Assuming you have the user ID stored in the session

    // Insert flower details into the database
    $query = "INSERT INTO my_flowers (name, description, price, available_quantity, difficulty, flower_images, user_id)
              VALUES ($1, $2, $3, $4, $5, $6, $7)";
    $params = array($name, $description, $price, $availableQuantity, $difficulty, $flowerImages, $userId);
    $result = pg_query_params($dbconn, $query, $params);

    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    // Redirect to a success page or perform any other desired actions
    header("Location: ../check.php");
}

pg_close($dbconn);
?>
