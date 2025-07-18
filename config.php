<?php
// Pengaturan Database
$db_host = 'localhost';
$db_user = 'root'; // Default username XAMPP
$db_pass = '';     // Default password XAMPP
$db_name = 'saweco_db';

// Membuat Koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek Koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Memulai Session hanya jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
