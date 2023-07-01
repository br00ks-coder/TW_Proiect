<?php
session_start();

// Check if the session is active and the user is authenticated
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require_once 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
$local_id = getUserFromJwt($jwtToken, $secretKey)['user_id'];
$db_connection = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com
 port=5432 dbname=webgardening user=postgres password=paroladb");
$query = "SELECT  available_quantity, humidity, user_id FROM flowers_humidity WHERE user_id = $local_id ";
$result = pg_query($db_connection, $query);
$humAverage = 0;
$flowerCount = 0;
$flowerStock = 0;
if ($result) {
    while ($row = pg_fetch_assoc($result)) {

        $flowerAvailableQ = $row['available_quantity'];
        $flowerStock = $flowerStock + $flowerAvailableQ;

        $flowerHumidity = $row['humidity'];
        $humAverage = $humAverage + $flowerHumidity;
        $flowerCount++;
    }
}
if ($flowerCount == 0) {

    $humAverage = 0;
} else {
    $humAverage = $humAverage / $flowerCount;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="#">
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/GeneralStyle.css"/>
    <link rel="stylesheet" href="css/MainPageStyle.css"/>
    <script src="https://kit.fontawesome.com/fb7068e0f1.js" crossorigin="anonymous"></script>
    <!--used for icons-->
    <title>Web Gardening</title>
</head>
<body>

<!-- Declared here to load as fast as possible -->

<?php include_once "./view/Header.php"; ?>

<main id="main">

    <section class="section1">
        <div class="section1 text" id="About_us">
            <h2>Welcome!</h2>
            <p>
                We created this site to help the people who love flowers be more in touch with them.
                As a seller or a buyer, our site puts technology
                to use so that you can check the status of the flowers that you love!
            </p>
        </div>

        <div class="section1 image" id="Photo_1">
            <img src="resources/flori.jpg" alt="Flower greenhouse"/>
        </div>
    </section>

    <br/>

    <section class="section2">
        <div class="section2 image" id="Photo_2">
            <img src="resources/ghiveci.jpg" alt="FlowerShop"/>
        </div>

        <div class="section2 text" id="Our_flowers">
            <h2>Your flowers...</h2>
            <p>
                will thank you!
                It was never easier to be able to sell your the flowers you grow.
                With the help of our website and some sensors you will be able to monitor the status of your
                flowers.
                You can do it anytime, anywhere.
            </p>
        </div>
    </section>

    <br/>

    <section>
        <div class="section3 text" id="Stats_text">
            <h2>With our latest technologies</h2>
            <p>
                We are able to provide different analyses through some sensors you have to put inside your flower's pot.
                Those sensors are able to read the humidity of the air, of the soil, the temperature and will let you
                know
                when you should water your flowers again.
            </p>
        </div>

        <?php if ($validationResult): ?>
        <div class="section3 stats" id="Stats_progress_bar">
            <p>The humidity level in ground</p>
            <div class="progress_bar" style="width:100%">
                <div class="progress_bar_fill" style="width: 80%"><?php echo $humAverage ?>%</div>
            </div>

            <p>Your total number of flowers</p>

            <div class="progress_bar" style="width: 100%">
                <div class="progress_bar_fill" style="width: 60%"><?php echo $flowerStock ?></div>
            </div>
            <?php else: ?>
                <div class="section3 text" id="Stats_text">
                    <p>Please login or register in order to see more of our features!</p>
                </div>
            <?php endif; ?>

            <br/>
        </div>
    </section>

    <br/>

    <section>
        <div class="section4 text" id="%Ready_text">
            <h2>How much is left?</h2>
            <p>
                Based on a series of calculations we are able to provide an estimate time of when the
                flowers you follow are ready! We check the weather, the humidity in soil and air
                and the approximate time of growth for the respective species of flower.
                Also, you can opt to receive an email when the flowers are ready to be bought!
            </p>
        </div>
        <div class="section4 text" id="%Ready_diagram">
            <h1>30 Days left</h1>
            <h3>Ready on 30th April 2023</h3>
            <p>Save the date</p>
        </div>
    </section>
</main>

<?php include_once './view/Footer.php'; ?>
</body>

<script>
    const textElements = document.querySelectorAll('.text');
    const imageElements = document.querySelectorAll('.image img');

    textElements.forEach((textElement, index) => {
        const imageElement = imageElements[index];

        // Check if imageElement is defined before accessing its properties
        if (imageElement) {
            const textHeight = getComputedStyle(textElement).height;
            imageElement.style.setProperty('--text_height', textHeight);
        }
    });


</script>

</html>
