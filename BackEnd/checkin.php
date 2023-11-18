<?php
// Include the database connection file
include 'db_connection.php';

// Check if the table 'CheckIn' exists; if not, create the table
$sqlCheckInTable = "CREATE TABLE IF NOT EXISTS CheckIn (
    checkinID INT AUTO_INCREMENT PRIMARY KEY,
    patronID INT,
    itemID INT,
    returnDate DATE,
    branchReturned VARCHAR(50),
    FOREIGN KEY (patronID) REFERENCES PatronAccount(patronID),
    FOREIGN KEY (itemID) REFERENCES Inventory(itemID)
)";

$conn->query($sqlCheckInTable);

// Enable error reporting for development (comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Find the related patronID, dueDate, and item info from the Checkout and Inventory tables using prepared statements
    $checkoutQuery = "SELECT c.patronID, c.dueDate, i.lateFee, i.cost FROM Checkout c
                      JOIN Inventory i ON c.itemID = i.itemID
                      WHERE c.itemID = ?";

    $stmt = $conn->prepare($checkoutQuery);
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $checkoutRow = $result->fetch_assoc();
        $patronID = $checkoutRow['patronID'];
        $dueDate = $checkoutRow['dueDate'];
        $lateFee = $checkoutRow['lateFee'];
        $itemCost = $checkoutRow['cost'];

        // Insert data into CheckIn table using prepared statements
        $returnDate = date("Y-m-d"); // Current date
        $branchReturned = "Branch"; // Update with the actual branch -- field to be adjusted
        $checkinInsertQuery = "INSERT INTO CheckIn (patronID, itemID, returnDate, branchReturned)
                               VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($checkinInsertQuery);
        $stmt->bind_param("iiss", $patronID, $itemID, $returnDate, $branchReturned);
        $stmt->execute();

        // Calculate late fees
        $lateFeeAmount = 0;
        $currentDate = new DateTime($returnDate); // Current date
        $dueDateObj = ($dueDate !== null && $dueDate !== '') ? new DateTime($dueDate) : null;

        if ($dueDateObj !== null && $currentDate > $dueDateObj) {
            $interval = $currentDate->diff($dueDateObj);
            $daysLate = $interval->days;

            // Calculate late fee based on the item's lateFee and multiply by daysLate
            $lateFeeAmount = min($daysLate * $lateFee, $itemCost);

            // Update lateFees in PatronAccount using prepared statements
            $patronUpdateQuery = "UPDATE PatronAccount SET lateFees = lateFees + ? WHERE patronID = ?";

            $stmt = $conn->prepare($patronUpdateQuery);
            $stmt->bind_param("di", $lateFeeAmount, $patronID);
            $stmt->execute();
        }

        // Delete the row from Checkout table using prepared statements
        $checkoutDeleteQuery = "DELETE FROM Checkout WHERE itemID = ?";

        $stmt = $conn->prepare($checkoutDeleteQuery);
        $stmt->bind_param("i", $itemID);
        $stmt->execute();

        echo "Check-in successful! Late fee: $lateFeeAmount";
    } else {
        echo "Error: Item not checked out or does not exist.";
    }
}
?>
