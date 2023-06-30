<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

require_once 'JwtGenerator.php'; // Assuming the JwtGenerator class is defined in a separate file named JwtGenerator.php
require  '2fa.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $code = $_POST['code'];
    $query = "SELECT id, username, password,fa_enabled ,is_admin FROM users WHERE username = $1 AND password = $2";
    $result = pg_query_params($dbconn, $query, array($username, $password));

    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($result);
    if ($row) {
        $userID = $row['id'];
        $username = $row['username'];

        $fa = $row['fa_enabled'];


        // Create an instance of JwtGenerator with your secret key
        $secretKey = 'your-secret-key'; // Replace with your own secret key
        $jwtGenerator = new JwtGenerator($secretKey);



        // Generate the JWT token
        if ($fa == 't' && verifyCode($code,$userID) == '0') {
            header("Location: ../login.php");
            exit;
        }


        if ($row['is_admin'] == 't') {

            // Redirect to the admin page
            $jwtToken = $jwtGenerator->generateToken($userID, $username);
            header("Location: ../admin.php");
        } else {
            // Redirect to a regular user page or display a success message
            $jwtToken = $jwtGenerator->generateToken($userID, $username);
            header("Location: ../profile.php");
        }
        exit; // Make sure to exit after the redirection
    } else {
        // User does not exist or credentials are incorrect
        echo "Invalid username or password.";
        header("Location: ../login.php");
    }
}

pg_close($dbconn);
?>
