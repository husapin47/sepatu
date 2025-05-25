<?php
session_start();
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
     <!-- Tombol Exit -->
     <a href="dashboard_admin.php" class="exit-button">X</a>
    <title>Daftar Sepatu</title>
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
        .header-content {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        h1 {
            color: #fff;
            margin: 0;
        }
        .button-container {
            margin-left: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #6a11cb;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .add-button {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .add-button:hover {
            background: #218838;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-content">
        <h1>Daftar Sepatu</h1>
        <div class="button-container">
            <a href="form_sepatu.php" class="add-button">Tambah Sepatu</a>
        </div>
    </div>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Ukuran</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sepatu as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['id_sepatu']); ?></td>
                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                        <td>Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($item['ukuran']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" width="50"></td>
                        <td>
                            <a href="form_sepatu.php?id_sepatu=<?php echo $item['id_sepatu']; ?>">Edit</a> |
                            <a href="delete_sepatu.php?id_sepatu=<?php echo $item['id_sepatu']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus sepatu ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
