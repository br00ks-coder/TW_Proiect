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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/GeneralStyle.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="register.js"></script>
    <script src="https://kit.fontawesome.com/fb7068e0f1.js" crossorigin="anonymous"></script>
    <!--used for icons-->
    <title>Web Gardening</title>
</head>
<body>
<!-- Image for background -->
<div id="background"
     style="
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: fixed;
    background-image: url('resources/background_lavender.jpeg');
    background-size: cover;
    filter: blur(4px);
    z-index: -1;
    ">
    >
</div>
<!-- Declared here to load as fast as possible -->

<?php
include_once './view/Header.php';
?>

    <main>
        <form method="POST" action="registerFunc.php">
            <h2>Forum Registration</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username2" name="username" />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password2" name="password" />
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password2" name="confirm-password" />
            </div>
            <button type="submit">Register</button>
            <div id="message" style="z-index: 2;">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>
        </form>
    </main>

<?php
include_once './view/Footer.php';
?>

</body>
</html>
