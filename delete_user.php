<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Delete the user from the database
        $query = "DELETE FROM users WHERE id = $1";
        $result = pg_query_params($dbconn, $query, array($userId));

        if (!$result) {
            // Handle query error
            die("Query failed: " . pg_last_error());
        }

        echo "User deleted successfully.";
    } else {
        echo "Invalid request.";
    }



pg_close($dbconn);
?>
