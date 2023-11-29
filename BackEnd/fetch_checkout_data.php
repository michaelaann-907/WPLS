<?php
include 'db_connection.php';

// Fetch Checkout table data
$sqlFetchCheckoutData = "SELECT * FROM Checkout";
$resultCheckoutData = $conn->query($sqlFetchCheckoutData);

if ($resultCheckoutData->num_rows > 0) {
    // Start building the HTML content
    $htmlContent = '';
    while ($row = $resultCheckoutData->fetch_assoc()) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $row['checkoutID'] . '</td>';
        $htmlContent .= '<td>' . $row['patronID'] . '</td>';
        $htmlContent .= '<td>' . $row['itemID'] . '</td>';
        $htmlContent .= '<td>' . $row['dueDate'] . '</td>';
        $htmlContent .= '<td>' . $row['checkoutDate'] . '</td>';
        $htmlContent .= '</tr>';
    }
    echo $htmlContent;
} else {
    echo '<tr><td colspan="5">No checkout records found</td></tr>';
}

$conn->close();
?>
