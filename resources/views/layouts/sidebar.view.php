<div class="sidebar">
    <div>
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <span>PerpusApi</span>
        </div>

        <div class="sidebar-section-label">Menu Utama</div>
        <ul class="sidebar-menu">
            <li class="<?= ($active_page ?? '') == 'dashboard' ? 'active' : ''; ?>">
                <a href="dashboard.php">
                    <i class="fa-solid fa-border-all"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= ($active_page ?? '') == 'buku' ? 'active' : ''; ?>">
                <a href="buku.php">
                    <i class="fa-solid fa-book"></i>
                    <span>Data Buku</span>
                </a>
            </li>
            <li class="<?= ($active_page ?? '') == 'statistik' ? 'active' : ''; ?>">
                <a href="statistik.php">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Statistik & Grafik</span>
                </a>
            </li>
            <li class="<?= ($active_page ?? '') == 'export' ? 'active' : ''; ?>">
                <a href="export.php">
                    <i class="fa-solid fa-file-export"></i>
                    <span>Export Laporan</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-section-label">Akun</div>
        <ul class="sidebar-menu">
            <li>
                <a href="logout.php" style="color: #ef4444;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer-widget">
        <h5>Perpustakaan API</h5>
        <p>XII RPL SMK PGRI 2</p>
        <a href="data_json.php" target="_blank">Cek Endpoint JSON</a>
    </div>
</div>
