<?php
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key';
// Retrieve the JWT token from the request


// Call the function to get the user ID from the JWT
$userId = getUserFromJwt($jwtToken, $secretKey)['user_id']; // Replace $secretKey with your actual secret key
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 
dbname=webgardening 
user=postgres 
password=paroladb");

//$query = "SELECT * FROM flowers";
//$result = pg_query($dbconn, $query);
//while ($row = pg_fetch_assoc($result)) {
//    $flowerName = $row['name'];
//    $flowerPrice = $row['price'];
//    $flowerDesc = $row['description'];
//    $flowerDiff = $row['difficulty'];
//    $flowerAvailableQ = $row['available_quantity'];
//    $flowerImg = $row['flower_images'];
//    $sellerId = $row['user_id'];

$apiUrl = 'http://localhost/flowersEP.php/flowers/list';

// Make a GET request to the API
$response = file_get_contents($apiUrl);
$responseData = json_decode($response, true);

if (isset($responseData['error'])) {
    echo '<p>An error occurred: ' . $responseData['error'] . '</p>';
} else {
    $flowers = $responseData;
    if (count($flowers) > 0) {

        foreach ($flowers as $flower) {
            echo '<div class="flower">';
            echo '<h3>' . $flower['name'] . '</h3>';
            echo '<p>Description: '  . $flower['description'] . '</p>';
            echo '<p>Price: ' . $flower['price'] . '</p>';
            echo '<p>Available Quantity: ' . $flower['available_quantity'] . '</p>';
            echo '<p>Difficulty to Maintain: ' . $flower['difficulty'] . '</p>';
//            echo '<button type = "button" onclick="addToCart(\'' . $flower['name'] . '\', ' . $flowerPrice . ', ' . $userId . ', ' . $sellerId . ')">Buy</button>';
            echo ' <script src="/js/cart.js"></script>';
            echo '</div>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No flowers found.</p>';
    }
}
//
//    echo '<div class="flower">';
//    echo '<h3>' . $flowerName . '</h3>';
//    echo '<p>Description: ' . $flowerDesc . '</p>';
//    echo '<p>Price: ' . $flowerPrice . '</p>';
//    echo '<p>Difficulty to Maintain: ' . $flowerDiff . '</p>';
//    echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
//
//    echo '<img class="flower-image" src="' . $flowerImg . '.jpg" >';


}


?>


