<?php
require 'config/database.php';
require 'src/functions.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_barang = isset($_POST['nama_barang']) ? trim($_POST['nama_barang']) : '';
    $deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    $sku = isset($_POST['sku']) ? trim($_POST['sku']) : '';
    $lokasi = isset($_POST['lokasi']) ? trim($_POST['lokasi']) : '';
    $stok = isset($_POST['stok']) ? filter_var($_POST['stok'], FILTER_VALIDATE_INT) : false;

    $errors = [];
    if (empty($nama_barang)) {
        $errors[] = "Nama barang tidak boleh kosong.";
    }
    if ($stok === false || $stok < 0) {
        $errors[] = "Stok harus berupa angka (0 atau lebih).";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO barang (nama_barang, deskripsi, sku, stok, lokasi) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_barang, $deskripsi, $sku, $stok, $lokasi]);

            set_message("Data barang berhasil disimpan!", "sukses");
            redirect("index.php");

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Error duplikat
                set_message("Gagal menyimpan: SKU '{$sku}' sudah ada.", "error");
            } else {
                set_message("Gagal menyimpan data. Terjadi kesalahan database.", "error");
            }
            redirect("create.php");
        }
    } else {
        set_message(implode("<br>", $errors), "error");
        redirect("create.php");
    }
} else {
    redirect("index.php");
}
?>