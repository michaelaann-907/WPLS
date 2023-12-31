<?php
// Include your database connection configuration here
include 'db_connection.php';


// Function to calculate late fees
function calculateLateFees($patronID, $itemID, $dueDate, $conn) {
    $currentDate = date('Y-m-d');
    $daysLate = (strtotime($currentDate) - strtotime($dueDate)) / (60 * 60 * 24);

    if ($daysLate > 0) {
        $inventoryLateFeeQuery = "SELECT lateFee FROM Inventory WHERE itemID = $itemID";
        $inventoryResult = $conn->query($inventoryLateFeeQuery);

        if ($inventoryResult->num_rows > 0) {
            $inventoryRow = $inventoryResult->fetch_assoc();
            $inventoryLateFee = $inventoryRow['lateFee'];
            
            $lateFee = $daysLate * $inventoryLateFee;

            $updateLateFees = "UPDATE PatronAccount SET lateFees = $lateFee WHERE patronID = $patronID";
            $conn->query($updateLateFees);
        }
    }
}

// Retrieve all patrons in the PatronAccount table
$patronQuery = "SELECT * FROM PatronAccount";
$result = $conn->query($patronQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patronID = $row['patronID'];

        // Retrieve checkout records related to each patron
        $checkoutRecordsQuery = "SELECT patronID, dueDate, itemID FROM Checkout WHERE patronID = $patronID";
        $checkoutResult = $conn->query($checkoutRecordsQuery);

        if ($checkoutResult->num_rows > 0) {
            while ($checkoutRow = $checkoutResult->fetch_assoc()) {
                $patronID = $checkoutRow['patronID'];
                $dueDate = $checkoutRow['dueDate'];
                $itemID = $checkoutRow['itemID'];

                // Calculate and update late fees for each checkout record of the patron
                calculateLateFees($patronID, $itemID, $dueDate, $conn);
            }
        }
    }
}

$conn->close();
?>
