<?php	
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];	
    $password = $_POST['password'];
   

    $query = "SELECT id,username,password,is_admin FROM users WHERE username = $1 AND password = $2";
    $result = pg_query_params($dbconn, $query, array($username, $password));

    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($result);
    if ($row) {

        // User exists, do further processing
        $_SESSION['user_id'] = $row['id']; // Store user ID in session variable
        $_SESSION['username'] = $row['username']; // Store username in session variable

       // Redirect to a protected page or display a success message

        if ($row['is_admin']=='t') {
            // Redirect to the admin page
            header("Location: ../admin.php");
            exit; // Make sure to exit after the redirection
        } else {
            // Redirect to a regular user page or display a success message
            header("Location: ../index.php");
            exit; // Make sure to exit after the redirection
        }    exit; // Make sure to exit after the redirection
    } else {
        // User does not exist or credentials are incorrect
        echo "Invalid username or password.";
        header("Location: ../login.php");
    }
}

pg_close($dbconn);
?>
