<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/auth.php";
requireRole("photographer");
include("../config/database.php");

$username = $_SESSION['username'];
$name     = $_SESSION['name'];
$user_id  = $_SESSION['user_id'];

/**
 * Helper function to prevent "Fatal error: Uncaught TypeError"
 * It checks if query is successful before fetching.
 */
function safeFetchCount($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['c'];
    }
    return 0; // Return 0 if table missing or query fails
}

// Total photos
$total_photos = safeFetchCount($conn, "SELECT COUNT(*) AS c FROM photos WHERE user_id='$user_id'");

// Total likes
$total_likes = safeFetchCount($conn, "SELECT COUNT(likes.id) AS c FROM likes JOIN photos ON likes.photo_id = photos.id WHERE photos.user_id='$user_id'");

// Total comments (Safe even if table doesn't exist)
$total_comments = safeFetchCount($conn, "SELECT COUNT(comments.id) AS c FROM comments JOIN photos ON comments.photo_id = photos.id WHERE photos.user_id='$user_id'");

// Followers
$followers = safeFetchCount($conn, "SELECT COUNT(*) AS c FROM follows WHERE following_id='$user_id'");

// Top 5 photos by likes
$top_photos_sql = "SELECT photos.*, COUNT(likes.id) AS like_count
                   FROM photos LEFT JOIN likes ON photos.id = likes.photo_id
                   WHERE photos.user_id='$user_id'
                   GROUP BY photos.id ORDER BY like_count DESC LIMIT 5";
$top_photos = mysqli_query($conn, $top_photos_sql);

// Recent uploads (last 7 days)
$recent_sql = "SELECT DATE(upload_date) AS day, COUNT(*) AS uploads
               FROM photos WHERE user_id='$user_id'
               AND upload_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
               GROUP BY DATE(upload_date) ORDER BY day ASC";
$recent_result = mysqli_query($conn, $recent_sql);

$chart_labels = []; $chart_data = [];
if ($recent_result) {
    while ($r = mysqli_fetch_assoc($recent_result)) {
        $chart_labels[] = date('d M', strtotime($r['day']));
        $chart_data[]   = (int)$r['uploads'];
    }
}

// Likes per day last 7 days
$likes_sql = "SELECT DATE(likes.created_at) AS day, COUNT(*) AS cnt
              FROM likes JOIN photos ON likes.photo_id = photos.id
              WHERE photos.user_id='$user_id'
              AND likes.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
              GROUP BY DATE(likes.created_at) ORDER BY day ASC";
$likes_chart_result = mysqli_query($conn, $likes_sql);
$likes_labels = []; $likes_data = [];
if ($likes_chart_result) {
    while ($r = mysqli_fetch_assoc($likes_chart_result)) {
        $likes_labels[] = date('d M', strtotime($r['day']));
        $likes_data[]   = (int)$r['cnt'];
    }
}

// Rank logic (Using RANK() if supported, else fallback)
$rank_sql = "SELECT u.id, COUNT(l.id) AS total_likes,
             RANK() OVER (ORDER BY COUNT(l.id) DESC) AS rnk
             FROM users u
             LEFT JOIN photos p ON u.id = p.user_id
             LEFT JOIN likes l ON p.id = l.photo_id
             WHERE u.role = 'photographer'
             GROUP BY u.id";
