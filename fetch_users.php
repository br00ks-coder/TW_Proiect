<?php
// Establish a database connection
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

$query = "SELECT id, username FROM users";
$result = pg_query($dbconn, $query);

if (!$result) {
    // Handle query error
    die("Query failed: " . pg_last_error());
}

// Generate the HTML content for user data
$html = '<div>';
while ($row = pg_fetch_assoc($result)) {
    $userId = $row['id'];
    $username = $row['username'];

    $html .= '<form id="delete-user-form" method="post" action="delete_user.php">';
        $html .= '<p>' . $username . '</p>';

    $html .= '<input type="hidden" name="user_id" value="' . $userId . '">';
    $html .= '<button type="submit" name="delete">Delete</button>';
    $html .= '</form>';

    $html .= '<form id="change-password-form" method="post" action="change_password.php">';
    $html .= '<input type="hidden" name="user_id1" value="' . $userId . '">';
    $html .= '<input type="password" name="new_password1" placeholder="New Password">';
    $html .= '<button type="submit" name="change_password">Change Password</button>';
    $html .= '</form>';
}
$html .= '</div>';

// Close the database connection
pg_close($dbconn);

// Return the generated HTML content as the AJAX response
echo $html;
?>
