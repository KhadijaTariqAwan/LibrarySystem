<?php
$conn = new mysqli("localhost", "root", "", "khadijas_library_complete");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
