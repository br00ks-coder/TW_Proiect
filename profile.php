<?php
session_start();

// Check if the session is active and the user is authenticated
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Close the database connection

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/GeneralStyle.css" />
  <link rel="stylesheet" href="css/style.css"
  <script src="https://kit.fontawesome.com/fb7068e0f1.js" crossorigin="anonymous"></script>
  <!--used for icons-->
  <title>Web Gardening</title>
</head>

<body>
<!-- Image for background -->
<div id="background"
     style="
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: fixed;
    background-image: url('resources/background_lavender.jpeg');
    background-size: cover;
    filter: blur(4px);
    z-index: -1;
    ">
    >
</div>
<!-- Declared here to load as fast as possible -->
<?php
include_once './view/Header.php';
?>

  <main class="mainProfile">
     

<form id="profileForm" action="profileFunc.php" method="POST">
  <label for="username">Username: <span id="username"><?php echo $_SESSION['username']; ?></span></label>
  <br>
  <label for="oldPwd">Current password:</label><br>
  <input type="password" id="oldPwd" name="oldPwd" placeholder="current password"><br><br>
  <label for="newPwd">New Password:</label><br>
  <input type="password" id="newPwd" name="newPwd" placeholder="new password"><br><br>
  <label for="newPwdCon">Confirm new password:</label><br>
  <input type="password" id="newPwdCon" name="newPwdCon" placeholder="confirm password"><br><br>
  <button type="submit">Change password</button>

</form> 


    
  </main>
<?php
include_once './view/Footer.php';
?>
</body>


</html>

