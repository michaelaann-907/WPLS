<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchInput']) && isset($_GET['searchCriteria'])) {
    $searchInput = mysqli_real_escape_string($conn, $_GET['searchInput']);
    $searchCriteria = mysqli_real_escape_string($conn, $_GET['searchCriteria']);

    // Construct the SQL query based on the selected search criteria
    $sqlSearch = "SELECT * FROM Inventory WHERE $searchCriteria LIKE '%$searchInput%'";

    $result = $conn->query($sqlSearch);

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
            echo "No matching records found.";
        }
    }

    $conn->close();
} else {
    echo "Invalid request";
}
?>