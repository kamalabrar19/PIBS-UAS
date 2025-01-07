<?php
// config.php

$host = 'localhost';
$db   = 'surat_tugas';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Aktifkan exception untuk error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch data sebagai array asosiatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Nonaktifkan emulasi prepared statements
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Koneksi gagal: " . $e->getMessage());
}

// Cek apakah sesi sudah dimulai sebelum memanggil session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Mulai sesi hanya jika sesi belum dimulai
}
?>
