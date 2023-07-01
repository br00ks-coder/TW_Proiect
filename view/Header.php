<head>
    <link rel="stylesheet" href="../css/header.css">

    <title>Header view</title>
</head>
<header class="header">

    <div class="logo_icon_container">
        <div class="logo_container">
            <a class="logo" href="../index.php">
                <!--Link within the logo to be redirected to the main page-->
                <img class="logo" id="logo" src="../resources/Logo.png" alt="logo" width="130em" height="70em"/>
            </a>
        </div>
        <div class="icon_container"><i class="fa-solid fa-bars" id="open_menu"></i></div>
    </div>

    <h1 class="title">John Doe's Web Garden</h1>
    <nav aria-label="login/register buttons" id="login_register_nav">

    <ul class="nav_bar">
        <ul class="login_list">
            <!-- HTML code -->

            <?php if ($validationResult): ?>
            <!-- Display content for logged-in users -->
            <li id="cart-window" style="display: none;">
                <h2>Cart</h2>
                <ul id="cart-items">
                </ul>
                <p>Total: $<span id="cart-total">0.00</span></p>
            </li>

            <button id="cart_button" onclick="toggleCartWindow()"><i class="fa fa-shopping-cart"></i></button>

            <li class="profile">
                <a href="../profile.php">Profile</a>
            </li>

            <li class="logout">
                <a href="../php/logout.php">Log out</a>
            </li>
        </ul>

        <?php else: ?>
            <!-- Display content for non-logged-in users -->

            <li class="log_in">
                <a href="../login.php">Log In</a>
            </li>

            <li class="register">
                <a href="../register.php">Register</a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>

    <div class="horizontal_rule"></div>

    <nav class="nav_list" aria-label="Site main menu">
        <?php if ($validationResult): ?>
            <ul>
                <li class="about_us">
                    <a href="../about.php">About</a>
                </li>

                <li class="check_flowers">
                    <a href="../check.php">Warehouse</a>
                </li>

                <li class="buy_flowers">
                    <a href="../buy.php">Shop</a>
                </li>

                <li class="humidify">
                    <a href="../humidify.php">Garden</a>
                </li>


                <li class="contact_button">
                    <a href="../contact.php">Contact</a>
                </li>

                <li class="contact_button">
                    <a href="../help.php">Get Help</a>
                </li>
            </ul>
        <?php else: ?>

            <ul>

                <li class="about_us">
                    <a href="../about.php">About</a>
                </li>

                <li class="buy_flowers">
                    <a href="../buy.php">Shop</a>
                </li>

                <li class="contact_button">
                    <a href="../contact.php">Contact</a>
                </li>

                <li class="contact_button">
                    <a href="../help.php">Get Help</a>
                </li>
            </ul>

        <?php endif; ?>


    </nav>
    <nav id="nav_for_media" aria-label="mobile-navigation">
        <ul>
            <li class="mobile_icon_menu">
                <i class="fa-solid fa-xmark" id="close_menu"></i>
            </li>

            <li class="log_in">
                <a href="../login.php">Log In</a>
            </li>

            <li class="register">
                <a href="../register.php">Register</a>
            </li>

            <li class="about_us">
                <a href="../about.php">About Us</a>
            </li>

            <li class="buy_flowers">
                <a href="../buy.php">Buy Flowers</a>
            </li>

            <li class="contact_button">
                <a href="../help.php">Get Help</a>
            </li>

            <li class="contact_button">
                <a href="../contact.php">Contact Us</a>
            </li>
        </ul>
    </nav>

</header>
<div id="background"></div>

<script src="../js/cart.js"></script>

<script>
    const openMobileMenu = document.querySelector('#open_menu');
    const close_menu = document.querySelector('#close_menu');
    let menu = document.querySelector("#nav_for_media");
    openMobileMenu.addEventListener('click', function () {
        menu.classList.toggle('active');
    });
    close_menu.addEventListener('click', function () {
        menu.classList.toggle('active');
    });
</script>
