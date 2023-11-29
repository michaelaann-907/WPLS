<!-- update_putback.php -->
<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Update CheckIn table to set branchReturned to Inventory.branch
    $updateQuery = $conn->prepare("UPDATE CheckIn SET branchReturned = (SELECT branch FROM Inventory WHERE itemID = ?) WHERE itemID = ?");
    $updateQuery->bind_param("ii", $itemID, $itemID);

    if ($updateQuery->execute()) {
        echo "Item Put Back Successfully!";
    } else {
        echo "Error updating item: " . $updateQuery->error;
    }

    $updateQuery->close();
}

// Close the database connection
$conn->close();
?>
