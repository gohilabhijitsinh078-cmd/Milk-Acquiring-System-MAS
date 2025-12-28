<?php

// Database Configuration
$host = "localhost";
$user = "root";
$password = ""; // No space, empty string if there's no password
$database = "mas";

// Create Database Connection
$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
