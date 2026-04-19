<?php
// settings.php - include in your main layout or use standalone
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturra - Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f0f13; color: #e2e0f0; margin: 0; padding: 0; }
 
        .s-card {
            background: #16161f;
            border: 1px solid #2a2a3e;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 18px;
        }
        .s-card h3 { font-size:15px; font-weight:600; color:#e2e0f0; margin:0 0 4px; }
        .s-desc    { font-size:12px; color:#6b6b8a; margin:0 0 20px; }
 
        .s-input {
            width: 100%;
            background: #0f0f13;
            border: 1px solid #3a3a5c;
            border-radius: 10px;
            color: #e2e0f0;
            padding: 10px 14px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .3s;
            margin-bottom: 14px;
            box-sizing: border-box;
        }
        .s-input:focus { border-color: #7c3aed; }
        .s-input::placeholder { color: #4a4a6a; }
 
        .s-label { display:block; font-size:12px; color:#a0a0c0; margin-bottom:5px; }
 
        .save-btn {
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity .3s;
        }
        .save-btn:hover { opacity: 0.88; }
 
        .danger-btn {
            background: transparent;
            border: 1px solid #7f1d1d;
            color: #f87171;
            padding: 9px 20px;
            border-radius: 10px;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .3s;
        }
        .danger-btn:hover { background: #2a1010; border-color: #ef4444; }
 
        .toggle { position:relative; width:42px; height:22px; flex-shrink:0; }
        .toggle input { opacity:0; width:0; height:0; }
        .t-slider {
            position:absolute; inset:0;
            background:#2a2a3e; border-radius:22px; cursor:pointer; transition:.3s;
        }
        .t-slider::before {
            content:''; position:absolute;
            width:16px; height:16px; background:#6b6b8a;
            border-radius:50%; left:3px; top:3px; transition:.3s;
        }
        .toggle input:checked + .t-slider { background:#1e1535; }
        .toggle input:checked + .t-slider::before { transform:translateX(20px); background:#a855f7; }
 
        .t-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:13px 0; border-bottom:1px solid #1e1e2e;
        }
        .t-row:last-child { border-bottom:none; padding-bottom:0; }
        .t-title { font-size:13px; color:#e2e0f0; }
        .t-sub   { font-size:11px; color:#6b6b8a; margin-top:2px; }
 
        .sidebar-nav {
            background: #16161f;
            border: 1px solid #2a2a3e;
            border-radius: 14px;
            overflow: hidden;
        }
        .s-nav-item {
            display:flex; align-items:center; gap:10px;
            padding:12px 18px; font-size:13px; color:#a0a0c0;
            cursor:pointer; border-left:3px solid transparent; transition:all .2s;
            border:none; background:none; width:100%; text-align:left;
            font-family:'Inter',sans-serif;
        }
        .s-nav-item:hover { background:#1e1535; color:#e2e0f0; }
        .s-nav-item.active { background:#1e1535; color:#a855f7; border-left:3px solid #7c3aed; }
        .s-nav-item i { width:16px; text-align:center; font-size:13px; }
 
        .tab-content { display:none; }
        .tab-content.active { display:block; }
 
        .avatar-circle {
            width:72px; height:72px; border-radius:50%;
            background:linear-gradient(135deg,#7c3aed,#a855f7);
            display:flex; align-items:center; justify-content:center;
            font-size:24px; font-weight:700; color:#fff; flex-shrink:0;
        }
        .plan-badge {
            background:#1e1535; color:#a855f7;
            border:1px solid #3a2060; font-size:11px;
            padding:3px 10px; border-radius:20px; font-weight:600;
        }
    </style>
</head>
<body>
 
<div style="max-width:1100px; margin:0 auto; padding:40px 24px 60px;">
 
    <!-- Page Title -->
    <div style="margin-bottom:28px;">
        <h1 style="font-size:28px; font-weight:700; color:#fff; margin:0 0 4px;">Settings</h1>
        <p style="font-size:13px; color:#6b6b8a; margin:0;">Manage your account preferences and privacy</p>
    </div>
 
    <div style="display:grid; grid-template-columns:220px 1fr; gap:24px;">
 
        <!-- Sidebar -->
        <div>
            <!-- Profile card -->
            <div class="s-card" style="display:flex; align-items:center; gap:14px; margin-bottom:14px;">
                <div class="avatar-circle" style="width:48px;height:48px;font-size:16px;">AC</div>
                <div>
                    <div style="font-size:13px; font-weight:600; color:#fff;">Alex Chen</div>
                    <div style="font-size:11px; color:#6b6b8a; margin-top:2px;">alex@gmail.com</div>
                    <div style="margin-top:4px;"><span class="plan-badge">Pro</span></div>
                </div>
            </div>
 
            <div class="sidebar-nav">
                <button class="s-nav-item active" onclick="switchTab('profile',this)"><i class="fa-solid fa-user"></i> Profile</button>
                <button class="s-nav-item" onclick="switchTab('account',this)"><i class="fa-solid fa-shield"></i> Account & Security</button>
                <button class="s-nav-item" onclick="switchTab('notifications',this)"><i class="fa-solid fa-bell"></i> Notifications</button>
                <button class="s-nav-item" onclick="switchTab('privacy',this)"><i class="fa-solid fa-lock"></i> Privacy</button>
                <button class="s-nav-item" onclick="switchTab('billing',this)"><i class="fa-solid fa-credit-card"></i> Billing</button>
                <button class="s-nav-item" onclick="switchTab('appearance',this)"><i class="fa-solid fa-palette"></i> Appearance</button>
            </div>
        </div>
 
        <!-- Content -->
        <div>
 
            <!-- Profile -->
            <div id="tab-profile" class="tab-content active">
                <div class="s-card">
                    <h3>Profile Information</h3>
                    <p class="s-desc">Update your public profile details</p>
                    <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid #1e1e2e;">
                        <div class="avatar-circle">AC</div>
                        <div style="display:flex; gap:10px;">
                            <button class="save-btn" style="padding:8px 16px; font-size:12px;">Change Photo</button>
                            <button class="danger-btn" style="padding:8px 14px; font-size:12px;">Remove</button>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div><label class="s-label">First Name</label><input type="text" class="s-input" value="Alex"></div>
                        <div><label class="s-label">Last Name</label><input type="text" class="s-input" value="Chen"></div>
                        <div><label class="s-label">Username</label><input type="text" class="s-input" value="@alexchen"></div>
                        <div><label class="s-label">Role</label>
                            <select class="s-input" style="-webkit-appearance:none;">
                                <option selected>Photographer</option>
                                <option>Client</option>
                            </select>
                        </div>
                        <div style="grid-column:span 2;"><label class="s-label">Bio</label>
                            <textarea class="s-input" rows="3" style="resize:none;">Portrait specialist based in New York.</textarea>
                        </div>
                        <div><label class="s-label">Location</label><input type="text" class="s-input" value="New York, USA"></div>
                        <div><label class="s-label">Website</label><input type="url" class="s-input" placeholder="https://yoursite.com"></div>
                    </div>
                    <button class="save-btn">Save Changes</button>
                </div>
            </div>
 
            <!-- Account -->
            <div id="tab-account" class="tab-content">
                <div class="s-card">
                    <h3>Email Address</h3><p class="s-desc">Update your login email</p>
                    <label class="s-label">Current Email</label><input type="email" class="s-input" value="alex@gmail.com">
                    <label class="s-label">New Email</label><input type="email" class="s-input" placeholder="Enter new email">
                    <button class="save-btn">Update Email</button>
                </div>
                <div class="s-card">
                    <h3>Change Password</h3><p class="s-desc">Use a strong password to stay secure</p>
                    <label class="s-label">Current Password</label><input type="password" class="s-input" placeholder="••••••••">
                    <label class="s-label">New Password</label><input type="password" class="s-input" placeholder="••••••••">
                    <label class="s-label">Confirm New Password</label><input type="password" class="s-input" placeholder="••••••••">
                    <button class="save-btn">Update Password</button>
                </div>
                <div class="s-card" style="border-color:#3a1010;">
                    <h3 style="color:#f87171;">Danger Zone</h3>
                    <p class="s-desc">These actions are permanent and cannot be undone.</p>
                    <div style="display:flex; gap:10px;">
                        <button class="danger-btn">Deactivate Account</button>
                        <button class="danger-btn" style="border-color:#ef4444;color:#ef4444;">Delete Account</button>
                    </div>
                </div>
            </div>
 
            <!-- Notifications -->
            <div id="tab-notifications" class="tab-content">
                <div class="s-card">
                    <h3>Email Notifications</h3><p class="s-desc">Choose what emails you want to receive</p>
                    <div class="t-row"><div><div class="t-title">New Followers</div><div class="t-sub">When someone follows your profile</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Photo Likes</div><div class="t-sub">When someone likes your photo</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Comments</div><div class="t-sub">When someone comments on your work</div></div><label class="toggle"><input type="checkbox"><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Booking Requests</div><div class="t-sub">When a client requests a booking</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Newsletter</div><div class="t-sub">Weekly articles and tips</div></div><label class="toggle"><input type="checkbox"><span class="t-slider"></span></label></div>
                </div>
                <div class="s-card">
                    <h3>Push Notifications</h3><p class="s-desc">Manage in-app and browser notifications</p>
                    <div class="t-row"><div><div class="t-title">Enable Push Notifications</div><div class="t-sub">Real-time alerts in browser</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Direct Messages</div><div class="t-sub">New messages from clients</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                </div>
                <button class="save-btn">Save Preferences</button>
            </div>
 
            <!-- Privacy -->
            <div id="tab-privacy" class="tab-content">
                <div class="s-card">
                    <h3>Privacy Settings</h3><p class="s-desc">Control who can see your content</p>
                    <div class="t-row"><div><div class="t-title">Public Profile</div><div class="t-sub">Anyone can view your profile</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Show in Search Results</div><div class="t-sub">Appear when people search photographers</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Show Follower Count</div><div class="t-sub">Display followers on your profile</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Allow Direct Messages</div><div class="t-sub">Let clients message you</div></div><label class="toggle"><input type="checkbox" checked><span class="t-slider"></span></label></div>
                    <div class="t-row"><div><div class="t-title">Show Activity Status</div><div class="t-sub">Show when you were last active</div></div><label class="toggle"><input type="checkbox"><span class="t-slider"></span></label></div>
                </div>
                <button class="save-btn">Save Privacy Settings</button>
            </div>
 
            <!-- Billing -->
            <div id="tab-billing" class="tab-content">
                <div class="s-card">
                    <h3>Current Plan</h3><p class="s-desc">Your active subscription</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border-radius:10px;background:#1a0a2e;border:1px solid #3a2060;margin-bottom:16px;">
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#fff;">Pro Plan</div>
                            <div style="font-size:12px;color:#a0a0c0;margin-top:3px;">₹999/month · Renews May 15, 2025</div>
                        </div>
                        <span class="plan-badge">Active</span>
                    </div>
                    <div style="display:flex;gap:10px;">
                        <button class="save-btn">Upgrade Plan</button>
                        <button class="danger-btn">Cancel Plan</button>
                    </div>
                </div>
                <div class="s-card">
                    <h3>Payment Method</h3><p class="s-desc">Your saved payment methods</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;border-radius:10px;background:#0f0f13;border:1px solid #2a2a3e;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <i class="fa-brands fa-cc-visa" style="font-size:22px;color:#a855f7;"></i>
                            <div>
                                <div style="font-size:13px;font-weight:500;color:#fff;">Visa ending in 4242</div>
                                <div style="font-size:11px;color:#6b6b8a;margin-top:2px;">Expires 12/26</div>
                            </div>
                        </div>
                        <button class="danger-btn" style="font-size:12px;padding:6px 12px;">Remove</button>
                    </div>
                    <button class="save-btn" style="font-size:12px;padding:9px 18px;">+ Add Payment Method</button>
                </div>
                <div class="s-card">
                    <h3>Billing History</h3><p class="s-desc">Your recent transactions</p>
                    <table style="width:100%;font-size:13px;border-collapse:collapse;">
                        <thead><tr style="color:#6b6b8a;border-bottom:1px solid #2a2a3e;">
                            <th style="text-align:left;padding-bottom:10px;font-weight:500;">Date</th>
                            <th style="text-align:left;padding-bottom:10px;font-weight:500;">Description</th>
                            <th style="text-align:left;padding-bottom:10px;font-weight:500;">Amount</th>
                            <th style="text-align:left;padding-bottom:10px;font-weight:500;">Status</th>
                        </tr></thead>
                        <tbody style="color:#a0a0c0;">
                            <tr style="border-bottom:1px solid #1e1e2e;"><td style="padding:10px 0;">Apr 15, 2025</td><td>Pro Plan</td><td>₹999</td><td style="color:#4ade80;font-size:12px;">✓ Paid</td></tr>
                            <tr style="border-bottom:1px solid #1e1e2e;"><td style="padding:10px 0;">Mar 15, 2025</td><td>Pro Plan</td><td>₹999</td><td style="color:#4ade80;font-size:12px;">✓ Paid</td></tr>
                            <tr><td style="padding:10px 0;">Feb 15, 2025</td><td>Pro Plan</td><td>₹999</td><td style="color:#4ade80;font-size:12px;">✓ Paid</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
 
            <!-- Appearance -->
            <div id="tab-appearance" class="tab-content">
                <div class="s-card">
                    <h3>Theme</h3><p class="s-desc">Choose your preferred interface theme</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                        <div style="padding:16px;border-radius:10px;text-align:center;cursor:pointer;background:#0f0f13;border:2px solid #7c3aed;">
                            <div style="font-size:22px;margin-bottom:6px;">🌙</div>
                            <div style="font-size:13px;font-weight:500;color:#fff;">Dark</div>
                            <div style="font-size:11px;margin-top:2px;color:#a855f7;">Active</div>
                        </div>
                        <div style="padding:16px;border-radius:10px;text-align:center;cursor:pointer;background:#0f0f13;border:1px solid #2a2a3e;">
                            <div style="font-size:22px;margin-bottom:6px;">☀️</div>
                            <div style="font-size:13px;font-weight:500;color:#fff;">Light</div>
                            <div style="font-size:11px;margin-top:2px;color:#6b6b8a;">Coming soon</div>
                        </div>
                        <div style="padding:16px;border-radius:10px;text-align:center;cursor:pointer;background:#0f0f13;border:1px solid #2a2a3e;">
                            <div style="font-size:22px;margin-bottom:6px;">💻</div>
                            <div style="font-size:13px;font-weight:500;color:#fff;">System</div>
                            <div style="font-size:11px;margin-top:2px;color:#6b6b8a;">Auto</div>
                        </div>
                    </div>
                </div>
                <div class="s-card">
                    <h3>Language</h3><p class="s-desc">Select your display language</p>
                    <select class="s-input" style="-webkit-appearance:none;width:200px;">
                        <option selected>English</option>
                        <option>Hindi</option>
                        <option>Spanish</option>
                        <option>French</option>
                    </select>
                    <button class="save-btn">Save</button>
                </div>
            </div>
 
        </div>
    </div>
</div>
 
<script>
function switchTab(name, el) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.s-nav-item').forEach(s => s.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    el.classList.add('active');
}
</script>
</body>
</html>