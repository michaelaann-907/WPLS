<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['itemID'])) {
        // Fetch the branch from the Inventory table based on itemID
        $itemID = $_POST['itemID'];
        $branchQuery = "SELECT branch FROM Inventory WHERE itemID = $itemID";
        $branchResult = $conn->query($branchQuery);

        if ($branchResult->num_rows > 0) {
            $branchRow = $branchResult->fetch_assoc();
            $branchReturned = $branchRow['branch'];

            echo $branchReturned;
        } else {
            echo "Branch not found";
        }
    } elseif (isset($_POST['getItemIDs'])) {
        // Fetch distinct itemID values from the Checkout table
        $itemIDQuery = "SELECT DISTINCT itemID FROM Checkout";
        $itemIDResult = $conn->query($itemIDQuery);

        if ($itemIDResult->num_rows > 0) {
            $options = "";
            while ($itemIDRow = $itemIDResult->fetch_assoc()) {
                $itemID = $itemIDRow['itemID'];
                $options .= "<option value='$itemID'>$itemID</option>";
            }
            echo $options;
        } else {
            echo "No itemID found";
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}
?>
