<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Capturra Analytics</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: #0a0a0f;
}

/* Glass Card */
.card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(168,85,247,0.2);
    backdrop-filter: blur(12px);
}

/* Glow */
.glow:hover {
    box-shadow: 0 0 25px rgba(168,85,247,0.6);
    transform: translateY(-5px);
    transition: 0.3s;
}

/* Neon text */
.neon {
    text-shadow: 0 0 10px rgba(168,85,247,0.8);
}
</style>
</head>

<body class="text-white">


<!-- HEADER -->
<div class="text-center mt-8">
    <h2 class="text-3xl font-bold text-purple-400 neon">📊 Analytics Dashboard</h2>
    <p class="text-gray-400 mt-2">Visualize your growth</p>
</div>

<!-- STATS -->
<div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 p-6">

    <div class="card p-6 rounded-xl glow text-center">
        <h3 class="text-gray-400">Total Bookings</h3>
        <p class="text-3xl font-bold text-purple-400 mt-2">120</p>
    </div>

    <div class="card p-6 rounded-xl glow text-center">
        <h3 class="text-gray-400">Total Earnings</h3>
        <p class="text-3xl font-bold text-green-400 mt-2">₹50,000</p>
    </div>

    <div class="card p-6 rounded-xl glow text-center">
        <h3 class="text-gray-400">Total Likes</h3>
        <p class="text-3xl font-bold text-pink-400 mt-2">2.3K</p>
    </div>

</div>

<!-- CHARTS -->
<div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-6 px-6 pb-10">

    <!-- BOOKINGS -->
    <div class="card p-5 rounded-xl">
        <h3 class="mb-3 text-purple-400 font-semibold">📈 Bookings Growth</h3>
        <canvas id="bookingChart"></canvas>
    </div>

    <!-- EARNINGS -->
    <div class="card p-5 rounded-xl">
        <h3 class="mb-3 text-purple-400 font-semibold">💰 Earnings Trend</h3>
        <canvas id="earningChart"></canvas>
    </div>

</div>

<script>

// BOOKINGS LINE CHART
new Chart(document.getElementById('bookingChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'Bookings',
            data: [10, 25, 18, 35, 28, 45],
            borderColor: '#a855f7',
            backgroundColor: 'rgba(168,85,247,0.2)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff'
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: '#ccc' } }
        },
        scales: {
            x: { ticks: { color: '#aaa' } },
            y: { ticks: { color: '#aaa' } }
        }
    }
});

// EARNINGS BAR CHART
new Chart(document.getElementById('earningChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'Earnings',
            data: [5000, 9000, 7000, 12000, 10000, 15000],
            backgroundColor: '#7c3aed'
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: '#ccc' } }
        },
        scales: {
            x: { ticks: { color: '#aaa' } },
            y: { ticks: { color: '#aaa' } }
        }
    }
});

</script>

</body>
</html>