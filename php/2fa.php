<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the enable 2FA checkbox value
    $enable2FA = isset($_POST['enable-2fa']) && $_POST['enable-2fa'] == 'on';

    // Get the userid
    $userid = $_POST['userid'];
    error_log("User ID: " . $userid);

    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

    // Handle the checkbox value and userid
    if ($enable2FA) {
        $secretKey = generateSecretKey();
        storeSecretKey($userid, $secretKey);

        // Enable 2FA for the user
        $updateQuery = "UPDATE users SET fa_enabled = true WHERE id = $userid";

        $updateResult = pg_query($dbconn, $updateQuery);
    } else {
        // Disable 2FA for the user
        $updateQuery = "UPDATE users SET fa_enabled = false WHERE id = $userid";
        $updateResult = pg_query($dbconn, $updateQuery);
        removeSecretKey($userid);


    }

    header("Location: ../profile.php");
    pg_close($dbconn);


}
function userChecked($userId) {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

    $query = "SELECT fa_enabled FROM users WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($userId));
    $row = pg_fetch_assoc($result);
    $isEnabled = $row['fa_enabled'];

    $isEnabledF = ($isEnabled === 't') ? true : false;

    pg_close($dbconn);

    return $isEnabledF;
}

function userCheckedDiv($userId) {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

    $query = "SELECT fa_enabled FROM users WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($userId));
    $row = pg_fetch_assoc($result);
    $isEnabled = $row['fa_enabled'];

    pg_close($dbconn);

    return ($isEnabled === 't') ? 'true' : 'false';
}


function verifyCode($code, $userId) {
    // Retrieve the user's secret key from the database based on their user ID
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    $query = "SELECT secret_key FROM users WHERE id = $userId";
    $result = pg_query($dbconn, $query);
    $row = pg_fetch_assoc($result);
    $secretKey1 = $row['secret_key'];

    // Generate the current time-based OTP using the secret key
    $otp = generateOTP($secretKey1);
    error_log('FA code: ' . $otp);
    error_log('FA codemine: ' . $code);
    error_log('FA key: ' . $secretKey1);
    // Compare the entered code with the generated OTP
    if ($code === $otp) {
        return '1'; // Code is valid
    } else {
        return '0'; // Code is invalid
    }
}

function generateOTP($secretKey) {
    $time = floor(time() / 30); // Get the current time in 30-second intervals
    $data = pack('J', $time); // Convert time to binary data
    $secret = base32Decode($secretKey); // Decode the secret key from base32

    // Generate the HMAC-SHA1 hash
    $hash = hash_hmac('sha1', $data, $secret, true);

    // Get the offset value from the last 4 bits of the hash
    $offset = ord(substr($hash, -1)) & 0x0F;

    // Generate a 4-byte OTP using the 4 bytes starting at the offset
    $otp = unpack('N', substr($hash, $offset, 4))[1];

    // Apply a modulo operation to get a 6-digit OTP
    $otp %= 1000000;

    // Pad the OTP with leading zeros if necessary
    $otp = str_pad($otp, 6, '0', STR_PAD_LEFT);

    return $otp;
}

function base32Decode($base32) {
    $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $base32charsFlipped = array_flip(str_split($base32chars));
    $output = '';

    $base32 = str_replace('=', '', strtoupper($base32));
    $base32Length = strlen($base32);
    $buffer = 0;
    $bufferLength = 0;

    for ($i = 0; $i < $base32Length; $i++) {
        $buffer <<= 5;
        $buffer |= $base32charsFlipped[$base32[$i]];
        $bufferLength += 5;

        if ($bufferLength >= 8) {
            $output .= chr(($buffer >> ($bufferLength - 8)) & 0xFF);
            $bufferLength -= 8;
        }
    }

    return $output;
}



function generateSecretKey() {
    // Generate a random byte string
    $randomBytes = random_bytes(10);

    // Encode the random byte string using base32
    $secretKey = base32_encode($randomBytes);

    return $secretKey;
}
function base32_encode($data) {
    $base32Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    $base32Data = '';
    $currentByte = 0;
    $bitsRemaining = 8;

    for ($i = 0; $i < strlen($data); $i++) {
        $currentByte = ($currentByte << 8) | ord($data[$i]);
        $bitsRemaining += 8;

        while ($bitsRemaining >= 5) {
            $bitsRemaining -= 5;
            $base32Data .= $base32Chars[($currentByte >> $bitsRemaining) & 0x1F];
        }
    }

    if ($bitsRemaining > 0) {
        $currentByte <<= (5 - $bitsRemaining);
        $base32Data .= $base32Chars[$currentByte & 0x1F];
    }

    return $base32Data;
}

function getSecretKey($userId){
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

    if (!$dbconn) {
        die("Failed to connect to the database.");
    }

    $query = "SELECT secret_key FROM users WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($userId));

    if (!$result) {
        die("Query failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($result);
    $secretKey = $row['secret_key'];

    pg_close($dbconn);

    return $secretKey;
}

function storeSecretKey($userid, $secretKey) {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    $updateQuery = "UPDATE users SET secret_key = '$secretKey' WHERE id = $userid";
    pg_query($dbconn, $updateQuery);
}



function removeSecretKey($userid) {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    $updateQuery = "UPDATE users SET secret_key = NULL WHERE id = $userid";
    pg_query($dbconn, $updateQuery);
    // Remove the secret key from the database
    // Implement your logic to remove the secret key for the given userid
}
?>
