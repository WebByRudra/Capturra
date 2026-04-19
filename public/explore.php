<?php
session_start();

// --- DATABASE CONFIGURATION ---
$host = "localhost";
$dbname = "capturra";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT p.*, u.username 
            FROM photos p 
            LEFT JOIN users u ON p.user_id = u.id 
            ORDER BY p.id DESC";
    
    $stmt = $pdo->query($sql);
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database Connection Error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Capturra | Explore</title>

<style>
:root { 
    --bg: #050a0a; 
    --card: #111d1d; 
    --purple: #a855f7; 
    --white: #ffffff; 
    --text-muted: #94a3b8;
}

body { 
    background-color: var(--bg); 
    color: var(--white); 
    font-family: 'Inter', sans-serif; 
    margin: 0; 
}

/* 🔥 NAVBAR */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;

    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);

    background: rgba(17, 29, 29, 0.6);
    border-bottom: 1px solid rgba(255,255,255,0.1);

    transition: all 0.3s ease;
}

.navbar.shrink {
    padding: 8px 0;
    background: rgba(17, 29, 29, 0.8);
}

/* Center content */
.nav-container {
    max-width: 1400px;
    margin: auto;
    padding: 15px 20px;
    text-align: center;
}

/* Logo */
.logo {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;

    background: linear-gradient(to right, #fff, #a855f7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Tagline */
.tagline {
    margin: 3px 0 0;
    font-size: 0.85rem;
    color: #94a3b8;
}

/* GRID */
.container {
    max-width: 1400px;
    margin: auto;
    padding: 30px 20px;
}

.explore-grid {
    columns: 3 300px;
    column-gap: 20px;
}

.photo-card {
    break-inside: avoid;
    margin-bottom: 20px;
    background: var(--card);
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    transition: 0.3s;
}

.photo-card:hover {
    transform: scale(1.02);
}

.photo-card img {
    width: 100%;
    display: block;
}

/* Overlay */
.info-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    opacity: 0;
    transition: 0.3s;
}

.photo-card:hover .info-overlay {
    opacity: 1;
}
</style>
</head>

<body>

<!-- 🔥 CLEAN NAVBAR -->
<header class="navbar" id="navbar">
    <div class="nav-container">
        <h1 class="logo">Capturra</h1>
        <p class="tagline">The digital home for world-class photography.</p>
    </div>
</header>

<!-- 🔥 CONTENT -->
<div class="container">
    <main class="explore-grid">

        <?php foreach ($photos as $photo): ?>

            <?php
            $imagePath = !empty($photo['photo_path']) 
                ? "/Capturra/uploads/" . $photo['photo_path']
                : "https://picsum.photos/800/1000";
            ?>

            <article class="photo-card">

                <img src="<?= $imagePath ?>" 
                     alt="Photo by <?= htmlspecialchars($photo['username'] ?? 'User') ?>"
                     loading="lazy">

                <div class="info-overlay">
                    @<?= htmlspecialchars($photo['username'] ?? 'User') ?>
                </div>

            </article>

        <?php endforeach; ?>

    </main>
</div>

<!-- 🔥 JS (Scroll Effect) -->
<script>
window.addEventListener("scroll", function() {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 50) {
        navbar.classList.add("shrink");
    } else {
        navbar.classList.remove("shrink");
    }
});
</script>

</body>
</html>