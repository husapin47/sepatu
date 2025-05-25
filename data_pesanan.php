<?php
// Konfigurasi koneksi database
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

// Fungsi untuk menghapus data
if (isset($_GET['delete'])) {
    $id_pesanan = $_GET['delete'];
    $sql = "DELETE FROM pesanan WHERE id_pesanan=$id_pesanan";
    $conn->query($sql);
}

// Fungsi untuk mengambil data pesanan
$sql = "SELECT * FROM pesanan";
$result = $conn->query($sql);

// Fungsi untuk mengambil data pesanan berdasarkan ID untuk keperluan edit
$edit_row = null;
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];
    $edit_sql = "SELECT * FROM pesanan WHERE id_pesanan=$id_pesanan";
    $edit_result = $conn->query($edit_sql);
    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
    }
}

// Fungsi untuk memperbarui data pesanan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    $total_harga = $_POST['total_harga'];
    
    $sql = "UPDATE pesanan SET metode_pembayaran='$metode_pembayaran', metode_pengiriman='$metode_pengiriman', alamat_pengiriman='$alamat_pengiriman', total_harga='$total_harga' WHERE id_pesanan=$id_pesanan";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: data_pesanan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
        h1 {
            margin-bottom: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons a, .action-buttons button {
            padding: 5px 10px;
            border: none;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .action-buttons a.delete {
            background-color: #dc3545;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
    <!-- Sertakan html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Data Pesanan</h1>
        <table id="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Metode Pembayaran</th>
                    <th>Metode Pengiriman</th>
                    <th>Alamat Pengiriman</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Tampilkan data pesanan dalam tabel
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_pesanan'] . "</td>";
                        echo "<td>" . $row['metode_pembayaran'] . "</td>";
                        echo "<td>" . $row['metode_pengiriman'] . "</td>";
                        echo "<td>" . $row['alamat_pengiriman'] . "</td>";
                        echo "<td>Rp" . $row['total_harga'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>
                            <div class='action-buttons'>
                                <a href='data_pesanan.php?id=" . $row['id_pesanan'] . "'>Edit</a>
                                <a href='?delete=" . $row['id_pesanan'] . "' class='delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a>
                            </div>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data pesanan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if ($edit_row) : ?>
        <h2>Edit Pesanan</h2>
        <form method="post" action="data_pesanan.php">
            <input type="hidden" name="id_pesanan" value="<?php echo $edit_row['id_pesanan']; ?>">
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <input type="text" name="metode_pembayaran" id="metode_pembayaran" value="<?php echo $edit_row['metode_pembayaran']; ?>" required>
            </div>
            <div class="form-group">
                <label for="metode_pengiriman">Metode Pengiriman</label>
                <input type="text" name="metode_pengiriman" id="metode_pengiriman" value="<?php echo $edit_row['metode_pengiriman']; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat_pengiriman">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="4" required><?php echo $edit_row['alamat_pengiriman']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="total_harga">Total Harga</label>
                <input type="number" name="total_harga" id="total_harga" value="<?php echo $edit_row['total_harga']; ?>" required>
            </div>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>

        <!-- Tombol untuk mencetak tabel -->
        <button id="print-button">Cetak ke PNG/JPG</button>
        <!-- Tombol Exit -->
        <div style="margin-top: 20px; text-align: center;">
            <a href="dashboard_admin.php" style="text-decoration: none; color: #fff; background-color: #6c757d; padding: 10px 20px; border-radius: 5px;">Exit</a>
        </div>
    </div>
    <script>
        document.getElementById("print-button").addEventListener("click", function () {
            html2canvas(document.getElementById("data-table")).then(function(canvas) {
                // Anda bisa mengubah "image/png" ke "image/jpeg" untuk format JPG
                var link = document.createElement('a');
                link.download = 'data_pesanan.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    </script>
</body>
</html>
