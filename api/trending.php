<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/config/database.php";

/* ✅ RETURN JSON */
header('Content-Type: application/json');

/* 🔥 FILTER */
$filter = $_GET['filter'] ?? 'week';

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

/* 🛡 SAFE COMMENTS TABLE CHECK */
$checkComments = mysqli_query($conn, "SHOW TABLES LIKE 'comments'");
$hasComments = $checkComments && mysqli_num_rows($checkComments) > 0;

/* Dynamic SQL parts */
$comments_join = $hasComments 
    ? "LEFT JOIN comments ON comments.photo_id = photos.id" 
    : "";

$comment_count = $hasComments 
    ? "COUNT(DISTINCT comments.id)" 
    : "0";

/* 🔥 MAIN QUERY */
$sql = "
SELECT 
    photos.id,
    photos.photo_path,
    photos.upload_date,
    users.username,

    COUNT(DISTINCT likes.id) AS like_count,
    $comment_count AS comment_count,

    (
        (COUNT(DISTINCT likes.id) * 2 + $comment_count * 3) /
        (TIMESTAMPDIFF(HOUR, photos.upload_date, NOW()) + 2)
    ) AS score

FROM photos
JOIN users ON photos.user_id = users.id
LEFT JOIN likes ON likes.photo_id = photos.id
$comments_join

WHERE $time_condition
GROUP BY photos.id
ORDER BY score DESC
LIMIT 6
";

/* ✅ EXECUTE */
$result = mysqli_query($conn, $sql);

/* ❌ ERROR HANDLE */
if(!$result){
    echo json_encode([
        "status" => false,
        "error" => mysqli_error($conn)
    ]);
    exit;
}

/* ✅ FETCH DATA */
$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

/* ✅ FINAL RESPONSE */
echo json_encode([
    "status" => true,
    "data" => $data
]); 