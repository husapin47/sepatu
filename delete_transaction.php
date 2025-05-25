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

// Terima ID transaksi dari parameter GET
$id_transaksi = $_GET['id'];

// Mulai transaksi
$conn->begin_transaction();

// Buat query untuk menghapus data dari kedua tabel
$sql_transaksi = "DELETE FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'";
$sql_pendaftar = "DELETE FROM pesanan WHERE id_pesanan = '$id_pesanan'";

// Jalankan query
if ($conn->query($sql_transaksi) === TRUE && $conn->query($sql_pendaftar) === TRUE) {
    // Jika berhasil, commit transaksi
    $conn->commit();
    echo "Transaksi dan data pendaftar berhasil dihapus";
} else {
    // Jika gagal, rollback transaksi
    $conn->rollback();
    echo "Error: " . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
