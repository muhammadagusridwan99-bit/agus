<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_system"; // Pastikan ini sama dengan yang ada di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>