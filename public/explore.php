<?php
session_start();
$host = "localhost"; $dbname = "capturra"; $username = "root"; $password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch photos + link to users for the username
    // IMPORTANT: Ensure 'image_path' matches your actual database column name!
    $sql = "SELECT p.*, u.username FROM photos p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.id DESC";
    $stmt = $pdo->query($sql);
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { 
    die("Connection failed: " . $e->getMessage()); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Capturra | Explore Creativity</title>
    <style>
        :root { --bg: #061111; --card: #122323; --purple: #8a2be2; --white: #ffffff; }
        body { background-color: var(--bg); color: var(--white); font-family: 'Segoe UI', sans-serif; margin: 0; padding: 40px; }
        .header { text-align: center; margin-bottom: 50px; }
        .header h1 { font-size: 3.5rem; margin-bottom: 5px; }
        .header p { color: #888; margin-bottom: 40px; }

        /* Modern Grid Layout */
        .explore-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .photo-card {
            background: var(--card);
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        .photo-card:hover { transform: scale(1.02); border-color: var(--purple); }

        .photo-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }

        .info-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Explore Creativity</h1>
        <p>Discover the world through the lens of our community.</p>
    </div>

    <div class="explore-grid">
        <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): ?>
                <div class="photo-card">
                    <?php 
                        // This line prevents the "Undefined array key" error
                        $img = isset($photo['image_path']) ? $photo['image_path'] : 'default.jpg'; 
                    ?>
                    <img src="../uploads/<?= htmlspecialchars($img) ?>" alt="Creative Work">
                    
                    <div class="info-overlay">
                        <b>@<?= htmlspecialchars($photo['username']) ?></b>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; width:100%; color:#555;">No photos found in the database.</p>
        <?php endif; ?>
    </div>

</body>
</html>
