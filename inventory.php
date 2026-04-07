<?php
include 'config.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Proses Hapus Barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
    header("Location: inventory.php");
}

// Ambil data produk
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventory Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Sistem Gudang</a>
        <div class="navbar-nav">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link active" href="inventory.php">Inventory</a>
            <a class="nav-link btn btn-danger btn-sm text-white ms-lg-3" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Inventori Barang</h3>
        <a href="tambah_barang.php" class="btn btn-success">+ Tambah Barang Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['nama_barang']; ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['kategori']; ?></span></td>
                        <td><?= $row['stok']; ?></td>
                        <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="edit_barang.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="inventory.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>