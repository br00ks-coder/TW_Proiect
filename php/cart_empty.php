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
$userId = getUserFromJwt($token, $secretKey)['user_id']; // Replace getUserFromJwt with your actual function to extract the user ID

// Delete all rows in the cart for the user ID
$query = "DELETE FROM shopping_cart WHERE user_id = $1";
$result = pg_query_params($dbconn, $query, array($userId));

if (!$result) {
    // Failed to delete rows from the cart
    echo 'Error deleting cart items: ' . pg_last_error($dbconn);
    exit;
}

// Return a response if needed
echo 'Cart emptied successfully!';



// Close the database connection
pg_close($dbconn);

// Return a response if needed
echo 'Cart items updated successfully!';

