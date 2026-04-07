<?php
include 'config.php';

// --- BAGIAN 1: LOGIKA TAMBAH BARANG ---
if (isset($_POST['tambah'])) {
    $nama  = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok  = $_POST['stok_barang'];

    $query = "INSERT INTO barang (nama_barang, harga_barang, stok_barang) VALUES ('$nama', '$harga', '$stok')";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: data_barang.php"); 
        exit(); 
    } else {
        echo "Gagal Tambah: " . mysqli_error($conn);
    }
}

// --- BAGIAN 2: LOGIKA HAPUS BARANG ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus']; 
    $query_hapus = "DELETE FROM barang WHERE id = '$id'"; 
    $hasil_hapus = mysqli_query($conn, $query_hapus);

    if ($hasil_hapus) {
        header("Location: data_barang.php");
        exit();
    } else {
        echo "Gagal Hapus: " . mysqli_error($conn);
    }
}

// --- BAGIAN 3: LOGIKA UPDATE/EDIT BARANG (INI YANG BARU) ---
if (isset($_POST['update'])) {
    $id    = $_POST['id']; // ID disembunyikan di form (hidden)
    $nama  = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok  = $_POST['stok_barang'];

    $query_update = "UPDATE barang SET 
                     nama_barang = '$nama', 
                     harga_barang = '$harga', 
                     stok_barang = '$stok' 
                     WHERE id = '$id'";
    
    $hasil_update = mysqli_query($conn, $query_update);

    if ($hasil_update) {
        header("Location: data_barang.php?status=sukses_edit");
        exit();
    } else {
        echo "Gagal Update: " . mysqli_error($conn);
    }
}
?>