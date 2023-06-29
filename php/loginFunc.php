
<?php
session_start();
$host = 'webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com';
$dbname = 'webgardening';
$username = 'postgres';
$password = 'paroladb';
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT id, username, password, is_admin FROM users WHERE username = :username AND password = :password');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if (!$stmt) {
        $errorInfo = $pdo->errorInfo();
        die("Query failed: " . $errorInfo[2]);
    }


    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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


?>
