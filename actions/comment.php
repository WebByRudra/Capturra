<?php
session_start();
include("../config/database.php");

// Check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit();
}

$user_id  = $_SESSION['user_id'];
$photo_id = $_POST['photo_id'];
$comment  = mysqli_real_escape_string($conn, $_POST['comment']);

// Insert comment
$sql = "INSERT INTO comments (user_id, photo_id, comment)
        VALUES ('$user_id', '$photo_id', '$comment')";

mysqli_query($conn, $sql);

// Redirect back
header("Location: ../public/photographer_home.php");
exit();
?>
