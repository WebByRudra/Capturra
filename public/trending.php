<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/auth.php";
include("../config/database.php");

$username = $_SESSION['username'] ?? '';
$name     = $_SESSION['name'] ?? '';
$user_id  = $_SESSION['user_id'] ?? 0;
$role     = $_SESSION['role'] ?? 'client';

// Trending Photos — top 3 by likes
$photos_sql = "SELECT photos.*, users.username, users.id AS photographer_id, users.name AS photographer_name,
               COUNT(likes.id) AS like_count,
               (SELECT COUNT(*) FROM comments WHERE comments.photo_id = photos.id) AS comment_count
               FROM photos
               JOIN users ON photos.user_id = users.id
               LEFT JOIN likes ON likes.photo_id = photos.id
               GROUP BY photos.id
               ORDER BY like_count DESC
               LIMIT 3";
$photos_result = mysqli_query($conn, $photos_sql);

// Trending Photographers — top 3 by total likes on their photos
$photographers_sql = "SELECT users.id, users.name, users.username,
                      COUNT(DISTINCT photos.id) AS photo_count,
                      COUNT(likes.id) AS total_likes,
                      COUNT(DISTINCT follows.follower_id) AS follower_count
                      FROM users
                      LEFT JOIN photos  ON users.id = photos.user_id
                      LEFT JOIN likes   ON photos.id = likes.photo_id
                      LEFT JOIN follows ON users.id = follows.following_id
                      WHERE users.role = 'photographer'
                      GROUP BY users.id
                      ORDER BY total_likes DESC
                      LIMIT 3";
