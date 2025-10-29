# Aplikasi Manajemen Gudang Sederhana

Aplikasi web sederhana yang dibangun menggunakan PHP Native (tanpa framework) untuk mengelola data barang di dalam gudang. Aplikasi ini mencakup fungsionalitas dasar CRUD (Create, Read, Update, Delete) dan menggunakan PDO untuk koneksi database yang aman serta *prepared statements* untuk mencegah SQL Injection.

---

## 📋 Fitur yang Tersedia

* **Manajemen Barang (CRUD):**
    * Menambah data barang baru (Nama, SKU, Deskripsi, Stok, Lokasi).
    * Melihat daftar semua barang.
    * Melihat detail untuk satu barang.
    * Memperbarui data barang.
    * Menghapus data barang.
* **Pencarian:** Mencari barang berdasarkan Nama Barang atau SKU.
* **Paginasi:** Membagi daftar barang yang panjang menjadi beberapa halaman.
* **Notifikasi:** Pesan *flash* (sukses/error) untuk memberi umpan balik kepada pengguna setelah setiap aksi.
* **Keamanan:**
    * Menggunakan **Prepared Statements (PDO)** untuk mencegah SQL Injection.
    * Melakukan *escaping* output (`htmlspecialchars`) untuk mencegah serangan XSS.
* **Validasi:** Validasi data sederhana di sisi server (misal: stok tidak boleh negatif, nama tidak boleh kosong).
* **Konfirmasi Hapus:** Konfirmasi JavaScript (`confirm()`) sebelum menghapus data untuk mencegah kesalahan.

---

## 🛠️ Kebutuhan Sistem

* Web Server (Contoh: Apache, Nginx).
* PHP 7.4 atau lebih baru (dengan ekstensi `pdo_mysql` aktif).
* Database Server (MySQL / MariaDB).
* Web Browser (Chrome, Firefox, Safari, dll.).

*Direkomendasikan:* Lingkungan pengembangan lokal terpadu seperti **Laragon** atau **XAMPP** yang sudah mencakup semua kebutuhan di atas.

---

## 🚀 Cara Instalasi dan Konfigurasi

1.  **Clone atau Unduh Proyek**
    Jika menggunakan `git`, clone repositori ini:
    ```bash
    git clone https://github.com/Amiya-24/Proyek-CRUD-Web
    ```
    Atau unduh file ZIP dan ekstrak ke direktori web server Anda (misal: `C:/laragon/www/Proyek-CRUD-Web`).

2.  **Buat Database**
    Buka *database client* Anda (misal: phpMyAdmin) dan buat database baru.
    ```sql
    CREATE DATABASE db_crud_php_native;
    ```

3.  **Guakan Database**
    ```sql
    USE db_crud_php_native;    
    ```

4.  **Impor Tabel `barang`**
    Jalankan kueri SQL berikut di dalam database `db_crud_php_native` untuk membuat tabel `barang`:
    ```sql
    CREATE TABLE barang (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_barang VARCHAR(255) NOT NULL,
        deskripsi TEXT,
        sku VARCHAR(100) UNIQUE,
        stok INT NOT NULL DEFAULT 0,
        lokasi VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    ```

5.  **Konfigurasi Database**
    Buka file `config/database.php` dan sesuaikan nilainya (`$host`, `$db`, `$user`, `$pass`) agar cocok dengan konfigurasi database lokal Anda. (Lihat contoh di bawah).

6.  **Jalankan Aplikasi**
    Buka browser Anda dan akses proyek dari server lokal Anda (misal: `http://Proyek-CRUD-Web.test` atau `http://localhost/Proyek-CRUD-Web`).

---

## 📁 Struktur Folder
```
/Proyek-CRUD-Web
├── /config         // Koneksi database dan konfigurasi
│   └── database.php
├── /public         // File yang diakses langsung (CSS, JS, images)
│   ├── /css
│   │   └── style.css
│   └── /js
│       └── script.js
├── /src            // Logika inti aplikasi (fungsi, class, dll)
│   └── functions.php   // (Opsional, untuk helper)
├── /templates      // Bagian template yang bisa dipakai ulang
│   ├── header.php
│   └── footer.php
│
├── index.php       // Halaman Read (List) + Pencarian + Paginasi
├── create.php      // Halaman Create (Form)
├── create_process.php // Logika backend untuk Create
├── update.php        // Halaman Update (Form)
├── update_process.php // Logika backend untuk Update
├── delete.php       // Logika backend untuk Delete
├── read.php      // Halaman Read (Detail)
└── README.md
```

---

## ⚙️ Contoh Konfigurasi Database

Berikut adalah isi contoh untuk file `config/database.php`. Sesuaikan dengan pengaturan Anda, terutama `$user` dan `$pass`.

```php
<?php
// config/database.php

$host = '127.0.0.1'; // atau 'localhost'
$db   = 'db_crud_php_native';
$user = 'root'; // User default Laragon/XAMPP
$pass = ''; // Password default Laragon/XAMPP (kosong)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
