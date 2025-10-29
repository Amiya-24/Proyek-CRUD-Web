<?php
// Impor file functions.php
// Kita asumsikan header.php dipanggil dari file di root (cth: index.php)
require_once 'src/functions.php';

// Fungsi ini akan memulai session DAN menampilkan pesan jika ada
display_message(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Gudang</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="create.php">Tambah Barang</a>
    </nav>
    <main class="container">
        
    <?php
    // Logika pesan sudah dipindah ke display_message() di atas
    ?>