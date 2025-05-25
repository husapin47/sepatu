<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran customer
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

// Pastikan id_sepatu dan action disediakan
if (isset($_POST['id_sepatu'], $_POST['action'])) {
    $id_sepatu = $_POST['id_sepatu'];
    $action = $_POST['action'];

    // Ambil keranjang belanja dari sesi
    $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];

    // Periksa apakah id_sepatu ada di dalam keranjang
    if (array_key_exists($id_sepatu, $keranjang)) {
        // Jika action adalah "tambah", tambahkan jumlah barang
        if ($action === "tambah") {
            $keranjang[$id_sepatu]['jumlah']++;
        }
        // Jika action adalah "kurangi", kurangi jumlah barang
        elseif ($action === "kurangi") {
            // Pastikan jumlah barang tidak kurang dari 1
            if ($keranjang[$id_sepatu]['jumlah'] > 1) {
                $keranjang[$id_sepatu]['jumlah']--;
            }
        }

        // Simpan kembali keranjang belanja ke sesi
        $_SESSION['keranjang'] = $keranjang;
    }
}

// Alihkan kembali ke halaman keranjang.php
header("Location: keranjang.php");
exit();
?>
