<?php
include 'config.php';

// Fitur Tambah
if (isset($_POST['tambah'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_kopi']);
    $kategori = $_POST['kategori'];
    $harga    = $_POST['harga'];
    $stok     = $_POST['stok'];
    $status   = ($stok > 0) ? 'Tersedia' : 'Habis';

    $query = "INSERT INTO kopi (nama_kopi, kategori, harga, stok, status) VALUES ('$nama', '$kategori', '$harga', '$stok', '$status')";
    mysqli_query($conn, $query);
    header("Location: data_kopi.php?pesan=berhasil");
}

// Fitur Update
if (isset($_POST['update'])) {
    $id       = $_POST['id'];
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_kopi']);
    $kategori = $_POST['kategori'];
    $harga    = $_POST['harga'];
    $stok     = $_POST['stok'];
    $status   = ($stok > 0) ? 'Tersedia' : 'Habis';

    $query = "UPDATE kopi SET nama_kopi='$nama', kategori='$kategori', harga='$harga', stok='$stok', status='$status' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: data_kopi.php?pesan=berhasil");
}

// Fitur Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kopi WHERE id='$id'");
    header("Location: data_kopi.php?pesan=berhasil");
}
?>