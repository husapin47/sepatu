<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodebarang = $_POST['kodebarang'];
    $Merksepatu = $_POST['Merksepatu'];
    $hargasepatu = $_POST['hargasepatu'];
    $ukuransepatu = $_POST['ukuransepatu'];
    $jumlah_sepatu = $_POST['jumlah_sepatu'];

    $sql = "INSERT INTO tb_barang (kodebarang, Merksepatu, hargasepatu, ukuransepatu, jumlah_sepatu) 
            VALUES ('$kodebarang', '$Merksepatu', '$hargasepatu', '$ukuransepatu', '$jumlah_sepatu')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "New record created successfully";
        $messageClass = "success-message";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        $messageClass = "error-message";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Data Barang</title>
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
        .input-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        .input-form img {
            width: 100px; /* Sesuaikan ukuran logo sesuai kebutuhan */
            margin-bottom: 20px;
        }
        .input-form h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2575fc;
        }
        .input-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .input-form button {
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
        .input-form button:hover {
            background-color: #1e63b6;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="input-form">
        <img src="image/logo.jpg" alt="Logo" width="100">  <!-- Sesuaikan jalur file logo Anda -->
        <h2>Input Data Barang</h2>
        <form method="post">
            <input type="text" name="kodebarang" placeholder="Kode Barang" required>
            <input type="text" name="Merksepatu" placeholder="Merk sepatu" required>
            <input type="text" name="hargasepatu" placeholder="Harga sepatu" required>
            <input type="text" name="ukuransepatu" placeholder="Ukuran sepatu" required>
            <input type="number" name="jumlah_sepatu" placeholder="Jumlah sepatu" required>
            <button type="submit">Submit</button>
            <?php 
            if(isset($message)) { 
                echo "<div class='message $messageClass'>$message</div>"; 
            } 
            ?>
        </form>
    </div>
</body>
</html>
