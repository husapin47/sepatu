<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="styles.css"> <!-- Sertakan file CSS Anda di sini -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Riwayat Transaksi</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Metode Pembayaran</th>
                    <th>Metode Pengiriman</th>
                    <th>Alamat Pengiriman</th>
                    <th>ID Pesanan</th>
                    <th>ID User</th>
                    <th>Aksi</th> <!-- Kolom untuk tombol hapus -->
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root"; // Ganti dengan username database Anda
                $password = ""; // Ganti dengan password database Anda
                $database = "db_dear"; // Ganti dengan nama database Anda

                // Buat koneksi
                $conn = new mysqli($servername, $username, $password, $database);

                // Periksa koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Ambil data transaksi dari database
                $sql = "SELECT * FROM tb_transaksi";
                $result = $conn->query($sql);

                // Periksa apakah ada hasil query sebelum mencoba mengakses num_rows
                if ($result) {
                    if ($result->num_rows > 0) {
                        // Lakukan iterasi pada hasil query
                        while ($row = $result->fetch_assoc()) {
                            // Tampilkan data transaksi
                            echo "<tr>";
                            echo "<td>" . $row['id_transaksi'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['alamat'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['metode_pembayaran'] . "</td>";
                            echo "<td>" . $row['metode_pengiriman'] . "</td>";
                            echo "<td>" . $row['alamat_pengiriman'] . "</td>";
                            echo "<td>" . $row['id_pesanan'] . "</td>";
                            echo "<td>" . $row['id_user'] . "</td>";
                            echo "<td><button class='delete-button' onclick='deleteTransaction(\"" . $row['id_transaksi'] . "\")'>Hapus</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Tidak ada data transaksi</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Error: " . $sql . "<br>" . $conn->error . "</td></tr>";
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Tombol untuk mencetak tabel -->
    <button id="print-button">Cetak ke PNG/JPG</button>

    <!-- Tombol Exit -->
    <div style="margin-top: 20px; text-align: center;">
        <a href="dashboard_admin.php" style="text-decoration: none; color: #fff; background-color: #6c757d; padding: 10px 20px; border-radius: 5px;">Exit</a>
    </div>

    <script>
        // Mengaktifkan fungsi pencetakan saat tombol ditekan
        document.getElementById("print-button").addEventListener("click", function() {
            window.print();
        });

        // Fungsi untuk mengirim permintaan penghapusan
        function deleteTransaction(id) {
            if (confirm("Anda yakin ingin menghapus transaksi ini?")) {
                // Mengirim permintaan AJAX ke file PHP penghapus data
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Refresh halaman setelah penghapusan berhasil
                        window.location.reload();
                    }
                };
                xhr.open("GET", "delete_transaction.php?id=" + id, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>
