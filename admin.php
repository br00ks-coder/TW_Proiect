<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/GeneralStyle.css" />
    <link rel="stylesheet" href="css/style.css" />
<<<<<<< Updated upstream
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

=======
      <link rel="stylesheet" href="css/admin.css" />
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                <a href="logout.php">
                    <li class="logout">Log out</li>
                </a>
           
=======
            <a href="php/logout.php">
                <li class="logout">Log out</li>
            </a>


>>>>>>> Stashed changes
        </ul>
    </nav>

<main style="min-height: 20vh;">


<section>
        <div id="user-container">
            <!-- User data will be loaded dynamically here -->
        </div>
    <form id="export-json" action="php/export.php" method="POST">
        <button type="submit" name="export">Export Database</button>
    </form>

<<<<<<< Updated upstream
<script>

$(document).ready(function() {
    // Function to fetch user data
    function fetchUserData() {
        $.ajax({
            url: "fetch_users.php",
            method: "GET",
            dataType: "html",
            success: function(response) {
                // Update the user container div with the fetched data
                $("#user-container").html(response);
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:", error);
            }
        });
=======

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
>>>>>>> Stashed changes
    }

    // Function to handle password change form submission
    function handlePasswordChangeFormSubmit() {
        var form = $(this);
        var url = form.attr("action");
        var formData = form.serialize(); // Serialize form data

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            success: function(response) {
                // Display success message
                console.log(response);

                // Fetch user data after successful password change
                fetchUserData();
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:", error);
            }
        });
    }

    // Function to handle delete user form submission
    function handleDeleteUserFormSubmit() {
        var form = $(this);
        var url = form.attr("action");
        var formData = form.serialize(); // Serialize form data

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            success: function(response) {
                // Display success message
                console.log(response);

                // Fetch user data after successful user deletion
                fetchUserData();
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:", error);
            }
        });
    }

<<<<<<< Updated upstream
    // Call fetchUserData initially
    fetchUserData();
=======
function pollUserData() {
  fetchUserData();
  setTimeout(pollUserData, 50);
}
>>>>>>> Stashed changes

    // Polling function to fetch user data at regular intervals
    function pollUserData() {
        fetchUserData(); // Call fetchUserData

        // Set the polling interval (e.g., every 5 seconds)
        setTimeout(pollUserData, 5000);
    }

    // Start the polling process
    pollUserData();

    // Event listener for password change form submission
    $(document).on("submit", "#change-password-form", function(event) {
        event.preventDefault(); // Prevent form submission
        handlePasswordChangeFormSubmit.call(this);
    });

    // Event listener for delete user form submission
    $(document).on("submit", "#delete-user-form", function(event) {
        event.preventDefault(); // Prevent form submission
        handleDeleteUserFormSubmit.call(this);
    });
});

</script>



</main>

  <?php
  include_once './view/Footer.php';
  ?>

  </body>

</html>
