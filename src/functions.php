<?php
// src/functions.php

/**
 * Memulai session jika belum ada.
 * Wajib dipanggil sebelum set_message() atau display_message().
 */
function inisialisasi_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Mengatur "flash message" untuk ditampilkan di halaman berikutnya.
 *
 * @param string $pesan Pesan yang ingin ditampilkan.
 * @param string $tipe Tipe pesan ('sukses' atau 'error') untuk styling CSS.
 */
function set_message($pesan, $tipe = 'sukses') {
    inisialisasi_session();
    $_SESSION['pesan'] = $pesan;
    $_SESSION['tipe_pesan'] = $tipe;
}

/**
 * Menampilkan "flash message" jika ada, lalu menghapusnya dari session.
 * Fungsi ini ideal untuk dipanggil di header.php.
 */
function display_message() {
    inisialisasi_session();
    if (isset($_SESSION['pesan'])) {
        // Tampilkan HTML alert
        echo '<div class="alert ' . htmlspecialchars($_SESSION['tipe_pesan']) . '">' 
             . htmlspecialchars($_SESSION['pesan']) . 
             '</div>';
        
        // Hapus pesan setelah ditampilkan
        unset($_SESSION['pesan']);
        unset($_SESSION['tipe_pesan']);
    }
}

/**
 * Fungsi helper untuk melakukan redirect dan menghentikan eksekusi script.
 *
 * @param string $url URL tujuan.
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Fungsi "escape" singkat untuk membersihkan output HTML (mencegah XSS).
 *
 * @param string|null $string String yang akan di-escape.
 * @return string String yang aman untuk ditampilkan di HTML.
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Fungsi helper untuk memformat angka menjadi format Rupiah.
 *
 * @param int $angka Angka yang akan diformat.
 * @return string String dalam format Rupiah (misal: "Rp 150.000").
 */
function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Fungsi "Die and Dump" untuk debugging.
 * Menampilkan variabel dengan rapi lalu menghentikan script.
 * HANYA UNTUK DEVELOPMENT.
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}

?>