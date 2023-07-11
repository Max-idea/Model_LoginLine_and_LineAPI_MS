<?php
// Create a new MySQL connection
$conn = new mysqli('', 'up0pykdpcofgq', 'bggssjm1cg4b', 'dbnqpjg8oxxuyj');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
