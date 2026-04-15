<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// 1. Logika Hapus Pengguna
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: data_pengguna.php");
    exit();
}

// 2. Logika Tambah Pengguna
if (isset($_POST['tambah_user'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role = $_POST['role'];
    $pass = MD5($_POST['password']); 
    
    $query_tambah = "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$user', '$pass', '$nama', '$role')";
    mysqli_query($conn, $query_tambah);
    header("Location: data_pengguna.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - SmartPOS Elite</title>
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
        .form-control, .form-select {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            color: white; border-radius: 12px;
        }
        .modal-content {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            color: white; border-radius: 25px;
        }
        /* Tombol aksi custom */
        .btn-edit { color: #0dcaf0; transition: 0.3s; }
        .btn-edit:hover { color: #fff; background: #0dcaf0; }
        .btn-delete { color: #ff4d4d; transition: 0.3s; }
        .btn-delete:hover { color: #fff; background: #ff4d4d; }
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
                <li class="nav-item"><a href="transaksi.php" class="nav-link"><i class="bi bi-receipt-cutoff me-2"></i> Kasir</a></li>
                <li class="nav-item"><a href="data_pengguna.php" class="nav-link active"><i class="bi bi-people-fill me-2"></i> Pengguna</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-power me-2"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-bold mb-1">Data Pengguna 👤</h2>
                        <p class="text-white-50">Kelola hak akses admin dan kasir.</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow" style="border-radius:15px" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah User
                    </button>
                </div>

                <div class="luxury-card shadow-lg">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                                
                                if (!$query) {
                                    echo "<tr><td colspan='5' class='text-center text-danger small'>Query Gagal: " . mysqli_error($conn) . "</td></tr>";
                                } else {
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)):
                                ?>
                                <tr>
                                    <td class="text-white-50 small"><?= $no++; ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= isset($row['nama_lengkap']) ? htmlspecialchars($row['nama_lengkap']) : '-'; ?></td>
                                    <td>
                                        <span class="badge <?= (isset($row['role']) && $row['role'] == 'Admin') ? 'bg-primary' : 'bg-info text-dark' ?>">
                                            <?= isset($row['role']) ? $row['role'] : 'Kasir'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit_pengguna.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-edit border-0 me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-delete border-0" onclick="return confirm('Hapus user ini?')">
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
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small text-white-50">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-white-50">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-white-50">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-white-50">Role</label>
                        <select name="role" class="form-select">
                            <option value="Kasir">Kasir</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="tambah_user" class="btn btn-primary w-100 py-2" style="border-radius:12px">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>