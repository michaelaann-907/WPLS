<?php
// Include your database connection configuration here
$host = "localhost";
$username = "username";
$password = "password";
$database = "username";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

try {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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
        $accountExpirationDate = date('Y-m-d', strtotime('+2 years'));

        // Generate a random 5-digit patron ID
        $patronID = mt_rand(10000, 99999);

        // Format data for insertion
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber); // Remove non-numeric characters
        $zipcode = preg_replace('/\D/', '', $zipcode); // Remove non-numeric characters

        // SQL query to insert form data into the PatronAccount table
        $insertQuery = "INSERT INTO PatronAccount (patronID, firstName, lastName, birthDate, email, phoneNumber, street, city, state, zipcode, country, identityConfirmed, accountExpirationDate, lateFees)
                        VALUES ('$patronID', '$firstName', '$lastName', '$birthDate', '$email', '$phoneNumber', '$street', '$city', '$state', '$zipcode', '$country', '$identityConfirmed', '$accountExpirationDate', 0)";

        if ($conn->query($insertQuery) === TRUE) {
            echo "New patron added successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();


?>
