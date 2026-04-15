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

    // MOCK DATA FOR DEVELOPMENT (If database is empty, show 12 random photos)
    if (empty($photos)) {
        for ($i = 1; $i <= 12; $i++) {
            $photos[] = [
                'image_path' => "https://picsum.photos" . ($i + 10) . "/800/1000",
                'username' => "Creator_" . $i,
                'is_mock' => true
            ];
        }
    }

} catch (PDOException $e) {
    die("Database Connection Error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra | Explore Creativity</title>
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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            margin: 0; 
            padding: 0; 
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header { 
            text-align: center; 
            margin-bottom: 60px;
        }

        .header h1 { 
            font-size: clamp(2.5rem, 6vw, 4rem); 
            margin: 0; 
            background: linear-gradient(to right, #fff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .header p { 
            color: var(--text-muted); 
            font-size: 1.2rem;
            margin-top: 10px;
        }

        /* Modern Masonry-style Grid */
        .explore-grid {
            columns: 3 300px; /* Number of columns and min-width */
            column-gap: 20px;
        }

        .photo-card {
            break-inside: avoid;
            margin-bottom: 20px;
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.4s ease;
        }

        .photo-card:hover { 
            transform: scale(1.02);
            border-color: var(--purple);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .photo-card img {
            width: 100%;
            height: auto;
            display: block;
            transition: filter 0.3s ease;
        }

        /* Glassmorphism Overlay */
        .info-overlay {
            position: absolute;
            bottom: 0; 
            left: 0; 
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            backdrop-filter: blur(4px);
            padding: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .photo-card:hover .info-overlay {
            opacity: 1;
        }

        .username {
            font-weight: 500;
            font-size: 0.9rem;
            color: #fff;
            text-decoration: none;
        }

        .badge {
            font-size: 0.7rem;
            background: var(--purple);
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

    </style>
</head>
<body>

    <div class="container">
        <header class="header">
            <h1>Capturra</h1>
            <p>The digital home for world-class photography.</p>
        </header>

       <main class="explore-grid">
    <?php foreach ($photos as $index => $photo): ?>
        <article class="photo-card">
            <div class="image-container">
                <?php 
                    /** 
                     * RANDOM PHOTO LOGIC
                     * We use the index to ensure each "jon" post gets a different image.
                     * 'nature,photography' ensures the vibe matches your brand.
                     */
                    $randomPhotoUrl = "https://picsum.photos" . ($index + 100) . "/800/1000";
                ?>
                
                <img src="<?= $randomPhotoUrl ?>" 
                     alt="Work by <?= htmlspecialchars($photo['username'] ?? 'jon') ?>"
                     loading="lazy"
                     style="min-height: 300px; background: #111;">
            </div>
                                                                                                                                                        
            <div class="info-overlay">
                <span class="username">
                    @<?= htmlspecialchars($photo['username'] ?? 'jon') ?>
                </span>
            </div>
        </article>
    <?php endforeach; ?>
</main>


    </div>

</body>
</html>
