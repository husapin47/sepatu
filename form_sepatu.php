<?php
session_start();
require 'conn.php';

// Inisialisasi variabel
$id_sepatu = '';
$nama = '';
$harga = '';
$ukuran = '';
$gambar = '';

if (isset($_GET['id_sepatu'])) {
    $id_sepatu = $_GET['id_sepatu'];
    $stmt = $conn->prepare("SELECT * FROM tb_sepatu WHERE id_sepatu = ?");
    $stmt->bind_param("i", $id_sepatu);
    $stmt->execute();
    $result = $stmt->get_result();
    $sepatu = $result->fetch_assoc();
    if ($sepatu) {
        $nama = $sepatu['nama'];
        $harga = $sepatu['harga'];
        $ukuran = $sepatu['ukuran'];
        $gambar = $sepatu['gambar'];
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sepatu = $_POST['id_sepatu'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $ukuran = $_POST['ukuran'];
    $gambar = $_POST['gambar']; // Atau logika upload gambar baru

    if ($id_sepatu) {
        // Update sepatu
        $stmt = $conn->prepare("UPDATE tb_sepatu SET nama = ?, harga = ?, ukuran = ?, gambar = ? WHERE id_sepatu = ?");
        $stmt->bind_param("sdsii", $nama, $harga, $ukuran, $gambar, $id_sepatu);
    } else {
        // Insert sepatu baru
        $stmt = $conn->prepare("INSERT INTO tb_sepatu (nama, harga, ukuran, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsis", $nama, $harga, $ukuran, $gambar);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Sepatu</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $id_sepatu ? 'Edit Sepatu' : 'Tambah Sepatu'; ?></h1>
        <form method="post" action="form_sepatu.php">
            <input type="hidden" name="id_sepatu" value="<?php echo htmlspecialchars($id_sepatu); ?>">
            <label for="nama">Nama Sepatu</label>
            <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
            
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($harga); ?>" required>
            
            <label for="ukuran">Ukuran</label>
            <input type="text" name="ukuran" id="ukuran" value="<?php echo htmlspecialchars($ukuran); ?>" required>
            
            <label for="gambar">Gambar (URL)</label>
            <input type="text" name="gambar" id="gambar" value="<?php echo htmlspecialchars($gambar); ?>" required>
            
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
