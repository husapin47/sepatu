<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sepatu = $_POST['id_sepatu'];

    // Ambil detail sepatu dari database
    require 'conn.php';
    $stmt = $conn->prepare("SELECT * FROM tb_sepatu WHERE id_sepatu = ?");
    $stmt->bind_param("i", $id_sepatu);
    $stmt->execute();
    $result = $stmt->get_result();
    $sepatu = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($sepatu) {
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        if (!isset($_SESSION['keranjang'][$id_sepatu])) {
            $_SESSION['keranjang'][$id_sepatu] = $sepatu;
            $_SESSION['keranjang'][$id_sepatu]['jumlah'] = 1;
        } else {
            $_SESSION['keranjang'][$id_sepatu]['jumlah'] += 1;
        }
    }
    // Redirect ke etalase dengan pesan sukses
    header("Location: etalase.php?success=1");
    exit();
}
