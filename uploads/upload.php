<?php
session_start();
include("../config/database.php");

if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){

    // Check if user logged in
    if(!isset($_SESSION['user_id'])){
        header("Location: ../public/login.php"); 
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $targetDir = "../uploads/";
    $fileName = basename($_FILES["photo"]["name"]);
    $uniqueName = time() . "_" . $fileName;
    $targetFilePath = $targetDir . $uniqueName;

    // Move uploaded file
    if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){

        // Save relative path in database
        $dbPath = "uploads/" . $uniqueName;

        $sql = "INSERT INTO photos (user_id, photo_path) 
                VALUES ('$user_id', '$dbPath')";
        mysqli_query($conn, $sql);

        // Set success message
        $_SESSION['success'] = "Photo uploaded successfully!";

        // Redirect to photographer home
        header("Location: ../public/photographer_home.php");
        exit();
    } 
    else{
        $_SESSION['error'] = "Upload failed. Try again.";
        header("Location: ../public/photographer_home.php");
        exit();
    }

} else {
    $_SESSION['error'] = "No file selected.";
    header("Location: ../public/photographer_home.php");
    exit();
}
?>
