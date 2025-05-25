<?php
session_start();
require 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data sepatu berdasarkan id
    $stmt = $conn->prepare("DELETE FROM tb_sepatu WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: daftar_sepatu.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
