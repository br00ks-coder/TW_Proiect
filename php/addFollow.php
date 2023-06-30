<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    echo "Failed to connect to the database.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clientId = $_POST["clientId"];
    $sellerId = $_POST["sellerId"];
    $flowerName = $_POST["flowerName"];

    // Check if the flower is already followed
    $checkQuery = "SELECT * FROM follow WHERE client_id = $clientId AND seller_id = $sellerId AND flower_name = '$flowerName'";
    $checkResult = pg_query($dbconn, $checkQuery);

    if (pg_num_rows($checkResult) > 0) {
        // Flower is already followed, delete the existing row
        $deleteQuery = "DELETE FROM follow WHERE client_id = $clientId AND seller_id = $sellerId AND flower_name = '$flowerName'";
        $deleteResult = pg_query($dbconn, $deleteQuery);

        if ($deleteResult) {
            echo "Unfollowed successfully.";
        } else {
            echo "Failed to unfollow the flower.";
        }
    } else {
        // Flower is not followed, add a new entry
        $insertQuery = "INSERT INTO follow (client_id, seller_id, flower_name) VALUES ($clientId, $sellerId, '$flowerName')";
        $insertResult = pg_query($dbconn, $insertQuery);

        if ($insertResult) {
            echo "Followed successfully.";
        } else {
            echo "Failed to follow the flower.";
        }
    }
}

pg_close($dbconn);
?>
