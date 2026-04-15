<?php
include 'config.php';
$data = json_decode(file_get_contents('php://input'), true);
if (!empty($data)) {
    mysqli_begin_transaction($conn);
    try {
        foreach ($data as $item) {
            $id = (int)$item['id'];
            $qty = (int)$item['qty'];
            mysqli_query($conn, "UPDATE barang SET stok_barang = stok_barang - $qty WHERE id = $id");
        }
        mysqli_commit($conn);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error']);
    }
}
?>