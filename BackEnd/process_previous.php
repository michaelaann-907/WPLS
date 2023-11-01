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
    // Generate a random 5-digit ID
    $random_id = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
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

    $insertQuery = "INSERT INTO PatronAccount (id,firstName, lastName, birthDate, email, phoneNumber, street, city, state, zipcode, country, identityConfirmed, accountExpirationDate)
                    VALUES ('$firstName', '$lastName', '$birthDate', '$email', '$phoneNumber', '$street', '$city', '$state', '$zipcode', '$country', '$identityConfirmed', '$accountExpirationDate')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}





//catalog.html inventory table
// Needs the following
/*
 * ID (Primary Key)
Title
Author
Year
Library of Congress Code
Shelf Location Code
Cost
ItemType
Branch
Copies (may add later)
InStock (may add later)
 */
// Create the inventory table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS inventory (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Year INT NOT NULL,
    Library_of_Congress_Code VARCHAR(20) NOT NULL,
    Shelf_Location_Code VARCHAR(20) NOT NULL,
    Cost DECIMAL(10, 2) NOT NULL,
    ItemType VARCHAR(50) NOT NULL,
    Branch VARCHAR(50) NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Inventory table created or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Generate a random 8-digit ID
$random_id = mt_rand(10000000, 99999999);

// Retrieve data from the catalog.html form
$title = $_POST['title'];
$author = $_POST['author'];
$year = $_POST['year'];
$locCode = $_POST['locCode'];
$shelfCode = $_POST['shelfCode'];
$cost = $_POST['cost'];
$itemType = $_POST['itemType'];
$branch = $_POST['branch'];

// Insert data into the inventory table
$sql_insert = "INSERT INTO inventory (ID, Title, Author, Year, Library_of_Congress_Code, Shelf_Location_Code, Cost, ItemType, Branch) 
        VALUES ('$random_id', '$title', '$author', '$year', '$locCode', '$shelfCode', '$cost', '$itemType', '$branch')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Item added to inventory successfully!";
} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}


$conn->close();
?>
