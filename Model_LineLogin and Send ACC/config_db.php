<?php
session_start();
//orderID = เลขออเดอร์ | orederItemID = เลขออเดอร์ | product_name = ชื่อสินค้า
function getDBConnection()
{
    $host = '';
    $username = 'up0pykdpcofgq';
    $password = 'bggssjm1cg4b';
    $database = 'dbnqpjg8oxxuyj';

    return new mysqli($host, $username, $password, $database);
}

if (isset($_SESSION['profile'])) {
    $orderID = $_SESSION['orderID'];
} else {
    $orderID = null;
}

// Prepare the SQL query
$conn = getDBConnection();
$query = "SELECT * FROM Line_Users WHERE orderID = '$orderID'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the data from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Access the data from each row
            $orderID_db = $row['orderID'];
            $name_line = $row['name'];
            $time = $row['time'];
            $status = $row['send_ms'];

        }
        if($orderID_db == $orderID and $status == 1){
            echo "<script>alert('ออเดอร์ $orderID ถูกรับไปแล้วโดยคุณ : $name_line   เวลาที่รับ : $time'); window.location.href = 'https://www.ttomoru.com/';</script>";
        }
    } 
} else {
    // Query execution failed
    echo "ไม่พบออเดอร์: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

// Check if the user is logged in and the profile data is available
if (isset($_SESSION['profile'])) {
    // Extract the required profile information
    $sub = $_SESSION['profile']->sub;
    $name = $_SESSION['profile']->name;
    $email = $_SESSION['profile']->email;
    $picture = $_SESSION['profile']->picture;

    // Check if the orderID exists in the database
if (!checkOrderID($orderID)) {
    $orderItemIDs = findOrderItemIDs($orderID);
    // Find the order item name
    $productNames = findOrderItemNames($orderItemIDs);
    if ($orderItemIDs) {
        // Convert the array to a comma-separated string
        $product_name = implode(',', $productNames);
        insertUserData($sub, $name, $email, $picture, $orderID, $productNames);
    } else {
        echo "Failed to retrieve order item names.";
    }
}

    // Update the send_ms value
    $connection = getDBConnection();
    $result = updateSendMSValue($orderID, $connection);
    echo $result;
    

    // Find the order status and echo it
    $orderStatus = findOrderStatus($orderID, $connection);
    if ($orderStatus) {
        if ($orderStatus === 'wc-completed') {
            $color = 'green';
            $text_status = 'สำเร็จ';
    } elseif ($orderStatus === 'wc-on-hold') {
        echo "<script>alert('คุณยังไม่ได้ชำระเงินในออเดอร์นี้ กรุณาทำการชำระก่อนเข้าหน้านี้.'); window.location.href = 'https://ttomoru.com/my-account/';</script>";
    }
    } else {
        echo "<script>alert('ไม่เจอออเดอร์ของคุณกรุณากลับมาใหม่อีกครั้ง หรือติดต่อแอดมิน.'); window.location.href = 'index.php?error';</script>";
        echo $orderStatus;
    }

    $orderItemIDs  = findOrderItemIDs($orderID);
    if ($orderItemIDs) {
        
    } else {
        echo  "<script>alert('ไม่เจอออเดอร์ของคุณกรุณาติดต่อแอดมินของระบบ :" . $orderItemID . "'); window.location.href = 'https://www.ttomoru.com/';</script>";
    }

    // Close the database connection
    $connection->close();
} else {
    // Redirect the user to the login page if not logged in
    header('Location: index.php');
    exit();
}

#get ACC
// Example usage
$productNames = findOrderItemNames($orderItemIDs);
$_SESSION['product_name'] = $productNames;
 // Replace "YourProductName" with the product name you want to search for

$productRows = findProductRowsForNames($productNames);
$_SESSION['productRows'] = $productRows;

if ($productRows!=null) {
    // If rows are found, echo all rows
} else {
    // If no rows are found, display a message
    echo "<script>alert('ไม่เจอรหัสในระบบกรุณาติดต่อแอดมินเพื่อเพิ่มสินค้า :" . $product_name . "'); window.location.href = 'https://www.ttomoru.com/';</script>";

}


function checkOrderID($orderID)
{
    $conn = getDBConnection();

    // Prepare the SQL statement with placeholders
    $sql = "SELECT orderID FROM Line_Users WHERE orderID = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $orderID);

    // Execute the prepared statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    // Check if the orderID exists in the database
    $exists = $result->num_rows > 0;

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();

    return $exists;
}

function insertUserData($sub, $name, $email, $picture, $orderID, $productNames)
{
    $conn = getDBConnection();

    // Convert the array to a comma-separated string
    $product_name = implode(',', $productNames);

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO Line_Users (sub, name, email, picture, orderID, product_name) VALUES (?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters and their respective types
    $stmt->bind_param("ssssss", $sub, $name, $email, $picture, $orderID, $product_name);

    // Execute the prepared statement
    if ($stmt->execute()) {
        //echo "User data inserted successfully!";
    } else {
        echo "Error inserting user data: " . $stmt->error;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
}

function updateSendMSValue($orderID, $connection)
{
    // Check if the send_ms value is NULL
    $checkQuery = "SELECT * FROM `Line_Users` WHERE `orderID` = '$orderID' AND `send_ms` IS NULL";
    $checkResult = mysqli_query($connection, $checkQuery);

    if ($checkResult) {
        // If the result contains rows, update the send_ms value to 0
        if (mysqli_num_rows($checkResult) > 0) {
            $updateQuery = "UPDATE `Line_Users` SET `send_ms` = 0 WHERE `orderID` = '$orderID'";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
                //return "send_ms updated successfully";
            } else {
                return "Failed to update send_ms";
            }
        }
        mysqli_free_result($checkResult);
    } else {
        return "Query execution failed";
    }
}

function findOrderStatus($orderID, $connection)
{
    $query = "SELECT status FROM wp_wc_order_stats WHERE order_id = '$orderID'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['status'];
    }

    return null;
}

function findOrderItemIDs($orderID)
{
    $conn = getDBConnection();
    // Prepare the SQL statement with placeholders
    $sql = "SELECT product_id FROM wp_wc_order_product_lookup WHERE order_id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $orderID);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($orderItemID);

    // Fetch all the results into an array
    $orderItemIDs = array();
    while ($stmt->fetch()) {
        $orderItemIDs[] = $orderItemID;
    }

    // Close the prepared statement
    $stmt->close();

    return $orderItemIDs;
}

function findOrderItemNames($orderItemIDs)
{
    $productNames = array();

    foreach ($orderItemIDs as $orderItemID) {
        $productName = findOrderItemName($orderItemID);
        $productNames[] = $productName;
    }

    return $productNames;
}

function findOrderItemName($orderItemID)
{
    $conn = getDBConnection();
    // Prepare the SQL statement with placeholders
    $sql = "SELECT sku FROM wp_wc_product_meta_lookup WHERE product_id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $orderItemID);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($product_name);

    // Fetch the result
    $stmt->fetch();

    // Close the prepared statement
    $stmt->close();

    return $product_name;
}

function findProductRowsForNames($productNames)
{
    $productRows = array();

    foreach ($productNames as $productName) {
        $rows = findProductRows($productName);
        $productRows = array_merge($productRows, $rows);
    }

    return $productRows;
}

function findProductRows($productName)
{
    $conn = getDBConnection();
    // Prepare the SQL statement with placeholders
    $sql = "SELECT * FROM `product_account` WHERE `Product` = ? AND `Stock` >= `Stock_Sell` ORDER BY `Product` ASC";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter and its respective type
    $stmt->bind_param("s", $productName);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all rows from the result
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Close the prepared statement
    $stmt->close();

    return $rows;
}


?>
