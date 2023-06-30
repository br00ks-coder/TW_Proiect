<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key';
// Retrieve the JWT token from the request


// Call the function to get the user ID from the JWT
$userId = getUserFromJwt($jwtToken, $secretKey)['user_id']; // Replace $secretKey with your actual secret key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $flowerId = $_POST['flower'];

        // Actualizează umiditatea la 100% pentru floarea selectată
        $updateQuery = "UPDATE flowers_humidity SET humidity = 100 WHERE id = $flowerId AND user_id=$userId";
        pg_query($dbconn, $updateQuery);

}


$query = "SELECT * from flowers_humidity where user_id=$userId";
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



    echo '<div class="flower">';
    echo '<h3>' . $flowerName . '</h3>';
    echo '<p>Description: ' . $flowerDesc . '</p>';
    echo '<p>Price: ' . $flowerPrice . '</p>';
    echo '<p>Difficulty to Maintain: ' . $flowerDiff . '</p>';
    echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
    echo '<p>Humidity: ' . $flowerHumidity . '</p>';
    echo '<img class="flower-image" src="' . $flowerImg . '.jpg">';
    echo '<form id="humForm" method="POST">
          <input type="hidden" name="flower" value="'. $flowerId .'">  
          <button id="water-button" type="submit" name="flower-button">Water Flowers</button>
    </form>';

    echo '<form id="extractForm" method="POST" action="php/extract.php">
          <input type="hidden" name="flower" value="'. $flowerName .'">
          <input type="hidden" name="userId" value="'. $userId .'">
          <button type="submit" name="extract-button">Extract Plant</button>
    </form>';

    echo '</div>';

}
?>
