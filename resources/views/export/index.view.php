<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Laporan - Perpustakaan API</title>
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
            
            <!-- TOP HEADER -->
            <div class="top-header">
                <div class="header-title">
                    <h1>Export Laporan Data Buku</h1>
                    <p>Pusat pengunduhan laporan resmi perpustakaan dalam format Excel (.xls) dan PDF</p>
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

            <!-- EXPORT HERO CARD & FILTER -->
            <div class="card" style="padding: 32px; margin-bottom: 28px; border-left: 6px solid var(--primary);">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <h3 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">
                            <i class="fa-solid fa-file-export" style="color: var(--primary); margin-right: 8px;"></i> Rekap Data & Filter Ekspor
                        </h3>
                        <p style="font-size: 14px; color: var(--text-muted);">
                            Pilih kata kunci atau kategori tertentu jika hanya ingin mengekspor data hasil pencarian spesifik.
                        </p>
                    </div>
                    <span class="badge" style="font-size: 13px; padding: 8px 16px;">
                        <i class="fa-solid fa-database" style="margin-right: 6px;"></i> Total <?= $total_buku; ?> Buku Tersedia
                    </span>
                </div>

                <!-- FILTER INPUTS UNTUK EXPORT -->
                <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                    <div class="search-box" style="width: 300px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="exportSearchInput" placeholder="Cari buku yang akan diekspor..." onkeyup="updateExportCenterLinks()">
                    </div>

                    <div class="select-box">
                        <select id="exportCategoryFilter" onchange="updateExportCenterLinks()">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- EXPORT OPTIONS GRID -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                
                <!-- CARD EXPORT EXCEL -->
                <div class="card" style="padding: 28px; transition: all 0.2s ease;">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: var(--success-light); color: var(--success); display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px;">
                        <i class="fa-solid fa-file-excel"></i>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">Export ke Spreadsheet Excel</h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">
                        Unduh data buku hasil filter ke dalam format Microsoft Excel (<code>data_buku.xls</code>).
                    </p>
                    <a href="export_excel.php" id="centerBtnExcel" class="btn btn-success btn-block" style="padding: 12px 20px;">
                        <i class="fa-solid fa-download"></i> UNDUH FILE EXCEL
                    </a>
                </div>

                <!-- CARD EXPORT PDF -->
                <div class="card" style="padding: 28px; transition: all 0.2s ease;">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: var(--warning-light); color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px;">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">Export ke Dokumen PDF</h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">
                        Unduh laporan resmi hasil filter dalam format dokumen PDF (<code>laporan_data_buku.pdf</code>).
                    </p>
                    <a href="export_pdf.php" id="centerBtnPdf" target="_blank" class="btn btn-warning btn-block" style="padding: 12px 20px;">
                        <i class="fa-solid fa-print"></i> CETAK / UNDUH PDF
                    </a>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();
            fetch("data_json.php")
                .then(r => r.json())
                .then(data => {
                    const catSelect = document.getElementById('exportCategoryFilter');
                    const categories = [...new Set(data.map(b => b.kategori).filter(Boolean))];
                    categories.forEach(cat => {
                        const opt = document.createElement('option');
                        opt.value = cat;
                        opt.textContent = cat;
                        catSelect.appendChild(opt);
                    });
                });
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

        function updateExportCenterLinks() {
            const query = document.getElementById('exportSearchInput').value.toLowerCase().trim();
            const category = document.getElementById('exportCategoryFilter').value;

            const btnExcel = document.getElementById('centerBtnExcel');
            const btnPdf = document.getElementById('centerBtnPdf');

            const params = new URLSearchParams();
            if (query) params.append('search', query);
            if (category) params.append('kategori', category);

            const queryString = params.toString() ? '?' + params.toString() : '';
            btnExcel.href = 'export_excel.php' + queryString;
            btnPdf.href = 'export_pdf.php' + queryString;
        }
    </script>
</body>
</html>
