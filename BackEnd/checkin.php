<?php
// Include the database connection file
include 'db_connection.php';

// Check if the table 'CheckIn' exists, if not, create the table
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Fetch the branchReturned from the form
    $branchReturned = $_POST['branchReturned'];

    // Find the related patronID and itemID from the Checkout table
    $checkoutQuery = "SELECT patronID, branch FROM Checkout JOIN Inventory ON Checkout.itemID = Inventory.itemID WHERE Checkout.itemID = $itemID";
    $checkoutResult = $conn->query($checkoutQuery);

    if ($checkoutResult->num_rows > 0) {
        $checkoutRow = $checkoutResult->fetch_assoc();
        $patronID = $checkoutRow['patronID'];
        $originBranch = $checkoutRow['branch'];

        // Check if the origin branch and branch returned are different
        if ($originBranch !== $branchReturned) {
            // Insert data into CheckIn table
            $returnDate = date("Y-m-d"); // Current date
            $checkinInsertQuery = "INSERT INTO CheckIn (patronID, itemID, returnDate, branchReturned)
                                   VALUES ('$patronID', '$itemID', '$returnDate', '$branchReturned')";
            $conn->query($checkinInsertQuery);

            // Delete the row from Checkout table
            $checkoutDeleteQuery = "DELETE FROM Checkout WHERE itemID = $itemID";
            $conn->query($checkoutDeleteQuery);

            // Update lateFees to 0 in PatronAccount if applicable
            $patronUpdateQuery = "UPDATE PatronAccount SET lateFees = 0 WHERE patronID = $patronID";
            $conn->query($patronUpdateQuery);

            // Redirect to success page with special message
            header("Location: checkin_success.html?specialMessage=ItemNeedsShipping");
            exit();
        } else {
            // Origin branch and branch returned are the same
            // You can add additional handling here if needed
            // For now, just redirect to success page without special message
            header("Location: checkin_success.html");
            exit();
        }
    } else {
        echo "Error: Item not checked out or does not exist.";
    }
}
?>
