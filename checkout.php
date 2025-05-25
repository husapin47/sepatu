<?php
session_start();
require 'conn.php';

// Ambil data keranjang dari sesi
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_harga = 0;

// Hitung total harga
foreach ($keranjang as $item) {
    $total_harga += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .checkout-button {
            margin-top: 20px;
            text-align: center;
        }

        .checkout-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Pesanan</h1>
        <form action="proses_pesanan.php" method="POST">
            <h2>Detail Pesanan</h2>
            <?php
            // Menampilkan detail barang yang ada di keranjang
            if (!empty($keranjang)) {
                echo "<table>";
                echo "<tr><th>Nama</th><th>Harga</th><th>Jumlah</th></tr>";
                foreach ($keranjang as $item) {
                    echo "<tr>";
                    echo "<td>".$item['nama']."</td>";
                    echo "<td>".$item['harga']."</td>";
                    echo "<td>".$item['jumlah']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Keranjang Anda kosong.</p>";
            }
            ?>
            <h2>Total Harga</h2>
            <p id="total_harga"><?php echo $total_harga; ?></p>
            <input type="hidden" id="base_total_harga" value="<?php echo $total_harga; ?>">

            <h2>Metode Pembayaran</h2>
            <select name="metode_pembayaran">
                <option value="transfer_bank">Transfer Admin Toko</option>
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="Gopay">Gopay</option>
            </select>

            <h2>Metode Pengiriman</h2>
            <select name="metode_pengiriman" onchange="updateTotalHarga(this.value)">
                <option value="regular">Reguler - Rp 10,000</option>
                <option value="express">Express - Rp 20,000</option>
                <option value="same_day">Same Day Delivery - Rp 30,000</option>
            </select>

            <h2>Alamat Pengiriman Untuk Customer</h2>
            <label for="province">Provinsi:</label>
            <select name="province" id="province" required onchange="updateCities(this.value)">
                <option value="" disabled selected>Pilih Provinsi</option>
                <option value="Aceh">Aceh</option>
                <option value="Bali">Bali</option>
                <option value="Banten">Banten</option>
                <option value="Bengkulu">Bengkulu</option>
                <option value="Gorontalo">Gorontalo</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Jambi">Jambi</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="Jawa Timur">Jawa Timur</option>
                <option value="Kalimantan Barat">Kalimantan Barat</option>
                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                <option value="Kalimantan Timur">Kalimantan Timur</option>
                <option value="Kalimantan Utara">Kalimantan Utara</option>
                <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                <option value="Kepulauan Riau">Kepulauan Riau</option>
                <option value="Lampung">Lampung</option>
                <option value="Maluku">Maluku</option>
                <option value="Maluku Utara">Maluku Utara</option>
                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                <option value="Papua">Papua</option>
                <option value="Papua Barat">Papua Barat</option>
                <option value="Riau">Riau</option>
                <option value="Sulawesi Barat">Sulawesi Barat</option>
                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                <option value="Sulawesi Utara">Sulawesi Utara</option>
                <option value="Sumatera Barat">Sumatera Barat</option>
                <option value="Sumatera Selatan">Sumatera Selatan</option>
                <option value="Sumatera Utara">Sumatera Utara</option>
                <option value="Yogyakarta">Yogyakarta</option>
                <!-- Add more provinces as needed -->
            </select>
            <br>
            <label for="city">Kota:</label>
            <select name="city" id="city" required>
                <option value="" disabled selected>Pilih Kota</option>
                <!-- Cities will be populated based on the selected province -->
            </select>
            <br>
            <textarea name="alamat_pengiriman" rows="4" cols="50" required placeholder="Masukkan alamat pengiriman"></textarea>

            <div class="checkout-button">
                <button type="submit" name="submit">Submit Pesanan</button>
            </div>
        </form>
    </div>
    <script>
        const citiesByProvince = {
            'Aceh': ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Meulaboh', 'Sabang', 'Subulussalam'],
            'Bali': ['Denpasar'],
            'Banten': ['Cilegon', 'Serang', 'Tangerang Selatan', 'Tangerang'],
            'Bengkulu': ['Bengkulu'],
            'Gorontalo': ['Gorontalo'],
            'Jakarta': ['Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara'],
            'Jambi': ['Jambi'],
            'Jawa Barat': ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya'],
            'Jawa Tengah': ['Magelang', 'Pekalongan', 'Salatiga', 'Semarang', 'Surakarta', 'Tegal'],
            'Jawa Timur': ['Batu', 'Blitar', 'Kediri', 'Madiun', 'Malang', 'Mojokerto', 'Pasuruan', 'Probolinggo', 'Surabaya'],
            'Kalimantan Barat': ['Pontianak', 'Singkawang'],
            'Kalimantan Selatan': ['Banjarbaru', 'Banjarmasin'],
            'Kalimantan Tengah': ['Palangka Raya'],
            'Kalimantan Timur': ['Balikpapan', 'Bontang', 'Samarinda'],
            'Kalimantan Utara': ['Tarakan'],
            'Kepulauan Bangka Belitung': ['Pangkal Pinang'],
            'Kepulauan Riau': ['Batam', 'Tanjung Pinang'],
            'Lampung': ['Bandar Lampung', 'Metro'],
            'Maluku': ['Ambon', 'Tual'],
            'Maluku Utara': ['Ternate', 'Tidore Kepulauan'],
            'Nusa Tenggara Barat': ['Bima', 'Mataram'],
            'Nusa Tenggara Timur': ['Kupang'],
            'Papua': ['Jayapura'],
            'Papua Barat': ['Manokwari'],
            'Riau': ['Dumai', 'Pekanbaru'],
            'Sulawesi Barat': ['Mamuju'],
            'Sulawesi Selatan': ['Makassar', 'Palopo', 'Parepare'],
            'Sulawesi Tengah': ['Palu'],
            'Sulawesi Tenggara': ['Bau-Bau', 'Kendari'],
            'Sulawesi Utara': ['Bitung', 'Kotamobagu', 'Manado', 'Tomohon'],
            'Sumatera Barat': ['Bukittinggi', 'Padang', 'Padangpanjang', 'Pariaman', 'Payakumbuh', 'Sawahlunto', 'Solok'],
            'Sumatera Selatan': ['Lubuklinggau', 'Pagar Alam', 'Palembang', 'Prabumulih'],
            'Sumatera Utara': ['Binjai', 'Medan', 'Padang Sidempuan', 'Pematangsiantar', 'Sibolga', 'Tanjungbalai', 'Tebingtinggi'],
            'Yogyakarta': ['Yogyakarta']
            // Add more provinces and their cities as needed
        };

        function updateCities(province) {
            const citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota</option>';

            if (province in citiesByProvince) {
                citiesByProvince[province].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            }
        }

        function updateTotalHarga(method) {
            let baseTotal = parseInt(document.getElementById('base_total_harga').value);
            let shippingCost = 0;

            if (method === 'regular') {
                shippingCost = 10000;
            } else if (method === 'express') {
                shippingCost = 20000;
            } else if (method === 'same_day') {
                shippingCost = 30000;
            }

            let totalHarga = baseTotal + shippingCost;
            document.getElementById('total_harga').innerText = totalHarga;
        }
    </script>
</body>
</html>
