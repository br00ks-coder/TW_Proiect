<?php
session_start(); // Start the session

if (isset($_SESSION['username'])) {
    // Session exists, destroy it
    session_destroy();
}

// Redirect to another page
header("Location: ../index.php");
exit;
?>
