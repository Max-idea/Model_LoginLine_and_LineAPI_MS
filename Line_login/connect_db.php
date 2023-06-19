<?php
$servername = 'localhost:8888';
$username = 'root';
$password = '6UYVrqJpqoRd';
$dbname = 'bitnami_wordpress';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

?>