<?php
session_start();
require_once("LineLogin.php");
require_once("LineAPI.php");

$profile = $_SESSION['profile'];
$userId = $profile->sub;

$channelId = '1661432242';
$channelSecret = '087dc5918a26c44f7869f94519ab73f3';
$accessToken = 'qmZWvnRccYyE5GM1lzSoQVX5uI6B/jhwloFAZrh1ZYphEsQ66x92TLy1VxIenqxas9maolOVqbGiVsVzLasnJWREX7h94gScVBPDwLlb9HxReAGy2T2eol0tFiMN2UL4DqpPYWLgR2ldwbB0oMZ4FwdB04t89/1O/w1cDnyilFU=';

$lineAPI = new LineAPI($channelId, $channelSecret, $accessToken);
$message = "กำลังตรวจสอบสถานะการชำระ";
$lineAPI->sendTextMessage($userId, $message);

sleep(5);

$message = "Hello Netflix Shop\nUser: XXXXXX\nPassword: XXXXXX\n";

if (!empty($userId)) {
    $lineAPI->sendTextMessage($userId, $message);
    header("Location: welcome.php?success=true");
    exit();
} else {
    header("Location: welcome.php?success=false");
    exit();
}
?>
