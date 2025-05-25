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

// Ambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];
    $sql = "SELECT * FROM pesanan WHERE id_pesanan=$id_pesanan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
}

// Fungsi untuk mengupdate data
if (isset($_POST['update'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    $total_harga = $_POST['total_harga'];
    $created_at = $_POST['created_at'];

    $sql = "UPDATE pesanan SET metode_pembayaran='$metode_pembayaran', metode_pengiriman='$metode_pengiriman', alamat_pengiriman='$alamat_pengiriman', total_harga='$total_harga', created_at='$created_at' WHERE id_pesanan=$id_pesanan";
    if ($conn->query($sql) === TRUE) {
        header("Location: riwayat_admin.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pesanan</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Data Pesanan</h1>
        <form method="POST">
            <input type="hidden" name="id_pesanan" value="<?php echo $row['id_pesanan']; ?>">
            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <input type="text" id="metode_pembayaran" name="metode_pembayaran" value="<?php echo $row['metode_pembayaran']; ?>" required>
            </div>
            <div class="form-group">
                <label for="metode_pengiriman">Metode Pengiriman:</label>
                <input type="text" id="metode_pengiriman" name="metode_pengiriman" value="<?php echo $row['metode_pengiriman']; ?>"
