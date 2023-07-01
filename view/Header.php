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


    <li id="fav-window" style="display: none;">
        <h2>Favorites</h2>
        <ul id="fav-items">
        </ul>
    </li>
    <button id="cart_button" onclick="toggleFavWindow()"><i class="fa-solid fa-heart"></i></button>


    <li id="cart-window" style="display: none;">
        <h2>Cart</h2>
        <ul id="cart-items">
        </ul>
        <p>Total: $<span id="cart-total">0.00</span></p>
    </li>
    <button id="cart_button" onclick="toggleCartWindow()"><i class="fa fa-shopping-cart" ></i></button>



                <a href="../profile.php">
                    <li class="profile">Profile</li>
                </a>

                <a href="../php/logout.php">
                    <li class="logout">Log out</li>
                </a>


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
             <?php if ($validationResult): ?>
        <ul>

            <a href="../about.php">
                <li class="about_us">About</li>
            </a>
            <a href="../check.php">
                <li class="check_flowers">Warehouse</li>
            </a>
            <a href="../buy.php">
                <li class="buy_flowers">Shop</li>
            </a>
            <a href="../humidify.php">
                <li class="humidify">Garden</li>
            </a>

            <a href="../contact.php">
                <li class="contact_button">Contact</li>
            </a>
            <a href="../help.php" >
                <li class="contact_button"> Get Help</li>
            </a>

        </ul>
             <?php else: ?>

        <ul>

            <a href="../about.php">
                <li class="about_us">About</li>
            </a>
            <a href="../buy.php">
                <li class="buy_flowers">Shop</li>
            <a href="../contact.php">
                <li class="contact_button">Contact</li>
            </a>
            <a href="../help.php" >
                <li class="contact_button"> Get Help</li>
            </a>

        </ul>

             <?php endif; ?>


    </nav>
    <nav id="nav_for_media">

            <?php if ($validationResult): ?>
                <ul><i class="fa-solid fa-xmark" id="close_menu"></i>

                    <a href="../about.php">
                        <li class="about_us">About</li>
                    </a>
                    <a href="../check.php">
                        <li class="check_flowers">Warehouse</li>
                    </a>
                    <a href="../buy.php">
                        <li class="buy_flowers">Shop</li>
                    </a>
                    <a href="../humidify.php">
                        <li class="humidify">Garden</li>
                    </a>

                    <a href="../contact.php">
                        <li class="contact_button">Contact</li>
                    </a>
                    <a href="../help.php" >
                        <li class="contact_button"> Get Help</li>
                    </a>
                    <a href="../php/logout.php">
                        <li class="logout">Log out</li>
                    </a>

                        <li id="fav-window" style="display: none;">
                            <h2>Favorites</h2>
                            <ul id="fav-items">
                            </ul>
                        </li>
                        <button id="cart_button" onclick="location.href = '../buy.php';"><i class="fa-solid fa-heart"></i></button>


                        <li id="cart-window" style="display: none;">
                            <h2>Cart</h2>
                            <ul id="cart-items">
                            </ul>
                            <p>Total: $<span id="cart-total">0.00</span></p>
                        </li>
                        <button id="cart_button" onclick="location.href = '../checkout.php';"><i class="fa fa-shopping-cart" ></i></button>


                </ul>
            <?php else: ?>

                <ul>

                    <a href="../about.php">
                        <li class="about_us">About</li>
                    </a>
                    <a href="../buy.php">
                        <li class="buy_flowers">Shop</li>

                        <a href="../contact.php">
                            <li class="contact_button">Contact</li>
                        </a>
                        <a href="../help.php" >
                            <li class="contact_button"> Get Help</li>
                        </a>

                </ul>

            <?php endif; ?>
        </ul>
    </nav>

</header>
<div id="background"">

</div>

<script src="js/cart.js"></script>
<script src="js/fav.js"></script>

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
