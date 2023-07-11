<?php
require_once("./config_db.php");

// Retrieve data from wp_wc_product_meta_lookup table
$sql = "SELECT * FROM `wp_wc_product_meta_lookup` ORDER BY `wp_wc_product_meta_lookup`.`stock_status` ASC";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract necessary data
        $sku = $row['sku'];
        $stock_quantity = $row['stock_quantity'];

        // Update data in product_account table
        $updateSql = "UPDATE `product_account` SET `Stock` = '$stock_quantity' WHERE `Product` = '$sku'";
        if ($conn->query($updateSql) === TRUE) {

        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "No results found.";
}

// Close the database connection (optional)
$conn->close();
echo "<script>alert('update successfully.'); window.location.href = 'https://www.ttomoru.com/Line_Login/Admin/admin.php';</script>";
// check_order.php

// Perform stock update logic here

// Redirect back to the previous page

?>
