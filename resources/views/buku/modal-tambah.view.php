<!-- MODAL TAMBAH BUKU -->
<div class="modal-overlay" id="tambahModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus-circle" style="color: var(--primary); margin-right: 8px;"></i>Tambah Data Buku</h3>
            <button class="close-modal" onclick="closeTambahModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="tambah.php" method="POST">
            <div class="form-group">
                <label>Kode Buku</label>
                <input type="text" name="kode_buku" id="tambah_kode_buku" value="<?= htmlspecialchars($next_kode_buku ?? 'BK001'); ?>" placeholder="Contoh: BK001" required>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" placeholder="Judul Buku" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" placeholder="Nama Penulis" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" placeholder="Contoh: Novel, Teknologi" required>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" placeholder="Contoh: 2024" required min="1900" max="2099">
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit" placeholder="Nama Penerbit" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-outline" onclick="closeTambahModal()">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> SIMPAN</button>
            </div>
        </form>
    </div>
</div>
