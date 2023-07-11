<?php
require_once("./config_db.php");
// Function to get status by order ID
function getStatusByOrderId($orderID, $conn)
{
    // Prepare the SQL statement with a placeholder
    $sql = "SELECT status FROM wp_wc_order_stats WHERE order_id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $orderID);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($status);

    // Fetch the result
    $stmt->fetch();

    // Close the prepared statement
    $stmt->close();

    // Check if the status is equal to "wc-completed"
    if ($status === "wc-completed") {
        return true;
    } else {
        return false;
    }
}
function getLine_status($conn)
{
    // Prepare the SQL statement with a placeholder
    $sql = "SELECT orderID FROM Line_Users WHERE send_ms ='0'";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $orderID);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($orderID);

    // Fetch the result
    $stmt->fetch();

    // Close the prepared statement
    $stmt->close();

    // Return the status
    return $orderID;
}
$orderID = getLine_status($status_ms, $conn);
$status = getStatusByOrderId($orderID, $conn);



echo "Status: " . $status;
echo "ID: ". $orderID;

// Close the database connection
$conn->close();



?>