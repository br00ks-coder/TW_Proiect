<?php
session_start();
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/GeneralStyle.css">
    <link rel="stylesheet" href="css/buy.css" />

      <script
      src="https://kit.fontawesome.com/fb7068e0f1.js"
      crossorigin="anonymous"
    ></script>
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

  <?php include_once "./view/Header.php"; ?>

<main style="height: fit-content">




    <!-- Button to toggle cart window -->



    <h2>Featured Flowers</h2>
    <section class="flowers">
        <?php include_once "php/buy_func.php" ?>
    </section>
    <section>
        <h2>Growing Garden: Blooms in Progress</h2>
    </section>

    <script>
        function followFlower(clientId, sellerId, flowerName) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "php/addFollow.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Handle the response from the server if needed
                    console.log(xhr.responseText);
                    // Update the button label based on the response
                    var heartButton = document.getElementById("heart-button");
                    if (xhr.responseText === "followed") {
                        heartButton.textContent = "Watching";
                    } else if (xhr.responseText === "unfollowed") {
                        heartButton.textContent = "Follow";
                    }
                }
            };
            xhr.send("clientId=" + clientId + "&sellerId=" + sellerId + "&flowerName=" + flowerName);
        }
    </script>



    <section class="flowers">
        <?php include_once "php/growing_func.php" ?>
    </section>


</main>

<?php
  include_once './view/Footer.php';
?>

</body>

</html>
