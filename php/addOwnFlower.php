<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availableQuantity = $_POST['available_quantity'];
    $difficulty = $_POST['difficulty'];
    $humidity = $_POST['humidity'];
    $flowerImages = $_POST['flower_images'];
    $userId = $_POST['userId'];

    // Connect to the database
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    if (!$dbconn) {
        // Handle connection error
        die("Connection failed: " . pg_last_error());
    }

    // Insert the flower data into the database
    $query = "INSERT INTO flowers_humidity (name, description, price, available_quantity, difficulty, humidity, flower_images, user_id)
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
    $params = array($name, $description, $price, $availableQuantity, $difficulty, $humidity, $flowerImages, $userId);
    $result = pg_query_params($dbconn, $query, $params);

    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    // Close the database connection
    pg_close($dbconn);

    // Redirect to a success page or any other desired action
    header("Location: ../humidify.php");
    exit();
}
?>
