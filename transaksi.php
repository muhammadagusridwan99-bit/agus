<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Logika Simpan Transaksi Baru (Jika ada form tambah)
if (isset($_POST['simpan_transaksi'])) {
    $pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $total = $_POST['total_harga'];
    $metode = $_POST['metode_bayar'];
    $tanggal = date('Y-m-d');

    $insert = mysqli_query($conn, "INSERT INTO transaksi (nama_pelanggan, total_harga, tanggal_transaksi, metode_bayar) 
                                   VALUES ('$pelanggan', '$total', '$metode', '$tanggal')");
    if($insert) {
        header("Location: transaksi.php");
    } else {
        $error_msg = mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Transaksi - SmartPOS Elite</title>
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
            background-image: radial-gradient(circle at 90% 10%, rgba(125, 95, 255, 0.05) 0%, transparent 40%);
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

        .badge-status {
            background: rgba(58, 227, 116, 0.1);
            color: #3ae374;
            border: 1px solid rgba(58, 227, 116, 0.2);
            padding: 5px 12px; border-radius: 8px; font-size: 0.75rem;
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
                <li class="nav-item"><a href="data_kopi.php" class="nav-link"><i class="bi bi-cup-hot me-2"></i> Menu Kopi</a></li>
                <li class="nav-item"><a href="transaksi.php" class="nav-link active"><i class="bi bi-receipt-cutoff me-2"></i> Kasir</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-power me-2"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-bold mb-1">Riwayat Transaksi 🧾</h2>
                        <p class="text-white-50">Daftar penjualan harian PPLG Smartsys.</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow" style="border-radius:15px" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
                        <i class="bi bi-plus-lg me-2"></i> Transaksi Baru
                    </button>
                </div>

                <?php if(isset($error_msg)): ?>
                    <div class="alert alert-danger"><?= $error_msg; ?></div>
                <?php endif; ?>

                <div class="luxury-card shadow-lg">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Metode</th>
                                    <th>Total Bayar</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // MENGATASI ERROR LINE 140:
                                // Pastikan query dicek keberhasilannya
                                $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
                                
                                if (!$query) {
                                    echo "<tr><td colspan='6' class='text-center text-danger'>Query Gagal: " . mysqli_error($conn) . "</td></tr>";
                                } else {
                                    $no = 1;
                                    if (mysqli_num_rows($query) > 0) {
                                        while($row = mysqli_fetch_array($query)):
                                ?>
                                <tr>
                                    <td class="text-white-50 small"><?= $no++; ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                                    <td class="small"><?= date('d M Y', strtotime($row['tanggal_transaksi'])); ?></td>
                                    <td>
                                        <i class="bi bi-wallet2 me-2"></i><?= $row['metode_bayar']; ?>
                                    </td>
                                    <td class="fw-bold text-primary">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center"><span class="badge-status">Success</span></td>
                                </tr>
                                <?php 
                                        endwhile; 
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center text-white-50'>Belum ada transaksi tersimpan.</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransaksi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: #0f172a; color: white; border-radius: 20px;">
            <form method="POST">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Input Transaksi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small text-white-50">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-white-50">Total Harga (Rp)</label>
                        <input type="number" name="total_harga" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-white-50">Metode Pembayaran</label>
                        <select name="metode_bayar" class="form-select bg-dark text-white border-secondary">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="simpan_transaksi" class="btn btn-primary w-100 py-2" style="border-radius:12px;">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>