<?php
session_start();
$orderID = $_GET['orderID'];
require_once('LineLogin.php');

if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];
    $line = new LineLogin();
    $line->revoke($profile->access_token);
    session_destroy();
}
if($_GET['send'] === '1')
{
    header("Location: https://ttomoru.com/my-account/");
    exit;
}
// Create a new orderID in the URL

// Redirect the user to index.php with the updated orderID in the URL
header("Location: index.php?orderID=$orderID");
exit;
?>
