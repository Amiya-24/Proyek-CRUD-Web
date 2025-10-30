<?php
session_start();
require 'config/database.php';
require 'src/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {
    set_message("ID tidak valid.", "error");
    redirect('index.php');
}

try {
    $sql = "DELETE FROM barang WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    set_message("Data berhasil dihapus!", "sukses");
    redirect("index.php");

} catch (PDOException $e) {
    set_message("Gagal menghapus data. Data ini mungkin terkait dengan data lain.", "error");
    redirect("index.php");
}
?>