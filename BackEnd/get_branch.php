<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Fetch the branch from the Inventory table based on itemID
    $branchQuery = "SELECT branch FROM Inventory WHERE itemID = $itemID";
    $branchResult = $conn->query($branchQuery);

    if ($branchResult->num_rows > 0) {
        $branchRow = $branchResult->fetch_assoc();
        $branchReturned = $branchRow['branch'];

        echo $branchReturned;
    } else {
        echo "Branch not found";
    }
} else {
    echo "Invalid request";
}
?>
