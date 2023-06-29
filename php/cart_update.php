<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
require_once 'jwtVerify.php';
// Retrieve the JSON data from the request body
$jsonData = file_get_contents('php://input');
$cartData = json_decode($jsonData, true);

// Get the user ID from the token (assuming the token is passed as 'token' in the JSON data)
$token = $cartData['token'];
$secretKey = 'your-secret-key'; // Replace with your own secret key

// Get the user ID from the cookie
$userId = getUserFromJwt($token,$secretKey)['user_id']; // Replace getUserFromJwt with your actual function to extract the user ID

// Get the cart items
$cartItems = $cartData['cartItems'];

// Update the quantity of each item in the cart in the database
foreach ($cartItems as $item) {
    $productName = $item['name'];
    $quantity = $item['quantity'];

    // Update the item in the database using prepared statements
    $query = "UPDATE shopping_cart SET quantity = $1
              WHERE product_name = $2 AND user_id = $3";
    $result = pg_query_params($dbconn, $query, array($quantity, $productName, $userId));

    if (!$result) {
        // Failed to update item in the database
        echo 'Error updating item: ' . pg_last_error($dbconn);
        exit;
    }
}

// Close the database connection
pg_close($dbconn);

// Return a response if needed
echo 'Cart items updated successfully!';

