<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if (isset($_POST['export'])) {
    // Retrieve the data from the users table
    $usersQuery = "SELECT * FROM users";
    $usersResult = pg_query($dbconn, $usersQuery);

    // Retrieve the data from the flowers table
    $flowersQuery = "SELECT * FROM flowers";
    $flowersResult = pg_query($dbconn, $flowersQuery);

    $messageQuerry = "SELECT * FROM contact_messages";
    $messageResult = pg_query($dbconn, $messageQuerry);

    $harvestsQuerry = "SELECT * FROM my_flowers";
    $harvestsResult = pg_query($dbconn, $harvestsQuerry);

    $humQuerry = "SELECT * from flowers_humidity";
    $humResult = pg_query($dbconn,$humQuerry);

    $orderQuerry = "SELECT * from orders";
    $orderResult = pg_query($dbconn,$orderQuerry);

    if ($usersResult && $flowersResult && $messageResult && $harvestsResult && $humResult && $orderResult) {
        $data = array();

        // Fetch data from the users table and store in the $data array
        while ($row = pg_fetch_assoc($usersResult)) {
            $data['users'][] = $row;
        }

        // Fetch data from the flowers table and store in the $data array
        while ($row = pg_fetch_assoc($flowersResult)) {
            $data['flowers'][] = $row;
        }

        while ($row = pg_fetch_assoc($messageResult)) {
            $data['message'][] = $row;
        }
        while ($row = pg_fetch_assoc($harvestsResult)) {
            $data['harvests'][] = $row;
        }

        while ($row = pg_fetch_assoc($humResult)) {
            $data['humidity'][] = $row;
        }

        while ($row = pg_fetch_assoc($orderResult)) {
            $data['order'][] = $row;
        }


        // Generate the JSON file
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);

        // Save the JSON string to a file
        $filename = "data_export.json";
        file_put_contents($filename, $jsonString);

        // Download the file
        header("Content-type: application/json");
        header("Content-Disposition: attachment; filename=$filename");
        readfile($filename);
        exit;
    } else {
        echo "Error: Database query failed.";
    }
}
?>
