<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: data_kopi.php");
    exit();
}

$id = intval($_GET['id']);

// Ambil data lama berdasarkan ID
$query_data = mysqli_query($conn, "SELECT * FROM menu_kopi WHERE id = $id");
$row = mysqli_fetch_array($query_data);

// Jika ID tidak ditemukan di database
if (!$row) {
    header("Location: data_kopi.php");
    exit();
}

// Proses Update Data
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kopi']);
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    $update = mysqli_query($conn, "UPDATE menu_kopi SET 
                                    nama_kopi = '$nama', 
                                    harga = '$harga', 
                                    kategori = '$kategori' 
                                    WHERE id = $id");

    if ($update) {
        header("Location: data_kopi.php");
        exit();
    } else {
        $error_msg = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - SmartPOS Elite</title>
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
            display: flex;
            align-items: center;
            background-image: radial-gradient(circle at 50% 50%, rgba(125, 95, 255, 0.08) 0%, transparent 50%);
        }

        .edit-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid var(--glass-border);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: white;
            border-radius: 12px;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 0.25 row rgba(125, 95, 255, 0.25);
        }

        .btn-update {
            background: linear-gradient(135deg, var(--accent-primary), #5741d9);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(125, 95, 255, 0.3);
            background: linear-gradient(135deg, #5741d9, var(--accent-primary));
        }

        .btn-back {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover { color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="edit-card shadow-lg">
        <div class="mb-4">
            <a href="data_kopi.php" class="btn-back"><i class="bi bi-arrow-left me-2"></i> Kembali ke Menu</a>
            <h3 class="fw-bold mt-3 mb-1">Edit Produk</h3>
            <p class="text-white-50 small">Perbarui informasi varian kopi Anda.</p>
        </div>

        <?php if(isset($error_msg)): ?>
            <div class="alert alert-danger py-2 small" style="border-radius:10px;"><?= $error_msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small text-white-50">Nama Menu</label>
                <input type="text" name="nama_kopi" class="form-control" value="<?= htmlspecialchars($row['nama_kopi']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label small text-white-50">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label small text-white-50">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="Coffee" <?= $row['kategori'] == 'Coffee' ? 'selected' : '' ?>>Coffee</option>
                    <option value="Non-Coffee" <?= $row['kategori'] == 'Non-Coffee' ? 'selected' : '' ?>>Non-Coffee</option>
                    <option value="Snack" <?= $row['kategori'] == 'Snack' ? 'selected' : '' ?>>Snack</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary btn-update w-100 mb-3">
                <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>