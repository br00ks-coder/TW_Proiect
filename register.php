<?php
if (isset($_POST['newUser'])) {
    $newUser = $_POST['newUser'];
    $file = fopen("users.txt","a");
      fwrite($file,$newUser);
    fclose($file);
    echo "Registration successful!";
} else {
    echo "Invalid request.";
}
?>
