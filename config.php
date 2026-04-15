<?php
// 1. Pengaturan Database
$host     = "localhost";  // Server lokal (XAMPP)
$user     = "root";       // Username default MySQL
$pass     = "";           // Password default MySQL (kosong)
$db_name  = "coffee_shop"; // Nama database yang kamu buat di phpMyAdmin

// 2. Perintah untuk Menghubungkan ke MySQL
$conn = mysqli_connect($host, $user, $pass, $db_name);

// 3. Cek Koneksi (Opsional, tapi sangat penting untuk debugging)
if (!$conn) {
    die("<div style='color:red; font-family:sans-serif;'>
            <h3>Koneksi Database Gagal!</h3>
            Pesan Error: " . mysqli_connect_error() . "
         </div>");
}

// Jika berhasil, variabel $conn akan menyimpan status koneksi aktif
?>