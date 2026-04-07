<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit();
}

if(!isset($_POST['photo_id'])){
    header("Location: ../public/photographer_home.php");
    exit();
}

$user_id  = $_SESSION['user_id'];
$photo_id = intval($_POST['photo_id']);

// Check if already liked
$stmt = $conn->prepare("SELECT id FROM likes WHERE user_id=? AND photo_id=?");
$stmt->bind_param("ii", $user_id, $photo_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){

    // Unlike
    $stmt = $conn->prepare("DELETE FROM likes WHERE user_id=? AND photo_id=?");
    $stmt->bind_param("ii", $user_id, $photo_id);
    $stmt->execute();

    // Decrease like count
    $stmt = $conn->prepare("UPDATE photos SET likes = likes - 1 WHERE id=?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();

} else {

    // Like
    $stmt = $conn->prepare("INSERT INTO likes (user_id, photo_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $photo_id);
    $stmt->execute();

    // Increase like count
    $stmt = $conn->prepare("UPDATE photos SET likes = likes + 1 WHERE id=?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
}

header("Location: ../public/photographer_home.php");
exit();
?>