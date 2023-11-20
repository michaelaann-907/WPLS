// add_one.php
<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = mysqli_real_escape_string($conn, $_POST['itemId']);

    // Update the inStock value for the item with itemId
    $updateQuery = $conn->prepare("UPDATE Inventory SET inStock = inStock + 1 WHERE itemID = ?");
    $updateQuery->bind_param("i", $itemId);

    if ($updateQuery->execute()) {
        echo "Book added successfully";
    } else {
        echo "Error updating inStock value: " . $updateQuery->error;
    }

    $updateQuery->close();
}

$conn->close();
?>
