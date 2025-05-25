<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sepatu = $_POST['id_sepatu'];

    if (isset($_SESSION['keranjang'][$id_sepatu])) {
        unset($_SESSION['keranjang'][$id_sepatu]);
    }
}

header("Location: keranjang.php");
exit();
?>
