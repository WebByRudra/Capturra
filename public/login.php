<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = $_SERVER['DOCUMENT_ROOT'] . "/Capturra/";
require_once $base_path . "config/database.php";
require_once $base_path . "includes/response.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response(false, "Invalid request method");
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($email) || empty($password)) {
    response(false, "All fields are required");
}

/* SELECT ALL REQUIRED FIELDS */
$stmt = mysqli_prepare($conn, "SELECT id, first_name, username, password, role FROM users WHERE email = ?");
if (!$stmt) {
    response(false, "Database error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    response(false, "User not found");
}

$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!password_verify($password, $user['password'])) {
    response(false, "Incorrect password");
}

/* SESSION */
$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];
$_SESSION['name']     = $user['first_name'];

// Direct PHP Redirect (HTML Form ke liye)
if ($user['role'] === "photographer") {
    header("Location: /Capturra/public/photographer_home.php");
} else {
    header("Location: /Capturra/public/client_home.php");
}
exit();
