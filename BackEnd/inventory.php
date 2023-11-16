<?php
include 'db_connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Your existing database connection code

    // Ensure the Inventory table exists, if not, create it
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS Inventory (
        itemID INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        year INT(4) NOT NULL,
        libraryOfCongressCode VARCHAR(20) NOT NULL,
        shelfLocationCode VARCHAR(10) NOT NULL,
        cost DECIMAL(10, 2) NOT NULL,
        lateFee DECIMAL(10, 2) NOT NULL,
        itemType VARCHAR(50) NOT NULL,
        duration INT NOT NULL,
        branch VARCHAR(50) NOT NULL,
        inStock INT NOT NULL DEFAULT 1
    )";

    if ($conn->query($sqlCreateTable) === FALSE) {
        echo "Error creating table: " . $conn->error;
        exit();
    }

    // Handle form submission for Inventory
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate the input data
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $year = (int)$_POST['year']; //converted to integer w/ 4 digits
        $libraryOfCongressCode = mysqli_real_escape_string($conn, $_POST['locCode']);
        $shelfLocationCode = mysqli_real_escape_string($conn, $_POST['shelfCode']);
        $cost = mysqli_real_escape_string($conn, $_POST['cost']);
        $lateFee = mysqli_real_escape_string($conn, $_POST['lateFee']);
        $itemType = mysqli_real_escape_string($conn, $_POST['itemType']);
        $duration = mysqli_real_escape_string($conn, $_POST['duration']);
        $branch = mysqli_real_escape_string($conn, $_POST['branch']);

        // Basic form validation
        if (empty($title) || empty($author) || empty($year) || empty($libraryOfCongressCode) || empty($shelfLocationCode) || empty($cost) || empty($lateFee) || empty($itemType) || empty($duration) || empty($branch)) {
            echo "All fields are required.";
        } else {
            // Use prepared statement to insert data
            $insertQuery = $conn->prepare("INSERT INTO Inventory (title, author, year, libraryOfCongressCode, shelfLocationCode, cost, lateFee, itemType, duration, branch, inStock)
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

            $insertQuery->bind_param("ssssssssss", $title, $author, $year, $libraryOfCongressCode, $shelfLocationCode, $cost, $lateFee, $itemType, $duration, $branch);

            if ($insertQuery->execute()) {
                echo "New Inventory record created successfully";
            } else {
                echo "Error: " . $insertQuery->error;
            }

            $insertQuery->close();
        }
    }

    // Fetch Inventory table data
    $sqlFetchData = "SELECT * FROM Inventory";
    $result = $conn->query($sqlFetchData);

    // Display table data
    if ($result === FALSE) {
        echo "Error fetching data: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            echo "<table>";

            // Display table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $columnName => $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>"; // Sanitize data for HTML output
                }

                // Add delete button to the last column
                echo '<td><button class="delete-button" data-id="' . $row['itemID'] . '">Delete</button></td>';

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Table is empty.";
        }
    }

    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
