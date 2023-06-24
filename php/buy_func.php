<?php

    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    $query = "SELECT * FROM flowers";
    $result = pg_query($dbconn, $query);
    while ($row = pg_fetch_assoc($result)) {
        $flowerName = $row['name'];
        $flowerPrice = $row['price'];
        $flowerDesc = $row['description'];
        $flowerDiff = $row['difficulty'];
        $flowerAvailableQ = $row['available_quantity'];
        $flowerImg = $row['flower_images'];


        echo '<div class="flower">';
        echo '<h3>' . $flowerName . '</h3>';
        echo '<p>Description: ' . $flowerDesc . '</p>';
        echo '<p>Price: ' . $flowerPrice . '</p>';
        echo '<p>Difficulty to Maintain: ' . $flowerDiff . '</p>';
        echo '<p>Available Quantity: ' . $flowerAvailableQ . '</p>';

        echo '<img class="flower-image" src="' . $flowerImg . '.jpg" >';
        echo '</div>';
    }


?>