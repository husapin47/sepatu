<?php
session_start();

// Aktifkan laporan kesalahan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Periksa apakah pengguna sudah login dan memiliki peran customer
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];

// Inisialisasi total harga
$total_harga = 0;

foreach ($keranjang as $item) {
    // Hitung total harga untuk setiap item dan tambahkan ke total harga keseluruhan
    $total_harga += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Gaya CSS Anda */
    </style>
</head>
<body>
    <header>
        <!-- Konten Header -->
    </header>
    <div class="container">
        <div class="sidebar">
            <!-- Sidebar Anda -->
        </div>
        <div class="content">
            <h1>Keranjang Belanja Anda</h1>
            <div class="exit-button">
                <a href="etalase.php"><button>Exit</button></a>
            </div>
            <?php if (empty($keranjang)): ?>
                <p>Keranjang Anda kosong.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keranjang as $item): ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" style="width: 100px;"></td>
                                <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                <td>Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="update_keranjang.php" method="POST">
                                            <input type="hidden" name="id_sepatu" value="<?php echo $item['id_sepatu']; ?>">
                                            <input type="hidden" name="action" value="kurangi">
                                            <button type="submit">-</button>
                                        </form>
                                        <span><?php echo $item['jumlah']; ?></span>
                                        <form action="update_keranjang.php" method="POST">
                                            <input type="hidden" name="id_sepatu" value="<?php echo $item['id_sepatu']; ?>">
                                            <input type="hidden" name="action" value="tambah">
                                            <button type="submit">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td>Rp. <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="hapus_keranjang.php" method="POST">
                                        <input type="hidden" name="id_sepatu" value="<?php echo $item['id_sepatu']; ?>">
                                        <button type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Harga:</strong></td>
                            <td><strong>Rp. <?php echo number_format($total_harga, 0, ',', '.'); ?></strong></td>
                            <td></td> <!-- Tambahkan kolom kosong untuk keseimbangan tata letak -->
                        </tr>
                    </tbody>
                </table>
                <div class="checkout-button">
                    <button onclick="window.location.href='checkout.php'">Checkout</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 My Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>
