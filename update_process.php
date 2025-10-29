<?php
session_start();
require 'config/database.php';
require 'src/functions.php'; // Panggil functions.php

// Pastikan ini adalah request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil & Sanitasi Data
    $id = (int)$_POST['id'];
    $nama_barang = trim($_POST['nama_barang']);
    $deskripsi = trim($_POST['deskripsi']);
    $sku = trim($_POST['sku']);
    $lokasi = trim($_POST['lokasi']);
    $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);

    // 2. Validasi Sisi Server
    $errors = [];
    if (empty($nama_barang)) {
        $errors[] = "Nama barang tidak boleh kosong.";
    }
    if ($stok === false || $stok < 0) {
        $errors[] = "Stok harus berupa angka positif.";
    }
    if ($id <= 0) {
         $errors[] = "ID barang tidak valid.";
    }

    // 3. Proses jika tidak ada error
    if (empty($errors)) {
        try {
            // 4. Gunakan Prepared Statements
            $sql = "UPDATE barang SET nama_barang = ?, deskripsi = ?, sku = ?, stok = ?, lokasi = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            
            // 5. Eksekusi dengan data
            $stmt->execute([$nama_barang, $deskripsi, $sku, $stok, $lokasi, $id]);

            // 6. Buat Flash Message Sukses
            set_message("Data berhasil diperbarui!", "sukses");
            
            // 7. Redirect ke halaman utama
            redirect("index.php");

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                set_message("Gagal memperbarui: SKU '{$sku}' sudah ada.", "error");
            } else {
                set_message("Gagal memperbarui data. Terjadi kesalahan database.", "error");
            }
            redirect("update.php?id=" . $id);
        }
    } else {
        // Jika ada error validasi
        set_message(implode("<br>", $errors), "error");
        redirect("update.php?id=" . $id);
    }
} else {
    redirect("index.php");
}
?>