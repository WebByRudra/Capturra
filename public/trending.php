<?php
$conn = new mysqli("localhost", "root", "", "capturra");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT photos.*, COUNT(likes.id) AS total_likes 
        FROM photos 
        LEFT JOIN likes ON likes.photo_id = photos.id 
        GROUP BY photos.id 
        ORDER BY total_likes DESC 
        LIMIT 9";

$result = $conn->query($sql);

if(!$result){
    die("Query Failed: " . $conn->error);
}
?>

<h2 style="font-size:24px; font-weight:bold;">🔥 Trending</h2>

<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:15px; padding:20px;">

<?php while($row = $result->fetch_assoc()) { ?>

    <div style="background:white; padding:10px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
        
        <img src="/Capturra/uploads/<?php echo $row['photo_path']; ?>" 
     style="width:100%; height:200px; object-fit:cover; border-radius:10px;">
        <p style="margin-top:5px;">❤️ <?php echo $row['total_likes']; ?> Likes</p>

    </div>

<?php } ?>

</div>