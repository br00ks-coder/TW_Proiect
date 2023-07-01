<?php
$dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");

function generateDivs($flowers) {
    $dbconn = pg_connect("host=webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com port=5432 dbname=webgardening user=postgres password=paroladb");
    $query = "SELECT id, name, available_quantity FROM flowers";
    $result = pg_query($dbconn, $query);
    $flowers = array();

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $flowers[] = $row;
        }
    }

    foreach ($flowers as $flower) {
        $flowerId = $flower['id'];
        $flowerName = $flower['name'];
        $availableQuantity = $flower['available_quantity'];

        echo "<div>";

        // Admin controls (delete and quantity update)
        echo "<form method='post' action=''>";
        echo "<p class='flower-name-admin'>Flower Name: $flowerName</p>";
        echo "<p class='flower-name-admin'>Available Quantity: $availableQuantity</p>";
        echo "<input type='hidden' name='flowerId' value='$flowerId'>";
        echo "<input type='submit' name='delete' value='Delete'>";
        echo "<input type='number' name='newQuantity' value='$availableQuantity'>";
        echo "<input type='submit' name='update' value='Update Quantity'>";
        echo "</form>";

        echo "</div>";
    }
}

// Function to delete a flower by ID
function deleteFlower($flowerId) {
    global $dbconn;

    // Delete the flower from the database
    $query = "DELETE FROM flowers WHERE id = $flowerId";
    pg_query($dbconn, $query);
}

// Function to update the available quantity of a flower
function updateQuantity($flowerId, $newQuantity) {
    global $dbconn;

    // Update the available quantity in the database
    $query = "UPDATE flowers SET available_quantity = $newQuantity WHERE id = $flowerId";
    pg_query($dbconn, $query);
}

// Handle delete and update actions
if (isset($_POST['delete'])) {
    $flowerId = $_POST['flowerId'];
    deleteFlower($flowerId);
}

if (isset($_POST['update'])) {
    $flowerId = $_POST['flowerId'];
    $newQuantity = $_POST['newQuantity'];
    updateQuantity($flowerId, $newQuantity);
}

// Handle add flower action
if (isset($_POST['add'])) {
    $flowerName = $_POST['flowerName'];
    $availableQuantity = $_POST['availableQuantity'];
    $price = $_POST['priceAdd'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];


    // Insert the new flower into the database
    $query = "INSERT INTO flowers (name, available_quantity,price,description,difficulty) VALUES ('$flowerName', $availableQuantity,$price,'$description','$difficulty')";
    pg_query($dbconn, $query);
}
?>

