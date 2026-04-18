<?php
session_start();

$base_path = $_SERVER['DOCUMENT_ROOT'] . "/Capturra/";
require_once $base_path . "config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$password = trim($_POST['password']);
$role     = trim($_POST['role']);

if (!$username || !$email || !$password || !$role) {
    die("All fields required");
}

/* HASH PASSWORD */
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/* INSERT USER */
$stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);

if (!mysqli_stmt_execute($stmt)) {
    die("Registration failed");
}

/* GET USER ID */
$user_id = mysqli_insert_id($conn);

/* SESSION */
$_SESSION['user_id'] = $user_id;
$_SESSION['username'] = $username;
$_SESSION['role'] = $role;

/* REDIRECT */
if ($role === "photographer") {
    header("Location: /Capturra/public/photographer_home.php");
} else {
    header("Location: /Capturra/public/client_home.php");
}
exit();