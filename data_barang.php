<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT * FROM kopi ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Kopi | SmartPOS Lavender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --lavender-dark: #6c5ce7; --bg-body: #f8f9fd; }
        body { background: var(--bg-body); font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0; background: #fff; border-right: 1px solid #eee; padding: 30px 20px; }
        .nav-link { color: #8e8e8e; font-weight: 600; padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; transition: 0.3s; display: flex; align-items: center; text-decoration: none; }
        .nav-link.active { background: var(--lavender-dark); color: #fff !important; box-shadow: 0 8px 20px rgba(108, 92, 231, 0.2); }
        
        .main-wrapper { margin-left: var(--sidebar-width); padding: 40px; }
        .data-card { background: #fff; border-radius: 25px; box-shadow: 0 10px 40px rgba(108, 92, 231, 0.04); overflow: hidden; padding: 10px; }
        
        .btn-lavender { background: var(--lavender-dark); color: white; border: none; border-radius: 14px; padding: 12px 25px; font-weight: 700; }
        .badge-status { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="mb-5 px-3 text-primary fw-bold fs-4"><i class="bi bi-cup-hot-fill me-2"></i>SmartPOS</div>
    <nav class="nav flex-column">
        <a href="dashboard.php" class="nav-link"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
        <a href="data_kopi.php" class="nav-link active"><i class="bi bi-cup-straw me-2"></i> Menu Kopi</a>
        <a href="transaksi.php" class="nav-link"><i class="bi bi-cart-fill me-2"></i> Transaksi</a>
        <a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-power me-2"></i> Keluar</a>
    </nav>
</aside>

<main class="main-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Katalog Kopi</h2>
        <button class="btn btn-lavender" data-bs-toggle="modal" data-bs-target="proses_kopi.php">
            <i class="bi bi-plus-lg me-2"></i> Menu Baru
        </button>
    </div>

    <div class="data-card">
        <table class="table table-hover align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)): ?>
                <tr>
                    <td class="ps-4 fw-bold"><?= $row['nama_kopi']; ?></td>
                    <td><span class="text-muted small"><?= $row['kategori']; ?></span></td>
                    <td class="fw-semibold text-primary">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>
                        <span class="badge-status <?= $row['status'] == 'Tersedia' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="proses_kopi.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-light border-0" style="border-radius: 10px;">
    <i class="bi bi-pencil-square text-primary"></i>
</a>
                        <a href="proses_kopi.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-light" onclick="return confirm('Hapus menu?')"><i class="bi bi-trash text-danger"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="edit<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="proses_kopi.php" method="POST" class="modal-content border-0 shadow" style="border-radius: 20px;">
                            <div class="modal-body p-4">
                                <h5 class="fw-bold mb-4">Edit Menu</h5>
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="mb-3"><label class="small fw-bold">Nama Kopi</label><input type="text" name="nama_kopi" class="form-control" value="<?= $row['nama_kopi']; ?>" required></div>
                                <div class="mb-3">
                                    <label class="small fw-bold">Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="Coffee" <?= $row['kategori'] == 'Coffee' ? 'selected' : ''; ?>>Coffee</option>
                                        <option value="Non-Coffee" <?= $row['kategori'] == 'Non-Coffee' ? 'selected' : ''; ?>>Non-Coffee</option>
                                        <option value="Manual Brew" <?= $row['kategori'] == 'Manual Brew' ? 'selected' : ''; ?>>Manual Brew</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3"><label class="small fw-bold">Harga</label><input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required></div>
                                    <div class="col-6 mb-3"><label class="small fw-bold">Stok</label><input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>" required></div>
                                </div>
                                <button type="submit" name="update" class="btn btn-lavender w-100 mt-2">Update Menu</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<div class="modal fade" id="tambahKopi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="proses_kopi.php" method="POST" class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-body p-4">
                <h5 class="fw-bold mb-4">Menu Kopi Baru</h5>
                <div class="mb-3"><label class="small fw-bold">Nama Kopi</label><input type="text" name="nama_kopi" class="form-control" placeholder="Lavender Latte" required></div>
                <div class="mb-3">
                    <label class="small fw-bold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Coffee">Coffee</option>
                        <option value="Non-Coffee">Non-Coffee</option>
                        <option value="Manual Brew">Manual Brew</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-6 mb-3"><label class="small fw-bold">Harga</label><input type="number" name="harga" class="form-control" placeholder="25000" required></div>
                    <div class="col-6 mb-3"><label class="small fw-bold">Stok</label><input type="number" name="stok" class="form-control" placeholder="10" required></div>
                </div>
                <button type="submit" name="tambah" class="btn btn-lavender w-100 mt-2">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>