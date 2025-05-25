<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM tb_users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil peran pengguna dari hasil query
        $user = $result->fetch_assoc();
        $role = $user['role'];

        // Set sesi email dan peran
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // Redirect ke dasbor sesuai peran
        if ($role === 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_customer.php");
        }
        exit();
    } else {
        $error = "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2575fc;
        }
        .login-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #2575fc;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .login-form button:hover {
            background-color: #1e63b6;
        }
        .login-form .register-link {
            margin-top: 15px;
            display: block;
            font-size: 14px;
            color: #2575fc;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-form">
        <img src="image/logo.jpg" alt="Logo" width="100"> 
        <h2>Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Masukkan Email" required>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            <button type="submit">Login</button>
            <?php if(isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        </form>
        <a class="register-link" href="register.php">Belum punya akun? Daftar di sini</a>
    </div>
</body>
</html>
