<?php
session_start();
require 'conn.php';

// Cek apakah transaksi baru saja selesai
if (isset($_SESSION['transaksi_selesai']) && $_SESSION['transaksi_selesai']) {
    $id_pesanan = $_SESSION['id_pesanan'];
    $id_transaksi = $_SESSION['id_transaksi'];
    $total_harga = $_SESSION['total_harga'];
    $metode_pembayaran = $_SESSION['metode_pembayaran'];
    $metode_pengiriman = $_SESSION['metode_pengiriman'];
    $alamat_pengiriman = $_SESSION['alamat_pengiriman'];

    echo "<div class='container'><p class='success-message'>Pesanan berhasil diproses dengan ID transaksi $id_transaksi, metode pembayaran $metode_pembayaran, metode pengiriman $metode_pengiriman, alamat pengiriman $alamat_pengiriman, dan total harga Rp $total_harga.</p></div>";

    // Ambil riwayat transaksi terbaru
    $result = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan ORDER BY created_at DESC");
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Riwayat Transaksi</h2>";
        echo "<table>";
        echo "<tr><th>ID Pesanan</th><th>Metode Pembayaran</th><th>Metode Pengiriman</th><th>Alamat Pengiriman</th><th>Total Harga</th><th>Waktu Pemesanan</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['id_pesanan']."</td>";
            echo "<td>".$row['metode_pembayaran']."</td>";
            echo "<td>".$row['metode_pengiriman']."</td>";
            echo "<td>".$row['alamat_pengiriman']."</td>";
            echo "<td>".$row['total_harga']."</td>";
            echo "<td>".$row['created_at']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Tambahkan tombol cetak
        echo "<button onclick='printHistory()'>Cetak Riwayat Pesanan</button>";
        echo "<script>
            function printHistory() {
                window.print();
            }
        </script>";

        // Tambahkan tombol Exit
        echo "<div class='exit-button'>
        <a href='keranjang.php' class='exit-link'>Exit</a>
        </div>";
    } else {
        echo "<p>Belum ada transaksi.</p>";
    }
} else {
    // Redirect ke halaman utama atau halaman lain jika tidak ada transaksi yang baru saja selesai
    header("Location: index.php");
    exit();
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .success-message {
        color: green;
    }

    .error-message {
        color: red;
    }

    .exit-button {
        margin-top: 20px;
    }

    .exit-link {
        text-decoration: none;
        color: #ffffff;
        background-color: #6c757d;
        padding: 10px 20px;
        border-radius: 5px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }
</style>
