<?php 
include 'config.php';
// session_start(); // Aktifkan jika sudah ada sistem login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang - Modern POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f5f7fb; font-family: 'Inter', sans-serif; }
        .card { border: none; border-radius: 15px; }
        .table thead { background-color: #f8f9fa; }
        .btn-primary { background-color: #4361ee; border: none; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">📦 Data Barang</h3>
            <p class="text-muted">Kelola stok dan harga produk Anda</p>
        </div>
        <button class="btn btn-primary px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-2"></i> Tambah Barang
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
                        while($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= $row['nama_barang']; ?></td>
                            <td>Rp <?= number_format($row['harga_barang'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge <?= $row['stok_barang'] < 10 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success'; ?> px-3">
                                    <?= $row['stok_barang']; ?> Item
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <a href="proses_barang.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-light" onclick="return confirm('Hapus barang ini?')">
                                    <i class="bi bi-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="proses_barang.php" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga</label>
                                                <input type="number" name="harga_barang" class="form-control" value="<?= $row['harga_barang']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Stok</label>
                                                <input type="number" name="stok_barang" class="form-control" value="<?= $row['stok_barang']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow">
            <form action="proses_barang.php" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Kopi Bubuk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Barang</label>
                        <input type="number" name="harga_barang" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" name="stok_barang" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="tambah" class="btn btn-primary w-100 py-2">Simpan ke Gudang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
