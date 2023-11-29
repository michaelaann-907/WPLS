<!-- putback_table.php -->
<?php
// Include the database connection file
include 'db_connection.php';

// Query to fetch items where Inventory(branch) is not equal to CheckIn(branchReturned)
$sql = "SELECT Inventory.itemID, Inventory.shelfLocationCode, Inventory.branch, CheckIn.branchReturned
        FROM Inventory
        LEFT JOIN CheckIn ON Inventory.itemID = CheckIn.itemID
        WHERE Inventory.branch <> CheckIn.branchReturned OR CheckIn.branchReturned IS NULL";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display table headers with checkbox column
    echo '<table border="1">
            <tr>
                <th>Put Back</th>
                <th>Item ID</th>
                <th>Shelf Location Code</th>
                <th>Origin Branch</th>
                <th>Branch Returned</th>
            </tr>';

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td><input type="checkbox" class="putBackCheckbox" data-itemid="' . $row["itemID"] . '"></td>
                <td>' . $row["itemID"] . '</td>
                <td>' . $row["shelfLocationCode"] . '</td>
                <td>' . $row["branch"] . '</td>
                <td>' . $row["branchReturned"] . '</td>
              </tr>';
    }

    echo '</table>';
} else {
    echo "No matching records found.";
}

// Close the database connection
$conn->close();
?>
