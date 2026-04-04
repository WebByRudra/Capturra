<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/auth.php";
requireRole("client");

$username = $_SESSION['username'];
$name     = $_SESSION['name'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Photography Community</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .notification-dot {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .upload-zone {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }
        
        .upload-zone:hover {
            border-color: #667eea;
            background-color: #f8fafc;
        }

        /* Dark mode overrides */
        .dark body {
            background-color: #07201f;
            color: #e6f9f8;
        }
        .dark nav {
            background-color: #164a46 !important;
            border-color: #123936 !important;
        }
        .dark nav a,
        .dark nav .text-gray-900,
        .dark nav .text-gray-700 {
            color: #e6f9f8 !important;
        }
        .dark .bg-white {
            background-color: #0f2a29 !important;
            color: #e6f9f8 !important;
            border-color: #123936 !important;
        }
        .dark .text-gray-900 { color: #e6f9f8 !important; }
        .dark .text-gray-700, .dark .text-gray-500 { color: #cfeae8 !important; }
        .dark .border-gray-200 { border-color: #123936 !important; }
        .dark .upload-zone { border-color: #2a6b69 !important; background-color: rgba(22,74,70,0.06) !important; }
        #darkToggle { background: transparent; border: 1px solid transparent; padding: 6px 8px; border-radius: 8px; color: inherit; }
        #darkToggle.active { background: rgba(255,255,255,0.04); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center cursor-pointer" onclick="goHome()">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">C</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Capturra</span>
                </div>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <input type="text" placeholder="Search creators, photos, categories..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Home</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Explore</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Trending</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Creators</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Messages</a>
                    
                    <!-- Dark mode toggle -->
                    <button id="darkToggle" title="Toggle dark mode" class="flex items-center justify-center w-9 h-9 rounded-md text-gray-700 hover:bg-gray-100 transition-colors" aria-pressed="false">🌙</button>
                    
                    <!-- Notifications -->
                    <div class="relative cursor-pointer" onclick="toggleNotifications()">
                        <svg class="h-6 w-6 text-gray-700 hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.07 2.82l3.93 3.93-3.93 3.93-3.93-3.93 3.93-3.93z">🔔</path>
                        </svg>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full notification-dot"></div>
                    </div>
                    
                    <!-- Profile Menu -->
                    <div class="relative">
                        <button onclick="toggleProfileMenu()" class="flex items-center space-x-2 focus:outline-none">
                           <div class="w-8 h-8 rounded-full border-2 border-purple-500 flex items-center justify-center bg-gray-100">
    <span class="text-gray-400 text-sm">👤</span>
</div>

                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                            <a href="profile.php" onclick="closeProfileMenu()" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profile</a>
                            <a href="settings.php" onclick="closeProfileMenu()" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Settings</a>
                            <hr class="my-1">
                            <button onclick="logout()" 
  class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-50">
  Logout
</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- User Profile Snapshot -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full mx-auto mb-4 border-4 border-purple-500 flex items-center justify-center bg-gray-100">
    <span class="text-2xl text-gray-400">👤</span>
</div>

                        <h3 class="font-semibold text-gray-900">
  <?php echo htmlspecialchars($name); ?>
</h3>
<p class="text-sm text-gray-500 mb-4">
  @<?php echo htmlspecialchars($username); ?>
</p>

                        <div class="flex justify-center space-x-4 text-sm">
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">0</div>
                                <div class="text-gray-500">Followers</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">0</div>
                                <div class="text-gray-500">Likes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Shortcut -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Quick Upload</h3>
                    <div class="upload-zone rounded-lg p-6 text-center cursor-pointer" onclick="uploadPhoto()">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-sm text-gray-600">Drag & drop or click to upload</p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-gray-700">My Portfolio</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="text-gray-700">Messages</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-700">Settings</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                            </svg>
                            <span class="text-gray-700">Support</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Hero / Welcome Section -->
                <div class="gradient-bg rounded-xl p-8 text-white">
                    <h1 class="text-3xl font-bold mb-2">
  Welcome back, <?php echo htmlspecialchars($name); ?> 👋
</h1>

                    <p class="text-purple-100 mb-6">Ready to capture and share amazing moments?</p>
                    <div class="flex flex-wrap gap-4">
                        <button onclick="uploadPhoto()" class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors flex items-center space-x-2">
                            <span>📷</span>
                            <span>Upload Photo</span>
                        </button>
                        <button onclick="viewPortfolio()" class="bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-800 transition-colors">
                            View Portfolio
                        </button>
                        <button onclick="hirePhotographer()" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">
                            Hire Photographer
                        </button>
                    </div>
                </div>

                <!-- Main Feed -->
                <div class="space-y-8">
                    <!-- Trending Photos -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">🔥 Trending Photos</h2>
                        <div class="photo-grid">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop" alt="Mountain landscape" class="w-full" style="height:auto; object-fit:contain;">
                                <div class="p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face" alt="Creator" class="w-8 h-8 rounded-full">
                                        <div>
                                            <p class="font-semibold text-gray-900">Alex Chen</p>
                                            <p class="text-sm text-gray-500">@alexphoto</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-3">Breathtaking sunrise at Mount Furano</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button onclick="likePost(this)" class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition-colors">
                                                <span>❤️</span>
                                                <span class="text-sm">234</span>
                                            </button>
                                            <button onclick="commentPost()" class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition-colors">
                                                <span>💬</span>
                                                <span class="text-sm">45</span>
                                            </button>
                                            <button onclick="sharePost()" class="flex items-center space-x-1 text-gray-500 hover:text-green-500 transition-colors">
                                                <span>↗️</span>
                                                <span class="text-sm">12</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover">
                                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=300&fit=crop" alt="Wedding photo" class="w-full" style="height:auto; object-fit:contain;">
                                <div class="p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face" alt="Creator" class="w-8 h-8 rounded-full">
                                        <div>
                                            <p class="font-semibold text-gray-900">Sarah Johnson</p>
                                            <p class="text-sm text-gray-500">@sarahweddings</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-3">Perfect moment captured ✨</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button onclick="likePost(this)" class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition-colors">
                                                <span>❤️</span>
                                                <span class="text-sm">567</span>
                                            </button>
                                            <button onclick="commentPost()" class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition-colors">
                                                <span>💬</span>
                                                <span class="text-sm">89</span>
                                            </button>
                                            <button onclick="sharePost()" class="flex items-center space-x-1 text-gray-500 hover:text-green-500 transition-colors">
                                                <span>↗️</span>
                                                <span class="text-sm">23</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover">
                                <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop" alt="Street photography" class="w-full" style="height:auto; object-fit:contain;">
                                <div class="p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=32&h=32&fit=crop&crop=face" alt="Creator" class="w-8 h-8 rounded-full">
                                        <div>
                                            <p class="font-semibold text-gray-900">Mike Rodriguez</p>
                                            <p class="text-sm text-gray-500">@mikestreet</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-3">Urban life in motion</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button onclick="likePost(this)" class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition-colors">
                                                <span>❤️</span>
                                                <span class="text-sm">189</span>
                                            </button>
                                            <button onclick="commentPost()" class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition-colors">
                                                <span>💬</span>
                                                <span class="text-sm">34</span>
                                            </button>
                                            <button onclick="sharePost()" class="flex items-center space-x-1 text-gray-500 hover:text-green-500 transition-colors">
                                                <span>↗️</span>
                                                <span class="text-sm">8</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Followed Creators' Updates -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">👥 Following Updates</h2>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center space-x-3 mb-4">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face" alt="Emma" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-gray-900">Emma Wilson</p>
                                        <p class="text-sm text-gray-500">2 hours ago</p>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">Just finished an amazing portrait session! Can't wait to share the results 📸</p>
                                <div class="flex items-center space-x-4">
                                    <button onclick="likePost(this)" class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition-colors">
                                        <span>❤️</span>
                                        <span class="text-sm">42</span>
                                    </button>
                                    <button onclick="commentPost()" class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition-colors">
                                        <span>💬</span>
                                        <span class="text-sm">8</span>
                                    </button>
                                    <button onclick="sharePost()" class="flex items-center space-x-1 text-gray-500 hover:text-green-500 transition-colors">
                                        <span>↗️</span>
                                        <span class="text-sm">3</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Top Creators Leaderboard -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">🏆 Top Creators</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">1</span>
                            </div>
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face" alt="Top creator" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Alex Chen</p>
                                <p class="text-xs text-gray-500">15.2K followers</p>
                            </div>
                            <button onclick="followCreator(this)" class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">Follow</button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">2</span>
                            </div>
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face" alt="Top creator" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Sarah Johnson</p>
                                <p class="text-xs text-gray-500">12.8K followers</p>
                            </div>
                            <button onclick="followCreator(this)" class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">Follow</button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-orange-100 text-orange-800 text-xs font-medium rounded-full">3</span>
                            </div>
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=32&h=32&fit=crop&crop=face" alt="Top creator" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Mike Rodriguez</p>
                                <p class="text-xs text-gray-500">9.5K followers</p>
                            </div>
                            <button onclick="followCreator(this)" class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">Follow</button>
                        </div>
                    </div>
                </div>

                <!-- Suggested Creators -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">💡 Suggested for You</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=32&h=32&fit=crop&crop=face" alt="Suggested creator" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Emma Wilson</p>
                                <p class="text-xs text-gray-500">Portrait specialist</p>
                            </div>
                            <button onclick="followCreator(this)" class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">Follow</button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face" alt="Suggested creator" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">David Park</p>
                                <p class="text-xs text-gray-500">Nature photographer</p>
                            </div>
                            <button onclick="followCreator(this)" class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">Follow</button>
                        </div>
                    </div>
                </div>

                <!-- Trending Hashtags -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">🔥 Trending Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 cursor-pointer hover:bg-purple-200 transition-colors">#Nature</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 cursor-pointer hover:bg-blue-200 transition-colors">#Wedding</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 cursor-pointer hover:bg-green-200 transition-colors">#Street</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 cursor-pointer hover:bg-yellow-200 transition-colors">#Portrait</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800 cursor-pointer hover:bg-pink-200 transition-colors">#Landscape</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 cursor-pointer hover:bg-indigo-200 transition-colors">#Architecture</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-lg">C</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Capturra</span>
                    </div>
                    <p class="text-gray-600 mb-4">The ultimate platform for photographers to showcase, connect, and grow their creative community.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-purple-500 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-500 transition-colors">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-500 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">About Capturra</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Community</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Guidelines</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Creator Program</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-gray-500 text-sm">© 2024 Capturra. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navigation functions
        function goHome() {
            alert('Navigating to homepage!');
        }

        function toggleNotifications() {
            alert('Notifications panel would open here!');
        }

        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        function closeProfileMenu() {
            const menu = document.getElementById('profileMenu');
            if (menu && !menu.classList.contains('hidden')) menu.classList.add('hidden');
        }

        // Hero section functions
        function uploadPhoto() {
            alert('Photo upload dialog would open here! 📷');
        }

        function viewPortfolio() {
            alert('Navigating to your portfolio!');
        }

        function hirePhotographer() {
            alert('Opening photographer hiring interface!');
        }

        // Post interaction functions
        function likePost(button) {
            const likeCount = button.querySelector('span:last-child');
            const currentCount = parseInt(likeCount.textContent);
            likeCount.textContent = currentCount + 1;
            button.classList.add('text-red-500');
            button.classList.remove('text-gray-500');
        }

        function commentPost() {
            alert('Comment dialog would open here! 💬');
        }

        function sharePost() {
            alert('Share options would appear here! ↗️');
        }

        // Creator interaction functions
        function followCreator(button) {
            if (button.textContent === 'Follow') {
                button.textContent = 'Following';
                button.classList.remove('bg-purple-100', 'text-purple-700', 'hover:bg-purple-200');
                button.classList.add('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            } else {
                button.textContent = 'Follow';
                button.classList.remove('bg-green-100', 'text-green-700', 'hover:bg-green-200');
                button.classList.add('bg-purple-100', 'text-purple-700', 'hover:bg-purple-200');
            }
        }

        // Close profile menu when clicking outside
        document.addEventListener('click', function(event) {
            const profileMenu = document.getElementById('profileMenu');
            const profileButton = event.target.closest('button');
            
            if (!profileButton || !profileButton.onclick || profileButton.onclick.toString().indexOf('toggleProfileMenu') === -1) {
                profileMenu.classList.add('hidden');
            }
        });

        // Search functionality
        document.querySelector('input[type="text"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                alert(`Searching for: "${this.value}"`);
            }
        });

        // Hashtag click functionality
        document.querySelectorAll('[class*="rounded-full"][class*="cursor-pointer"]').forEach(tag => {
            tag.addEventListener('click', function() {
                const tagName = this.textContent;
                alert(`Exploring ${tagName} photos!`);
            });
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'977391c52447f651',t:'MTc1NjU0OTM3Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>

<script>
function logout() {
  fetch("http://localhost:8888/Capturra/api/auth/logout.php")
    .then(res => res.json())
    .then(data => {
      if (data.status) {
        window.location.href = "/Capturra/public/login.html";
      } else {
        alert("Logout failed");
      }
    })
    .catch(err => {
      console.error(err);
      alert("Server error");
    });
}
</script>


</body>
</html>

<script>
(function(){
    const btn = document.getElementById('darkToggle');
    if(!btn) return;
    const KEY = 'capturra-dark';
    function applyDark(d){
        document.documentElement.classList.toggle('dark', d);
        document.body.classList.toggle('dark', d);
        btn.setAttribute('aria-pressed', d);
        btn.textContent = d ? '☀️' : '🌙';
        if(d) btn.classList.add('active'); else btn.classList.remove('active');
    }
    const saved = localStorage.getItem(KEY);
    const prefers = saved !== null ? saved === '1' : (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
    applyDark(prefers);
    btn.addEventListener('click', function(){
        const isDark = !document.documentElement.classList.contains('dark');
        applyDark(isDark);
        localStorage.setItem(KEY, isDark ? '1' : '0');
    });
})();
</script>
