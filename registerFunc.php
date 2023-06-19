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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    // Add more fields as needed

    // Validate the form data
    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "Passwords do not match.";
        header("Location: register.php");
        exit;
    }

    // Check if the user already exists
    $query = "SELECT COUNT(*) FROM users WHERE username = $1";
    $result = pg_query_params($dbconn, $query, array($username));
    $row = pg_fetch_row($result);
    $userExists = $row[0] > 0;
    if ($userExists) {
        $_SESSION['message'] = "User already registered.";
        header("Location: register.php");
        exit;
    }

    // Perform additional validation checks here...

    // Insert the user data into the database
    $query = "INSERT INTO users (username, password) VALUES ($1, $2)";
    $result = pg_query_params($dbconn, $query, array($username, $password));

    if ($result) {
        // Registration successful
        // You can perform additional actions or redirect to a success page
        $_SESSION['message'] = "Registration successful!";
        header("Location: login.php");
        exit;
    } else {
        // Registration failed
        $_SESSION['message'] = "Registration failed.";
        header("Location: register.php");
        exit;
    }
}

pg_close($dbconn);
?>
