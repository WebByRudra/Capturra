<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Capturra - Blogs</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { font-family: 'Inter', sans-serif; }
body { background: #0f0f13; color: #e2e0f0; }

.blog-card {
    background: #16161f;
    border: 1px solid #2a2a3e;
    border-radius: 16px;
    overflow: hidden;
    transition: 0.3s;
}
.blog-card:hover {
    border-color: #7c3aed;
    transform: translateY(-4px);
}

.tag {
    background: #1e1535;
    color: #a855f7;
    border: 1px solid #3a2060;
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 20px;
}

.category-btn {
    background: #16161f;
    border: 1px solid #2a2a3e;
    padding: 7px 16px;
    border-radius: 20px;
    cursor: pointer;
}
.category-btn.active {
    background: #1e1535;
    border-color: #7c3aed;
    color: #a855f7;
}
.section {
    scroll-margin-top: 120px;
}
</style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">

<!-- HEADER -->
<h1 class="text-3xl text-center mb-6">Capturra Blog</h1>

<!-- SEARCH -->
<input type="text" id="search" placeholder="Search..."
class="w-full p-3 rounded bg-[#16161f] border border-[#333] mb-6">

<!-- CATEGORY BUTTONS -->
<div class="flex flex-wrap gap-3 mb-10">
    <button class="category-btn active" onclick="showAll()">All</button>
    <button class="category-btn" onclick="scrollToSection('tips')">Photography Tips</button>
    <button class="category-btn" onclick="scrollToSection('gear')">Gear Reviews</button>
    <button class="category-btn" onclick="scrollToSection('stories')">Creator Stories</button>
    <button class="category-btn" onclick="scrollToSection('business')">Business</button>
    <button class="category-btn" onclick="scrollToSection('editing')">Editing</button>
    <button class="category-btn" onclick="scrollToSection('inspiration')">Inspiration</button>
</div>

<!-- ================= SECTIONS ================= -->

<!-- TIPS -->
<div id="tips" class="section mb-10">
<h2 class="text-xl mb-4">Photography Tips</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Photography Tips</span>
<h3>Mastering Golden Hour</h3>
<p>Learn how to capture perfect warm lighting during sunrise and sunset for cinematic photos.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Photography Tips</span>
<h3>Composition Rules You Must Know</h3>
<p>Rule of thirds, leading lines and framing techniques explained simply.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Photography Tips</span>
<h3>Low Light Photography Guide</h3>
<p>Shoot sharp photos even in dark environments without noise.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Photography Tips</span>
<h3>Portrait Lighting Basics</h3>
<p>Understand soft light, hard light and shadows for better portraits.</p>
</div>
</div>

<!-- GEAR -->
<div id="gear" class="section mb-10">
<h2 class="text-xl mb-4">Gear Reviews</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Gear Reviews</span>
<h3>Best Cameras 2025</h3>
<p>Top mirrorless cameras for beginners & professionals.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Gear Reviews</span>
<h3>Best Lenses for Portraits</h3>
<p>50mm vs 85mm vs 35mm — which lens suits your style?</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Gear Reviews</span>
<h3>Budget Photography Setup</h3>
<p>Complete setup under ₹50,000 for beginners.</p>
</div>
</div>

<!-- STORIES -->
<div id="stories" class="section mb-10">
<h2 class="text-xl mb-4">Creator Stories</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Creator Stories</span>
<h3>From Hobbyist to Pro</h3>
<p>Journey of a photographer turning passion into career.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Creator Stories</span>
<h3>Freelancer Life Reality</h3>
<p>Truth about working as a freelance photographer.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Creator Stories</span>
<h3>First Client Experience</h3>
<p>What to expect when you get your first paid shoot.</p>
</div>
</div>

<!-- BUSINESS -->
<div id="business" class="section mb-10">
<h2 class="text-xl mb-4">Business</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Business</span>
<h3>Pricing Strategy</h3>
<p>How to price your work without undercharging.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Business</span>
<h3>Getting Clients on Instagram</h3>
<p>Turn your posts into client leads.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Business</span>
<h3>Portfolio Building Tips</h3>
<p>Create a strong portfolio that attracts clients.</p>
</div>
</div>

<!-- EDITING -->
<div id="editing" class="section mb-10">
<h2 class="text-xl mb-4">Editing</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Editing</span>
<h3>Lightroom vs Photoshop</h3>
<p>Which tool is best for your workflow?</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Editing</span>
<h3>Color Grading Basics</h3>
<p>Make your photos look cinematic with simple tweaks.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Editing</span>
<h3>Skin Retouching Guide</h3>
<p>Clean skin edits without making it look fake.</p>
</div>
</div>

<!-- INSPIRATION -->
<div id="inspiration" class="section mb-10">
<h2 class="text-xl mb-4">Inspiration</h2>

<div class="blog-card p-4 searchable">
<span class="tag">Inspiration</span>
<h3>Street Photography Ideas</h3>
<p>Creative composition tips for street shots.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Inspiration</span>
<h3>Creative Photo Concepts</h3>
<p>Unique ideas to make your photos stand out.</p>
</div>

<div class="blog-card p-4 mt-4 searchable">
<span class="tag">Inspiration</span>
<h3>Minimal Photography Style</h3>
<p>Less is more — master minimal compositions.</p>
</div>
</div>
<!-- ================= JS ================= -->
<script>

// SCROLL FUNCTION
function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({
        behavior: 'smooth'
    });
}

// SHOW ALL
function showAll() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// SEARCH
document.getElementById("search").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let cards = document.querySelectorAll(".searchable");

    cards.forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(value)
            ? "block" : "none";
    });
});

// ACTIVE BUTTON UI
document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

</script>

</body>
</html>