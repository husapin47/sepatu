<?php
session_start();
// Aktifkan laporan kesalahan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS untuk styling form pencarian di sidebar */
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            width: calc(100% - 40px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }
        .search-container button {
            padding: 10px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 0 4px 4px 0;
            font-size: 16px;
            cursor: pointer;
            width: 40px;
        }
        .search-container button:hover {
            background-color: #218838;
        }
        .search-container button i {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/logo.jpg" alt="Logo" class="logo">
            <div class="header-text">
                <h1>My Dashboard</h1>
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
            <a href="etalase.php"><i class="fas fa-box"></i> Etalase</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content">
            <h1>Selamat datang di toko kami</h1>
            <p>This is your main control panel.</p>
            
            <!-- Add shoe sales content -->
            <div class="shoe-sales">
                <h2>Top Selling Shoes</h2>
                <div class="shoe-grid">
                    <div class="shoe-item">
                        <img src="image/nikeE.jpg" alt="NIKE">
                        <h3>NIKE</h3>
                        <p>Rp.550.000</p>
                    </div>
                    <div class="shoe-item">
                        <img src="image/adidas.jpg" alt="ADIDAS">
                        <h3>ADIDAS</h3>
                        <p>Rp.700.000</p>
                    </div>
                    <div class="shoe-item">
                        <img src="image/ventela.jpg" alt="VENTELA">
                        <h3>VENTELA</h3>
                        <p>Rp.600.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 My Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>
