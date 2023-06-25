<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

// Retrieve the JSON data from the request body
$jsonData = file_get_contents('php://input');
$cartItems = json_decode($jsonData, true);






// Insert each item in the cart into the database

    $productName = $cartItems['name'];
    $productPrice = $cartItems['price'];
    $userId = $cartItems['user_id'];

// Insert the item into the database using prepared statements (recommended for security)
$query = "INSERT INTO shopping_cart (product_name, price, user_id, quantity)
          VALUES ($1, $2, $3, 1)
          ON CONFLICT (product_name, user_id)
          DO UPDATE SET quantity = shopping_cart.quantity + 1";
$result = pg_query_params($dbconn, $query, array($productName, $productPrice, $userId));

if (!$result) {
        // Failed to insert item into the database
        echo 'Error inserting item: ' . pg_last_error($dbconn);
        exit;
    }


// Close the database connection
pg_close($dbconn);

// Return a response if needed
echo 'Cart items inserted successfully!';
?>
