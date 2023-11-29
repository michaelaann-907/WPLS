<?php
// Example: Add error handling in fetch_checkin_data.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

// Fetch Checkin table data
$sqlFetchCheckinData = "SELECT * FROM Checkin";
$resultCheckinData = $conn->query($sqlFetchCheckinData);

if (!$resultCheckinData) {
    die('Error fetching data: ' . $conn->error);
}

if ($resultCheckinData->num_rows > 0) {
    // Start building the HTML content
    $htmlContent = '';
    while ($row = $resultCheckinData->fetch_assoc()) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $row['checkinID'] . '</td>';
        $htmlContent .= '<td>' . $row['patronID'] . '</td>';
        $htmlContent .= '<td>' . $row['itemID'] . '</td>';
        $htmlContent .= '<td>' . $row['returnDate'] . '</td>';
        $htmlContent .= '<td>' . $row['branchReturned'] . '</td>';
        $htmlContent .= '</tr>';
    }
    echo $htmlContent;
} else {
    echo '<tr><td colspan="5">No checkin records found</td></tr>';
}

$conn->close();
?>
