<?php
// Credentials to connect to phpMyAdmin
$host = "localhost"; // Change this to your MySQL server host
$username = "mp9689"; // Change this to your MySQL username
$password = "2pOPgPgAnt1Q3Q"; // Change this to your MySQL password
$database = "mp9689"; // Change this to your MySQL database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS PatronAccount (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    birthDate DATE NOT NULL,
    email VARCHAR(100),
    phoneNumber VARCHAR(12) NOT NULL,
    street VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50),
    zipcode VARCHAR(5) NOT NULL,
    country VARCHAR(50) NOT NULL,
    identityConfirmed ENUM('yes', 'no') NOT NULL,
    accountExpirationDate DATE NOT NULL
)";

$conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $identityConfirmed = $_POST['identityConfirmed'];
    $accountExpirationDate = date('Y-m-d', strtotime('+2 years')); // Date 2 years from now

    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    $zipcode = preg_replace('/\D/', '', $zipcode);

    $insertQuery = "INSERT INTO PatronAccount (firstName, lastName, birthDate, email, phoneNumber, street, city, state, zipcode, country, identityConfirmed, accountExpirationDate)
                    VALUES ('$firstName', '$lastName', '$birthDate', '$email', '$phoneNumber', '$street', '$city', '$state', '$zipcode', '$country', '$identityConfirmed', '$accountExpirationDate')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}




// catalog.html page
// Create the "inventory" table if it doesn't exist
$createTableSQL = "CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    locCode VARCHAR(255) NOT NULL,
    shelfCode VARCHAR(255) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    itemType VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL,
    code VARCHAR(8) NOT NULL,
    copies INT NOT NULL,
    inStock VARCHAR(3) NOT NULL
)";
if ($conn->query($createTableSQL) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];
    $locCode = $_POST["locCode"];
    $shelfCode = $_POST["shelfCode"];
    $cost = $_POST["cost"];
    $itemType = $_POST["itemType"];
    $branch = $_POST["branch"];

    // Generate a random 8-digit code
    $code = sprintf("%08d", mt_rand(1, 99999999));

    // Insert the data into the "inventory" table
    $sql = "INSERT INTO inventory (title, author, year, locCode, shelfCode, cost, itemType, branch, code, copies, inStock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'Yes')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssssd", $title, $author, $year, $locCode, $shelfCode, $cost, $itemType, $branch, $code);

    if ($stmt->execute()) {
        echo "Item added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>