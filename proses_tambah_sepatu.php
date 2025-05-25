<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar'];

    // Path penyimpanan gambar
    $target_dir = "image/";
    $target_file = $target_dir . basename($gambar["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file adalah gambar
    $check = getimagesize($gambar["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($gambar["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Perbolehkan format tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk adalah 0
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Jika semuanya baik, coba unggah file
        if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
            // Siapkan dan eksekusi statement
            $stmt = $conn->prepare("INSERT INTO tb_sepatu (nama, harga, gambar) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param("sis", $nama, $harga, $target_file);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Sepatu berhasil ditambahkan!";
                header("Location: daftar_sepatu.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $conn->close();
}
?>
