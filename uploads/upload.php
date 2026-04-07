<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit();
}

if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0){

    $user_id = $_SESSION['user_id'];

    $targetDir = "../uploads/";

    // File info
    $fileName = basename($_FILES["photo"]["name"]);
    $fileTmp  = $_FILES["photo"]["tmp_name"];
    $fileSize = $_FILES["photo"]["size"];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed extensions
    $allowed = ["jpg","jpeg","png","webp"];

    if(!in_array($fileExt, $allowed)){
        $_SESSION['error'] = "Only JPG, PNG, WEBP allowed.";
        header("Location: ../public/photographer_home.php");
        exit();
    }

    if($fileSize > 5 * 1024 * 1024){
        $_SESSION['error'] = "File too large. Max 5MB.";
        header("Location: ../public/photographer_home.php");
        exit();
    }

    // Unique filename
    $uniqueName = uniqid() . "_" . time() . "." . $fileExt;

    $targetFilePath = $targetDir . $uniqueName;

    if(move_uploaded_file($fileTmp, $targetFilePath)){

        // Save path for database
        $dbPath = "uploads/" . $uniqueName;

        $stmt = $conn->prepare("INSERT INTO photos (user_id, photo_path) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $dbPath);
        $stmt->execute();

        $_SESSION['success'] = "Photo uploaded successfully!";
        header("Location: ../public/photographer_home.php");
        exit();

    } else {

        $_SESSION['error'] = "Upload failed.";
        header("Location: ../public/photographer_home.php");
        exit();

    }

} else {

    $_SESSION['error'] = "No file selected.";
    header("Location: ../public/photographer_home.php");
    exit();

}
?>