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
    <nav class="nav_bar">
        <ul class="login_list">
            <!-- HTML code -->


            <?php if ($validationResult): ?>
                <!-- Display content for logged-in users -->
                <a href="../profile.php">
                    <li class="profile">Profile</li>
                </a>
                <a href="../php/logout.php">
                    <li class="logout">Log out</li>
                </a>
            <li id="cart-window">
                <h2>Cart</h2>
                <ul id="cart-items">
                </ul>
                <p>Total: $<span id="cart-total">0.00</span></p>
            </li>
            <button id="cart_button" onclick="toggleCartWindow()"><i class="fa fa-shopping-cart" aria-hidden="true"></i></button>

                </ul>
            <?php else: ?>
                <!-- Display content for non-logged-in users -->
                <a href="../login.php">
                    <li class="log_in">Log In</li>
                </a>
                <a href="../register.php">
                    <li class="register">Register</li>
                </a>

            <?php endif; ?>
        </ul>
    </nav>
    <div class="horizontal_rule"></div>
    <nav class="nav_list">
        <ul>

            <a href="../about.php">
                <li class="about_us">About Us</li>
            </a>
            <a href="../check.php">
                <li class="check_flowers">Check Flowers</li>
            </a>
            <a href="../buy.php">
                <li class="buy_flowers">Buy Flowers</li>
            </a>
            <a href="../humidify.php">
                <li class="humidify">Humidify</li>
            </a>
            <a href="../contact.php">
                <li class="contact_button">Contact Us</li>
            </a>
            <a href="../help.php" >
                <li class="contact_button"> Get Help</li>
            </a>
        </ul>
    </nav>
    <nav id="nav_for_media">
        <ul><i class="fa-solid fa-xmark" id="close_menu"></i>
            <a href="../login.php">
                <li class="log_in">Log In</li>
            </a>
            <a href="../register.php">
                <li class="register">Register</li>
            </a>
            <a href="../index.php#main">
                <li class="about_us">About Us</li>
            </a>
            <a href="../check.php">
                <li class="check_flowers">Check Flowers</li>
            </a>
            <a href="../buy.php">
                <li class="buy_flowers">Buy Flowers</li>
            </a>
            <a href="../help.php" >
                <li class="contact_button"> Get Help</li>
            </a>
            <a href="#footer">
                <li class="contact_button">Contact Us</li>
            </a>
        </ul>
    </nav>
</header>
<script src="js/cart.js"></script>

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
