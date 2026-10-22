<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-book"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_buku; ?></h3>
            <p>TOTAL BUKU</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-tags"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_kategori; ?></h3>
            <p>KATEGORI</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-user-pen"></i>
        </div>
        <div class="stat-info">
            <h3><?= $total_penulis; ?></h3>
            <p>DATA PENULIS</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <div class="stat-info">
            <h3><?= $tahun_terbaru; ?></h3>
            <p>TERBIT TERBARU</p>
        </div>
    </div>
</div>

<!-- SECTION GRAFIK DEDIKASI STATISTIK (CHART.JS) -->
<div class="charts-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
    <div class="card" style="padding: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 16px; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-chart-pie" style="color: var(--primary);"></i> Distribusi Buku per Kategori
        </h4>
        <div style="height: 220px; position: relative;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div class="card" style="padding: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 16px; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-chart-column" style="color: #10b981;"></i> Jumlah Buku per Tahun Terbit
        </h4>
        <div style="height: 220px; position: relative;">
            <canvas id="yearChart"></canvas>
        </div>
    </div>
</div>
