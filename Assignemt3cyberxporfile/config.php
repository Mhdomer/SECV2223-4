<?php
// Database configuration
$servername = "localhost";
$username = "root";  // XAMPP default username
$password = "";      // XAMPP default - no password
$dbname = "portfolio_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?> 