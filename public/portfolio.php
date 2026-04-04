<?php
include("../config/database.php");

// 1. Get ID from URL
$p_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// 2. Fetch User (Fixed Query)
$user_query = mysqli_query($conn, "SELECT username, email FROM users WHERE id = '$p_id'");
$user_data = mysqli_fetch_assoc($user_query);

if (!$user_data) {
    // This will trigger if the ID is still 0 or doesn't exist
    die("Photographer not found. ID received: " . $p_id);
}

// 3. Set Display Name
$photographer_name = htmlspecialchars($user_data['username']); 
$photographer_email = htmlspecialchars($user_data['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $full_name; ?> | Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --bg-color: #ffffff; --text-color: #18181b; }
        .dark-mode { --bg-color: #09090b; --text-color: #fafafa; }
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', sans-serif; transition: all 0.5s ease; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        .masonry { column-count: 1; column-gap: 1.5rem; }
        @media (min-width: 768px) { .masonry { column-count: 2; } }
        @media (min-width: 1024px) { .masonry { column-count: 3; } }
        .masonry-item { break-inside: avoid; margin-bottom: 1.5rem; }
        .loading { overflow: hidden; }
    </style>
</head>
<body>

    <div id="loader" class="fixed inset-0 z-[100] flex items-center justify-center bg-white transition-opacity duration-700">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 border-4 border-zinc-100 border-t-zinc-900 rounded-full animate-spin"></div>
            <p class="mt-4 text-[10px] uppercase tracking-[0.5em] text-zinc-400 animate-pulse">Developing Film...</p>
        </div>
    </div>

    <nav class="p-8 flex justify-between items-center sticky top-0 bg-inherit z-40">
        <span class="text-[10px] uppercase tracking-[0.4em] font-bold opacity-60">Capturra / Portfolio</span>
        <div class="flex items-center space-x-6">
            <button onclick="document.body.classList.toggle('dark-mode')" class="text-[10px] uppercase tracking-widest font-bold">🌓 Mode</button>
            <a href="photographer_analytics.php" class="text-[10px] uppercase tracking-widest font-bold hover:line-through">Back</a>
        </div>
    </nav>

    <header class="max-w-5xl mx-auto px-6 pt-24 pb-32 text-center">
        <div class="mb-10 inline-block rounded-full p-1 border border-zinc-200">
            <div class="w-24 h-24 bg-zinc-100 rounded-full flex items-center justify-center text-3xl overflow-hidden">
                👤
            </div>
        </div>
        <h1 class="text-6xl md:text-8xl mb-8 italic tracking-tighter"><?php echo $full_name; ?></h1>
        <p class="text-zinc-500 dark:text-zinc-400 max-w-xl mx-auto leading-relaxed font-light text-xl">
            <?php echo $bio; ?>
        </p>
    </header>

    <section class="max-w-[1600px] mx-auto px-6 pb-32">
        <div class="masonry">
            <?php while($row = mysqli_fetch_assoc($photos_query)): ?>
                <div class="masonry-item group overflow-hidden bg-zinc-100 rounded-lg">
                    <img src="../<?php echo htmlspecialchars($row['photo_path']); ?>" 
                         class="w-full h-auto grayscale hover:grayscale-0 transition-all duration-1000 ease-in-out transform group-hover:scale-105"
                         onload="this.style.opacity='1'">
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-32 border-t border-zinc-100 dark:border-zinc-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20">
            <div>
                <h2 class="text-4xl italic mb-6">Work with Me</h2>
                <p class="text-zinc-500 font-light mb-8">Ready to bring your vision to life? Drop a message below.</p>
                <div class="space-y-2 text-xs uppercase tracking-widest font-bold opacity-60">
                    <p>User: @<?php echo $username; ?></p>
                    <p>Email: <?php echo $photographer_email; ?></p>
                </div>
            </div>
            
            <form action="send_inquiry.php" method="POST" class="space-y-8">
                <input type="hidden" name="target_email" value="<?php echo $photographer_email; ?>">
                <input type="text" name="visitor_name" placeholder="Name" required class="w-full border-b border-zinc-200 py-3 bg-transparent outline-none focus:border-indigo-500 transition-colors">
                <input type="email" name="visitor_email" placeholder="Email" required class="w-full border-b border-zinc-200 py-3 bg-transparent outline-none focus:border-indigo-500 transition-colors">
                <textarea name="message" rows="3" placeholder="Message" required class="w-full border-b border-zinc-200 py-3 bg-transparent outline-none focus:border-indigo-500 transition-colors resize-none"></textarea>
                <button type="submit" class="w-full py-4 bg-zinc-900 text-white dark:bg-white dark:text-black text-[10px] uppercase tracking-[0.4em] font-bold">Send Message</button>
            </form>
        </div>
    </section>

    <script>
        // Hide Loader
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.display = 'none'; }, 700);
        });
    </script>
</body>

<script>
    // Add loading class to body on start
    document.body.classList.add('loading');

    window.addEventListener('load', function() {
        const loader = document.getElementById('loader');
        
        // Start fade out
        loader.style.opacity = '0';
        
        // Completely remove loader and restore scroll after fade finishes
        setTimeout(() => {
            loader.style.display = 'none';
            document.body.classList.remove('loading');
        }, 700); // Matches the duration-700 class
    });
</script>

</html>