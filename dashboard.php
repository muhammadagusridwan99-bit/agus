<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Pastikan arahkan ke file login kamu
    exit();
}

// Data Dinamis dari Database
// 1. Hitung Jumlah Transaksi Hari Ini
$tgl_sekarang = date('Y-m-d');
// (Nanti kamu bisa ganti statis ini dengan query SQL asli)
$jumlah_transaksi = 45; 
$total_pendapatan = 3500000;
$stok_menipis = 15;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPOS - Elite Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #060b18;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --accent-primary: #7d5fff;
            --accent-success: #3ae374;
            --accent-warning: #ff9f43;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-dark);
            color: #ffffff;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(125, 95, 255, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(58, 227, 116, 0.05) 0%, transparent 40%);
        }

        /* Sidebar Glass Styling */
        .sidebar {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            min-height: 100vh;
            position: sticky; top: 0;
        }

        .nav-link {
            color: #94a3b8;
            padding: 14px 20px;
            margin: 8px 15px;
            border-radius: 15px;
            transition: 0.3s;
            display: flex; align-items: center;
            font-weight: 500;
        }

        .nav-link i { font-size: 1.2rem; margin-right: 12px; }
        .nav-link:hover { background: var(--glass); color: #fff; }
        .nav-link.active {
            background: linear-gradient(135deg, var(--accent-primary), #5741d9);
            color: #fff;
            box-shadow: 0 10px 20px rgba(125, 95, 255, 0.3);
        }

        /* Topbar */
        .top-nav {
            padding: 20px 40px;
            background: rgba(6, 11, 24, 0.5);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }

        /* Stats Card Luxury */
        .stat-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 25px;
            position: relative;
            overflow: hidden;
            transition: 0.4s;
        }
        .stat-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .icon-circle {
            width: 55px; height: 55px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .glow-primary { background: rgba(125, 95, 255, 0.15); color: var(--accent-primary); box-shadow: 0 0 20px rgba(125, 95, 255, 0.2); }
        .glow-success { background: rgba(58, 227, 116, 0.15); color: var(--accent-success); box-shadow: 0 0 20px rgba(58, 227, 116, 0.2); }
        .glow-warning { background: rgba(255, 159, 67, 0.15); color: var(--accent-warning); box-shadow: 0 0 20px rgba(255, 159, 67, 0.2); }

        /* Table Design */
        .luxury-card {
            background: var(--glass);
            border-radius: 30px;
            border: 1px solid var(--glass-border);
            padding: 30px;
        }
        .table { color: #e2e8f0; --bs-table-bg: transparent; }
        .table thead th { border: none; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .table tbody tr { border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }

        .badge-status {
            background: rgba(58, 227, 116, 0.1);
            color: var(--accent-success);
            border: 1px solid rgba(58, 227, 116, 0.2);
            padding: 6px 15px; border-radius: 10px; font-size: 0.8rem;
        }

        .user-pill {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            padding: 8px 20px; border-radius: 50px;
            color: #fff; text-decoration: none;
            transition: 0.3s;
        }
        .user-pill:hover { background: #fff; color: #000; }

        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }
        .live-indicator {
            width: 8px; height: 8px;
            background: var(--accent-success);
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
            <div class="p-4 mb-4 text-center">
                <div class="glow-primary icon-circle mx-auto mb-3" style="width: 45px; height: 45px; border-radius: 12px;">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <h5 class="fw-bold mb-0">SMART<span class="text-primary">POS</span></h5>
                <p class="small text-white-50">Waroeng D` Gebyok</p>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="data_kopi.php" class="nav-link"><i class="bi bi-cup-hot"></i> Menu Kopi</a></li>
                <li class="nav-item"><a href="data_pengguna.php" class="nav-link"><i class="bi bi-people"></i> Anggota Tim</a></li>
                <li class="nav-item"><a href="transaksi.php" class="nav-link"><i class="bi bi-receipt-cutoff"></i> Kasir</a></li>
                <li class="mt-5 px-4"><hr class="opacity-10"></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="bi bi-power"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <header class="top-nav d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 small"><i class="bi bi-calendar3 me-2"></i><?= date('D, d M Y'); ?></span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="small text-white-50"><span class="live-indicator"></span>System Online</span>
                    <a href="#" class="user-pill small">
                        <i class="bi bi-person-circle me-2"></i><?= $_SESSION['username']; ?>
                    </a>
                </div>
            </header>

            <div class="p-5">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="fw-bold mb-1">Hello, <?= $_SESSION['username']; ?>! ✨</h2>
                        <p class="text-white-50">Berikut adalah performa bisnismu hari ini di perusahaan PPLG.</p>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon-circle glow-primary">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <h6 class="text-white-50 small fw-bold text-uppercase mb-2">Total Transaksi</h6>
                            <h2 class="fw-bold mb-0"><?= $jumlah_transaksi; ?> <span class="fs-6 fw-normal text-white-50">Orders</span></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon-circle glow-success">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <h6 class="text-white-50 small fw-bold text-uppercase mb-2">Pendapatan Hari Ini</h6>
                            <h2 class="fw-bold mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon-circle glow-warning">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h6 class="text-white-50 small fw-bold text-uppercase mb-2">Stok Menipis</h6>
                            <h2 class="fw-bold mb-0"><?= $stok_menipis; ?> <span class="fs-6 fw-normal text-white-50">Varian</span></h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="luxury-card shadow-lg">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Aktifitas Terakhir</h5>
                                <a href="transaksi.php" class="btn btn-sm btn-outline-light border-0 opacity-50">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pelanggan</th>
                                            <th>Produk</th>
                                            <th>Metode</th>
                                            <th>Total</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-white-50 small">#8821</td>
                                            <td class="fw-bold">marcell</td>
                                            <td>Iced Caramel Macchiato</td>
                                            <td><i class="bi bi-credit-card me-2"></i>QRIS</td>
                                            <td class="fw-bold text-primary">Rp 35.000</td>
                                            <td class="text-center"><span class="badge-status">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-white-50 small">#8820</td>
                                            <td class="fw-bold">wiliamm</td>
                                            <td>Double Shot Espresso</td>
                                            <td><i class="bi bi-cash me-2"></i>Tunai</td>
                                            <td class="fw-bold text-primary">Rp 22.000</td>
                                            <td class="text-center"><span class="badge-status">Success</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>