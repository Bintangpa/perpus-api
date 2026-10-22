<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Center Dashboard - Perpustakaan API</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="app-layout">
        
        <!-- SIDEBAR -->
        <?php include __DIR__ . '/../layouts/sidebar.view.php'; ?>

        <!-- MAIN CONTENT AREA -->
        <div class="main-wrapper">
            
            <!-- TOP HEADER WITH USER PROFILE & DARK MODE TOGGLE -->
            <div class="top-header">
                <div class="header-title">
                    <h1>Control Center Dashboard</h1>
                    <p>Pusat kontrol utama, ringkasan statistik, dan manajemen sistem perpustakaan</p>
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

            <!-- ALERTS FROM CRUD -->
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Berhasil memperbarui data buku!</span>
                </div>
            <?php endif; ?>

            <!-- STATISTIK SECTION (4 KOTAK RINGKASAN UTAMA) -->
            <?php include __DIR__ . '/../layouts/stats-cards.view.php'; ?>

            <!-- GRID MODUL KONTROL & NAVIGASI CEPAT -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 24px;">
                
                <!-- CARD 1: DATA BUKU -->
                <div class="card" style="padding: 20px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <span style="font-size: 11px; font-weight: 700; background: var(--primary-light); color: var(--primary); padding: 3px 8px; border-radius: 20px;">
                            <?= $total_buku; ?> Buku
                        </span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Kelola Data Buku</h4>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.4;">Tabel koleksi data buku lengkap dengan fitur pencarian, filter, edit, dan hapus.</p>
                    <a href="buku.php" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">
                        Kelola Data Buku <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i>
                    </a>
                </div>

                <!-- CARD 2: GRAFIK & STATISTIK -->
                <div class="card" style="padding: 20px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <span style="font-size: 11px; font-weight: 700; background: var(--primary-light); color: var(--primary); padding: 3px 8px; border-radius: 20px;">
                            Interactive
                        </span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Statistik & Grafik</h4>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.4;">Visualisasi diagram lingkaran & batang untuk distribusi kategori dan tahun terbit.</p>
                    <a href="statistik.php" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; color: var(--primary); border-color: var(--primary);">
                        Buka Grafik <i class="fa-solid fa-chart-line" style="margin-left: 6px;"></i>
                    </a>
                </div>

                <!-- CARD 3: EXPORT LAPORAN -->
                <div class="card" style="padding: 20px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa-solid fa-file-export"></i>
                        </div>
                        <span style="font-size: 11px; font-weight: 700; background: var(--primary-light); color: var(--primary); padding: 3px 8px; border-radius: 20px;">
                            PDF / Excel
                        </span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Export Laporan</h4>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.4;">Ekspor laporan perpustakaan ke format Spreadsheet Excel atau dokumen PDF.</p>
                    <a href="export.php" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; color: var(--primary); border-color: var(--primary);">
                        Halaman Export <i class="fa-solid fa-download" style="margin-left: 6px;"></i>
                    </a>
                </div>

                <!-- CARD 4: ENDPOINT API JSON -->
                <div class="card" style="padding: 20px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <span style="font-size: 11px; font-weight: 700; background: var(--primary-light); color: var(--primary); padding: 3px 8px; border-radius: 20px;">
                            REST API
                        </span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">JSON API Endpoint</h4>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.4;">Akses langsung data JSON publik untuk kebutuhan integrasi web & mobile.</p>
                    <a href="data_json.php" target="_blank" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                        Cek JSON API <i class="fa-solid fa-arrow-up-right-from-square" style="margin-left: 6px;"></i>
                    </a>
                </div>

            </div>

            <!-- SECTION OVERVIEW: PREVIEW BUKU TERBARU & STATUS SISTEM -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
                
                <!-- TABEL PREVIEW BUKU TERBARU -->
                <div class="card" style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Buku Terbaru Ditambahkan
                            </h4>
                            <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">5 rekaman data buku paling baru dalam database</p>
                        </div>
                        <a href="buku.php" class="btn btn-outline btn-sm" style="font-size: 12px;">
                            Lihat Semua <i class="fa-solid fa-chevron-right" style="margin-left: 4px;"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>KODE</th>
                                    <th>JUDUL BUKU</th>
                                    <th>PENULIS</th>
                                    <th>KATEGORI</th>
                                    <th>TAHUN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_books)): ?>
                                    <?php foreach ($recent_books as $b): ?>
                                        <tr>
                                            <td><span class="badge"><?= htmlspecialchars($b['kode_buku']); ?></span></td>
                                            <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($b['judul']); ?></td>
                                            <td><?= htmlspecialchars($b['penulis']); ?></td>
                                            <td><?= htmlspecialchars($b['kategori']); ?></td>
                                            <td><?= htmlspecialchars($b['tahun_terbit']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 18px;">
                                            Belum ada data buku tersimpan.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- WIDGET CONTROL STATUS SISTEM -->
                <div class="card" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-server" style="color: var(--primary);"></i> Status Sistem
                        </h4>
                        
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid var(--border-light);">
                                <span style="font-size: 12.5px; color: var(--text-muted); font-weight: 500;">Database Status</span>
                                <span style="font-size: 11.5px; font-weight: 700; color: #10b981; background: #ecfdf5; padding: 3px 10px; border-radius: 20px; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-circle" style="font-size: 7px;"></i> Connected
                                </span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid var(--border-light);">
                                <span style="font-size: 12.5px; color: var(--text-muted); font-weight: 500;">API Endpoint</span>
                                <span style="font-size: 11.5px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 3px 10px; border-radius: 20px;">
                                    REST JSON
                                </span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid var(--border-light);">
                                <span style="font-size: 12.5px; color: var(--text-muted); font-weight: 500;">Total Koleksi</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--text-main);">
                                    <?= $total_buku; ?> Rekaman
                                </span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 12.5px; color: var(--text-muted); font-weight: 500;">Autentikasi Admin</span>
                                <span style="font-size: 12.5px; font-weight: 700; color: var(--text-main);">
                                    <?= htmlspecialchars($_SESSION['admin']); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 24px;">
                        <button onclick="openTambahModal()" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <i class="fa-solid fa-plus-circle"></i> Tambah Buku Baru
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL TAMBAH BUKU -->
    <?php include __DIR__ . '/../buku/modal-tambah.view.php'; ?>

    <!-- SCRIPT FETCH API & DARK MODE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();
        });

        // DARK MODE SCRIPT
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

        function openTambahModal() {
            document.getElementById('tambahModal').classList.add('active');
        }
        function closeTambahModal() {
            document.getElementById('tambahModal').classList.remove('active');
        }
    </script>
</body>
</html>
