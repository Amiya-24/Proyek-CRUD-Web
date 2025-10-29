<?php
require 'config/database.php';
require 'src/functions.php'; // Panggil functions.php

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {
    redirect('index.php');
}

try {
    // Ambil data barang berdasarkan ID
    $sql = "SELECT * FROM barang WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $barang = $stmt->fetch();

    if (!$barang) {
        set_message("Data tidak ditemukan.", "error");
        redirect('index.php');
    }

} catch (PDOException $e) {
    die("Terjadi kesalahan saat mengambil data."); 
}

// Tampilkan header SETELAH logika fetch data
require 'templates/header.php';
?>

<div class="detail-produk"> <h2><?php echo e($barang['nama_barang']); ?></h2>
    
    <div class="detail-info">
        <strong>SKU:</strong>
        <span><?php echo e($barang['sku']); ?></span>
    </div>

    <div class="detail-info">
        <strong>Stok:</strong>
        <span><?php echo e($barang['stok']); ?> unit</span>
    </div>

    <div class="detail-info">
        <strong>Lokasi:</strong>
        <span><?php echo e($barang['lokasi']); ?></span>
    </div>
    
    <div class="detail-info">
        <strong>Tanggal Dibuat:</strong>
        <span><?php echo date('d F Y \p\u\k\u\l H:i', strtotime($barang['created_at'])); ?></span>
    </div>
    
    <div class="detail-deskripsi">
        <strong>Deskripsi:</strong>
        <p><?php echo nl2br(e($barang['deskripsi'])); ?></p>
    </div>
    
    <a href="index.php" class="btn btn-sekunder">Kembali ke Daftar</a>
    <a href="update.php?id=<?php echo $barang['id']; ?>" class="btn btn-edit">Edit</a>
</div>


<?php
require 'templates/footer.php';
?>