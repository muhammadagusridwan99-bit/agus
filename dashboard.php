<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Simulasi data (Ganti dengan query database asli Anda)
$tanggal_hari_ini = date('Y-m-d');
$jumlah_transaksi = 25; // Contoh statis
$total_pendapatan = "Rp 2.500.000";
$stok_menipis = 5;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern POS - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --sidebar-bg: #1e1e2d;
            --body-bg: #f5f7fb;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--body-bg);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: #a2a3b7;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            color: #a2a3b7;
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar .nav-link i { font-size: 1.2rem; margin-right: 15px; }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(67, 97, 238, 0.15);
            color: #ffffff;
        }

        .sidebar .nav-link.active { background: var(--primary-color); }

        /* Content Styling */
        .main-content { padding: 30px; }

        .top-nav {
            background: #fff;
            padding: 15px 30px;
            border-bottom: 1px solid #e1e1e1;
        }

        /* Card Customization */
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            background: #fff;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bg-light-primary { background: rgba(67, 97, 238, 0.1); color: var(--primary-color); }
        .bg-light-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .bg-light-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar { min-height: auto; }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-3 col-lg-2 sidebar d-none d-md-block shadow">
            <div class="p-4 text-center">
                <h4 class="text-white fw-bold mb-0">SMART<span class="text-primary">POS</span></h4>
                <p class="small opacity-50">Management System</p>
            </div>
            
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="#" class="nav-link active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="data_barang.php" class="nav-link"><i class="bi bi-box-seam"></i> Data Barang</a>
                </li>
                <li class="nav-item">
                    <a href="data_pengguna.php" class="nav-link"><i class="bi bi-people"></i> Pengguna</a>
                </li>
                <li class="nav-item">
                    <a href="transaksi.php" class="nav-link"><i class="bi bi-receipt"></i> Transaksi</a>
                </li>
                <li class="mt-4 px-4 text-uppercase small fw-bold opacity-50" style="letter-spacing: 1px;">Account</li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</a>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <header class="top-nav d-flex justify-content-between align-items-center shadow-sm">
                <h5 class="mb-0 fw-semibold">Overview</h5>
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-3 dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i> <?php echo $_SESSION['username']; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </header>

            <div class="main-content">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark">Selamat Datang Kembali! 👋</h3>
                    <p class="text-muted">Ini adalah ringkasan penjualan toko Anda untuk hari ini.</p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="stat-card shadow-sm d-flex align-items-center">
                            <div class="icon-box bg-light-primary me-3">
                                <i class="bi bi-cart-check-fill"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small fw-bold text-uppercase">Transaksi Hari Ini</p>
                                <h3 class="mb-0 fw-bold"><?php echo $jumlah_transaksi; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="stat-card shadow-sm d-flex align-items-center">
                            <div class="icon-box bg-light-success me-3">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small fw-bold text-uppercase">Total Pendapatan</p>
                                <h3 class="mb-0 fw-bold"><?php echo $total_pendapatan; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="stat-card shadow-sm d-flex align-items-center">
                            <div class="icon-box bg-light-warning me-3">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small fw-bold text-uppercase">Stok Menipis</p>
                                <h3 class="mb-0 fw-bold"><?php echo $stok_menipis; ?> <span class="small fw-normal text-muted">Item</span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="mb-0 fw-bold">Transaksi Terbaru</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">ID Transaksi</th>
                                                <th>Nama Barang</th>
                                                <th>Waktu</th>
                                                <th>Total</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 fw-medium">#TRX-001</td>
                                                <td>Kopi Arabika 250g</td>
                                                <td class="text-muted">10:20 AM</td>
                                                <td class="fw-bold text-primary">Rp 45.000</td>
                                                <td class="text-center"><span class="badge bg-success-subtle text-success px-3 rounded-pill">Selesai</span></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 fw-medium">#TRX-002</td>
                                                <td>Susu UHT Full Cream</td>
                                                <td class="text-muted">09:15 AM</td>
                                                <td class="fw-bold text-primary">Rp 18.500</td>
                                                <td class="text-center"><span class="badge bg-success-subtle text-success px-3 rounded-pill">Selesai</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 py-3 text-center">
                                <a href="transaksi.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">Lihat Semua Transaksi</a>
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
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 72998866e94db66d3606ba4d5e927ebc08315b7c
