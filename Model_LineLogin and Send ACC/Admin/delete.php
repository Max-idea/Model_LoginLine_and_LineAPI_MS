<?php
require_once './connect_db.php';

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Sanitize the 'id' parameter to prevent SQL injection
    $id = $_GET['id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM product_account WHERE ID = ?");
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
        echo "<script>window.location.href = 'admin.php';</script>";
        exit; // Terminate script execution after redirection
    } else {
        echo "Error deleting record.";
    }
} else {
    echo "Invalid request. No ID specified.";
}

$stmt->close();
$conn->close();
?>
