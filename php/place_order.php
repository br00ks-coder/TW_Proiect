<?php
session_start();
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
if (!$dbconn) {
    // Handle connection error
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zipCode = $_POST['zipCode'];
    $deliveryType = $_POST['deliveryType'];
    $paymentMethod = $_POST['paymentMethod'];
    $totalPrice = $_POST['totalPrice'];
    $userId = $_POST['userId'];



    // Generate order number
    $query = "SELECT nextval('orders_order_number_seq') AS order_number";
    $result = pg_query($dbconn, $query);
    $row = pg_fetch_assoc($result);
    $orderNumber = $row['order_number'];

    // Insert order details into the database
    $query = "INSERT INTO orders (first_name, last_name, street, city, zip_code, delivery_type, payment_method, total_price, user_id)
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
    $params = array($firstName, $lastName, $street, $city, $zipCode, $deliveryType, $paymentMethod, $totalPrice, $userId);
    $result = pg_query_params($dbconn, $query, $params);

    $query = "DELETE FROM shopping_cart WHERE user_id = $1";
    $result = pg_query_params($dbconn, $query, array($userId));

    $query = "SELECT product_name, user_id, seller_id FROM shopping_cart WHERE user_id = '$userId'";
    $result = pg_query($dbconn, $query);
    while ($row = pg_fetch_assoc($result)) {
        $productName = $row['product_name'];
        $userId = $row['user_id'];
        $sellerId = $row['seller_id'];

        // Delete matching flowers from flowers table
        $deleteQuery = "DELETE FROM flowers WHERE name = '$productName' AND user_id = '$sellerId'";
        $deleteResult = pg_query($dbconn, $deleteQuery);


    }
// Replace <seller_id> with the actual seller ID value


    if (!$result) {
        // Handle query error
        die("Query failed: " . pg_last_error());
    }

    // Success message or redirection
    header("Location: ../buy.php");
    exit;
    // You can redirect to a success page if desired
    // header("Location: order_success.php");
}

pg_close($dbconn);

