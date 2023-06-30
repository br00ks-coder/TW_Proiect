<?php


$host = "webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com";
$dbname = "webgardening";
$username = "postgres";
$password = "paroladb";
$dbconn = pg_connect("host=$host port=5432 dbname=$dbname user=$username password=$password");
require_once 'jwtVerify.php';
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key';
// Retrieve the JWT token from the request

$totalPrice=0;
// Call the function to get the user ID from the JWT
$userId = getUserFromJwt($jwtToken, $secretKey)['user_id']; // Replace $secretKey with your actual secret key
$query = "SELECT product_name,price,user_id,quantity from shopping_cart where user_id = $userId";
$result = pg_query($dbconn, $query);

while ($row = pg_fetch_assoc($result)) {

    $name = $row['product_name'];
    error_log("the name:" . $name);

    $price = $row['price'];
    $quantity = $row['quantity'];

        $query1 = "SELECT flower_images,name FROM flowers WHERE name = '$name'";
    $result1 = pg_query($dbconn, $query1);

    $row1 = pg_fetch_assoc($result1);
    $flowerImages = $row1['flower_images'];






    echo '<div class="flower">';
    echo '<h3>' . $name. '</h3>';
    echo '<p>Quantity: ' . $quantity . '</p>';
    echo '<p>Price: ' . $price . '</p>';
    echo '<p>Total: ' . $quantity*$price. '</p>';
    echo '<img class="flower-image" src="' . $flowerImages . '.jpg" >';
    $totalPrice+=$quantity*$price;
    echo '</div>';
}
?>