<?php   
session_start();
fget
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldpass = $_POST['oldPwd']; 
    $newpass = $_POST['newPwd'];
    $newpassconf = $_POST['newPwdCon'];
    $username = $_POST['username'];
    
    // Retrieve the current password from the database
    $query = "SELECT password FROM users WHERE username = $1";
    $result = pg_query_params($dbconn, $query, array($username));
    
    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($result);
    $dbPassword = $row['password'];

    if ($dbPassword === $oldpass && $newpass === $newpassconf) {
        // Update the password in the database
        $updateQuery = "UPDATE users SET password = $1 WHERE username = $2";
        $updateResult = pg_query_params($dbconn, $updateQuery, array($newpass, $username));
        
        if (!$updateResult) {
            // Handle update query error
            die("Update query failed: " . pg_last_error());
        }
         $successMessage = "Password changed successfully.";
    
    // Redirect to registerResponse.php with success message
    header("Location: ../profile.php?message=" . urlencode($successMessage));
    exit; // Make sure to exit after the redirection
} else {
    // Invalid old password or new passwords do not match
    $errorMessage = "Invalid old password or new passwords do not match.";
    
    // Redirect to registerResponse.php with error message
    header("Location: ../profile.php?message=" . urlencode($errorMessage));
    exit; // Make sure to exit after the redirection
    }
}

pg_close($dbconn);
?>
