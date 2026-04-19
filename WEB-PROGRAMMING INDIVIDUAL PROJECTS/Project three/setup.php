<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "hotel_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db($dbname);

// Create tables
$tables = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255)
    )",
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        menu_item VARCHAR(100),
        address TEXT,
        order_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        location VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($tables as $table) {
    if ($conn->query($table) === TRUE) {
        echo "Table created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Insert default user
$hashed_password = password_hash('admin', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, password) VALUES ('admin', '$hashed_password')";
if ($conn->query($sql) === TRUE) {
    echo "Default user inserted<br>";
} else {
    echo "Error inserting user: " . $conn->error . "<br>";
}

$conn->close();
?>