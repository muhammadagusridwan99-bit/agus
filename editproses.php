if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok = $_POST['stok_barang'];

    $result = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', harga_barang='$harga', stok_barang='$stok' WHERE id=$id");

    if($result) {
        header("Location: data_barang.php?pesan=berhasil");
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}