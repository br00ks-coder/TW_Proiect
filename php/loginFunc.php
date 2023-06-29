
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

    $query = "SELECT id, username, password, is_admin FROM users WHERE username = $1 AND password = $2";
    $result = pg_query_params($dbconn, $query, array($username, $password));

    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($result);
    if ($row) {
        $userID = $row['id'];
        $username = $row['username'];

        // Generate the JWT token
        $secretKey = 'your-secret-key'; // Replace with your own secret key
        $expirationTime = time() + 3600; // Set the expiration time (e.g., 1 hour from now)

        $payload = [
            'user_id' => $userID,
            'username' => $username
            // Add any additional data you want to include in the payload
        ];

        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($payload);

        function base64UrlEncode($data)
        {
            $base64 = base64_encode($data);
            if ($base64 === false) {
                return false;
            }

            $base64Url = strtr($base64, '+/', '-_');
            return rtrim($base64Url, '=');
        }

        $base64UrlHeader = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);

        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secretKey, true);
        $base64UrlSignature = base64UrlEncode($signature);

        $jwtToken = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        // Set the JWT token as a cookie
        setcookie('jwt_token', $jwtToken, $expirationTime, '/');

        if ($row['is_admin'] == 't') {
            // Redirect to the admin page
            header("Location: ../admin.php");
        } else {
            // Redirect to a regular user page or display a success message
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
