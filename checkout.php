<?php
session_start();
$jwtToken = $_COOKIE['jwt_token'] ?? null; // Example: Retrieving from a cookie
$secretKey = 'your-secret-key'; // Replace with your own secret key
require 'php/jwtVerify.php';

$validationResult = verifyJwtToken($jwtToken, $secretKey);
if($validationResult==0)
{
    header("Location: index.php");
}
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

<main id="checkout" style="height: fit-content">
    <h1>Your shopping list:</h1>
    <section class="flowers">
        <?php include_once './php/checkout.php'?>
    </section>

    <section>
        <h2>Checkout Information</h2>
        <form action="php/place_order.php" method="post" id="checkout-form">
            <label for="firstname">First Name:</label>
            <input type="text" id="name" name="firstName" required>
            <label for="lastname" style="margin-top: 5%;">Last name:</label>
            <input type="text" id="name" name="lastName" required>
            <label for="address">Address:</label>
            <input type="text" id="street" name="street" placeholder="Street" required>
            <input type="text" id="city" name="city" placeholder="City" required>
            <input type="text" id="zip" name="zipCode" placeholder="ZIP Code" required>
            <!-- Add any other necessary address fields here -->
            <label for="delivery">Delivery Type:</label>
            <select id="delivery" name="deliveryType" required>
                <option value="fan">Fan courier</option>
                <option value="cargus">Cargus</option>
                <option value="ridicare">Ridicare din sediu</option>

            </select>
            <label for="payment">Payment Method:</label>
            <select id="payment" name="paymentMethod" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            <div id="creditCardDetails" style="display: none;">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber">

                <label for="expiryDate">Expiry Date:</label>
                <input type="text" id="expiryDate" name="expiryDate">

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv">
            </div>

            <div id="paypalDetails" style="display: none;">
                <label for="paypalEmail">PayPal Email:</label>
                <input type="email" id="paypalEmail" name="paypalEmail">
            </div>

            <div id="bankTransferDetails" style="display: none;">
                <label for="bankName">Bank Name:</label>
                <input type="text" id="bankName" name="bankName">
                <input style="display: none;" name="userId" id="userId" value="<?php echo $userId?>">
                <label for="accountNumber">Account Number:</label>
                <input type="text" id="accountNumber" name="accountNumber">
            </div>
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">

            <p>Total Price: <?php echo $totalPrice; ?></p>

            <button type="submit">Place Order</button>
        </form>
    </section>
</main>

<script>
    const paymentSelect = document.getElementById('payment');
    const creditCardDetails = document.getElementById('creditCardDetails');
    const paypalDetails = document.getElementById('paypalDetails');
    const bankTransferDetails = document.getElementById('bankTransferDetails');

    paymentSelect.addEventListener('change', () => {
        if (paymentSelect.value === 'credit_card') {
            creditCardDetails.style.display = 'block';
            paypalDetails.style.display = 'none';
            bankTransferDetails.style.display = 'none';
        } else if (paymentSelect.value === 'paypal') {
            creditCardDetails.style.display = 'none';
            paypalDetails.style.display = 'block';
            bankTransferDetails.style.display = 'none';
        } else if (paymentSelect.value === 'bank_transfer') {
            creditCardDetails.style.display = 'none';
            paypalDetails.style.display = 'none';
            bankTransferDetails.style.display = 'block';
        } else {
            creditCardDetails.style.display = 'none';
            paypalDetails.style.display = 'none';
            bankTransferDetails.style.display = 'none';
        }
    });
</script>


<?php
include_once './view/Footer.php';
?>

</body>

</html>
