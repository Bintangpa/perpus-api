<!-- MODAL EDIT BUKU -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="color: var(--warning); margin-right: 8px;"></i>Edit Data Buku</h3>
            <button class="close-modal" onclick="closeEditModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
                <label>Kode Buku</label>
                <input type="text" name="kode_buku" id="edit_kode_buku" required>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" id="edit_judul" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" id="edit_penulis" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" id="edit_kategori" required>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="edit_tahun_terbit" required>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit" id="edit_penerbit" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> UPDATE</button>
            </div>
        </form>
    </div>
</div>
