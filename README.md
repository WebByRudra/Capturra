# Capturra

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Where Creators Shine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: #333;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-section {
            padding: 100px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .background-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .background-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .background-slide.active {
            opacity: 1;
        }

        .background-slide:nth-child(1) {
            background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        }

        .background-slide:nth-child(2) {
            background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        }

        .background-slide:nth-child(3) {
            background-image: url('https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        }

        .background-slide:nth-child(4) {
            background-image: url('https://images.unsplash.com/photo-1541961017774-22349e4a1262?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        }

        .background-slide:nth-child(5) {
            background-image: url('https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .slider-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .slider-dot.active {
            background: white;
            transform: scale(1.2);
        }

        .slider-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .slider-arrow {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .slider-arrow:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .slider-arrow.prev {
            left: 30px;
        }

        .slider-arrow.next {
            right: 30px;
        }

        .hero-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-tagline {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .content-section {
            padding: 80px 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 50px;
            color: #333;
        }

        .website-preview {
            margin-bottom: 60px;
            text-align: center;
        }

        .preview-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .browser-mockup {
            max-width: 600px;
            margin: 0 auto;
            background: #f5f5f5;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .browser-header {
            background: #e0e0e0;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .browser-buttons {
            display: flex;
            gap: 8px;
        }

        .browser-buttons span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .btn-close { background: #ff5f57; }
        .btn-minimize { background: #ffbd2e; }
        .btn-maximize { background: #28ca42; }

        .browser-url {
            background: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #666;
            flex: 1;
        }

        .browser-content {
            background: white;
            padding: 30px;
            min-height: 200px;
        }

        .mockup-hero {
            text-align: center;
            margin-bottom: 20px;
        }

        .mockup-hero h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .mockup-hero p {
            color: #666;
            font-size: 0.9rem;
        }

        .mockup-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .mockup-card {
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            opacity: 0.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .comments-section {
            max-width: 800px;
            margin: 0 auto;
        }

        .comment {
            display: flex;
            gap: 15px;
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .comment-author {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .comment-time {
            color: #666;
            font-size: 0.8rem;
        }

        .comment-text {
            color: #333;
            line-height: 1.5;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .comment-actions button {
            background: none;
            border: none;
            color: #666;
            font-size: 0.85rem;
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .comment-actions button:hover {
            background: #f0f0f0;
            color: #333;
        }

        .like-btn:hover {
            background: #e3f2fd;
            color: #1976d2;
        }

        .dislike-btn:hover {
            background: #ffebee;
            color: #d32f2f;
        }

        .reply-btn:hover {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-secondary {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-tagline {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .artists-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main>
        <section class="hero-section">
            <div class="background-slideshow">
                <div class="background-slide active"></div>
                <div class="background-slide"></div>
                <div class="background-slide"></div>
                <div class="background-slide"></div>
                <div class="background-slide"></div>
            </div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="hero-title">Capturra</h1>
                <h2 class="hero-tagline">Where Creators Shine</h2>
            </div>
            

        </section>

        <section class="content-section">
            <div class="container">
                <h2 class="section-title">Platform Features & Preview</h2>
                
<div class="website-preview" style="text-align: center;">
    <h3 class="preview-title">How Capturra Looks</h3>

    <!-- Image Slider -->
    <div class="slider" style="position: relative; max-width: 500px; margin: 20px auto; overflow: hidden; border-radius: 12px;">
        <div class="slides" style="display: flex; transition: transform 0.5s ease-in-out;">

            <!-- ✅ Responsive images -->
            <img src="1-1.jpg" style="width:100%; max-width:500px; height:auto; aspect-ratio: 5/3; flex-shrink: 0; object-fit: cover; border-radius: 12px;">
            <img src="2.jpg" style="width:100%; max-width:500px; height:auto; aspect-ratio: 5/3; flex-shrink: 0; object-fit: cover; border-radius: 12px;">
            <img src="3.jpg" style="width:100%; max-width:500px; height:auto; aspect-ratio: 5/3; flex-shrink: 0; object-fit: cover; border-radius: 12px;">

        </div>

        <!-- Navigation Buttons -->
        <button onclick="prevSlide()" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px;">&#10094;</button>
        <button onclick="nextSlide()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px;">&#10095;</button>
    </div>

    <!-- Dots -->
    <div class="dots" style="margin-top: 10px;"></div>
</div>

                <!-- Features Grid -->
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🎨</div>
                        <h3 class="feature-title">Portfolio Showcase</h3>
                        <p class="feature-description">Create stunning portfolios with our drag-and-drop builder. Showcase your work with beautiful galleries and custom layouts.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🌐</div>
                        <h3 class="feature-title">Global Community</h3>
                        <p class="feature-description">Connect with creators worldwide. Share ideas, collaborate on projects, and grow your network in our vibrant community.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💼</div>
                        <h3 class="feature-title">Client Matching</h3>
                        <p class="feature-description">Get discovered by potential clients. Our smart matching system connects you with projects that fit your skills and style.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3 class="feature-title">Analytics Dashboard</h3>
                        <p class="feature-description">Track your portfolio views, engagement rates, and client inquiries with detailed analytics and insights.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🚀</div>
                        <h3 class="feature-title">SEO Optimization</h3>
                        <p class="feature-description">Your portfolio is automatically optimized for search engines, helping you get discovered by more potential clients.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💬</div>
                        <h3 class="feature-title">Real-time Chat</h3>
                        <p class="feature-description">Communicate directly with clients and collaborators through our built-in messaging system with file sharing capabilities.</p>
                    </div>
                </div>

                <!-- Website Look & Feel Section -->
                <div style="margin-top: 80px;">
                    <h3 class="preview-title">What Your Website Will Look Like</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 40px; margin-top: 40px;">
                        
                        <!-- Photographer View -->
                        <div style="text-align: center;">
                            <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px; color: #333;">For Photographers</h4>
                            <div class="browser-mockup" style="max-width: 100%;">
                                <div class="browser-header">
                                    <div class="browser-buttons">
                                        <span class="btn-close"></span>
                                        <span class="btn-minimize"></span>
                                        <span class="btn-maximize"></span>
                                    </div>
                                    <div class="browser-url">sarah-photography.capturra.com</div>
                                </div>
                                <div class="browser-content" style="padding: 20px; min-height: 280px;">
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📸</div>
                                        <div>
                                            <h5 style="margin: 0; font-size: 1.2rem; color: #333;">Sarah Chen</h5>
                                            <p style="margin: 0; color: #666; font-size: 0.9rem;">Wedding & Portrait Photographer</p>
                                            <p style="margin: 0; color: #999; font-size: 0.8rem;">📍 San Francisco, CA</p>
                                        </div>
                                    </div>
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Wedding</div>
                                        </div>
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Portrait</div>
                                        </div>
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Nature</div>
                                        </div>
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Events</div>
                                        </div>
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Fashion</div>
                                        </div>
                                        <div style="height: 60px; background: url('https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=200') center/cover; border-radius: 8px; position: relative;">
                                            <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Studio</div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 8px; text-align: left;">
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">✨ 2,847 portfolio views this month</p>
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">💼 12 new booking inquiries</p>
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">⭐ 4.9/5 average rating (47 reviews)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client View -->
                        <div style="text-align: center;">
                            <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px; color: #333;">For Clients</h4>
                            <div class="browser-mockup" style="max-width: 100%;">
                                <div class="browser-header">
                                    <div class="browser-buttons">
                                        <span class="btn-close"></span>
                                        <span class="btn-minimize"></span>
                                        <span class="btn-maximize"></span>
                                    </div>
                                    <div class="browser-url">capturra.com/discover</div>
                                </div>
                                <div class="browser-content" style="padding: 20px; min-height: 280px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                                        <h5 style="margin: 0; font-size: 1.2rem; color: #333;">Find Your Perfect Photographer</h5>
                                        <div style="display: flex; gap: 8px;">
                                            <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 12px; font-size: 0.7rem;">Wedding</span>
                                            <span style="background: #f3e5f5; color: #7b1fa2; padding: 4px 8px; border-radius: 12px; font-size: 0.7rem;">Portrait</span>
                                        </div>
                                    </div>
                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                                        <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px;">
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                                <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">📸</div>
                                                <div>
                                                    <h6 style="margin: 0; font-size: 0.9rem; color: #333;">Sarah Chen</h6>
                                                    <p style="margin: 0; color: #666; font-size: 0.7rem;">Wedding Photographer</p>
                                                </div>
                                            </div>
                                            <div style="height: 40px; background: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=200') center/cover; border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="color: #666; font-size: 0.7rem;">⭐ 4.9 (47)</span>
                                                <span style="background: #4caf50; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Available</span>
                                            </div>
                                        </div>
                                        <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px;">
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                                <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #48dbfb 0%, #0abde3 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">📷</div>
                                                <div>
                                                    <h6 style="margin: 0; font-size: 0.9rem; color: #333;">Mike Rodriguez</h6>
                                                    <p style="margin: 0; color: #666; font-size: 0.7rem;">Portrait Photographer</p>
                                                </div>
                                            </div>
                                            <div style="height: 40px; background: url('https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200') center/cover; border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="color: #666; font-size: 0.7rem;">⭐ 4.8 (32)</span>
                                                <span style="background: #ff9800; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Busy</span>
                                            </div>
                                        </div>
                                        <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px;">
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                                <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🎨</div>
                                                <div>
                                                    <h6 style="margin: 0; font-size: 0.9rem; color: #333;">Emma Wilson</h6>
                                                    <p style="margin: 0; color: #666; font-size: 0.7rem;">Event Photographer</p>
                                                </div>
                                            </div>
                                            <div style="height: 40px; background: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=200') center/cover; border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="color: #666; font-size: 0.7rem;">⭐ 5.0 (28)</span>
                                                <span style="background: #4caf50; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Available</span>
                                            </div>
                                        </div>
                                        <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px;">
                                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                                <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #54a0ff 0%, #2e86de 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🌟</div>
                                                <div>
                                                    <h6 style="margin: 0; font-size: 0.9rem; color: #333;">Alex Kim</h6>
                                                    <p style="margin: 0; color: #666; font-size: 0.7rem;">Fashion Photographer</p>
                                                </div>
                                            </div>
                                            <div style="height: 40px; background: url('https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=200') center/cover; border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="color: #666; font-size: 0.7rem;">⭐ 4.7 (19)</span>
                                                <span style="background: #4caf50; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">Available</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 8px; text-align: left;">
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">🔍 Search by location, style, and budget</p>
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">💬 Direct messaging with photographers</p>
                                        <p style="margin: 0; font-size: 0.8rem; color: #666;">📅 Real-time availability calendar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <!-- Key Features List -->
                    <div style="margin-top: 50px; background: #f8f9fa; padding: 40px; border-radius: 15px;">
                        <h4 style="text-align: center; font-size: 1.5rem; font-weight: 600; margin-bottom: 30px; color: #333;">How Your Website Will Work</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">🎯</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Custom Domain</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Get your own professional URL like yourname.capturra.com</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">📱</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Responsive Design</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Looks perfect on desktop, tablet, and mobile devices</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">⚡</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Lightning Fast</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Optimized for speed and search engine ranking</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">🔧</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Easy Updates</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Add new work with simple drag-and-drop interface</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">📊</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Analytics Included</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Track visitors, views, and client inquiries</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 15px;">
                                <span style="font-size: 1.5rem;">💼</span>
                                <div>
                                    <h5 style="margin: 0 0 8px 0; color: #333; font-size: 1rem;">Client Contact</h5>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem; line-height: 1.4;">Built-in contact forms and messaging system</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <h2 class="section-title">Trending Comments</h2>
                <div class="comments-section">
                    <div class="comment">
                        <img src="https://via.placeholder.com/40x40" alt="User Avatar" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">@CreativePixel</span>
                                <span class="comment-time">2 hours ago</span>
                            </div>
                            <p class="comment-text">This platform is absolutely incredible! The community here is so supportive and inspiring. I've discovered so many talented artists 🎨✨</p>
                            <div class="comment-actions">
                                <button class="like-btn">👍 <span>247</span></button>
                                <button class="dislike-btn">👎</button>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment">
                        <img src="https://via.placeholder.com/40x40" alt="User Avatar" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">@ArtLover2024</span>
                                <span class="comment-time">5 hours ago</span>
                            </div>
                            <p class="comment-text">Just uploaded my first portfolio here and already got 3 client inquiries! The exposure on this platform is amazing 🚀</p>
                            <div class="comment-actions">
                                <button class="like-btn">👍 <span>189</span></button>
                                <button class="dislike-btn">👎</button>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment">
                        <img src="https://via.placeholder.com/40x40" alt="User Avatar" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">@DigitalDreamer</span>
                                <span class="comment-time">1 day ago</span>
                            </div>
                            <p class="comment-text">The featured artists section is pure gold! So much talent in one place. Manorita's work is mind-blowing 🤯</p>
                            <div class="comment-actions">
                                <button class="like-btn">👍 <span>156</span></button>
                                <button class="dislike-btn">👎</button>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment">
                        <img src="https://via.placeholder.com/40x40" alt="User Avatar" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">@PhotoMaster</span>
                                <span class="comment-time">2 days ago</span>
                            </div>
                            <p class="comment-text">Been using this for 6 months now. Best decision ever! My photography business has grown 300% thanks to the connections I made here 📸</p>
                            <div class="comment-actions">
                                <button class="like-btn">👍 <span>312</span></button>
                                <button class="dislike-btn">👎</button>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment">
                        <img src="https://via.placeholder.com/40x40" alt="User Avatar" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">@NewArtist</span>
                                <span class="comment-time">3 days ago</span>
                            </div>
                            <p class="comment-text">Just joined yesterday and I'm already blown away by the quality of work here. This is exactly what I was looking for! 🎭</p>
                            <div class="comment-actions">
                                <button class="like-btn">👍 <span>98</span></button>
                                <button class="dislike-btn">👎</button>
                                <button class="reply-btn">Reply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="container">
                <h2 class="section-title">Explore the Platform</h2>
                <p>Find your next great creative project or share your own with the world. Join our growing community today.</p>
                <a href="#" class="btn-secondary">Learn More</a>
            </div>
        </section>
    </main>

<script>
    let currentIndex = 0;
    const slides = document.querySelector(".slides");
    const totalSlides = document.querySelectorAll(".slides img").length;
    const sliderContainer = document.querySelector(".slider");
    const dotsContainer = document.querySelector(".dots");
    let dots = [];
    let slideInterval;

    // ✅ Auto-generate dots
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        dot.style.cssText = "height: 12px; width: 12px; margin: 0 5px; background-color: #bbb; border-radius: 50%; display: inline-block; cursor: pointer;";
        dot.addEventListener("click", () => goToSlide(i));
        dotsContainer.appendChild(dot);
        dots.push(dot);
    }

    function showSlide(index) {
        if (index >= totalSlides) currentIndex = 0;
        else if (index < 0) currentIndex = totalSlides - 1;
        else currentIndex = index;

        slides.style.transform = `translateX(-${currentIndex * 100}%)`;

        // ✅ update active dot
        dots.forEach(dot => dot.style.backgroundColor = "#bbb");
        dots[currentIndex].style.backgroundColor = "#333";
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function prevSlide() {
        showSlide(currentIndex - 1);
    }

    function goToSlide(index) {
        currentIndex = index;
        showSlide(currentIndex);
        resetSlideshow();
    }

    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 4000);
    }

    function resetSlideshow() {
        clearInterval(slideInterval);
        startSlideshow();
    }

    // ✅ Pause slideshow on hover
    sliderContainer.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
    });

    sliderContainer.addEventListener("mouseleave", () => {
        startSlideshow();
    });

    // ✅ Initialize
    showSlide(currentIndex);
    startSlideshow();
</script>


<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'97a61a80f3c1a7bb',t:'MTc1NzA3OTI2MS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
