<?php
session_start();
// Check if user is logged in and has admin role
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/logo.jpg" alt="Logo" class="logo">
            <div class="header-text">
                <h1> Dashboard Admin</h1>
                <p>Welcome, <?php echo $_SESSION['email']; ?></p>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sidebar">
            <a href="daftar_sepatu.php"><i class="fas fa-box"></i> Produk</a>
            <a href="data_pesanan.php"><i class="fas fa-exchange-alt"></i> Pesanan</a>
            <a href="riwayat(admin).php"><i class="fas fa-file-export"></i> Riwayat Transaksi</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="content">
            <h1>Admin Kaki Kita</h1>
            <p>This is your main control panel.</p>
            
            <!-- Add shoe sales content -->
            <div class="shoe-sales">
                <h2>Etalase Toko</h2>
                <div class="shoe-grid">
                    <div class="shoe-item">
                        <img src="image/nikee.jpg" alt="NIKE">
                        <h3>Sporty Runner</h3>
                        
                    </div>
                    <div class="shoe-item">
                        <img src="image/adidas.jpg" alt="Shoe 2">
                        <h3>Adidas</h3>
                        
                    </div>
                    <div class="shoe-item">
                        <img src="image/ventela.jpg" alt="Shoe 3">
                        <h3>Ventela</h3>
                        
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
