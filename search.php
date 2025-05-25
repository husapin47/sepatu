<?php
session_start();
// Aktifkan laporan kesalahan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conn.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

// Cari barang berdasarkan query
$stmt = $conn->prepare("SELECT * FROM tb_sepatu WHERE nama LIKE ?");
$searchTerm = '%' . $query . '%';
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$sepatu = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/logo.jpg" alt="Logo" class="logo">
            <div class="header-text">
                <h1>Hasil Pencarian</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidebar">
            <a href="dashboard_customer.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="etalase.php"><i class="fas fa-box"></i> Etalase</a>
            <a href="keranjang.php"><i class="fas fa-exchange-alt"></i> Keranjangh</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content">
            <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($query); ?>"</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Ukuran</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sepatu)): ?>
                        <?php foreach ($sepatu as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['id_sepatu']); ?></td>
                                <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                <td>Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($item['ukuran']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" width="50"></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Tidak ada hasil yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 My Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>
