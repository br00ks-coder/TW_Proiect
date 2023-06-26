<?php
// Start the session
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
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
<!-- Image for background -->
<div id="background"
     style="
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    position: fixed;
    background: linear-gradient(-45deg,#1b4d3e,#018749,#1cac78);
    background-size: cover;

    z-index: -1;
    @keyframes  {
        0%{
            background-position: 0% 50%;
        }
        50%{
            background-position: 100% 50%;
        }
        100%{

            background-position: 0% 50%;

        }
    }
    ">
    >
</div>
<!-- Declared here to load as fast as possible -->

<?php include_once "./view/Header.php"; ?>

<main id="main">

    <section class="section1">
        <div class="section1 text" id="About_us"> <span>
            <h2>Welcome!</h2>
            <p>
              We created this site to help the people who love flowers be more in touch with them.
                 As a seller or a buyer, our site puts technology to use so that you can check the status of the flowers that you love!

            </p>
          </span></div>
        <div class="section1 image" id="Photo_1"><img src="resources/flori.jpg" alt="Flower greenhouse"/></div>
    </section>
    <br/>
    <section class="section2">
        <div class="section2 image" id="Photo_2"><img src="resources/ghiveci.jpg" alt="FlowerShop"/></div>
        <div class="section2 text" id="Our_flowers"> <span>
            <h2>Your flowers...</h2>
            <p>
                will thank you!
                 It was never easier to be able to sell your the flowers you grow.
                 With the help of our website and some sensors you will be able to monitor the status of your flowers.
                 You can do it anytime, anywhere.
            </p>
          </span></div>
    </section>
    <br/>
    <section>
        <div class="section3 text" id="Stats_text"> <span>
            <h2>With our latest technologies</h2>
            <p>
              We are able to provide different analyses through some sensors you have to put inside your flower's pot.
                 Those sensors are able to read the humidity of the air, of the soil, the temperature and will let you know
                 when you should water your flowers again.
            </p>
          </span></div>
        <div class="section3 stats" id="Stats_progress_bar"> <span>
            <p>The humidity level in ground</p>
            <div class="progress_bar" style="width:100%">
              <div class="progress_bar_fill" style="width: 80%">
                80%</div>
            </div>
            <p>The flower is % ready</p>
            <div class="progress_bar" style="width: 100%">
              <div class="progress_bar_fill" style="width: 90%">
                90%</div>
            </div>
            <p>One more sensor</p>
            <div class="progress_bar" style="width: 100%">
              <div class="progress_bar_fill" style="width: 60%">
                60%</div>
            </div>
            <br/>
          </span></div>
    </section>
    <br/>
    <section>
        <div class="section4 text" id="%Ready_text"> <span>
            <h2>How much is left?</h2>
            <p>
              Based on a series of calculations we are able to provide an estimate time of when the
                 flowers you follow are ready! We check the weather, the humidity in soil and air
                 and the approximate time of growth for the respective species of flower.
                 Also, you can opt to receive an email when the flowers are ready to be bought!
            </p>
          </span></div>
        <div class="section4 text" id="%Ready_diagram"> <span>
            <h1>30 Days left</h1>
            <h3>Ready on 30th April 2023</h3>
            <p>Save the date</p>
          </span></div>
    </section>
</main>
<?php
include_once './view/Footer.php';
?>
</body>

<script>
    const textElements = document.querySelectorAll('.text');
    const imageElements = document.querySelectorAll('.image img');

    textElements.forEach((textElement, index) => {
        const imageElement = imageElements[index];
        const textHeight = getComputedStyle(textElement).height;
        imageElement.style.setProperty('--text_height', textHeight);
    });

</script>

</html>
