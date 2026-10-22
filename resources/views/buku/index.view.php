<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - Perpustakaan API</title>
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
                    <h1>Data Buku Perpustakaan</h1>
                    <p>Kelola koleksi data buku, tambah baru, edit, hapus, dan ekspor laporan</p>
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

            <!-- STATISTIK SECTION (4 KOTAK RINGKASAN) -->
            <?php include __DIR__ . '/../layouts/stats-cards.view.php'; ?>

            <!-- TABEL BUKU CARD (DENGAN SEARCH BAR & FILTER KATEGORI) -->
            <div class="card" id="tabelBuku">
                <div class="card-header">
                    <h3>Koleksi Data Buku (<span id="bookCount">0</span> buku)</h3>
                    
                    <div class="header-actions">
                        <!-- FILTER DROPDOWN KATEGORI STYLED -->
                        <div class="select-box">
                            <select id="categoryFilter" onchange="filterBooks()">
                                <option value="">Semua Kategori</option>
                            </select>
                        </div>

                        <!-- URUTKAN (SORTING) STYLED -->
                        <div class="select-box">
                            <select id="sortFilter" onchange="filterBooks()">
                                <option value="id_asc">Urutkan: Default (ID)</option>
                                <option value="judul_asc">Judul (A-Z)</option>
                                <option value="judul_desc">Judul (Z-A)</option>
                                <option value="tahun_desc">Tahun (Terbaru)</option>
                                <option value="tahun_asc">Tahun (Terlama)</option>
                            </select>
                        </div>

                        <!-- LIVE SEARCH BOX DI AREA TABEL BUKU -->
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchInput" placeholder="Cari kode, judul, penulis..." onkeyup="filterBooks()">
                        </div>

                        <button class="btn btn-primary btn-sm" onclick="openTambahModal()">
                            <i class="fa-solid fa-plus"></i> Tambah Buku
                        </button>
                        <a href="export_excel.php" id="btnExportExcel" class="btn btn-success btn-sm" title="Ekspor Hasil Pencarian ke Excel">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </a>
                        <a href="export_pdf.php" id="btnExportPdf" target="_blank" class="btn btn-warning btn-sm" title="Ekspor Hasil Pencarian ke PDF">
                            <i class="fa-solid fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NO / ID</th>
                                <th>KODE BUKU</th>
                                <th>JUDUL BUKU</th>
                                <th>PENULIS</th>
                                <th>KATEGORI</th>
                                <th>TAHUN TERBIT</th>
                                <th>PENERBIT</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="bukuTableBody">
                            <tr>
                                <td colspan="8" style="text-align: center; color: #64748b;">Memuat data via Fetch API...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION CONTROLS CONTAINER -->
                <div class="pagination-wrapper" id="paginationContainer"></div>
            </div>

        </div>
    </div>

    <!-- MODALS -->
    <?php include __DIR__ . '/modal-tambah.view.php'; ?>
    <?php include __DIR__ . '/modal-edit.view.php'; ?>

    <!-- SCRIPT FETCH API, SEARCH FILTER, PAGINATION & DARK MODE -->
    <script>
        let allBooks = [];
        let currentFilteredBooks = [];
        let currentPage = 1;
        const itemsPerPage = 10;

        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();
            loadBooksFromAPI();
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

        function loadBooksFromAPI() {
            fetch("data_json.php")
                .then(response => response.json())
                .then(data => {
                    allBooks = data;
                    populateCategoryDropdown(allBooks);
                    filterBooks();
                })
                .catch(error => {
                    console.error('Error fetching API:', error);
                    document.getElementById('bukuTableBody').innerHTML = `
                        <tr><td colspan="8" style="text-align:center; color:#ef4444;"><i class="fa-solid fa-triangle-exclamation"></i> Gagal mengambil data dari API!</td></tr>`;
                });
        }

        function populateCategoryDropdown(books) {
            const catSelect = document.getElementById('categoryFilter');
            const categories = [...new Set(books.map(b => b.kategori).filter(Boolean))];
            
            catSelect.innerHTML = '<option value="">Semua Kategori</option>';
            categories.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat;
                opt.textContent = cat;
                catSelect.appendChild(opt);
            });
        }

        function filterBooks() {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            const selectedCategory = document.getElementById('categoryFilter').value;
            const selectedSort = document.getElementById('sortFilter').value;

            updateExportLinks(query, selectedCategory, selectedSort);

            let filtered = allBooks.filter(buku => {
                const matchCategory = !selectedCategory || buku.kategori === selectedCategory;
                const matchQuery = !query || (
                    (buku.kode_buku && buku.kode_buku.toLowerCase().includes(query)) ||
                    (buku.judul && buku.judul.toLowerCase().includes(query)) ||
                    (buku.penulis && buku.penulis.toLowerCase().includes(query)) ||
                    (buku.kategori && buku.kategori.toLowerCase().includes(query)) ||
                    (buku.penerbit && buku.penerbit.toLowerCase().includes(query)) ||
                    (buku.tahun_terbit && buku.tahun_terbit.toString().includes(query))
                );
                return matchCategory && matchQuery;
            });

            if (selectedSort === 'judul_asc') {
                filtered.sort((a, b) => a.judul.localeCompare(b.judul));
            } else if (selectedSort === 'judul_desc') {
                filtered.sort((a, b) => b.judul.localeCompare(a.judul));
            } else if (selectedSort === 'tahun_desc') {
                filtered.sort((a, b) => b.tahun_terbit - a.tahun_terbit);
            } else if (selectedSort === 'tahun_asc') {
                filtered.sort((a, b) => a.tahun_terbit - b.tahun_terbit);
            } else if (selectedSort === 'id_asc') {
                filtered.sort((a, b) => a.id - b.id);
            }

            currentFilteredBooks = filtered;
            currentPage = 1;
            renderPaginatedBooks();
        }

        function renderPaginatedBooks() {
            const totalItems = currentFilteredBooks.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
            const paginatedBooks = currentFilteredBooks.slice(startIndex, endIndex);

            renderBooksTable(paginatedBooks, startIndex);
            renderPaginationControls(totalItems, totalPages, startIndex, endIndex);
        }

        function renderBooksTable(books, startIndex = 0) {
            const tableBody = document.getElementById('bukuTableBody');
            const countLabel = document.getElementById('bookCount');
            tableBody.innerHTML = '';
            countLabel.textContent = currentFilteredBooks.length;

            if (books.length === 0) {
                tableBody.innerHTML = `
                    <tr><td colspan="8" style="text-align:center; color:#64748b; padding: 24px;"><i class="fa-solid fa-folder-open" style="margin-right: 8px;"></i> Tidak ada data buku ditemukan.</td></tr>`;
                return;
            }

            books.forEach((buku, index) => {
                const rowNo = startIndex + index + 1;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>#${rowNo}</strong></td>
                    <td><span class="badge">${escapeHtml(buku.kode_buku)}</span></td>
                    <td style="font-weight:600; color: var(--text-main);">${escapeHtml(buku.judul)}</td>
                    <td>${escapeHtml(buku.penulis)}</td>
                    <td>${escapeHtml(buku.kategori)}</td>
                    <td>${escapeHtml(buku.tahun_terbit)}</td>
                    <td>${escapeHtml(buku.penerbit)}</td>
                    <td style="text-align: center; white-space: nowrap;">
                        <button class="btn btn-warning btn-icon" title="Edit" onclick='openEditModal(${JSON.stringify(buku)})'>
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-danger btn-icon" title="Hapus" onclick="konfirmasiHapus(${buku.id}, '${escapeHtml(buku.judul)}')">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });
        }

        function getPaginationPages(current, total) {
            if (total <= 7) {
                return Array.from({ length: total }, (_, i) => i + 1);
            }
            if (current <= 4) {
                return [1, 2, 3, 4, 5, '...', total];
            }
            if (current >= total - 3) {
                return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
            }
            return [1, '...', current - 1, current, current + 1, '...', total];
        }

        function renderPaginationControls(totalItems, totalPages, startIndex, endIndex) {
            const container = document.getElementById('paginationContainer');
            if (!container) return;

            if (totalItems === 0) {
                container.innerHTML = '';
                return;
            }

            const startDisplay = startIndex + 1;
            let html = `
                <div class="pagination-info">
                    Menampilkan <strong>${startDisplay}-${endIndex}</strong> dari <strong>${totalItems}</strong> data buku
                </div>
                <div class="pagination-buttons">
                    <button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
            `;

            const pageNumbers = getPaginationPages(currentPage, totalPages);
            pageNumbers.forEach(p => {
                if (p === '...') {
                    html += `<span class="page-ellipsis">...</span>`;
                } else {
                    html += `
                        <button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="changePage(${p})">
                            ${p}
                        </button>
                    `;
                }
            });

            html += `
                    <button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            `;

            container.innerHTML = html;
        }

        function changePage(page) {
            currentPage = page;
            renderPaginatedBooks();
        }

        function updateExportLinks(query, category, sort) {
            const btnExcel = document.getElementById('btnExportExcel');
            const btnPdf = document.getElementById('btnExportPdf');
            
            const params = new URLSearchParams();
            if (query) params.append('search', query);
            if (category) params.append('kategori', category);
            if (sort) params.append('sort', sort);

            const queryString = params.toString() ? '?' + params.toString() : '';
            if (btnExcel) btnExcel.href = 'export_excel.php' + queryString;
            if (btnPdf) btnPdf.href = 'export_pdf.php' + queryString;
        }

        function konfirmasiHapus(id, judul) {
            if (confirm(`Apakah Anda yakin ingin menghapus buku "${judul}"?`)) {
                window.location.href = `hapus.php?id=${id}`;
            }
        }

        function generateNextKodeBuku() {
            if (!allBooks || allBooks.length === 0) return 'BK001';
            
            let maxNum = 0;
            let prefix = 'BK';
            let padLength = 3;

            allBooks.forEach(buku => {
                if (buku.kode_buku) {
                    const match = String(buku.kode_buku).match(/^([A-Za-z]+)(\d+)$/);
                    if (match) {
                        prefix = match[1];
                        const num = parseInt(match[2], 10);
                        if (num > maxNum) {
                            maxNum = num;
                            padLength = Math.max(match[2].length, 3);
                        }
                    }
                }
            });

            const nextNum = maxNum + 1;
            return prefix + String(nextNum).padStart(padLength, '0');
        }

        function openTambahModal() {
            const kodeInput = document.getElementById('tambah_kode_buku');
            if (kodeInput) {
                kodeInput.value = generateNextKodeBuku();
            }
            document.getElementById('tambahModal').classList.add('active');
        }
        function closeTambahModal() {
            document.getElementById('tambahModal').classList.remove('active');
        }

        function openEditModal(buku) {
            document.getElementById('edit_id').value = buku.id;
            document.getElementById('edit_kode_buku').value = buku.kode_buku;
            document.getElementById('edit_judul').value = buku.judul;
            document.getElementById('edit_penulis').value = buku.penulis;
            document.getElementById('edit_kategori').value = buku.kategori;
            document.getElementById('edit_tahun_terbit').value = buku.tahun_terbit;
            document.getElementById('edit_penerbit').value = buku.penerbit;
            document.getElementById('editModal').classList.add('active');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>
