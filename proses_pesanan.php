<?php
session_start();
require 'conn.php';

if (isset($_POST['submit'])) {
    // Ambil informasi dari form
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    $total_harga = isset($_SESSION['total_harga']) ? $_SESSION['total_harga'] : 0;

    // Tentukan biaya pengiriman berdasarkan metode
    $biaya_pengiriman = 0;
    if ($metode_pengiriman == 'regular') {
        $biaya_pengiriman = 10000;
    } elseif ($metode_pengiriman == 'express') {
        $biaya_pengiriman = 20000;
    } elseif ($metode_pengiriman == 'same_day') {
        $biaya_pengiriman = 30000;
    }

    // Tambahkan biaya pengiriman ke total harga
    $total_harga += $biaya_pengiriman;

    // Simpan pesanan ke database
    $sql = "INSERT INTO pesanan (metode_pembayaran, metode_pengiriman, alamat_pengiriman, total_harga) VALUES ('$metode_pembayaran', '$metode_pengiriman', '$alamat_pengiriman', '$total_harga')";
    if (mysqli_query($conn, $sql)) {
        // Dapatkan ID pesanan yang baru saja dimasukkan
        $id_pesanan = mysqli_insert_id($conn);

        // Generate ID transaksi menggunakan uniqid()
        $id_transaksi = uniqid('trx_');

        // Simpan pesanan ke tabel `tb_transaksi`
        // Ambil informasi user dari session atau dari form
        
        $nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest';
        $alamat = isset($_SESSION['alamat']) ? $_SESSION['alamat'] : 'Unknown';
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Unknown';
        $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;

        $sql_transaksi = "INSERT INTO tb_transaksi (id_transaksi, nama, alamat, email, metode_pembayaran, metode_pengiriman, alamat_pengiriman, id_pesanan, id_user) VALUES ('$id_transaksi', '$nama', '$alamat', '$email', '$metode_pembayaran', '$metode_pengiriman', '$alamat_pengiriman', '$id_pesanan', '$id_users')";
        if (mysqli_query($conn, $sql_transaksi)) {
            // Data berhasil disimpan ke kedua tabel
            echo "<div class='container'><p class='success-message'>Pesanan berhasil diproses dengan ID transaksi $id_transaksi, metode pembayaran $metode_pembayaran, metode pengiriman $metode_pengiriman, alamat pengiriman $alamat_pengiriman, dan total harga Rp $total_harga.</p></div>";

            // Ambil riwayat transaksi
            $result = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY created_at DESC");
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
            echo "<div class='container'><p class='error-message'>Terjadi kesalahan dalam memproses pesanan: " . mysqli_error($conn) . "</p></div>";
        }
    } else {
        echo "<div class='container'><p class='error-message'>Terjadi kesalahan dalam memproses pesanan: " . mysqli_error($conn) . "</p></div>";
    }
}
?>
