<?php

class JwtGenerator {
    private $secretKey;
    private $expirationTime;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
        $this->expirationTime = time() + 3600;
    }

    public function generateToken($userID, $username) {
        if (!$userID || !$username) {
            die('Invalid user ID or username');
        }

        $payload = [
            'user_id' => $userID,
            'username' => $username,
            'random_value' => $this->generateRandomValue(),
            'is_guest' => false // Set the is_guest flag to true for guest users
            // Add any additional data you want to include in the payload
        ];

        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($payload);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwtToken = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        setcookie('jwt_token', $jwtToken, $this->expirationTime, '/');

        return $jwtToken;
    }
    public function generateTokenGuest($userID, $username) {
        if (!$userID || !$username) {
            die('Invalid user ID or username');
        }

        $payload = [
            'user_id' => 'guest',
            'username' => 'guest',
            'random_value' => $this->generateRandomValue(),
            'is_guest' => true // Set the is_guest flag to true for guest users
            // Add any additional data you want to include in the payload
        ];

        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($payload);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwtToken = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        setcookie('jwt_token', $jwtToken, $this->expirationTime, '/');

        return $jwtToken;
    }
    private function generateRandomValue() {
        $randomValue = bin2hex(random_bytes(16)); // Generate a 32-character random string
        return $randomValue;
    }

    private function base64UrlEncode($data) {
        $base64 = base64_encode($data);
        if ($base64 === false) {
            return false;
        }

        $base64Url = strtr($base64, '+/', '-_');
        return rtrim($base64Url, '=');
    }
}