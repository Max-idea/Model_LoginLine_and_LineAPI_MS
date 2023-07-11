<?php
session_start();
require_once("./LineLogin.php");
require_once("./LineAPI.php");
require_once("./config_db.php");

$profile = $_SESSION['profile'];
$userId = $profile->sub;
$orderID = $_SESSION['orderID'];
$channelId = '1661432242';
$channelSecret = '087dc5918a26c44f7869f94519ab73f3';
$accessToken = 'qmZWvnRccYyE5GM1lzSoQVX5uI6B/jhwloFAZrh1ZYphEsQ66x92TLy1VxIenqxas9maolOVqbGiVsVzLasnJWREX7h94gScVBPDwLlb9HxReAGy2T2eol0tFiMN2UL4DqpPYWLgR2ldwbB0oMZ4FwdB04t89/1O/w1cDnyilFU=';

$lineAPI = new LineAPI($channelId, $channelSecret, $accessToken);
$message = "กำลังตรวจสอบสถานะการชำระ";
$lineAPI->sendTextMessage($userId, $message);

sleep(5);

if (!empty($userId)) {
    
    foreach ($_SESSION['productRows'] as $element) {
        $product = $element['Product'];
        $username = $element['Username'];
        $password = $element['Password'];
        $stockSell = $element['Stock_Sell'];
        $conn = getDBConnection();
        $stmt = $conn->prepare("UPDATE `product_account` SET `Stock_Sell` = `Stock_Sell` + 1 WHERE `product` = ?");
        $stmt->bind_param("s", $product);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT `Stock_Sell` FROM `product_account` WHERE `product` = ?");
        $stmt->bind_param("s", $product);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stockSell = $row['Stock_Sell'];
    


        // Send the message using $product, $username, $password, and $stockSell
        $message = "TTOMURU SHOP\nOrder Name: $product\nUser: $username\nPassword: $password\nScreen: $stockSell";
        $lineAPI->sendTextMessage($userId, $message);
    }
    
    
    // Check if the order has been sent before
    $checkQuery = "SELECT send_ms FROM Line_Users WHERE orderID = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $orderID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();
    
    if ($checkRow['send_ms'] == 0) {
        // Update send_ms to 1
        $updateQuery = "UPDATE Line_Users SET send_ms = 1 WHERE orderID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("s", $orderID);
        $updateStmt->execute();
        $updateStmt->close();
        // The order has already been sent
    } else {
        echo "<script>alert('คุณได้กดรับรหัสไปแล้วกรุณาติดต่อแอดมินหากเกิดปัญหา'); window.location.href = 'logout.php';</script>";
        exit();
    }
    
    $checkStmt->close();
    $conn->close();
} else {
    header("Location: welcome.php?success=false");
    exit();
}

echo "<script>alert('การส่งรหัสสำเร็จ ขอขอบคุณที่คุณลูกค้าให้เราดูแล'); window.location.href = 'logout.php?send=1';</script>";
exit();
?>
