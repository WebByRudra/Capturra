<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if (!isset($_FILES["photo"]) || $_FILES["photo"]["error"] !== 0) {
    $_SESSION['error'] = "No file selected.";
    header("Location: ../public/photographer_home.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ABSOLUTE PATH FIX */
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Capturra/uploads/";

/* CREATE FOLDER IF NOT EXISTS */
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* FILE INFO */
$fileTmp  = $_FILES["photo"]["tmp_name"];
$fileSize = $_FILES["photo"]["size"];
$fileName = $_FILES["photo"]["name"];

$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

/* ALLOWED EXTENSIONS */
$allowed = ["jpg", "jpeg", "png", "webp"];

if (!in_array($fileExt, $allowed)) {
    $_SESSION['error'] = "Only JPG, PNG, WEBP allowed.";
    header("Location: ../public/photographer_home.php");
    exit();
}

/* MIME TYPE CHECK */
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $fileTmp);

$validMimeTypes = ["image/jpeg", "image/png", "image/webp"];
if (!in_array($mime, $validMimeTypes)) {
    $_SESSION['error'] = "Invalid file type.";
    header("Location: ../public/photographer_home.php");
    exit();
}

/* SIZE CHECK */
if ($fileSize > 5 * 1024 * 1024) {
    $_SESSION['error'] = "File too large. Max 5MB.";
    header("Location: ../public/photographer_home.php");
    exit();
}

/* UNIQUE NAME */
$uniqueName = uniqid() . "_" . time() . "." . $fileExt;

$targetPath = $uploadDir . $uniqueName;

/* MOVE FILE */
if (move_uploaded_file($fileTmp, $targetPath)) {

    /* DB PATH (IMPORTANT) */
    $dbPath = "uploads/" . $uniqueName;

    $stmt = $conn->prepare("INSERT INTO photos (user_id, photo_path) VALUES (?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $user_id, $dbPath);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Photo uploaded successfully!";
    } else {
        $_SESSION['error'] = "Database error.";
    }

} else {
    $_SESSION['error'] = "Upload failed.";
}

header("Location: ../public/photographer_home.php");
exit();