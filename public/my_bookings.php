<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookings - Capturra</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
}

/* Glass effect */
.glass {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
}

/* Glow hover */
.glow:hover {
    box-shadow: 0 0 20px rgba(168,85,247,0.6);
}
</style>
</head>

<body class="text-white">



<!-- PAGE TITLE -->
<div class="text-center mt-8">
    <h2 class="text-3xl font-bold text-purple-300">📅 My Bookings</h2>
    <p class="text-gray-300 mt-2">Track your photography sessions easily</p>
</div>

<!-- BOOKINGS GRID -->
<div class="max-w-6xl mx-auto p-6 grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- BOOKING CARD -->
    <div class="glass rounded-xl p-5 glow transition">

        <img src="https://images.unsplash.com/photo-1519741497674-611481863552"
             class="rounded-lg mb-4 h-40 w-full object-cover">

        <h3 class="text-lg font-semibold">Wedding Shoot</h3>
        <p class="text-sm text-gray-300">Photographer: Rahul Sharma</p>

        <div class="mt-3 space-y-1 text-sm">
            <p>📍 Location: Mumbai</p>
            <p>📅 Date: 25 Dec 2026</p>
            <p>⏰ Time: 10:00 AM</p>
        </div>

        <!-- STATUS -->
        <div class="mt-4 flex justify-between items-center">
            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs">
                Confirmed
            </span>

            <button onclick="cancelBooking(this)"
                class="text-red-400 hover:text-red-300 text-sm">
                Cancel
            </button>
        </div>
    </div>

    <!-- CARD 2 -->
    <div class="glass rounded-xl p-5 glow transition">

        <img src="https://images.unsplash.com/photo-1492724441997-5dc865305da7"
             class="rounded-lg mb-4 h-40 w-full object-cover">

        <h3 class="text-lg font-semibold">Pre-Wedding Shoot</h3>
        <p class="text-sm text-gray-300">Photographer: Ankit Verma</p>

        <div class="mt-3 space-y-1 text-sm">
            <p>📍 Location: Delhi</p>
            <p>📅 Date: 10 Jan 2027</p>
            <p>⏰ Time: 4:00 PM</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs">
                Pending
            </span>

            <button onclick="cancelBooking(this)"
                class="text-red-400 hover:text-red-300 text-sm">
                Cancel
            </button>
        </div>
    </div>

    <!-- CARD 3 -->
    <div class="glass rounded-xl p-5 glow transition">

        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
             class="rounded-lg mb-4 h-40 w-full object-cover">

        <h3 class="text-lg font-semibold">Product Shoot</h3>
        <p class="text-sm text-gray-300">Photographer: Sneha Kapoor</p>

        <div class="mt-3 space-y-1 text-sm">
            <p>📍 Location: Bangalore</p>
            <p>📅 Date: 5 Feb 2027</p>
            <p>⏰ Time: 2:00 PM</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs">
                Cancelled
            </span>

            <button class="text-gray-400 text-sm cursor-not-allowed">
                Cancelled
            </button>
        </div>
    </div>

</div>

<!-- EMPTY STATE -->
<div id="emptyState" class="hidden text-center mt-16 text-gray-400">
    <p>No bookings found 😕</p>
</div>

<!-- JS -->
<script>
function cancelBooking(btn){
    const card = btn.closest('.glass');
    card.remove();

    // check if no bookings left
    const remaining = document.querySelectorAll('.glass');
    if(remaining.length === 1){ // navbar is also glass
        document.getElementById('emptyState').classList.remove('hidden');
    }
}
</script>

</body>
</html>