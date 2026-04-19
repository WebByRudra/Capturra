<?php
// blogs.php - include this in your main layout or use as standalone
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Blogs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f0f13; color: #e2e0f0; margin: 0; padding: 0; }
 
        .blog-card {
            background: #16161f;
            border: 1px solid #2a2a3e;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .blog-card:hover {
            border-color: #7c3aed;
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(124,58,237,0.15);
        }
        .blog-thumb {
            height: 160px;
            background: linear-gradient(135deg, #1a1a2e, #2d1f50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 44px;
        }
        .featured-thumb {
            height: 260px;
            background: linear-gradient(135deg, #1a0a2e, #3b1f7a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 68px;
        }
        .featured-card {
            background: #16161f;
            border: 1px solid #2a2a3e;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .featured-card:hover { border-color: #7c3aed; box-shadow: 0 12px 30px rgba(124,58,237,0.15); }
 
        .tag {
            display: inline-block;
            background: #1e1535;
            color: #a855f7;
            border: 1px solid #3a2060;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        .search-input {
            background: #16161f;
            border: 1px solid #3a3a5c;
            border-radius: 10px;
            color: #e2e0f0;
            padding: 10px 16px 10px 42px;
            outline: none;
            width: 100%;
            font-size: 14px;
            transition: border-color .3s;
        }
        .search-input:focus { border-color: #7c3aed; }
        .search-input::placeholder { color: #6b6b8a; }
 
        .category-btn {
            background: #16161f;
            border: 1px solid #2a2a3e;
            color: #a0a0c0;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: all .3s;
            font-family: 'Inter', sans-serif;
        }
        .category-btn:hover, .category-btn.active {
            background: #1e1535;
            border-color: #7c3aed;
            color: #a855f7;
        }
        .sidebar-card {
            background: #16161f;
            border: 1px solid #2a2a3e;
            border-radius: 12px;
            padding: 20px;
        }
        .read-btn {
            background: transparent;
            border: 1px solid #7c3aed;
            color: #a855f7;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all .3s;
            font-family: 'Inter', sans-serif;
        }
        .read-btn:hover { background: #1e1535; }
        .page-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
 
<div style="max-width:1280px; margin:0 auto; padding: 40px 24px 60px;">
 
    <!-- Page Header -->
    <div style="text-align:center; margin-bottom:36px;">
        <div style="display:inline-block; margin-bottom:14px; padding:4px 16px; border-radius:20px; font-size:11px; font-weight:600; letter-spacing:1.5px; text-transform:uppercase; background:#1e1535; color:#a855f7; border:1px solid #3a2060;">
            Capturra Blog
        </div>
        <h1 style="font-size:36px; font-weight:700; color:#fff; margin:0 0 10px;">Stories, Tips &amp; Inspiration</h1>
        <p style="color:#6b6b8a; font-size:15px; margin:0 0 24px;">Photography guides, creator stories, and industry insights.</p>
        <div style="position:relative; max-width:480px; margin:0 auto;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#6b6b8a; font-size:14px;"></i>
            <input type="text" class="search-input" placeholder="Search articles...">
        </div>
    </div>
 
    <!-- Categories -->
    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:32px;">
        <button class="category-btn active">All</button>
        <button class="category-btn">Photography Tips</button>
        <button class="category-btn">Gear Reviews</button>
        <button class="category-btn">Creator Stories</button>
        <button class="category-btn">Business</button>
        <button class="category-btn">Editing</button>
        <button class="category-btn">Inspiration</button>
    </div>
 
    <!-- Main Grid -->
    <div style="display:grid; grid-template-columns:1fr 300px; gap:28px;">
 
        <!-- Left: Posts -->
        <div>
            <!-- Featured -->
            <div class="featured-card" style="margin-bottom:24px;">
                <div class="featured-thumb">🌄</div>
                <div style="padding:24px;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                        <span class="tag">Photography Tips</span>
                        <span style="color:#6b6b8a; font-size:12px;">Apr 15, 2025</span>
                    </div>
                    <h2 style="font-size:20px; font-weight:600; color:#fff; margin:0 0 10px;">Mastering Golden Hour: A Complete Guide for Photographers</h2>
                    <p style="color:#a0a0c0; font-size:13px; line-height:1.7; margin:0 0 16px;">The golden hour offers the most beautiful natural light of the day. Learn how to plan your shoots, choose the right settings, and capture breathtaking images during this magical window...</p>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a855f7);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;">AC</div>
                            <div>
                                <div style="font-size:13px; font-weight:500; color:#fff;">Alex Chen</div>
                                <div style="font-size:11px; color:#6b6b8a;">8 min read</div>
                            </div>
                        </div>
                        <button class="read-btn">Read More →</button>
                    </div>
                </div>
            </div>
 
            <!-- Blog Grid -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
 
                <div class="blog-card">
                    <div class="blog-thumb">📸</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Gear Reviews</span>
                            <span style="color:#6b6b8a; font-size:11px;">Apr 10</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">Best Mirrorless Cameras of 2025</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">An in-depth look at the top mirrorless options for both beginners and pros.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
                <div class="blog-card">
                    <div class="blog-thumb">🎨</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Editing</span>
                            <span style="color:#6b6b8a; font-size:11px;">Apr 8</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">Lightroom vs Photoshop: Which One for You?</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">We break down the differences to help you decide which tool fits your style.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
                <div class="blog-card">
                    <div class="blog-thumb">💼</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Business</span>
                            <span style="color:#6b6b8a; font-size:11px;">Apr 5</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">How to Price Your Photography Services</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">Stop undercharging. A practical framework to set rates that value your work.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
                <div class="blog-card">
                    <div class="blog-thumb">🌟</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Creator Stories</span>
                            <span style="color:#6b6b8a; font-size:11px;">Apr 2</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">From Hobbyist to Full-Time Photographer</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">Sarah Johnson shares her journey to a thriving photography business.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
                <div class="blog-card">
                    <div class="blog-thumb">🏙️</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Inspiration</span>
                            <span style="color:#6b6b8a; font-size:11px;">Mar 28</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">10 Street Photography Compositions to Try</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">Elevate your street shots with creative framing techniques.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
                <div class="blog-card">
                    <div class="blog-thumb">🌿</div>
                    <div style="padding:18px;">
                        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                            <span class="tag">Photography Tips</span>
                            <span style="color:#6b6b8a; font-size:11px;">Mar 24</span>
                        </div>
                        <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 8px;">Nature Photography: Patience is Your Best Lens</h3>
                        <p style="color:#a0a0c0; font-size:12px; line-height:1.6; margin:0 0 14px;">Tips on slowing down and capturing nature's most stunning moments.</p>
                        <button class="read-btn" style="width:100%;">Read More →</button>
                    </div>
                </div>
 
            </div>
 
            <!-- Pagination -->
            <div style="display:flex; gap:8px; justify-content:center;">
                <button class="page-btn" style="background:#1e1535; color:#a855f7; border:1px solid #7c3aed;">1</button>
                <button class="page-btn category-btn">2</button>
                <button class="page-btn category-btn">3</button>
                <button class="page-btn category-btn">→</button>
            </div>
        </div>
 
        <!-- Sidebar -->
        <div style="display:flex; flex-direction:column; gap:16px;">
 
            <div class="sidebar-card">
                <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #2a2a3e;">🔥 Popular Posts</h3>
                <div style="display:flex; flex-direction:column; gap:14px;">
                    <div style="display:flex; gap:10px; align-items:flex-start;">
                        <div style="width:44px;height:44px;border-radius:8px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">🌄</div>
                        <div>
                            <p style="font-size:12px; font-weight:500; color:#fff; margin:0 0 3px; line-height:1.4;">Mastering Golden Hour Photography</p>
                            <p style="font-size:11px; color:#6b6b8a; margin:0;">2.4K views</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:flex-start;">
                        <div style="width:44px;height:44px;border-radius:8px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">📸</div>
                        <div>
                            <p style="font-size:12px; font-weight:500; color:#fff; margin:0 0 3px; line-height:1.4;">Best Mirrorless Cameras of 2025</p>
                            <p style="font-size:11px; color:#6b6b8a; margin:0;">1.8K views</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:flex-start;">
                        <div style="width:44px;height:44px;border-radius:8px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">💼</div>
                        <div>
                            <p style="font-size:12px; font-weight:500; color:#fff; margin:0 0 3px; line-height:1.4;">How to Price Your Photography</p>
                            <p style="font-size:11px; color:#6b6b8a; margin:0;">1.3K views</p>
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="sidebar-card" style="background:linear-gradient(135deg,#1a0a2e,#16161f);">
                <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 6px;">📬 Newsletter</h3>
                <p style="font-size:12px; color:#a0a0c0; margin:0 0 14px;">Get weekly articles in your inbox.</p>
                <input type="email" placeholder="Your email" class="search-input" style="padding:9px 14px; margin-bottom:10px;">
                <button style="width:100%; padding:9px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:linear-gradient(135deg,#7c3aed,#5b21b6); border:none; cursor:pointer; font-family:'Inter',sans-serif;">Subscribe</button>
            </div>
 
            <div class="sidebar-card">
                <h3 style="font-size:14px; font-weight:600; color:#fff; margin:0 0 14px; padding-bottom:12px; border-bottom:1px solid #2a2a3e;">🏷️ Tags</h3>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <span class="tag" style="cursor:pointer;">#portrait</span>
                    <span class="tag" style="cursor:pointer;">#landscape</span>
                    <span class="tag" style="cursor:pointer;">#wedding</span>
                    <span class="tag" style="cursor:pointer;">#lightroom</span>
                    <span class="tag" style="cursor:pointer;">#gear</span>
                    <span class="tag" style="cursor:pointer;">#street</span>
                    <span class="tag" style="cursor:pointer;">#business</span>
                    <span class="tag" style="cursor:pointer;">#tips</span>
                </div>
            </div>
 
        </div>
    </div>
</div>
 
<script>
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
</body>
</html>