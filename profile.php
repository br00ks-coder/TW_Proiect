<?php
session_start();

// Check if the session is active and the user is authenticated


$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if(!$validationResult)
{
    header("Location: login.php");
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/GeneralStyle.css" />
  <link rel="stylesheet" href="css/style.css"/>
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



      <form id="profileForm" action="php/profileFunc.php" method="POST">
          <label for="username">Username: <span id="username"><?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?></span></label><br>
          <input type="hidden" name="username" value="<?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?>">
          <label for="oldPwd">Current password:</label><br>
          <input type="password" id="oldPwd" name="oldPwd" placeholder="current password"><br><br>
          <label for="newPwd">New Password:</label><br>
          <input type="password" id="newPwd" name="newPwd" placeholder="new password"><br><br>
          <label for="newPwdCon">Confirm new password:</label><br>
          <input type="password" id="newPwdCon" name="newPwdCon" placeholder="confirm password"><br><br>
          <button id="changePwdBtn">Change Password</button>
          <?php if (getUserFromJwt($jwtToken, $secretKey)['username'] == 'admin'): ?>
              <a href="admin.php">
                  <i class="fa-solid fa-screwdriver-wrench" style="display: inline-block; padding-top: 100%;"></i>
              </a>
          <?php endif; ?>
      </form>



      <script>
          document.getElementById("changePwdBtn").addEventListener("click", function() {
              var username = "<?php echo getUserFromJwt($jwtToken, $secretKey)['username']; ?>";
              var oldPwd = document.getElementById("oldPwd").value;
              var newPwd = document.getElementById("newPwd").value;
              var newPwdCon = document.getElementById("newPwdCon").value;

              // Create an XMLHttpRequest object
              var xhr = new XMLHttpRequest();

              // Set up the request
              xhr.open("POST", "php/profileFunc.php", true);

              // Set the response type
              xhr.responseType = "json";

              // Set up the event handler for the AJAX response
              xhr.onload = function() {
                  if (xhr.status === 200) {
                      // Successful response
                      var response = xhr.response;
                      // Handle the response as needed
                      console.log(response);
                  } else {
                      // Error handling
                      console.error("Request failed. Status: " + xhr.status);
                  }
              };

              // Create the request payload
              var payload = {
                  username: username,
                  oldPwd: oldPwd,
                  newPwd: newPwd,
                  newPwdCon: newPwdCon
              };

              // Convert the payload to JSON
              var payloadJson = JSON.stringify(payload);

              // Set the appropriate request headers
              xhr.setRequestHeader("Content-Type", "application/json");

              // Send the request with the payload
              xhr.send(payloadJson);
          });
      </script>

    
  </main>
<?php
include_once './view/Footer.php';
?>
</body>


</html>

