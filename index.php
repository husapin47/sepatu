<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Jika sudah login, arahkan ke dasbor sesuai peran
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_customer.php");
    }
    exit();
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
