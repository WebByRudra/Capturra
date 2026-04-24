<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/auth.php";
include("../config/database.php");
$role = $_SESSION['role'] ?? 'client';

$category_label = 'Nature';
$sql = "SELECT photos.*, users.username, users.id AS photographer_id, users.name AS photographer_name,
        (SELECT COUNT(*) FROM likes WHERE likes.photo_id = photos.id) AS like_count
        FROM photos JOIN users ON photos.user_id = users.id
        WHERE photos.category = '$category_label'
        ORDER BY like_count DESC";
$result = mysqli_query($conn, $sql);
$total = $result ? mysqli_num_rows($result) : 0;

$photographers_sql = "SELECT users.id, users.name, users.username, COUNT(DISTINCT photos.id) AS photo_count,
        COUNT(likes.id) AS total_likes
        FROM users JOIN photos ON users.id = photos.user_id
        LEFT JOIN likes ON photos.id = likes.photo_id
        WHERE photos.category = '$category_label' AND users.role = 'photographer'
        GROUP BY users.id ORDER BY total_likes DESC LIMIT 5";
$photographers = mysqli_query($conn, $photographers_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Nature Photography</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f0f13; color: #e2e0f0; margin: 0; }
        .gradient-bg { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); }
        nav { background: #0d0d11; border-bottom: 1px solid #2a2a3e; }
        .photo-card { background:#16161f; border:1px solid #2a2a3e; border-radius:14px; overflow:hidden; transition:all .3s; break-inside:avoid; margin-bottom:1.2rem; }
        .photo-card:hover { border-color:#7c3aed; transform:translateY(-3px); box-shadow:0 12px 30px rgba(124,58,237,0.15); }
        .masonry { columns:3; column-gap:1.2rem; }
        @media(max-width:768px){.masonry{columns:2;}}
        @media(max-width:480px){.masonry{columns:1;}}
        .cap-card { background:#16161f; border:1px solid #2a2a3e; border-radius:12px; padding:18px; }
        .follow-btn { background:#1e1535; color:#a855f7; border:1px solid #3a2060; padding:5px 14px; border-radius:20px; font-size:12px; cursor:pointer; }
        .follow-btn:hover { background:#2d1f50; }
        .cat-pill { display:inline-block; padding:6px 16px; border-radius:20px; font-size:12px; font-weight:500; text-decoration:none; transition:all .2s; border:1px solid #2a2a3e; color:#a0a0c0; background:#16161f; }
        .cat-pill:hover, .cat-pill.active { background:#1e1535; border-color:#7c3aed; color:#a855f7; }
        .nav-link { color:#a0a0c0; font-size:13px; text-decoration:none; transition:color .2s; }
        .nav-link:hover { color:#a855f7; }
        #profileMenu { background:#16161f; border-color:#2a2a3e; }
        .notification-dot { animation:pulse 2s infinite; }
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
    </style>
</head>
<body class="min-h-screen">
<nav class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?php echo $role==='photographer'?'photographer_home.php':'client_home.php'; ?>" class="flex items-center gap-3" style="text-decoration:none;">
                <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center"><span class="text-white font-bold">C</span></div>
                <div><div style="font-size:17px;font-weight:700;color:#fff;">Capturra</div><div style="font-size:10px;color:#6b6b8a;margin-top:-2px;">Where Creators Shine</div></div>
            </a>
            <div class="hidden md:flex items-center gap-5">
                <a href="<?php echo $role==='photographer'?'photographer_home.php':'client_home.php'; ?>" class="nav-link">Home</a>
                <a href="explore.php"  class="nav-link" style="color:#a855f7;">Explore</a>
                <a href="trending.php" class="nav-link">Trending</a>
                <a href="creator.php"  class="nav-link">Creators</a>
                <a href="blogs.php"    class="nav-link">Blogs</a>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative cursor-pointer"><span class="text-xl">🔔</span><div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full notification-dot"></div></div>
                <div class="relative">
                    <button onclick="document.getElementById('profileMenu').classList.toggle('hidden')" class="w-8 h-8 rounded-full border-2 flex items-center justify-center" style="border-color:#7c3aed;background:#1e1535;"><span style="color:#a855f7;font-size:13px;">👤</span></button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-40 rounded-lg shadow-lg py-2" style="background:#16161f;border:1px solid #2a2a3e;">
                        <a href="<?php echo $role==='photographer'?'photographer_profile.php':'profile.php';?>" class="block px-4 py-2 text-sm hover:bg-purple-900" style="color:#e2e0f0;">Profile</a>
                        <a href="settings.php" class="block px-4 py-2 text-sm hover:bg-purple-900" style="color:#e2e0f0;">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<section style="background:radial-gradient(ellipse at 50% 0%,#1a0a2e 0%,#0f0f13 60%);padding:36px 24px 24px;text-align:center;">
    <div style="font-size:52px;margin-bottom:10px;">🌿</div>
    <h1 style="font-size:30px;font-weight:700;color:#fff;margin:0 0 6px;">Nature Photography</h1>
    <p style="color:#6b6b8a;font-size:13px;margin:0 0 16px;"><?php echo $total; ?> photos · Capturing the beauty of the natural world</p>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:8px;">
        <a href="portrait.php" class="cat-pill">👤 Portrait</a>
        <a href="nature.php" class="cat-pill active">🌿 Nature</a>
        <a href="fashion.php" class="cat-pill">👗 Fashion</a>
        <a href="wedding.php" class="cat-pill">💒 Wedding</a>
        <a href="street.php" class="cat-pill">🏙️ Street</a>
        <a href="events.php" class="cat-pill">🎭 Events</a>
    </div>
</section>

<div style="max-width:1200px;margin:0 auto;padding:24px 24px 60px;display:grid;grid-template-columns:1fr 260px;gap:24px;">
    <div>
        <?php if($total > 0): ?>
        <p style="color:#6b6b8a;font-size:12px;margin-bottom:16px;"><?php echo $total; ?> photos found</p>
        <div class="masonry">
        <?php while($row = mysqli_fetch_assoc($result)):
            $fn  = basename(str_replace('\\','/',$row['photo_path']));
            $src = "/Capturra/uploads/".$fn;
        ?>
        <div class="photo-card">
            <a href="photo.php?id=<?php echo $row['id'];?>">
                <img src="<?php echo htmlspecialchars($src);?>" style="width:100%;display:block;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div style="display:none;height:160px;background:#1a1a2e;align-items:center;justify-content:center;color:#6b6b8a;font-size:12px;">📷 Not found</div>
            </a>
            <div style="padding:12px;">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <a href="photographer_profile.php?id=<?php echo $row['photographer_id'];?>" style="display:flex;align-items:center;gap:7px;text-decoration:none;">
                        <div style="width:26px;height:26px;border-radius:50%;background:#1e1535;display:flex;align-items:center;justify-content:center;color:#a855f7;font-size:11px;flex-shrink:0;">👤</div>
                        <span style="font-size:12px;font-weight:600;color:#fff;" onmouseover="this.style.color='#a855f7'" onmouseout="this.style.color='#fff'"><?php echo htmlspecialchars($row['photographer_name']?:$row['username']);?></span>
                    </a>
                    <span style="font-size:12px;color:#6b6b8a;">❤️ <?php echo $row['like_count'];?></span>
                </div>
            </div>
        </div>
        <?php endwhile;?>
        </div>
        <?php else: ?>
        <div style="text-align:center;padding:60px 20px;">
            <div style="font-size:48px;margin-bottom:14px;">🌿</div>
            <h3 style="color:#fff;font-size:16px;margin-bottom:6px;">No Nature photos yet</h3>
            <p style="color:#6b6b8a;font-size:13px;">Be the first to upload a Nature photo!</p>
            <?php if($role==='photographer'): ?>
            <a href="photographer_home.php" style="display:inline-block;margin-top:14px;padding:9px 22px;border-radius:8px;font-size:13px;font-weight:600;color:#fff;background:linear-gradient(135deg,#7c3aed,#5b21b6);text-decoration:none;">Upload Now</a>
            <?php endif;?>
        </div>
        <?php endif;?>
    </div>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <div class="cap-card">
            <h3 style="font-size:13px;font-weight:600;color:#fff;margin:0 0 14px;padding-bottom:10px;border-bottom:1px solid #2a2a3e;">📸 Top Nature Photographers</h3>
            <?php if($photographers && mysqli_num_rows($photographers)>0):
                while($p=mysqli_fetch_assoc($photographers)):?>
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:12px;">
                <div style="width:32px;height:32px;border-radius:50%;background:#1e1535;display:flex;align-items:center;justify-content:center;color:#a855f7;font-size:12px;flex-shrink:0;">👤</div>
                <div style="flex:1;min-width:0;">
                    <a href="photographer_profile.php?id=<?php echo $p['id'];?>" style="font-size:12px;font-weight:600;color:#fff;text-decoration:none;" onmouseover="this.style.color='#a855f7'" onmouseout="this.style.color='#fff'"><?php echo htmlspecialchars($p['name']?:$p['username']);?></a>
                    <div style="font-size:10px;color:#6b6b8a;"><?php echo $p['photo_count'];?> photos · ❤️ <?php echo $p['total_likes'];?></div>
                </div>
                <button class="follow-btn">Follow</button>
            </div>
            <?php endwhile; else:?>
            <p style="color:#6b6b8a;font-size:12px;">No photographers yet</p>
            <?php endif;?>
        </div>

        <div class="cap-card">
            <h3 style="font-size:13px;font-weight:600;color:#fff;margin:0 0 12px;padding-bottom:10px;border-bottom:1px solid #2a2a3e;">💡 Nature Tips</h3>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="background:#1a0a2e;border:1px solid #3a2060;border-radius:8px;padding:10px;font-size:12px;color:#a0a0c0;">📸 Frame foreground elements to add depth</div>
                <div style="background:#1a0a2e;border:1px solid #3a2060;border-radius:8px;padding:10px;font-size:12px;color:#a0a0c0;">💡 Shoot during golden hour for warm tones</div>
                <div style="background:#1a0a2e;border:1px solid #3a2060;border-radius:8px;padding:10px;font-size:12px;color:#a0a0c0;">🌊 Use a tripod near water for smooth long exposures</div>
                <div style="background:#1a0a2e;border:1px solid #3a2060;border-radius:8px;padding:10px;font-size:12px;color:#a0a0c0;">🐦 Be patient — wait for the perfect wildlife moment</div>
            </div>
        </div>

        <div class="cap-card">
            <h3 style="font-size:13px;font-weight:600;color:#fff;margin:0 0 12px;">🗂️ Other Categories</h3>
            <div style="display:flex;flex-direction:column;gap:5px;">
                <a href="portrait.php" class="cat-pill" style="text-align:left;border-radius:8px;">👤 Portrait</a>
                <a href="fashion.php" class="cat-pill" style="text-align:left;border-radius:8px;">👗 Fashion</a>
                <a href="wedding.php" class="cat-pill" style="text-align:left;border-radius:8px;">💒 Wedding</a>
                <a href="street.php" class="cat-pill" style="text-align:left;border-radius:8px;">🏙️ Street</a>
                <a href="events.php" class="cat-pill" style="text-align:left;border-radius:8px;">🎭 Events</a>
            </div>
        </div>
    </div>
</div>
<footer style="border-top:1px solid #1e1a2e;padding:20px;text-align:center;"><p style="color:#6b6b8a;font-size:12px;">© 2025 Capturra. All rights reserved.</p></footer>
<script>
document.addEventListener('click', function(e) {
    const pm = document.getElementById('profileMenu');
    if(pm && !pm.classList.contains('hidden') && !pm.contains(e.target) && !e.target.closest('[onclick*="profileMenu"]'))
        pm.classList.add('hidden');
});
</script>
</body>
</html>