<?php
// Connect to the database
$host = "localhost"; // Change this to your MySQL server host
$username = "your_username"; // Change this to your MySQL username
$password = "your_password"; // Change this to your MySQL password
$database = "your_database"; // Change this to your MySQL database name

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fields that will need to be created for the Database table:: addpatron feature

// First Name = firstName
// Last Name = lastName
// Phone Number = phoneNumber
// Street = street
// City = city
// State = state
// Zipcode = zipcode







$conn->close();
?>

