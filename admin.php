<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}
include('php/flowers_admin.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/GeneralStyle.css" />
      <!-- <link rel="stylesheet" href="css/style.css" />-->
      <link rel="stylesheet" href="css/admin.css" />
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

  <nav class="nav_bar">
        <ul class="login_list">
            <!-- HTML code -->
            <a href="php/logout.php">
                <li class="logout">Log out</li>
            </a>


        </ul>
    </nav>

<main style="min-height: 20vh;">


    <section>
        <h2>USERS:</h2>
        <div id="user-container">
            <!-- User data will be loaded dynamically here -->
        </div>
        <h2>EXPORT DB:</h2>

        <form id="export-json" action="php/export.php" method="POST">
            <button type="submit" name="export">Export Database</button>
        </form>
    </section>

    <section>
        <h2>FLOWER ADMINISTRATION:</h2>

        <?php
        // Display the generated <div> elements
        generateDivs($flowers);
        ?>
    </section>









    <script>
function fetchUserData() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "./php/fetch_users.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = xhr.responseText;
        document.getElementById("user-container").innerHTML = response;
      } else {
        console.log("AJAX request error:", xhr.status);
      }
    }
  };
  xhr.send();
}

function handlePasswordChangeFormSubmit(event) {
  event.preventDefault();

  var form = event.target;
  var url = form.getAttribute("action");
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = xhr.responseText;
        console.log(response);
        fetchUserData();
      } else {
        console.log("AJAX request error:", xhr.status);
      }
    }
  };
  xhr.send(formData);
}

function handleDeleteUserFormSubmit(event) {
  event.preventDefault();

  var form = event.target;
  var url = form.getAttribute("action");
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = xhr.responseText;
        console.log(response);
        fetchUserData();
      } else {
        console.log("AJAX request error:", xhr.status);
      }
    }
  };
  xhr.send(formData);
}

function pollUserData() {
  fetchUserData();
  setTimeout(pollUserData, 5000);
}

fetchUserData();
pollUserData();

document.addEventListener("submit", function(event) {
  var target = event.target;
  if (target.getAttribute("id") === "change-password-form") {
    event.preventDefault();
    handlePasswordChangeFormSubmit(event);
  } else if (target.getAttribute("id") === "delete-user-form") {
    event.preventDefault();
    handleDeleteUserFormSubmit(event);
  }
});

</script>



</main>

  <?php
  include_once './view/Footer.php';
  ?>

  </body>

</html>
