<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Grafik - Perpustakaan API</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="app-layout">
        
        <!-- SIDEBAR -->
        <?php include __DIR__ . '/../layouts/sidebar.view.php'; ?>

        <!-- MAIN CONTENT AREA -->
        <div class="main-wrapper">
            
            <!-- TOP HEADER -->
            <div class="top-header">
                <div class="header-title">
                    <h1>Statistik & Grafik Data Buku</h1>
                    <p>Visualisasi grafik ringkas dan esensial data koleksi buku perpustakaan</p>
                </div>

                <div class="header-right">
                    <!-- DARK MODE TOGGLE BUTTON -->
                    <button id="darkModeToggle" class="dark-toggle-btn" title="Toggle Dark/Light Mode" onclick="toggleDarkMode()">
                        <i class="fa-solid fa-moon"></i>
                    </button>

                    <!-- USER PROFILE -->
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span><?= htmlspecialchars($_SESSION['admin']); ?></span>
                    </div>
                </div>
            </div>

            <!-- STATISTIK CARDS (4 KOTAK RINGKASAN) -->
            <?php include __DIR__ . '/../layouts/stats-cards.view.php'; ?>

            <!-- 2 GRAFIK UTAMA & ESENSIAL -->
            <div class="charts-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px;">
                
                <!-- GRAFIK 1: KATEGORI BUKU -->
                <div class="card" style="padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-chart-pie" style="color: var(--primary);"></i> 1. Grafik Distribusi per Kategori Buku
                    </h3>
                    <div style="height: 320px; position: relative;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- GRAFIK 2: TAHUN TERBIT BUKU -->
                <div class="card" style="padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--text-main); display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-chart-column" style="color: #10b981;"></i> 2. Grafik Tren Publikasi per Tahun Terbit
                    </h3>
                    <div style="height: 320px; position: relative;">
                        <canvas id="yearChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPT FETCH API, CHARTS & DARK MODE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();
            loadBooksForCharts();
        });

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateDarkModeIcon();
        }

        function initDarkMode() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
            updateDarkModeIcon();
        }

        function updateDarkModeIcon() {
            const toggleBtn = document.getElementById('darkModeToggle');
            if (!toggleBtn) return;
            const isDark = document.body.classList.contains('dark-mode');
            toggleBtn.innerHTML = isDark ? '<i class="fa-solid fa-sun" style="color: #f59e0b;"></i>' : '<i class="fa-solid fa-moon"></i>';
        }

        function loadBooksForCharts() {
            fetch("data_json.php")
                .then(response => response.json())
                .then(books => {
                    renderCharts(books);
                })
                .catch(error => {
                    console.error('Error fetching API for charts:', error);
                });
        }

        function renderCharts(books) {
            const catCounts = {};
            books.forEach(b => {
                const cat = b.kategori || 'Lainnya';
                catCounts[cat] = (catCounts[cat] || 0) + 1;
            });
            const catLabels = Object.keys(catCounts);
            const catData = Object.values(catCounts);

            const yearCounts = {};
            books.forEach(b => {
                const yr = b.tahun_terbit || 'Unknown';
                yearCounts[yr] = (yearCounts[yr] || 0) + 1;
            });
            const yearLabels = Object.keys(yearCounts).sort();
            const yearData = yearLabels.map(y => yearCounts[y]);

            const ctxCat = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catData,
                        backgroundColor: ['#0066ff', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { family: 'Inter', size: 12, weight: '600' }, padding: 16 }
                        }
                    }
                }
            });

            const ctxYr = document.getElementById('yearChart').getContext('2d');
            new Chart(ctxYr, {
                type: 'bar',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        label: 'Jumlah Buku Terbit',
                        data: yearData,
                        backgroundColor: '#10b981',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: 'Inter', size: 12, weight: '600' } } }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
    </script>
</body>
</html>
