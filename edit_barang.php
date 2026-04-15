<?php 
include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];
if(!isset($id)) { header("Location: data_barang.php"); }

// Cari data barang berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan
if(mysqli_num_rows($query) < 1) { die("Data tidak ditemukan..."); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang | SmartPOS Lavender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --lavender-dark: #6c5ce7; --bg-body: #f8f9fd; }
        body { background: var(--bg-body); font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0; background: #fff; border-right: 1px solid #eee; padding: 30px 20px; }
        .nav-link { color: #8e8e8e; font-weight: 600; padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; text-decoration: none; display: flex; align-items: center; }
        .nav-link.active { background: var(--lavender-dark); color: #fff !important; }
        .main-wrapper { margin-left: var(--sidebar-width); padding: 40px; }
        .form-card { background: #fff; border-radius: 25px; box-shadow: 0 10px 40px rgba(108, 92, 231, 0.04); padding: 30px; border: none; max-width: 600px; }
        .btn-lavender { background: var(--lavender-dark); color: white; border: none; border-radius: 12px; padding: 12px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-lavender:hover { background: #5b4bc4; color: white; transform: translateY(-2px); }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #eee; background: #fbfbff; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="mb-5 px-3 text-primary fw-bold fs-4"><i class="bi bi-cup-hot-fill me-2"></i>SmartPOS</div>
    <nav class="nav flex-column">
        <a href="dashboard.php" class="nav-link"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
        <a href="data_barang.php" class="nav-link active"><i class="bi bi-archive-fill me-2"></i> Data Barang</a>
        <a href="transaksi.php" class="nav-link"><i class="bi bi-cart-fill me-2"></i> Transaksi</a>
    </nav>
</aside>

<main class="main-wrapper">
    <div class="mb-4">
        <a href="data_barang.php" class="text-decoration-none text-muted small fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold mt-2">Edit Data Barang</h2>
    </div>

    <div class="form-card">
        <form action="proses_barang.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang']; ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Harga (Rp)</label>
                    <input type="number" name="harga_barang" class="form-control" value="<?= $data['harga_barang']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Stok Tersedia</label>
                    <input type="number" name="stok_barang" class="form-control" value="<?= $data['stok_barang']; ?>" required>
                </div>
            </div>

            <button type="submit" name="update" class="btn btn-lavender mt-3 shadow">
                <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>