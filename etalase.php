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

require 'conn.php';

// Ambil data sepatu dari database
$stmt = $conn->prepare("SELECT * FROM tb_sepatu");
$stmt->execute();
$result = $stmt->get_result();
$sepatu = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Etalase Sepatu</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .shoe-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }
        .shoe-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            width: 30%;
        }
        .shoe-item img {
            max-width: 100%;
            border-radius: 10px;
        }
        .shoe-item h3 {
            margin: 10px 0;
        }
        .shoe-item p {
            margin: 0;
        }
        .shoe-item button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/logo.jpg" alt="Logo" class="logo">
            <div class="header-text">
                <h1>Etalase Sepatu</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidebar">
            <div class="search-container">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Cari barang...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a href="dashboard_customer.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="etalase.php"><i class="fas fa-box"></i> Etalase</a>
            <a href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content">
            <h1>Semua Produk Sepatu</h1>
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message" id="success-message">
                    Produk berhasil ditambahkan ke keranjang!
                </div>
            <?php endif; ?>
            <div class="shoe-grid">
                <?php foreach ($sepatu as $item): ?>
                    <div class="shoe-item">
                        <img src="<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>">
                        <h3><?php echo htmlspecialchars($item['nama']); ?></h3>
                        <p>Harga: Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                        <p>Ukuran: <?php echo htmlspecialchars($item['ukuran']); ?></p>
                        <form action="tambah_keranjang.php" method="POST">
                            <input type="hidden" name="id_sepatu" value="<?php echo $item['id_sepatu']; ?>">
                            <button type="submit">Tambah ke Keranjang</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 My Dashboard. All Rights Reserved.</p>
    </footer>
    <script>
        // Sembunyikan pesan sukses setelah 5 detik
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var successMessage = document.getElementById("success-message");
                if (successMessage) {
                    successMessage.style.display = "none";
                }
            }, 5000);
        });
    </script>
</body>
</html>
