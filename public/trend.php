<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/config/database.php";

/* 🔥 TIME FILTER */
$filter = $_GET['filter'] ?? 'today';

switch($filter){
    case 'today':
        $time_condition = "photos.upload_date >= CURDATE()";
        break;
    case 'week':
        $time_condition = "photos.upload_date >= NOW() - INTERVAL 7 DAY";
        break;
    case 'month':
        $time_condition = "photos.upload_date >= NOW() - INTERVAL 30 DAY";
        break;
    default:
        $time_condition = "1";
}

/* 🔥 SAFE CHECK FOR COMMENTS TABLE */
$checkComments = mysqli_query($conn, "SHOW TABLES LIKE 'comments'");
$comments_join = (mysqli_num_rows($checkComments) > 0)
    ? "LEFT JOIN comments ON comments.photo_id = photos.id"
    : "";

/* 🔥 TRENDING PHOTOS QUERY */
$sql = "
SELECT photos.*, users.username,
COUNT(DISTINCT likes.id) AS like_count,
" . ($comments_join ? "COUNT(DISTINCT comments.id)" : "0") . " AS comment_count

FROM photos
JOIN users ON photos.user_id = users.id
LEFT JOIN likes ON likes.photo_id = photos.id
$comments_join

WHERE $time_condition
GROUP BY photos.id
ORDER BY like_count DESC
LIMIT 12
";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Trending</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    background: radial-gradient(circle at top,#1a0a2e,#0f0f13);
    color:white;
    font-family:'Inter',sans-serif;
}

/* CARD */
.card{
    background:#16161f;
    border:1px solid #2a2a3e;
    border-radius:16px;
    overflow:hidden;
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
    border-color:#7c3aed;
    box-shadow:0 20px 50px rgba(124,58,237,0.3);
}

/* BADGE */
.badge{
    position:absolute;
    top:10px;
    left:10px;
    background:#7c3aed;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
}

/* FILTER BUTTON */
.filter-btn{
    padding:8px 16px;
    border-radius:20px;
    border:1px solid #2a2a3e;
    cursor:pointer;
}
.filter-btn.active{
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
}
</style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">

<!-- HEADER -->
<h1 class="text-3xl font-bold mb-6 text-center">
🔥 Trending
</h1>

<!-- FILTER -->
<div class="flex gap-3 justify-center mb-8">

<a href="?filter=today" class="filter-btn <?php if($filter=='today') echo 'active'; ?>">Today</a>

<a href="?filter=week" class="filter-btn <?php if($filter=='week') echo 'active'; ?>">This Week</a>

<a href="?filter=month" class="filter-btn <?php if($filter=='month') echo 'active'; ?>">This Month</a>

<a href="?filter=all" class="filter-btn <?php if($filter=='all') echo 'active'; ?>">All</a>

</div>

<!-- GRID -->
<div class="grid md:grid-cols-3 gap-6">

<?php if(mysqli_num_rows($result)>0): ?>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<div class="card">

<div class="relative">

<img src="/Capturra/uploads/<?php echo htmlspecialchars($row['photo_path']); ?>"
     class="w-full h-56 object-cover">

<span class="badge">🔥</span>

</div>

<div class="p-4">

<h2 class="font-semibold text-lg">
@<?php echo $row['username']; ?>
</h2>

<div class="flex justify-between mt-3 text-sm text-gray-400">

<span>❤️ <?php echo $row['like_count']; ?></span>

<span>💬 <?php echo $row['comment_count']; ?></span>

</div>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p class="text-center col-span-3 text-gray-400">
No trending data available
</p>

<?php endif; ?>

</div>

</div>

</body>
</html>