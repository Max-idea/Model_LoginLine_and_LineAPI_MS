<?php 
require_once('./connect_db.php');
function getStockQuantity($sku, $conn) {
    // Prepare the SQL statement with a placeholder
    $sql = "SELECT stock_quantity FROM `wp_wc_product_meta_lookup` WHERE sku = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $sku);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($stockQuantity);

    // Fetch the result
    $stmt->fetch();

    // Close the prepared statement
    $stmt->close();

    // Return the stock quantity
    return $stockQuantity;
}
?>