$photographers_result = mysqli_query($conn, $photographers_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Trending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f0f13; color: #e2e0f0; }
        .gradient-bg { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); }
        nav { background: #0d0d11; border-bottom: 1px solid #2a2a3e; }

        .photo-card {
            background: #16161f; border: 1px solid #2a2a3e; border-radius: 16px; overflow: hidden;
            transition: all 0.3s ease;
        }
        .photo-card:hover { border-color: #7c3aed; transform: translateY(-4px); box-shadow: 0 16px 40px rgba(124,58,237,0.2); }

        .photographer-card {
            background: #16161f; border: 1px solid #2a2a3e; border-radius: 16px; padding: 24px;
            transition: all 0.3s ease; text-align: center;
        }
        .photographer-card:hover { border-color: #7c3aed; transform: translateY(-4px); box-shadow: 0 16px 40px rgba(124,58,237,0.2); }

        .rank-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 50%;
            font-size: 12px; font-weight: 700;
        }
        .rank-1 { background: #2a1a0a; color: #fbbf24; border: 1px solid #78350f; }
        .rank-2 { background: #1a1a2e; color: #94a3b8; border: 1px solid #334155; }
        .rank-3 { background: #1a1010; color: #cd7c3a; border: 1px solid #7c2d12; }

        .follow-btn { background: #1e1535; color: #a855f7; border: 1px solid #3a2060; padding: 7px 18px; border-radius: 20px; font-size: 13px; cursor: pointer; transition: all .2s; }
        .follow-btn:hover { background: #2d1f50; }
        .following-btn { background: #1a2e1a; color: #4ade80; border: 1px solid #1a4a1a; padding: 7px 18px; border-radius: 20px; font-size: 13px; cursor: pointer; }

        .tab-btn { padding: 10px 28px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s; border: 1px solid #2a2a3e; background: #16161f; color: #a0a0c0; }
        .tab-btn.active { background: linear-gradient(135deg,#7c3aed,#5b21b6); color: #fff; border-color: #7c3aed; }

        .notification-dot { animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
        #profileMenu { background: #16161f; border-color: #2a2a3e; }

        .stat-pill { background: #1e1535; color: #a855f7; border: 1px solid #3a2060; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

        .fire-badge { background: linear-gradient(135deg,#7c1d1d,#dc2626); color:#fff; font-size:10px; padding:3px 10px; border-radius:20px; font-weight:700; }
    </style>
</head>
<body class="min-h-screen">

<!-- Hero -->
<section style="background: radial-gradient(ellipse at 50% 0%, #1a0a2e 0%, #0f0f13 60%); padding:40px 24px 30px; text-align:center;">
    <div style="display:inline-block; margin-bottom:12px; padding:4px 14px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:1.5px; text-transform:uppercase; background:#1e1535; color:#a855f7; border:1px solid #3a2060;">This Week</div>
    <h1 style="font-size:32px; font-weight:700; color:#fff; margin:0 0 8px;">🔥 Trending on Capturra</h1>
    <p style="color:#6b6b8a; font-size:14px; margin:0;">Most liked photos and top photographers this week</p>
</section>

<div style="max-width:1100px; margin:0 auto; padding:30px 24px 60px;">

    <!-- Tab Buttons -->
    <div style="display:flex; gap:12px; margin-bottom:32px;">
        <button class="tab-btn active" onclick="showTab('photos', this)">📸 Trending Photos</button>
        <button class="tab-btn" onclick="showTab('photographers', this)">👤 Trending Photographers</button>
    </div>

    <!-- ── TRENDING PHOTOS ── -->
    <div id="tab-photos">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h2 style="font-size:20px; font-weight:700; color:#fff; margin:0;">Top 3 Most Liked Photos</h2>
            <a href="explore.php" style="font-size:13px; color:#a855f7; text-decoration:none;">View All →</a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
        <?php
        $rank = 1;
        if($photos_result && mysqli_num_rows($photos_result) > 0):
            while($photo = mysqli_fetch_assoc($photos_result)):
                $filename = basename(str_replace('\\','/',$photo['photo_path']));
                $img_src  = "/Capturra/uploads/" . $filename;
        ?>
        <div class="photo-card">
            <!-- Rank + Image -->
            <div style="position:relative;">
                <a href="photo.php?id=<?php echo $photo['id']; ?>">
                    <img src="<?php echo htmlspecialchars($img_src); ?>"
                         style="width:100%; height:220px; object-fit:cover; display:block;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none; height:220px; background:#1a1a2e; align-items:center; justify-content:center; color:#6b6b8a; font-size:13px;">📷 Not found</div>
                </a>
                <!-- Rank badge -->
                <div style="position:absolute; top:10px; left:10px;">
                    <span class="rank-badge rank-<?php echo $rank; ?>">#<?php echo $rank; ?></span>
                </div>
                <!-- Fire badge -->
                <div style="position:absolute; top:10px; right:10px;">
                    <span class="fire-badge">🔥 Hot</span>
                </div>
            </div>

            <div style="padding:16px;">
                <!-- Like count big -->
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:12px;">
                    <span style="font-size:20px;">❤️</span>
                    <span style="font-size:22px; font-weight:700; color:#fff;"><?php echo $photo['like_count']; ?></span>
                    <span style="font-size:12px; color:#6b6b8a;">likes</span>
                </div>

                <!-- Photographer -->
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <a href="photographer_profile.php?id=<?php echo $photo['photographer_id']; ?>" style="display:flex; align-items:center; gap:8px; text-decoration:none;">
                        <div style="width:32px;height:32px;border-radius:50%;background:#1e1535;display:flex;align-items:center;justify-content:center;color:#a855f7;font-size:13px;flex-shrink:0;">👤</div>
                        <div>
                            <div style="font-size:13px; font-weight:600; color:#fff;" onmouseover="this.style.color='#a855f7'" onmouseout="this.style.color='#fff'">
                                <?php echo htmlspecialchars($photo['photographer_name'] ?: $photo['username']); ?>
                            </div>
                            <div style="font-size:11px; color:#6b6b8a;">@<?php echo htmlspecialchars($photo['username']); ?></div>
                        </div>
                    </a>
                    <div style="display:flex; gap:10px; font-size:12px; color:#6b6b8a;">
                        <span>💬 <?php echo $photo['comment_count']; ?></span>
                    </div>
                </div>

                <?php if(!empty($photo['description'])): ?>
                <p style="font-size:12px; color:#a0a0c0; margin-top:10px; line-height:1.5;"><?php echo htmlspecialchars(mb_strimwidth($photo['description'],0,70,'...')); ?></p>
                <?php endif; ?>

                <div style="margin-top:12px; font-size:11px; color:#6b6b8a;">
                    📅 <?php echo date('d M Y', strtotime($photo['upload_date'])); ?>
                </div>
            </div>
        </div>
        <?php $rank++; endwhile;
        else: ?>
        <div style="grid-column:span 3; text-align:center; padding:60px 20px;">
            <div style="font-size:48px; margin-bottom:16px;">📷</div>
            <h3 style="color:#fff; font-size:18px; margin-bottom:8px;">No trending photos yet</h3>
            <p style="color:#6b6b8a;">Upload photos and get likes to appear here!</p>
        </div>
        <?php endif; ?>
        </div>
    </div>

    <!-- ── TRENDING PHOTOGRAPHERS ── -->
    <div id="tab-photographers" style="display:none;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h2 style="font-size:20px; font-weight:700; color:#fff; margin:0;">Top 3 Photographers</h2>
            <a href="creator.php" style="font-size:13px; color:#a855f7; text-decoration:none;">View All →</a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
        <?php
        $rank = 1;
        if($photographers_result && mysqli_num_rows($photographers_result) > 0):
            while($photographer = mysqli_fetch_assoc($photographers_result)):
        ?>
        <div class="photographer-card">
            <!-- Rank -->
            <div style="display:flex; justify-content:center; margin-bottom:16px;">
                <span class="rank-badge rank-<?php echo $rank; ?>" style="width:36px; height:36px; font-size:14px;">#<?php echo $rank; ?></span>
            </div>

            <!-- Avatar -->
            <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#a855f7); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:26px; font-weight:700; color:#fff; border:3px solid #3a2060;">
                <?php echo strtoupper(substr($photographer['name'] ?: $photographer['username'], 0, 1)); ?>
            </div>

            <!-- Name -->
            <a href="photographer_profile.php?id=<?php echo $photographer['id']; ?>" style="text-decoration:none;">
                <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0 0 4px;" onmouseover="this.style.color='#a855f7'" onmouseout="this.style.color='#fff'">
                    <?php echo htmlspecialchars($photographer['name'] ?: $photographer['username']); ?>
                </h3>
            </a>
            <p style="font-size:12px; color:#6b6b8a; margin:0 0 16px;">@<?php echo htmlspecialchars($photographer['username']); ?></p>

            <!-- Stats -->
            <div style="display:flex; justify-content:center; gap:10px; margin-bottom:16px; flex-wrap:wrap;">
                <span class="stat-pill">❤️ <?php echo $photographer['total_likes']; ?> likes</span>
                <span class="stat-pill">📸 <?php echo $photographer['photo_count']; ?> photos</span>
                <span class="stat-pill">👥 <?php echo $photographer['follower_count']; ?> followers</span>
            </div>

            <!-- Actions -->
            <div style="display:flex; gap:10px; justify-content:center;">
                <button class="follow-btn" onclick="followCreator(this, <?php echo $photographer['id']; ?>)">Follow</button>
                <a href="photographer_profile.php?id=<?php echo $photographer['id']; ?>" style="display:inline-block; padding:7px 18px; border-radius:20px; font-size:13px; font-weight:600; text-decoration:none; border:1px solid #3a3a5c; color:#e2e0f0; background:#0f0f13;">View Profile</a>
            </div>
        </div>
        <?php $rank++; endwhile;
        else: ?>
        <div style="grid-column:span 3; text-align:center; padding:60px 20px;">
            <div style="font-size:48px; margin-bottom:16px;">👤</div>
            <h3 style="color:#fff; font-size:18px; margin-bottom:8px;">No trending photographers yet</h3>
            <p style="color:#6b6b8a;">Upload photos and build your audience to appear here!</p>
        </div>
        <?php endif; ?>
        </div>
    </div>

</div>

<!-- Footer -->
<footer style="border-top:1px solid #1e1a2e; padding:32px 24px; text-align:center;">
    <p style="color:#6b6b8a; font-size:13px;">© 2025 Capturra. All rights reserved. Where Creators Shine ✨</p>
</footer>

<script>
function showTab(tab, btn) {
    document.getElementById('tab-photos').style.display        = tab === 'photos' ? 'block' : 'none';
    document.getElementById('tab-photographers').style.display = tab === 'photographers' ? 'block' : 'none';
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function followCreator(btn, id) {
    if (btn.textContent.trim() === 'Follow') {
        btn.textContent = 'Following';
        btn.className = 'following-btn';
    } else {
        btn.textContent = 'Follow';
        btn.className = 'follow-btn';
    }
}

function toggleProfileMenu() { document.getElementById('profileMenu').classList.toggle('hidden'); }
function toggleNotifications() { alert('Notifications 🔔'); }

document.addEventListener('click', function(e) {
    const pm = document.getElementById('profileMenu');
    if (pm && !pm.classList.contains('hidden') && !pm.contains(e.target) && !e.target.closest('[onclick*="toggleProfileMenu"]'))
        pm.classList.add('hidden');
});

function logout() {
    fetch("/Capturra/api/auth/logout.php")
        .then(res => res.json())
        .then(data => { if(data.status) window.location.href="/Capturra/public/login.html"; });
}
</script>
</body>
</html>