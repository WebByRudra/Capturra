<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = $_SERVER['DOCUMENT_ROOT'] . "/Capturra/";
require_once $base_path . "config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    die("All fields are required");
}

/* PREPARED STATEMENT */
$stmt = mysqli_prepare($conn, "SELECT id, first_name, username, password, role FROM users WHERE email = ?");
if (!$stmt) {
    die("Database error");
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("User not found");
}

$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

/* PASSWORD VERIFY */
if (!password_verify($password, $user['password'])) {
    die("Incorrect password");
}

/* 🔐 SECURITY FIX (VERY IMPORTANT) */
session_regenerate_id(true);

/* SESSION STORE */
$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];
$_SESSION['name']     = $user['first_name'];

/* REDIRECT */
if ($user['role'] === "photographer") {
    header("Location: /Capturra/public/photographer_home.php");
} else {
    header("Location: /Capturra/public/client_home.php");
}
exit();