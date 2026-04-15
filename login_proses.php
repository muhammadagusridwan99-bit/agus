<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mencari user
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

// Hitung jumlah data yang ditemukan
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = "login";
    
    header("location:data_barang.php"); // Alihkan ke halaman utama
} else {
    // Jika gagal, kembali ke login dengan pesan error
    header("location:index.php?pesan=gagal");
}
?>