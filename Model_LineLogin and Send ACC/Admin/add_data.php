<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $type = $_POST['type'];
    $product = $_POST['product'];
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize the form data (you can add your own validation logic here)

    // Connect to the database
   require_once './connect_db.php';

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO product_account (Type, Product, user_id, Username, Password) VALUES ('$type', '$product', '$user_id', '$username', '$password')";

    // Execute the SQL statement
    if ($conn->query($sql) === true) {
        // Data inserted successfully
        header( "location: admin.php?success=true");
        exit();
    } else {
        // Error occurred while inserting data
        header("Location: admin.php?success=false");
        exit();
    }

    // Close the database connection
    $conn->close();
}
?>