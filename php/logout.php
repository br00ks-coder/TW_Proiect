<?php
// Clear JWT token cookie
setcookie('jwt_token', '', time() - 3600, '/');

// Redirect to another page
header("Location: ../index.php");
exit;
?>
