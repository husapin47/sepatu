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

// Inisialisasi variabel
$metode_pembayaran = $metode_pengiriman = $alamat_pengiriman = $total_harga = "";

// Periksa apakah ID pesanan tersedia di URL
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];
    
    // Ambil data pesanan dari database berdasarkan ID
    $sql = "SELECT * FROM pesanan WHERE id_pesanan=$id_pesanan";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $metode_pembayaran = $row['metode_pembayaran'];
        $metode_pengiriman = $row['metode_pengiriman'];
        $alamat_pengiriman = $row['alamat_pengiriman'];
        $total_harga = $row['total_harga'];
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

// Proses update data pesanan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = $_POST['id_pesanan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    $total_harga = $_POST['total_harga'];
    
    // Mulai transaksi
    $conn->begin_transaction();
    
    try {
        // Update data di tabel pesanan
        $sql = "UPDATE pesanan SET metode_pembayaran='$metode_pembayaran', metode_pengiriman='$metode_pengiriman', alamat_pengiriman='$alamat_pengiriman', total_harga='$total_harga' WHERE id_pesanan=$id_pesanan";
        if ($conn->query($sql) !== TRUE) {
            throw new Exception("Error updating pesanan: " . $conn->error);
        }
        
        // Update data di tabel tb_transaksi
        $sql = "UPDATE tb_transaksi SET metode_pembayaran='$metode_pembayaran', metode_pengiriman='$metode_pengiriman', alamat_pengiriman='$alamat_pengiriman', total_harga='$total_harga' WHERE id_transaksi=$id_pesanan";
        if ($conn->query($sql) !== TRUE) {
            throw new Exception("Error updating tb_transaksi: " . $conn->error);
        }
        
        // Commit transaksi
        $conn->commit();
        header("Location: data_pesanan.php");
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo $e->getMessage();
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
    <title>Edit Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
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
</head>
<body>
    <div class="container">
        <h1>Edit Pesanan</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="id_pesanan" value="<?php echo $id_pesanan; ?>">
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <input type="text" name="metode_pembayaran" id="metode_pembayaran" value="<?php echo $metode_pembayaran; ?>" required>
            </div>
            <div class="form-group">
                <label for="metode_pengiriman">Metode Pengiriman</label>
                <input type="text" name="metode_pengiriman" id="metode_pengiriman" value="<?php echo $metode_pengiriman; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat_pengiriman">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="4" required><?php echo $alamat_pengiriman; ?></textarea>
            </div>
            <div class="form-group">
                <label for="total_harga">Total Harga</label>
                <input type="number" name="total_harga" id="total_harga" value="<?php echo $total_harga; ?>" required>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
