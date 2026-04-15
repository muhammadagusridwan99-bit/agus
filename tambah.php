<?php
include 'koneksi.php';
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kopi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    $insert = mysqli_query($conn, "INSERT INTO menu_kopi VALUES (NULL, '$nama', '$harga', '$kategori', '$deskripsi')");
    if($insert) header("Location: data_kopi.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card p-4">
            <h3>Tambah Menu Baru</h3>
            <form method="POST">
                <div class="mb-3">
                    <label>Nama Kopi</label>
                    <input type="text" name="nama_kopi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Coffee">Coffee</option>
                        <option value="Non-Coffee">Non-Coffee</option>
                        <option value="Snack">Snack</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
                <button type="submit" name="simpan" class="btn btn-success w-100">Simpan Menu</button>
            </form>
        </div>
    </div>
</body>
</html>