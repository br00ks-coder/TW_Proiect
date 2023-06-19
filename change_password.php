<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());



}
        


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id1']) && isset($_POST['new_password1'])) {
        $userId = $_POST['user_id1'];
        $newPassword = $_POST['new_password1'];

        // Update the user's password in the database
        $query = "UPDATE users SET password = $1 WHERE id = $2";
        $result = pg_query_params($dbconn, $query, array($newPassword, $userId));

        if (!$result) {
            // Handle query error
            die("Query failed: " . pg_last_error());
        }

        echo "Password changed successfully.";
    } else {
        echo "Invalid request.";
        exit;
    }


pg_close($dbconn);
?>
