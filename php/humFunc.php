<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $flowerId = $_POST['flower'];

        // Actualizează umiditatea la 100% pentru floarea selectată
        $updateQuery = "UPDATE flowers_humidity SET humidity = 100 WHERE id = $flowerId";
        pg_query($dbconn, $updateQuery);

}


$query = "SELECT flowers.name, flowers.available_quantity, flowers.flower_images, flowers_humidity.humidity, flowers.id FROM flowers JOIN flowers_humidity ON flowers.id = flowers_humidity.id;";
$result = pg_query($dbconn, $query);

while ($row = pg_fetch_assoc($result)) {
    $flowerName = $row['name'];
    $flowerAvailableQ = $row['available_quantity'];
    $flowerImg = $row['flower_images'];
    $flowerHumidity = $row['humidity'];
    $flowerId = $row['id'];



    echo '<div class="flower">';
    echo '<h3>' . $flowerName . '</h3>';
    echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';
    echo '<p>Humidity: ' . $flowerHumidity . '</p>';
    echo '<img class="flower-image" src="' . $flowerImg . '.jpg">';
    echo '<form id="humForm" method="POST">
              <input type="hidden" name="flower" value="'. $flowerId .'">  
              <button id="water-button" type="submit" name="flower-button">Water Flowers</button>
        </form>';
    echo '</div>';
}
?>
