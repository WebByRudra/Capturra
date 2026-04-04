<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit();
}

$user_id  = $_SESSION['user_id'];
$photo_id = $_POST['photo_id'];

// Check if already liked
$check = mysqli_query($conn, 
    "SELECT * FROM likes WHERE user_id='$user_id' AND photo_id='$photo_id'"
);

if(mysqli_num_rows($check) > 0){
    // Unlike
    mysqli_query($conn, 
        "DELETE FROM likes WHERE user_id='$user_id' AND photo_id='$photo_id'"
    );
} else {
    // Like
    mysqli_query($conn, 
        "INSERT INTO likes (user_id, photo_id) VALUES ('$user_id','$photo_id')"
    );
}

header("Location: ../public/photographer_home.php");
exit();
?>
