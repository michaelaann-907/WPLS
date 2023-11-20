<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = mysqli_real_escape_string($conn, $_POST['itemId']);

    // Fetch the current inStock value for the item with itemId
    $result = $conn->query("SELECT inStock, title FROM Inventory WHERE itemID = $itemId");

    if ($result === FALSE) {
        echo 'error';
    } else {
        $row = $result->fetch_assoc();
        $inStock = $row['inStock'];
        $title = $row['title'];

        if ($inStock == 1) {
            // If inStock is 1, delete the item
            $conn->query("DELETE FROM Inventory WHERE itemID = $itemId");
            echo 'deleted';
        } else {
            // If inStock is more than 1, decrement the inStock value
            $conn->query("UPDATE Inventory SET inStock = inStock - 1 WHERE itemID = $itemId");
            echo 'updated';
        }

        // Close the result set
        $result->close();
    }
}

$conn->close();
?>
