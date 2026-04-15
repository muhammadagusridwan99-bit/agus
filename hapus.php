<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM menu_kopi WHERE id=$id");
header("Location: data_kopi.php");
?>