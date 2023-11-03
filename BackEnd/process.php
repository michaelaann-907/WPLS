<?php
// Credentials to connect to phpMyAdmin
$host = "localhost"; // Change this to your MySQL server host
$username = "username"; // Change this to your MySQL username
$password = "password"; // Change this to your MySQL password
$database = "database"; // Change this to your MySQL database name

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table 'PatronAccount' exists, if not, create the table
$sql = "CREATE TABLE IF NOT EXISTS PatronAccount (
    patronID INT AUTO_INCREMENT PRIMARY KEY,
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
    accountExpirationDate DATE NOT NULL,
    lateFees DECIMAL(10, 2) DEFAULT 0
)";

$conn->query($sql);

// Handle form submission
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

    // Format data for insertion
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber); // Remove non-numeric characters
    $zipcode = preg_replace('/\D/', '', $zipcode); // Remove non-numeric characters

    // SQL query to insert form data into the PatronAccount table
    $insertQuery = "INSERT INTO PatronAccount (firstName, lastName, birthDate, email, phoneNumber, street, city, state, zipcode, country, identityConfirmed, accountExpirationDate, lateFees)
                    VALUES ('$firstName', '$lastName', '$birthDate', '$email', '$phoneNumber', '$street', '$city', '$state', '$zipcode', '$country', '$identityConfirmed', '$accountExpirationDate', 0)";

    if ($conn->query($insertQuery) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
$conn->close();
?>
