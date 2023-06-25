<?php
function verifyJwtToken($jwtToken, $secretKey)
{
// Step 2: Get the JWT token from the request (cookie, header, or query parameter)
if (!$jwtToken) {
return 0; // Token not found
}

// Step 3: Split the JWT token into its three parts: header, payload, and signature
$tokenParts = explode('.', $jwtToken);

if (count($tokenParts) !== 3) {
return 0; // Invalid token
}

$base64UrlHeader = $tokenParts[0];
$base64UrlPayload = $tokenParts[1];
$base64UrlSignature = $tokenParts[2];

// Step 4: Verify the signature
$signature = base64UrlDecode($base64UrlSignature);

$expectedSignature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secretKey, true);

if ($signature !== $expectedSignature) {
return 0; // Invalid signature
}

// Step 5: Decode the header and payload
$header = base64UrlDecode($base64UrlHeader);
$payload = base64UrlDecode($base64UrlPayload);

$headerData = json_decode($header, true);
$payloadData = json_decode($payload, true);

if (!$headerData || !$payloadData) {
return 0; // Invalid token data
}

// Step 6: Perform any additional validation or processing as needed
// Example: Validate the expiration time
if (isset($payloadData['exp']) && $payloadData['exp'] < time()) {
return 0; // Token expired
}

// Example: Retrieve user ID and username from the payload
$userID = $payloadData['user_id'];
$username = $payloadData['username'];

// Step 7: Successful token validation
return 1; // Token is valid
}

function getUserFromJwt($jwtToken, $secretKey)
{
    // Verify the JWT token
    $validationResult = verifyJwtToken($jwtToken, $secretKey);

    if ($validationResult) {
        // Decode the payload to extract user information
        $tokenParts = explode('.', $jwtToken);

        if (count($tokenParts) !== 3) {
            return false; // Invalid token
        }

        $base64UrlPayload = $tokenParts[1];
        $payload = base64UrlDecode($base64UrlPayload);
        $payloadData = json_decode($payload, true);

        if (!$payloadData) {
            return false; // Invalid token data
        }

        // Extract user information from the payload
        $userID = $payloadData['user_id'];
        $username = $payloadData['username'];

        // Return the user information
        return [
            'user_id' => $userID,
            'username' => $username
        ];
    } else {
        return false; // Invalid token
    }
}

// Helper function to decode base64 URL-safe encoded data
function base64UrlDecode($data)
{
$base64Url = strtr($data, '-_', '+/');
$paddedBase64 = str_pad($base64Url, strlen($data) % 4, '=', STR_PAD_RIGHT);
return base64_decode($paddedBase64);
}
?>