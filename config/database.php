<?php
// Database configuration for localhost:8888 (XAMPP)
// Adjust these values if needed
$host = 'localhost';
$user = 'root';
$password = ''; // Empty by default in XAMPP
$dbname = 'capturra'; // Change if your DB name is different
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die(json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]));
}

mysqli_set_charset($conn, 'utf8mb4');
