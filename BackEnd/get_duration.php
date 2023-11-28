<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Fetch the duration for the selected item from the Inventory table
    $stmt = $conn->prepare("SELECT duration FROM Inventory WHERE itemID = ?");
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $duration = $row['duration'];

        // Return the duration as JSON
        echo json_encode(['duration' => $duration]);
    } else {
        // Handle the case when the item ID is not found
        echo json_encode(['duration' => 0]);
    }
}

$conn->close();
?>