<?php
// templates/header.php sudah menyertakan session_start()
require 'templates/header.php'; 
?>

<h2>Tambah Barang Baru</h2>

<form action="create_process.php" method="POST" class="form-modern">
    <div class="form-group">
        <label for="nama_barang">Nama Barang</label>
        <input type="text" id="nama_barang" name="nama_barang" required>
    </div>
    
    <div class="form-group">
        <label for="sku">SKU (Stock Keeping Unit)</label>
        <input type="text" id="sku" name="sku">
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>
    </div>
    
    <div class="form-group">
        <label for="stok">Stok Awal</label>
        <input type="number" id="stok" name="stok" required min="0" value="0">
    </div>

    <div class="form-group">
        <label for="lokasi">Lokasi (Misal: Rak A-01)</label>
        <input type="text" id="lokasi" name="lokasi">
    </div>
    
    <button type="submit" class="btn btn-primer">Simpan</button>
    <a href="index.php" class="btn btn-sekunder">Batal</a>
</form>

<?php
require 'templates/footer.php';
?>