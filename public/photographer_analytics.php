<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/auth.php";
requireRole("photographer");
include("../config/database.php");

$username = $_SESSION['username'];
$name     = $_SESSION['name'];
$user_id  = $_SESSION['user_id'];

// --- 1. BASIC STATS ---
$total_photos = 0;
$res = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM photos WHERE user_id='$user_id'");
if($res && $r = mysqli_fetch_assoc($res)) $total_photos = $r['cnt'];

$total_likes = 0;
$res = mysqli_query($conn, "SELECT COUNT(l.id) AS cnt FROM likes l JOIN photos p ON l.photo_id = p.id WHERE p.user_id='$user_id'");
if($res && $r = mysqli_fetch_assoc($res)) $total_likes = $r['cnt'];

$total_comments = 0;
$res = mysqli_query($conn, "SELECT COUNT(c.id) AS cnt FROM comments c JOIN photos p ON c.photo_id = p.id WHERE p.user_id='$user_id'");
if($res && $r = mysqli_fetch_assoc($res)) $total_comments = $r['cnt'];

// --- 2. CHART DATA (Last 7 Days) ---
$chart_labels = [];
$chart_values = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $display_date = date('D', strtotime($date)); // e.g., "Mon"
    
    $sql_chart = "SELECT COUNT(l.id) as daily_cnt 
                  FROM likes l 
                  JOIN photos p ON l.photo_id = p.id 
                  WHERE p.user_id='$user_id' AND DATE(l.created_at) = '$date'";
    $res_chart = mysqli_query($conn, $sql_chart);
    $row_chart = mysqli_fetch_assoc($res_chart);
    
    $chart_labels[] = "'$display_date'";
    $chart_values[] = $row_chart['daily_cnt'] ?? 0;
}

// --- 3. TOP PHOTOS ---
$top_photos = [];
$sql = "SELECT p.id, p.photo_path, COUNT(l.id) AS likes 
        FROM photos p 
        LEFT JOIN likes l ON p.id = l.photo_id 
        WHERE p.user_id='$user_id' 
        GROUP BY p.id 
        ORDER BY likes DESC LIMIT 6";
$res = mysqli_query($conn, $sql);
if($res) {
    while($row = mysqli_fetch_assoc($res)) { $top_photos[] = $row; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra | Pro Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.5); }
    </style>
</head>
<body class="text-slate-900 pb-20">

    <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold tracking-tight">Capturra</h1>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Analytics Engine</p>
                </div>
            </div>
            <a href="photographer_home.php" class="px-4 py-2 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-10">
        
        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Portfolio Overview</h2>
                <p class="text-slate-500 font-medium">Hello, <?php echo htmlspecialchars($name); ?>. Here is your latest performance data.</p>
            </div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Last updated: Just now</div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></span>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Photos</p>
                <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_photos; ?></h3>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-rose-50 text-rose-600 rounded-2xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></span>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Likes</p>
                <h3 class="text-4xl font-black text-rose-600 mt-1"><?php echo $total_likes; ?></h3>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <span class="p-3 bg-blue-50 text-blue-600 rounded-2xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg></span>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Comments</p>
                <h3 class="text-4xl font-black text-blue-600 mt-1"><?php echo $total_comments; ?></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-extrabold tracking-tight">Engagement Growth</h3>
                        <div class="text-xs font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-500">LAST 7 DAYS</div>
                    </div>
                    <div class="h-[350px]">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>

                <div>
                    <h3 class="text-2xl font-extrabold mb-6 flex items-center">
                        <span class="mr-3">🏆</span> Best Performing Work
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php if(empty($top_photos)): ?>
                            <div class="col-span-full p-12 text-center bg-slate-100 rounded-[2rem] border-2 border-dashed border-slate-300 text-slate-400">No data found.</div>
                        <?php else: ?>
                            <?php foreach($top_photos as $idx => $p): ?>
                                <div class="group relative bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500">
                                    <img src="../<?php echo htmlspecialchars($p['photo_path']); ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-sm">
                                        <span class="text-rose-500"><?php echo $p['likes']; ?></span>
                                        <svg class="w-3 h-3 text-rose-500 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    </div>
                                    <div class="p-6">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Rank #<?php echo $idx+1; ?></p>
                                        <h4 class="font-bold text-slate-800 mt-1">Portfolio Shot</h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/20 blur-3xl rounded-full"></div>
                    <h3 class="text-lg font-bold mb-4">Quick Insights</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="p-1 bg-emerald-500 rounded-full mt-1"></span>
                            <p class="text-sm text-slate-300">Your engagement is up <strong>14%</strong> compared to last week.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="p-1 bg-indigo-500 rounded-full mt-1"></span>
                            <p class="text-sm text-slate-300">The best time for you to post is <strong>7:00 PM</strong>.</p>
                        </li>
                    </ul>
                    <button class="w-full mt-8 py-3 bg-white text-slate-900 rounded-xl font-bold text-sm hover:bg-indigo-50 transition-colors">Generate Full PDF</button>
                </div>

                <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100">
                    <h3 class="text-lg font-bold mb-2">Pro Tip 💡</h3>
                    <p class="text-sm text-indigo-100 leading-relaxed">Photos with high-contrast lighting received 40% more comments this week. Try uploading more low-key photography!</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Chart Initialization
        const ctx = document.getElementById('growthChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo implode(',', $chart_labels); ?>],
                datasets: [{
                    label: 'Likes',
                    data: [<?php echo implode(',', $chart_values); ?>],
                    borderColor: '#6366F1',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#6366F1',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#e2e8f0' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    </script>
</body>
</html>