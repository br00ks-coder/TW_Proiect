<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['extract-button'])) {
    $flowerId = $_POST['flower'];
    $userId = $_POST['userId'];

    // Get flower details from flowers_humidity table
    $query = "SELECT * FROM flowers_humidity WHERE name = $1 AND user_id = $userId";
    $result = pg_query_params($dbconn, $query, array($flowerId));
    $row = pg_fetch_assoc($result);

    // Insert row into my_flowers table
    $insertQuery = "INSERT INTO my_flowers (name, description, price, available_quantity, difficulty, flower_images, user_id)
                    VALUES ($1, $2, $3, $4, $5, $6, $7)";
    $insertParams = array(
        $flowerId,
        $row['description'],
        $row['price'],
        $row['available_quantity'],
        $row['difficulty'],
        $row['flower_images'],
        $userId
    );
    $insertResult = pg_query_params($dbconn, $insertQuery, $insertParams);

    if (!$insertResult) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    // Delete row from flowers_humidity table
    $deleteQuery = "DELETE FROM flowers_humidity WHERE name = $1 AND user_id = $2";
    $deleteResult = pg_query_params($dbconn, $deleteQuery, array($flowerId, $userId));


    if (!$deleteResult) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    // Redirect to the desired page after extraction
    header("Location: ../humidify.php");
}

pg_close($dbconn);
?>
