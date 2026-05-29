<?php
$host = "127.0.0.1:3307"; // Using local IP and explicitly naming port 3306
$username = "root";
$password = "";
$database = "wealth_ledger"; 

// Establish connection
$conn = mysqli_connect($host, $username, $password, $database);

// Verify connection status
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>