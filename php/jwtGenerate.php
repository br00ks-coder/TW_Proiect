<?php
// Step 1: Define your secret key and other necessary variables
$secretKey = 'your-secret-key'; // Replace with your own secret key
$expirationTime = time() + 3600; // Set the expiration time (e.g., 1 hour from now)

// Step 2: Retrieve the user ID and username from the query parameters
$userID = $_GET['user_id'] ?? null;
$username = $_GET['username'] ?? null;

// Step 3: Validate the user ID and username (Add your own validation logic here)

if (!$userID || !$username) {
    die('Invalid user ID or username');
}

// Step 4: Create the payload data for the JWT
$payload = [
    'user_id' => $userID,
    'username' => $username
    // Add any additional data you want to include in the payload
];

// Step 5: Generate the JWT token (same as before)

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

// Step 6: Set the JWT token as a cookie
setcookie('jwt_token', $jwtToken, $expirationTime, '/');

echo 'JWT token generated and stored in the cookie.';
?>
