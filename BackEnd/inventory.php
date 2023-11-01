<?php
$host = "localhost"; // Change this to your MySQL server host
$username = "username"; // Change this to your MySQL username
$password = "password"; // Change this to your MySQL password
$database = "database"; // Change this to your MySQL database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table 'Inventory' exists, if not, create the table
$sql = "CREATE TABLE IF NOT EXISTS Inventory (
    itemID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    year YEAR,
    libraryOfCongressCode INT,
    shelfLocationCode VARCHAR(255),
    cost INT,
    itemType INT,
    branch INT,
    copies INT,
    inStock INT
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
    $itemType = $_POST['itemType'];
    $branch = $_POST['branch'];
    $copies = $_POST['copies'];
    $inStock = $_POST['inStock'];

    $insertQuery = "INSERT INTO Inventory (title, author, year, libraryOfCongressCode, shelfLocationCode, cost, itemType, branch, copies, inStock)
                    VALUES ('$title', '$author', '$year', '$libraryOfCongressCode', '$shelfLocationCode', '$cost', '$itemType', '$branch', '$copies', '$inStock')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "New Inventory record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
