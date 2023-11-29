<?php
include 'db_connection.php';

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

if (!$conn->query($createTableQuery)) {
    die("Error creating table: " . $conn->error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $patronID = $_POST['patronID'];
        $itemID = $_POST['itemID'];
        $dueDate = $_POST['dueDate'];
        $checkoutDate = $_POST['checkoutDate'];

        // Check if the patronID exists in PatronAccount table
        $checkPatronQuery = "SELECT * FROM PatronAccount WHERE patronID = ?";
        $stmt = $conn->prepare($checkPatronQuery);
        $stmt->bind_param("i", $patronID);
        $stmt->execute();
        $resultPatron = $stmt->get_result();
        if ($resultPatron->num_rows == 0) {
            die("Error: Patron ID not found in the PatronAccount table.");
        }

        // Check if the itemID exists in Inventory table
        $checkItemQuery = "SELECT * FROM Inventory WHERE itemID = ?";
        $stmt = $conn->prepare($checkItemQuery);
        $stmt->bind_param("i", $itemID);
        $stmt->execute();
        $resultItem = $stmt->get_result();
        if ($resultItem->num_rows == 0) {
            die("Error: Item ID not found in the Inventory table.");
        }

        // Insert data into Checkout table
        $insertQuery = "INSERT INTO Checkout (patronID, itemID, dueDate, checkoutDate) 
                        VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiss", $patronID, $itemID, $dueDate, $checkoutDate);
        
        if ($stmt->execute()) {
            // Redirect to the checkout success page
            header("Location: checkout_success.html");
            exit();
        } else {
            die("Error: " . $stmt->error);
        }
    } catch (Exception $e) {
        die(json_encode(array('error' => 'Error: ' . $e->getMessage())));
    }
}

// Fetch patron IDs for the dropdown
$sqlFetchPatronData = "SELECT patronID, firstName, lastName FROM PatronAccount";
$resultPatronData = $conn->query($sqlFetchPatronData);

$patronData = ($resultPatronData->num_rows > 0) ? $resultPatronData->fetch_all(MYSQLI_ASSOC) : array();

// Fetch ItemID and Title data for the dropdown
$sqlFetchItemData = "SELECT itemID, title, author, itemType FROM Inventory";
$resultItemData = $conn->query($sqlFetchItemData);

$itemData = ($resultItemData->num_rows > 0) ? $resultItemData->fetch_all(MYSQLI_ASSOC) : array();

// Combine data into an associative array
$combinedData = array('patronData' => $patronData, 'itemData' => $itemData);

echo json_encode($combinedData);

$conn->close();
?>
