<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
require_once 'jwtVerify.php';
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key';
// Retrieve the JWT token from the request


// Call the function to get the user ID from the JWT
$userId = getUserFromJwt($jwtToken, $secretKey)['user_id']; // Replace $secretKey with your actual secret key

if ($userId === null) {
    // Handle invalid or expired JWT
    // Return an error response or perform appropriate actions
}

// Fetch the cart items from the database
$query = "SELECT * from follow where client_id = $userId ";
$result = pg_query($dbconn, $query);

$cartItems = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $cartItems[] = array(
            'name' => $row['flower_name'],
        );
    }
}

// Prepare the response
$response = array(
    'items' => $cartItems,
);

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

pg_close($dbconn);
?>
