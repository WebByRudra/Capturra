<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile | Capturra</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    background: radial-gradient(circle at top,#1a0a2e,#0f0f13);
    color:white;
    font-family:'Inter',sans-serif;
}

.glass{
    background: rgba(22,22,31,0.6);
    backdrop-filter: blur(18px);
    border:1px solid rgba(124,58,237,0.2);
    border-radius:20px;
}

.avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    border:3px solid #7c3aed;
    object-fit:cover;
}

.btn{
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
    padding:8px 16px;
    border-radius:10px;
    font-size:13px;
}

.tab{
    padding:8px 18px;
    border-radius:30px;
    border:1px solid #2a2a3e;
    cursor:pointer;
}
.tab.active{
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
}

/* GALLERY */
.gallery{ column-count:3; column-gap:16px; }
.card{ position:relative; margin-bottom:16px; border-radius:12px; overflow:hidden; }
.card img{ width:100%; border-radius:12px; }

.overlay{
    position:absolute;
    bottom:10px;
    left:10px;
    display:flex;
    gap:8px;
}
.icon{
    background:rgba(0,0,0,0.6);
    padding:6px 10px;
    border-radius:20px;
    font-size:12px;
    cursor:pointer;
}

/* MODALS */
.modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.9);
    display:none;
    justify-content:center;
    align-items:center;
}
.modal img{ max-width:80%; max-height:80%; border-radius:12px; }

.comment-box{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    background:#16161f;
    padding:20px;
    display:none;
}
</style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">

<!-- HEADER -->
<div class="glass p-6 flex items-center gap-6 mb-8">
<img id="avatar" src="https://i.pravatar.cc/200" class="avatar">

<div class="flex-1">
<h1 id="name" class="text-2xl font-bold">Vidhisha Shinde</h1>
<p class="text-gray-400">@capturra_user</p>
<p id="bio" class="text-gray-300 mt-2">Photographer 📸 | Story Teller</p>

<div class="flex gap-3 mt-4">
<button class="btn" onclick="openEdit()">Edit Profile</button>
<button class="btn" onclick="toggleFollow()">Follow</button>
</div>
</div>
</div>

<!-- STATS -->
<div class="grid grid-cols-3 gap-4 mb-8">
<div class="glass p-4 text-center"><h2>6</h2><p class="text-gray-400 text-sm">Posts</p></div>
<div class="glass p-4 text-center"><h2>5200</h2><p class="text-gray-400 text-sm">Followers</p></div>
<div class="glass p-4 text-center"><h2>4.8⭐</h2><p class="text-gray-400 text-sm">Rating</p></div>
</div>

<!-- TABS -->
<div class="flex gap-3 mb-6">
<button class="tab active" onclick="showTab('gallery')">Gallery</button>
<button class="tab" onclick="showTab('about')">About</button>
</div>

<!-- GALLERY -->
<div id="gallery" class="tab-content">
<div class="gallery" id="galleryContainer"></div>
</div>

<!-- 💜 IMPROVED ABOUT SECTION -->
<div id="about" class="tab-content hidden space-y-6">

<!-- BIO -->
<div class="glass p-6">
<h2 class="text-lg font-bold mb-2">About Me</h2>
<p id="aboutText">
I am a passionate photographer specializing in portraits, weddings, and creative storytelling. 
My goal is to capture emotions, moments, and stories through my lens.
</p>
</div>

<!-- SKILLS -->
<div class="glass p-6">
<h2 class="text-lg font-bold mb-4">Skills</h2>
<div class="flex flex-wrap gap-2">
<span class="tag">Portrait</span>
<span class="tag">Wedding</span>
<span class="tag">Editing</span>
<span class="tag">Lighting</span>
<span class="tag">Photoshop</span>
</div>
</div>

<!-- SERVICES -->
<div class="glass p-6">
<h2 class="text-lg font-bold mb-2">Services</h2>
<ul class="text-gray-300 space-y-1">
<li>✔ Wedding Photography</li>
<li>✔ Pre-wedding Shoots</li>
<li>✔ Fashion Shoots</li>
<li>✔ Event Coverage</li>
</ul>
</div>

<!-- GEAR -->
<div class="glass p-6">
<h2 class="text-lg font-bold mb-2">My Gear</h2>
<p class="text-gray-300">Canon EOS R5 • Sony A7III • 50mm Lens • 85mm Portrait Lens</p>
</div>

<!-- CONTACT -->
<div class="glass p-6">
<h2 class="text-lg font-bold mb-2">Contact</h2>
<p>Email: user@email.com</p>
<p>Location: India</p>
</div>

</div>

</div>

<!-- MODALS -->
<div id="imgModal" class="modal" onclick="this.style.display='none'">
<img id="modalImg">
</div>

<div id="commentBox" class="comment-box">
<input type="text" placeholder="Add comment..." class="w-full p-2 bg-black border border-gray-700">
<button class="btn mt-2" onclick="closeComment()">Close</button>
</div>

<div id="editModal" class="modal">
<div class="glass p-6">
<h2>Edit Profile</h2>
<input id="editName" placeholder="Name" class="w-full p-2 mb-2 bg-black">
<input id="editBio" placeholder="Bio" class="w-full p-2 mb-2 bg-black">
<button class="btn" onclick="saveProfile()">Save</button>
</div>
</div>

<script>

/* LOAD IMAGES */
let container = document.getElementById("galleryContainer");
for(let i=0;i<12;i++){
container.innerHTML += `
<div class="card">
<img src="https://picsum.photos/400/${500+i*10}?random=${i}" onclick="openModal(this.src)">
<div class="overlay">
<div class="icon" onclick="like(this)">❤️ <span>0</span></div>
<div class="icon" onclick="openComment()">💬</div>
</div>
</div>`;
}

/* FUNCTIONS */
function showTab(tab){
document.querySelectorAll('.tab-content').forEach(t=>t.classList.add('hidden'));
document.getElementById(tab).classList.remove('hidden');
}

function openModal(src){
document.getElementById('imgModal').style.display='flex';
document.getElementById('modalImg').src=src;
}

function like(el){
let span = el.querySelector("span");
span.innerText = parseInt(span.innerText)+1;
}

function openComment(){ document.getElementById('commentBox').style.display='block'; }
function closeComment(){ document.getElementById('commentBox').style.display='none'; }

let following=false;
function toggleFollow(){
following=!following;
event.target.innerText = following ? "Following" : "Follow";
}

function openEdit(){ document.getElementById('editModal').style.display='flex'; }

function saveProfile(){
document.getElementById('name').innerText = document.getElementById('editName').value;
document.getElementById('bio').innerText = document.getElementById('editBio').value;
document.getElementById('editModal').style.display='none';
}

</script>

</body>
</html>