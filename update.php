<?php
require 'config/database.php';
require 'src/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {
    redirect('index.php');
}

try {
    $sql = "SELECT * FROM barang WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $barang = $stmt->fetch();

    if (!$barang) {
        set_message("Data tidak ditemukan.", "error");
        redirect('index.php');
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

require 'templates/header.php';
?>

<h2>Edit Barang</h2>

<form action="update_process.php" method="POST" class="form-modern">
    <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
    
    <div class="form-group">
        <label for="nama_barang">Nama Barang</label>
        <input type="text" id="nama_barang" name="nama_barang" 
               value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU (Stock Keeping Unit)</label>
        <input type="text" id="sku" name="sku"
               value="<?php echo htmlspecialchars($barang['sku']); ?>">
    </div>
    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($barang['deskripsi']); ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" id="stok" name="stok" 
               value="<?php echo htmlspecialchars($barang['stok']); ?>" required min="0">
    </div>

    <div class="form-group">
        <label for="lokasi">Lokasi</label>
        <input type="text" id="lokasi" name="lokasi"
               value="<?php echo htmlspecialchars($barang['lokasi']); ?>">
    </div>
    
    <button type="submit" class="btn btn-primer">Simpan Perubahan</button>
    <a href="index.php" class="btn btn-sekunder">Batal</a>
</form>

<?php
require 'templates/footer.php';
?>