$rank_result = mysqli_query($conn, $rank_sql);
$my_rank = '—';
if ($rank_result) {
    while ($r = mysqli_fetch_assoc($rank_result)) {
        if ($r['id'] == $user_id) { $my_rank = '#' . $r['rnk']; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f0f13; color: #e2e0f0; }
        .gradient-bg { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); }
        nav { background: #0d0d11; border-bottom: 1px solid #2a2a3e; }
        .stat-card {
            background: #16161f; border: 1px solid #2a2a3e; border-radius: 14px;
            padding: 24px; transition: all .3s;
        }
        .stat-card:hover { border-color: #7c3aed; box-shadow: 0 8px 24px rgba(124,58,237,0.12); }
        .cap-card { background: #16161f; border: 1px solid #2a2a3e; border-radius: 14px; padding: 24px; }
        .photo-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid #1e1e2e; }
        .photo-row:last-child { border-bottom: none; }
        .progress-bar-bg { background: #1e1e2e; border-radius: 20px; height: 6px; overflow: hidden; }
        .progress-bar     { background: linear-gradient(90deg, #7c3aed, #a855f7); height: 100%; border-radius: 20px; }
        .trend-up   { color: #4ade80; }
        footer { background: #080810; border-color: #1e1a2e; }
    </style>
</head>
<body class="min-h-screen">



<div style="max-width:1100px; margin:0 auto; padding:36px 24px 60px;">

    <div style="margin-bottom:28px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#fff; margin:0 0 4px;">📊 Analytics</h1>
            <p style="font-size:13px; color:#6b6b8a; margin:0;">Your performance overview, <?php echo htmlspecialchars($name); ?></p>
        </div>
        <div style="font-size:13px; color:#6b6b8a;">Last updated: <?php echo date('d M Y, H:i'); ?></div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div class="stat-card">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#1e1535;display:flex;align-items:center;justify-content:center;font-size:18px;">📸</div>
            </div>
            <div style="font-size:28px; font-weight:700; color:#fff;"><?php echo $total_photos; ?></div>
            <div style="font-size:12px; color:#6b6b8a;">Total Photos</div>
        </div>

        <div class="stat-card">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#2a1010;display:flex;align-items:center;justify-content:center;font-size:18px;">❤️</div>
            </div>
            <div style="font-size:28px; font-weight:700; color:#fff;"><?php echo number_format($total_likes); ?></div>
            <div style="font-size:12px; color:#6b6b8a;">Total Likes</div>
        </div>

        <div class="stat-card">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#0f1e35;display:flex;align-items:center;justify-content:center;font-size:18px;">💬</div>
            </div>
            <div style="font-size:28px; font-weight:700; color:#fff;"><?php echo number_format($total_comments); ?></div>
            <div style="font-size:12px; color:#6b6b8a;">Total Comments</div>
        </div>

        <div class="stat-card">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#0f2a1a;display:flex;align-items:center;justify-content:center;font-size:18px;">👥</div>
                <span style="font-size:18px; font-weight:700; color:#a855f7;"><?php echo $my_rank; ?></span>
            </div>
            <div style="font-size:28px; font-weight:700; color:#fff;"><?php echo number_format($followers); ?></div>
            <div style="font-size:12px; color:#6b6b8a;">Followers</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px;">
        <div class="cap-card">
            <h3 style="font-size:14px; font-weight:600; color:#fff; margin-bottom:18px;">📸 Uploads</h3>
            <canvas id="uploadsChart" height="180"></canvas>
        </div>
        <div class="cap-card">
            <h3 style="font-size:14px; font-weight:600; color:#fff; margin-bottom:18px;">❤️ Likes</h3>
            <canvas id="likesChart" height="180"></canvas>
        </div>
    </div>

</div>

<script>
Chart.defaults.color = '#6b6b8a';
Chart.defaults.borderColor = '#2a2a3e';

// Uploads Chart
new Chart(document.getElementById('uploadsChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chart_labels ?: ['No Data']); ?>,
        datasets: [{
            label: 'Uploads',
            data: <?php echo json_encode($chart_data ?: [0]); ?>,
            backgroundColor: 'rgba(124,58,237,0.6)',
            borderRadius: 6,
        }]
    }
});

// Likes Chart
new Chart(document.getElementById('likesChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($likes_labels ?: ['No Data']); ?>,
        datasets: [{
            label: 'Likes',
            data: <?php echo json_encode($likes_data ?: [0]); ?>,
            borderColor: '#a855f7',
            fill: true,
            tension: 0.4
        }]
    }
});
</script>
</body>
</html>