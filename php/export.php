<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if (isset($_POST['export'])) {
    // Retrieve the data from the users table
    $usersQuery = "SELECT id, username, password, is_admin FROM users";
    $usersResult = pg_query($dbconn, $usersQuery);

    // Retrieve the data from the flowers table
    $flowersQuery = "SELECT id, name, description,price,difficulty,created_at,available_quantity FROM flowers";
    $flowersResult = pg_query($dbconn, $flowersQuery);

    $messageQuerry = "SELECT id, name, email,message,created_at FROM contact_messages";
    $messageResult = pg_query($dbconn, $messageQuerry);

    $harvestsQuerry = "SELECT har_name,date_planted,harvest_date,har_id FROM my_harvests";
    $harvestsResult = pg_query($dbconn, $harvestsQuerry);

    $humQuerry = "SELECT id,humidity from flowers_humidity";
    $humResult = pg_query($dbconn,$humQuerry);

    if ($usersResult && $flowersResult && $messageResult && $harvestsResult && $humResult) {
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
