<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Ambil id dari form
    $nama = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Ambil peran dari dropdown

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Periksa apakah email sudah ada
        $checkEmailStmt = $conn->prepare("SELECT * FROM tb_users WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists";
        } else {
            // Siapkan dan ikat
            $stmt = $conn->prepare("INSERT INTO tb_users (id, nama, email, password, role) VALUES (?, ?, ?, ?, ?)");
            
            // Periksa apakah statement berhasil dibuat
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("issss", $id, $nama, $email, $password, $role);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Registration successful!";
                header("Location: register.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $checkEmailStmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .register-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .register-form h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2575fc;
        }
        .register-form input, .register-form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .register-form button {
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
        .register-form button:hover {
            background-color: #1e63b6;
        }
        .register-form .login-link {
            margin-top: 15px;
            display: block;
            font-size: 14px;
            color: #2575fc;
        }
        .success-message {
            color: green;
            margin-top: 10px;
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
    <div class="register-form">
        <img src="image/logo.jpg" alt="Logo" width="100"> 
        <h2>Register</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="number" name="id" placeholder="ID" required>
            <input type="text" name="fullname" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Masukkan Email" required>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <select name="role" required>
                <option value="">Pilih Peran</option>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
            </select>
            <button type="submit">Register</button>
            <?php if(isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        </form>
        <a class="login-link" href="login.php">Sudah punya akun? Login di sini</a>
    </div>
</body>
</html>
