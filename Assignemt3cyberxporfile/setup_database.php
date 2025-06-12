<?php
// Database setup script - Run this once to create the database and tables

$servername = "localhost";
$username = "root";  // Change this to your MySQL username
$password = "";      // Change this to your MySQL password

// Create connection without selecting database
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS portfolio_db";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("portfolio_db");

// Create contact_messages table
$sql = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'contact_messages' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Create guestbook table
$sql = "CREATE TABLE IF NOT EXISTS guestbook (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    message TEXT NOT NULL,
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'guestbook' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
echo "<br>Database setup complete! You can now use the contact form and guestbook.";
?> 