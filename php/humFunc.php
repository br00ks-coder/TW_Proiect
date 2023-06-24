<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if (isset($_POST['water_flowers'])) {
// Perform the update query to change the humidity to 100%
    $updateQuery = "UPDATE flowers_humidity SET humidity = 100";
    pg_query($dbconn, $updateQuery);
}

$query = "select flowers.name, flowers.available_quantity,flowers.flower_images , flowers_humidity.humidity from flowers join flowers_humidity on flowers.id = flowers_humidity.id;";
$result = pg_query($dbconn, $query);

while ($row = pg_fetch_assoc($result)) {
    $flowerName = $row['name'];
    $flowerAvailableQ = $row['available_quantity'];
    $flowerImg = $row['flower_images'];
    $flowerHumidity = $row['humidity'];

    echo '<div class="flower">';
    echo '<h3>' . $flowerName . '</h3>';
    echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
    echo '<p>Humidity: ' . $flowerHumidity . '</p>';

    echo '<img class="flower-image" src="' . $flowerImg . '.jpg" >';
    echo '</div>';
}
?>