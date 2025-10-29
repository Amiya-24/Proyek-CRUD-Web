<?php
// config/database.php

$host = '127.0.0.1'; // atau 'localhost'
$db   = 'db_crud_php_native';
$user = 'root'; // User default Laragon
$pass = ''; // Password default Laragon (kosong)
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
     // Tampilkan pesan error yang ramah pengguna
     // Di produksi, ini harus dicatat (log) bukan ditampilkan
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}