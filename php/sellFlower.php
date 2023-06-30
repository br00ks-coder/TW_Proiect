<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
// Handle connection error
die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$flowerName = $_POST['flowerName'];
$flowerPrice = $_POST['flowerPrice'];
$userId = $_POST['userId'];
$description = $_POST['description'];
$availableQuantity = $_POST['availableQuantity'];
$difficulty = $_POST['difficulty'];
$flowerImages = $_POST['flowerImages'];

$query = "INSERT INTO flowers (name, price, user_id, description, available_quantity, difficulty, flower_images)
VALUES ($1, $2, $3, $4, $5, $6, $7)";
$params = array($flowerName, $flowerPrice, $userId, $description, $availableQuantity, $difficulty, $flowerImages);
$result = pg_query_params($dbconn, $query, $params);
    $query = "DELETE FROM my_flowers WHERE name = $1 AND user_id = $2";
    $params = array($flowerName, $userId);
    $result = pg_query_params($dbconn, $query, $params);
if (!$result) {
// Handle query error
die("Query failed: " . pg_last_error());
}

// Success message or redirection
echo "Flower successfully added!";
// You can redirect to a success page if desired
// header("Location: success.php");
}

pg_close($dbconn);
