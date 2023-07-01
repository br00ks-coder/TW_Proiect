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

    <nav class="nav_bar" aria-label="login_nav_bar">
        <?php if ($validationResult): ?>
            <ul class="login_list">
                <!-- Display content for logged-in users -->

                <li id="fav-window" style="display: none;">
                    <h2>Favorites</h2>
                    <ul id="fav-items">
                    </ul>
                </li>

                <li>
                    <button id="cart_button" onclick="toggleFavWindow()"><i class="fa-solid fa-heart"></i></button>
                </li>

                <li id="cart-window" style="display: none;">
                    <h2>Cart</h2>
                    <ul id="cart-items">
                    </ul>
                    <p>Total: $<span id="cart-total">0.00</span></p>
                </li>

                <li>
                    <button id="cart_button" onclick="toggleCartWindow()"><i class="fa fa-shopping-cart"></i></button>
                </li>

                <li class="profile">
                    <a href="../profile.php">Profile</a>
                </li>

                <li class="logout">
                    <a href="../php/logout.php">Log out</a>
                </li>

            </ul>

        <?php else: ?>
            <!-- Display content for non-logged-in users -->
            <ul class="login_list">
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

    <nav class="nav_list" aria-label="main_menu">
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

                <li class="log_in">
                    <a href="../login.php">Log In</a>
                </li>

                <li class="register">
                    <a href="../register.php">Register</a>
                </li>

                <li class="about_us">
                    <a href="../about.php"> About</a>
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

    <nav id="nav_for_media" aria-label="media nav">

        <?php if ($validationResult): ?>
            <ul>
                <li><i class="fa-solid fa-xmark" id="close_menu"></i></li>

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

                <li class="logout">
                    <a href="../php/logout.php">Log out</a>
                </li>

                <li id="fav-window" style="display: none;">
                    <h2>Favorites</h2>
                    <ul id="fav-items">
                    </ul>
                </li>

                <li>
                    <button id="cart_button" onclick="location.href = '../buy.php';">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </li>

                <li id="cart-window" style="display: none;">
                    <h2>Cart</h2>
                    <ul id="cart-items">
                    </ul>
                    <p>Total: $<span id="cart-total">0.00</span></p>
                </li>

                <li>
                    <button id="cart_button" onclick="location.href = '../checkout.php';">
                        <i class="fa fa-shopping-cart"></i>
                    </button>
                </li>
            </ul>
        <?php else: ?>

            <ul>
                <li class="log_in">
                    <a href="../login.php">Log In</a>
                </li>

                <li class="register">
                    <a href="../register.php">Register</a>
                </li>

                <li class="about_us">
                    <a href="../about.php"><a href="../about.php">About</a>
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
</header>
<div id="background"></div>

<script src="../js/cart.js"></script>
<script src="../js/fav.js"></script>

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
