<?php
include 'config.php';

// --- LOGIKA TAMBAH USER ---
if (isset($_POST['tambah'])) {
    $user = $_POST['username'];
    $pass = $_POST['password']; // Sebaiknya gunakan password_hash untuk keamanan
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: data_pengguna.php");
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}

// --- LOGIKA EDIT USER ---
if (isset($_POST['update'])) {
    $id   = $_POST['id'];
    $user = $_POST['username'];
    $role = $_POST['role'];
    $pass = $_POST['password'];

    if (!empty($pass)) {
        // Jika password diisi, update password juga
        $query = "UPDATE users SET username='$user', password='$pass', role='$role' WHERE id='$id'";
    } else {
        // Jika password kosong, jangan ubah password lama
        $query = "UPDATE users SET username='$user', role='$role' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: data_pengguna.php");
    }
}

// --- LOGIKA HAPUS USER ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (mysqli_query($conn, "DELETE FROM users WHERE id='$id'")) {
        header("Location: data_pengguna.php");
    }
}
?>