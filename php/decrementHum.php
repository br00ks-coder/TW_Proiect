<?php
// Connect to your database and execute the decrement query
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
$updateQuery = "UPDATE flowers_humidity SET humidity = humidity - 1 WHERE humidity > 0";
// Execute the update query in your database
// ...
$usersResult = pg_query($dbconn, $updateQuery);

// Add any additional logic if needed
// ...
?>
