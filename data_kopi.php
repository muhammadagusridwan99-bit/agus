<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// --- LOGIKA CRUD ---

// 1. Hapus Data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM menu_kopi WHERE id=$id");
    header("Location: data_kopi.php");
    exit();
}

// 2. Tambah Data
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kopi']);
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    $query_tambah = "INSERT INTO menu_kopi (nama_kopi, harga, kategori) VALUES ('$nama', '$harga', '$kategori')";
    mysqli_query($conn, $query_tambah);
    header("Location: data_kopi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Kopi - SmartPOS Elite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #060b18;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --accent-primary: #7d5fff;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-dark);
            color: #ffffff;
            min-height: 100vh;
            background-image: radial-gradient(circle at 10% 20%, rgba(125, 95, 255, 0.05) 0%, transparent 40%);
        }

        .sidebar {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            min-height: 100vh;
            position: sticky; top: 0;
        }

        .nav-link {
            color: #94a3b8; padding: 14px 20px; margin: 8px 15px;
            border-radius: 15px; transition: 0.3s; display: flex; align-items: center;
            text-decoration: none;
        }

        .nav-link:hover, .nav-link.active {
            background: linear-gradient(135deg, var(--accent-primary), #5741d9);
            color: #fff;
        }

        .luxury-card {
            background: var(--glass);
            border-radius: 30px;
            border: 1px solid var(--glass-border);
            padding: 30px;
        }

        .table { color: #e2e8f0; --bs-table-bg: transparent; }
        .table thead th { border: none; color: #64748b; font-size: 0.8rem; text-transform: uppercase; }

        /* Style khusus untuk tombol Edit Biru Muda */
        .btn-edit { color: #0dcaf0; transition: 0.3s; }
        .btn-edit:hover { color: #fff; background: #0dcaf0; }
        
        /* Style khusus untuk tombol Hapus Merah */
        .btn-delete { color: #ff4d4d; transition: 0.3s; }
        .btn-delete:hover { color: #fff; background: #ff4d4d; }

        .modal-content {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            color: white; border-radius: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
            <div class="p-4 mb-4 text-center">
                <h5 class="fw-bold mb-0">SMART<span class="text-primary">POS</span></h5>
                <p class="small text-white-50">Waroeng D' Gebyok</p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="data_kopi.php" class="nav-link active"><i class="bi bi-cup-hot me-2"></i> Menu Kopi</a></li>
                <li class="nav-item"><a href="transaksi.php" class="nav-link"><i class="bi bi-receipt-cutoff me-2"></i> Kasir</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-power me-2"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-bold mb-1">Manajemen Menu ☕</h2>
                        <p class="text-white-50">Kelola varian produk dengan kontrol penuh.</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow" style="border-radius:15px" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Menu
                    </button>
                </div>

                <div class="luxury-card shadow-lg">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM menu_kopi ORDER BY id DESC");
                                if (!$query) {
                                    echo "<tr><td colspan='5' class='text-center text-danger'>Error: " . mysqli_error($conn) . "</td></tr>";
                                } else {
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)):
                                ?>
                                <tr>
                                    <td class="text-white-50 small"><?php echo $no++; ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['nama_kopi']); ?></td>
                                    <td><span class="badge bg-dark border border-secondary"><?php echo $row['kategori']; ?></span></td>
                                    <td class="fw-bold text-primary">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="edit_kopi.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit border-0 me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete border-0" onclick="return confirm('Hapus menu ini?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-white-50">Nama Menu</label>
                        <input type="text" name="nama_kopi" class="form-control" required style="background: rgba(255,255,255,0.05); color:white; border-radius:12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-white-50">Harga</label>
                        <input type="number" name="harga" class="form-control" required style="background: rgba(255,255,255,0.05); color:white; border-radius:12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-white-50">Kategori</label>
                        <select name="kategori" class="form-select" style="background: rgba(255,255,255,0.05); color:white; border-radius:12px;">
                            <option value="Coffee">Coffee</option>
                            <option value="Non-Coffee">Non-Coffee</option>
                            <option value="Snack">Snack</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="tambah" class="btn btn-primary w-100 py-2" style="border-radius:12px">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>