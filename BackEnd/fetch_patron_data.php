<?php
// Include the database connection file
include 'db_connection.php';

try {
    // Check if the PatronAccount table exists and create it if it doesn't
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

    // Use the global $conn variable from the included file
    $conn->query($sql);

    // Fetch PatronAccount table data and display it as an HTML table
    $sql = "SELECT * FROM PatronAccount";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr>";
        // Display table column names as table headers
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>".$fieldinfo->name."</th>";
        }
        echo "</tr>";

        // Display table data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Table is empty.";
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>