<?php
include 'config.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM inventory WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    die("Barang tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Informasi Detail Barang</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr><th>Nama Barang</th><td>: <?= $item['nama_barang']; ?></td></tr>
                            <tr><th>Kategori</th><td>: <?= $item['kategori']; ?></td></tr>
                            <tr><th>Harga</th><td>: Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok Saat Ini</th><td>: <?= $item['stok']; ?></td></tr>
                            <tr><th>Status</th><td>: <?= $item['status']; ?></td></tr>
                        </table>
                        <a href="dashboard.php" class="btn btn-secondary w-100">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>