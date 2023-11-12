<?php
// Include your database connection configuration here
include 'db_connection.php';



// Check if the table 'Inventory' exists, if not, create the table
$sql = "CREATE TABLE IF NOT EXISTS Inventory (
    itemID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    year YEAR NOT NULL,
    libraryOfCongressCode VARCHAR(20) NOT NULL,
    shelfLocationCode VARCHAR(10) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    lateFee DECIMAL(10, 2) NOT NULL,
    itemType VARCHAR(50) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    copies INT NOT NULL,
    inStock INT NOT NULL
)";

$conn->query($sql);

// Handle form submission for Inventory
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $libraryOfCongressCode = $_POST['locCode']; 
    $shelfLocationCode = $_POST['shelfCode']; 
    $cost = $_POST['cost'];
    $lateFee = $_POST['lateFee'];
    $itemType = $_POST['itemType'];
    $branch = $_POST['branch'];
    $copies = $_POST['copies'];
    $inStock = $_POST['inStock'];

    $insertQuery = "INSERT INTO Inventory (title, author, year, libraryOfCongressCode, shelfLocationCode, cost, lateFee, itemType, branch, copies, inStock)
                    VALUES ('$title', '$author', '$year', '$libraryOfCongressCode', '$shelfLocationCode', '$cost', '$lateFee', '$itemType', '$branch', '$copies', '$inStock')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "New Inventory record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}


// Fetch Inventory table data
$sql = "SELECT * FROM Inventory";
$result = $conn->query($sql);

// Display table data
if ($result->num_rows > 0) {
    echo "<table>";

    // Display table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $columnName => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Table is empty.";
}


