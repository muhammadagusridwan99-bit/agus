<?php
include 'config.php';

// PROSES EDIT (UPDATE)
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $nama  = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok  = $_POST['stok_barang'];

    $sql = "UPDATE barang SET 
            nama_barang = '$nama', 
            harga_barang = '$harga', 
            stok_barang = '$stok' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: data_barang.php");
    } else {
        echo "Gagal Update: " . mysqli_error($conn);
    }
}

// PROSES TAMBAH
if (isset($_POST['tambah'])) {
    $nama  = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok  = $_POST['stok_barang'];

    $sql = "INSERT INTO barang (nama_barang, harga_barang, stok_barang) VALUES ('$nama', '$harga', '$stok')";

    if (mysqli_query($conn, $sql)) {
        header("Location: data_barang.php");
    }
}

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");
    header("Location: data_barang.php");
}
?>