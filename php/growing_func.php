<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key';
// Retrieve the JWT token from the request


// Call the function to get the user ID from the JWT
$clientId = getUserFromJwt($jwtToken, $secretKey)['user_id'];

// Call the function to get the user ID from the JWT


$query = "SELECT * from flowers_humidity";
$result = pg_query($dbconn, $query);

while ($row = pg_fetch_assoc($result)) {
    $flowerName = $row['name'];
    $flowerAvailableQ = $row['available_quantity'];
    $flowerImg = $row['flower_images'];
    $flowerHumidity = $row['humidity'];
    $flowerId = $row['id'];
    $flowerDesc= $row['description'];
    $flowerPrice=$row['price'];
    $flowerDiff=$row['difficulty'];
    $sellerId=$row['user_id'];


    echo '<div class="flower">';
    echo '<h3>' . $flowerName . '</h3>';
    echo '<p>Description: ' . $flowerDesc . '</p>';
    echo '<p>Price: ' . $flowerPrice . '</p>';
    echo '<p>Difficulty to Maintain: ' . $flowerDiff . '</p>';
    echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
    echo '<p>Humidity: ' . $flowerHumidity . '</p>';
    echo '<img class="flower-image" src="' . $flowerImg . '.jpg">';

// Check if the flower is already followed
    $checkQuery = "SELECT * FROM follow WHERE client_id = $clientId AND seller_id = $sellerId AND flower_name = '$flowerName'";
    $checkResult = pg_query($dbconn, $checkQuery);

    if (pg_num_rows($checkResult) > 0) {
        // Flower is already followed
        echo '<button id="heart-button" onclick="followFlower(' . $clientId . ', ' . $sellerId . ', \'' . $flowerName . '\')">Watching</button>';
    } else {
        // Flower is not followed
        echo '<button id="heart-button" onclick="followFlower(' . $clientId . ', ' . $sellerId . ', \'' . $flowerName . '\')">Follow</button>';
    }

    echo '</div>';


}



