<?php
include('db_connection.php'); // Include the database connection file



// Check if Checkout table exists, if not create it
$createTableQuery = "CREATE TABLE IF NOT EXISTS Checkout (
    checkoutID INT AUTO_INCREMENT PRIMARY KEY,
    patronID INT NOT NULL,
    itemID INT NOT NULL,
    dueDate DATE,
    checkoutDate DATE,
    FOREIGN KEY (patronID) REFERENCES PatronAccount(patronID),
    FOREIGN KEY (itemID) REFERENCES Inventory(itemID)
)";

if ($conn->query($createTableQuery) === false) {
    // Table creation failed, so display the error message
    echo "Error creating table: " . $conn->error;
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $patronID = $_POST['patronID'];
    $itemID = $_POST['bookID'];
    $dueDate = $_POST['dueDate'];
    $checkoutDate = $_POST['checkoutDate'];

    // Check if the patronID exists in PatronAccount table
    $checkPatronQuery = "SELECT * FROM PatronAccount WHERE patronID = $patronID";
    $resultPatron = $conn->query($checkPatronQuery);
    if ($resultPatron->num_rows == 0) {
        echo "Error: Patron ID not found in the PatronAccount table.";
    } else {
        // Check if the itemID exists in Inventory table
        $checkItemQuery = "SELECT * FROM Inventory WHERE itemID = $itemID";
        $resultItem = $conn->query($checkItemQuery);
        if ($resultItem->num_rows == 0) {
            echo "Error: Item ID not found in the Inventory table.";
        } else {
            // Insert data into Checkout table
            $insertQuery = "INSERT INTO Checkout (patronID, itemID, dueDate, checkoutDate) 
                            VALUES ($patronID, $itemID, '$dueDate', '$checkoutDate')";
            if ($conn->query($insertQuery) !== true) {
                echo "Error: " . $conn->error;
            } else {
                echo "Checkout successful!";
            }
        }
    }
}
?>
