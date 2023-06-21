<?php
session_start();

// Database connection details
$host = "webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com";
$dbname = "webgardening";
$username = "postgres";
$password = "paroladb";

// Establish a database connection
$dbconn = pg_connect("host=$host port=5432 dbname=$dbname user=$username password=$password");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // Insert data into the table
    $query = "INSERT INTO contact_messages (name, email, message) VALUES ($1, $2, $3)";
    $result = pg_query_params($dbconn, $query, array($name, $email, $message));
    
    if ($result) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . pg_last_error($dbconn);
    }
            header("Location: ../contact.php");

}
?>
