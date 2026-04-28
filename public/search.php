<?php
header('Content-Type: application/json; charset=utf-8');
// Error display ON karein
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "DB Connection Failed: " . $conn->connect_error]));
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query === '') {
    echo json_encode(['users' => [], 'photos' => [], 'msg' => 'No query provided']);
    exit;
}

$searchTerm = "%$query%";
$users = [];
$photos = [];

// =========================
// 🔍 SEARCH USERS
// =========================
$usersSql = "SELECT first_name, last_name, username FROM users 
             WHERE first_name LIKE ? OR last_name LIKE ? OR username LIKE ? 
             LIMIT 6";

$stmt = $conn->prepare($usersSql);
if (!$stmt) {
    die(json_encode(["error" => "Users SQL Prepare Failed: " . $conn->error]));
}

$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$stmt->bind_result($f_name, $l_name, $u_name);

while ($stmt->fetch()) {
    $users[] = [
        'name' => trim($f_name . ' ' . $l_name),
        'username' => $u_name
    ];
}
$stmt->close();

// =========================
// 🔍 SEARCH PHOTOS
// =========================
// JOIN ke waqt user_id check karein
$photosSql = "SELECT p.id, p.image, p.description, u.username 
              FROM photos p
              JOIN users u ON p.user_id = u.id 
              WHERE p.description LIKE ? OR u.username LIKE ?
              ORDER BY p.upload_date DESC 
              LIMIT 6";

$stmt = $conn->prepare($photosSql);
if (!$stmt) {
    // Agar photos table fail ho rahi hai toh user data fir bhi dikhayenge
    $photo_error = $conn->error;
} else {
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $stmt->bind_result($p_id, $p_img, $p_desc, $p_user);

    while ($stmt->fetch()) {
        $photos[] = [
            'id' => $p_id,
            'image_path' => "/Capturra/" . $p_img,
            'username' => $p_user,
            'title' => !empty($p_desc) ? $p_desc : 'Untitled'
        ];
    }
    $stmt->close();
}

echo json_encode([
    'users' => $users,
    'photos' => $photos,
    'debug_query' => $query,
    'photo_sql_error' => isset($photo_error) ? $photo_error : 'none'
], JSON_UNESCAPED_SLASHES);