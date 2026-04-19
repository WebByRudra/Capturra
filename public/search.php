<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query === '') {
    echo json_encode([
        'users' => [],
        'photos' => []
    ]);
    exit;
}

$searchTerm = "%$query%";

$users = [];
$photos = [];


// =========================
// 🔍 SEARCH USERS (FIXED)
// =========================
$usersSql = "SELECT first_name, last_name, username 
             FROM users 
             WHERE first_name LIKE ? 
                OR last_name LIKE ? 
                OR username LIKE ?
             LIMIT 6";

$stmt = $conn->prepare($usersSql);

if ($stmt) {
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();

    // ❗ NO get_result() → use bind_result
    $stmt->bind_result($first_name, $last_name, $username);

    while ($stmt->fetch()) {
        $users[] = [
            'name' => trim($first_name . ' ' . $last_name),
            'username' => $username
        ];
    }

    $stmt->close();
}


// =========================
// 🔍 SEARCH PHOTOS (FIXED)
// =========================
$photosSql = "SELECT photos.id, photos.photo_path, photos.caption, users.username 
              FROM photos 
              JOIN users ON photos.user_id = users.id 
              WHERE photos.caption LIKE ? 
                 OR users.username LIKE ?
              ORDER BY photos.upload_date DESC 
              LIMIT 6";

$stmt = $conn->prepare($photosSql);

if ($stmt) {
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();

    $stmt->bind_result($id, $photo_path, $caption, $username);

    while ($stmt->fetch()) {
        $photos[] = [
            'id' => $id,
            'photo_path' => "/Capturra/uploads/" . $photo_path,
            'username' => $username,
            'caption' => !empty($caption) ? $caption : 'Photo'
        ];
    }

    $stmt->close();
}


// =========================
// ✅ FINAL OUTPUT
// =========================
echo json_encode([
    'users' => $users,
    'photos' => $photos
], JSON_UNESCAPED_SLASHES);