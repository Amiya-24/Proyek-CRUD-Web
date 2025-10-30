<?php
session_start();
require 'config/database.php';
require 'src/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = (int)$_POST['id'];
    $nama_barang = trim($_POST['nama_barang']);
    $deskripsi = trim($_POST['deskripsi']);
    $sku = trim($_POST['sku']);
    $lokasi = trim($_POST['lokasi']);
    $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);

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

    if (empty($errors)) {
        try {
            $sql = "UPDATE barang SET nama_barang = ?, deskripsi = ?, sku = ?, stok = ?, lokasi = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([$nama_barang, $deskripsi, $sku, $stok, $lokasi, $id]);

            set_message("Data berhasil diperbarui!", "sukses");
            
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
        set_message(implode("<br>", $errors), "error");
        redirect("update.php?id=" . $id);
    }
} else {
    redirect("index.php");
}
?>