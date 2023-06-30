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
    if (!$result) {
// Handle query error
        die("Query failed: " . pg_last_error());
    }
    $row = pg_fetch_assoc($result);
    $orderNumber = $row['order_number'];

// Insert order details into the database
    $query = "INSERT INTO orders (first_name, last_name, street, city, zip_code, delivery_type, payment_method, total_price, user_id)
VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
        $params = array($firstName, $lastName, $street, $city, $zipCode, $deliveryType, $paymentMethod, $totalPrice, $userId);
    $result = pg_query_params($dbconn, $query, $params);
    if (!$result) {
// Handle query error
        die("Query failed: " . pg_last_error());
    }

    $query = "SELECT product_name, user_id, seller_id, quantity FROM shopping_cart WHERE user_id = '$userId'";
    $result = pg_query($dbconn, $query);
    if (!$result) {
// Handle query error
        die("Query failed: " . pg_last_error());
    }

    while ($row = pg_fetch_assoc($result)) {
        $productName = $row['product_name'];
        $userId = $row['user_id'];
        $sellerId = $row['seller_id'];
        $quantitycart = $row['quantity'];

        error_log('Sqqqqqqq: ' . $quantitycart);
// Update the quantity of matching flowers in the flowers table
        $updateQuery = "UPDATE flowers SET available_quantity = available_quantity - $quantitycart WHERE name = '$productName' AND user_id = '$sellerId'";
        $updateResult = pg_query($dbconn, $updateQuery);
        if (!$updateResult) {
// Handle query error
            die("Query failed: " . pg_last_error());
        }

// Check if the quantity reached 0
        $checkQuantityQuery = "SELECT available_quantity FROM flowers WHERE name = '$productName' AND user_id = '$sellerId'";
        $checkQuantityResult = pg_query($dbconn, $checkQuantityQuery);
        if (!$checkQuantityResult) {
// Handle query error
            die("Query failed: " . pg_last_error());
        }
        $quantityRow = pg_fetch_assoc($checkQuantityResult);
        $quantity = $quantityRow['available_quantity'];

// If the quantity is 0, delete the flower from the flowers table
        if ($quantity <= 0) {
            $deleteQuery = "DELETE FROM flowers WHERE name = '$productName' AND user_id = '$sellerId'";
            $deleteResult = pg_query($dbconn, $deleteQuery);
            if (!$deleteResult) {
// Handle query error
                die("Query failed: " . pg_last_error());
            }
        }
    }

    $query = "DELETE FROM shopping_cart WHERE user_id = $1";
    $result = pg_query_params($dbconn, $query, array($userId));
    if (!$result) {
// Handle query error
        die("Query failed: " . pg_last_error());
    }

// Success message or redirection
    header("Location: ../buy.php");
    exit;
}

pg_close($dbconn);
