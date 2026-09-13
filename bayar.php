<?php
session_start();
include "koneksi.php";

// 1. Cek apakah user sudah login
if ($_SESSION['level'] == "") {
    header("location:index.php?pesan=gagal");
    exit();
}

// 2. Ambil parameter id_daftar dari URL (GET) atau Form (POST)
$id_daftar = isset($_GET['id_daftar']) ? mysqli_real_escape_string($connect, $_GET['id_daftar']) : '';
if (empty($id_daftar)) {
    $id_daftar = isset($_POST['id_daftar']) ? mysqli_real_escape_string($connect, $_POST['id_daftar']) : '';
}

if (empty($id_daftar)) {
    die("Error: ID Daftar tidak ditentukan.");
}

// 3. Ambil data registrasi periksa, pasien, dan dokter
$query = mysqli_query($connect, "
    SELECT 
        daftar.id_daftar,
        daftar.tanggal_periksa,
        daftar.id_pasien,
        daftar.id_dokter,
        pasien.nama_pasien,
        COALESCE(NULLIF(TRIM(pasien.norm_pasien), ''), pasien.id_pasien) AS no_rekam_medis,
        dokter.nama_dokter,
        dokter.biaya_periksa,
        rekam_medis.id_rekam_medis
    FROM daftar
    JOIN pasien ON daftar.id_pasien = pasien.id_pasien
    JOIN dokter ON daftar.id_dokter = dokter.id_dokter
    LEFT JOIN rekam_medis ON rekam_medis.id_daftar = daftar.id_daftar
    WHERE daftar.id_daftar = '$id_daftar'
");

if (!$query) {
    die("Query error: " . mysqli_error($connect));
}

$data = mysqli_fetch_array($query);
if (!$data) {
    die("Error: Data pemeriksaan tidak ditemukan.");
}

$id_rekam_medis = $data['id_rekam_medis'];

// 4. Ambil resep obat untuk pemeriksaan ini
if (!empty($id_rekam_medis)) {
    $query_obat = mysqli_query($connect, "
        SELECT 
            detail_rekam_medis.*, 
            obat.nama_obat, 
            obat.harga_obat 
        FROM detail_rekam_medis
        JOIN obat ON detail_rekam_medis.id_obat = obat.id_obat
        WHERE detail_rekam_medis.id_rekam_medis = '$id_rekam_medis'
    ");
} else {
    $query_obat = false;
}

// 5. Proses Simpan Pembayaran (saat tombol Bayar Sekarang diklik)
if (isset($_POST['bayar_sekarang'])) {
    $biaya_periksa_input = (float) $_POST['biaya_periksa'];
    $total_obat_input = (float) $_POST['total_obat'];
    $total_bayar_input = (float) $_POST['total_bayar'];
    $metode_bayar = mysqli_real_escape_string($connect, $_POST['metode_bayar']);
    $tanggal_bayar = date('Y-m-d H:i:s');

    // Tentukan nilai id_rekam_medis (bisa integer atau NULL)
    $id_rekam_medis_val = !empty($id_rekam_medis) ? "'$id_rekam_medis'" : "NULL";

    // Masukkan data ke tabel bayar sesuai struktur database user
    $insert_pembayaran = mysqli_query($connect, "
        INSERT INTO bayar (id_rekam_medis, id_daftar, tanggal_bayar, biaya_pemeriksaan, biaya_obat, total_bayar, metode_bayar, status_bayar)
        VALUES ($id_rekam_medis_val, '$id_daftar', '$tanggal_bayar', '$biaya_periksa_input', '$total_obat_input', '$total_bayar_input', '$metode_bayar', 'Lunas')
    ");

    if ($insert_pembayaran) {
        // Update status_periksa di tabel daftar menjadi 'selesai'
        mysqli_query($connect, "UPDATE daftar SET status_periksa = 'selesai' WHERE id_daftar = '$id_daftar'");

        echo "<script>alert('Pembayaran berhasil disimpan!'); window.location='manage_pemeriksaan_dokter.php';</script>";
        exit();
    } else {
        $error = "Gagal menyimpan pembayaran: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Halaman Pembayaran</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_sheet.css">
    <link rel="stylesheet" href="style_periksa.css">
    <link rel="icon" type="image/png" href="assets/logo-udinus.png">
    <style>
        /* Desain Tambahan Khusus Halaman Pembayaran */
        .info-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 12px;
            margin-bottom: 25px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .info-label {
            font-weight: 600;
            color: #000000ff;
            display: flex;
            align-items: center;
        }

        .info-value {
            background-color: #5dbcdaff;
            /* Sesuai warna hijau di mockup */
            color: #000000ff;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-family: 'Courier New', Courier, monospace;
            width: fit-content;
            /* Mencegah background melebar penuh */
        }

        .table-payment {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-payment th {
            background-color: #ffa000;
            /* Warna oranye/kuning di mockup */
            color: black;
            font-weight: bold;
            padding: 12px;
            text-align: left;
            border: 1px solid #e0e0e0;
        }

        .table-payment td {
            padding: 12px;
            border: 1px solid #e0e0e0;
        }

        .bg-green {
            background-color: #c5e1a5;
            /* Warna hijau muda di mockup */
            color: #000000ff;
            font-weight: bold;
        }

        .select-payment {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #cbd5e0;
            background-color: #c5e1a5;
            color: #000000ff;
            font-weight: bold;
            width: 250px;
            cursor: pointer;
        }

        .btn-pay-now {
            background-color: #082c63ff;
            color: white;
            border: none;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }

        .btn-pay-now:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>

<body>
    <div class="top-left">
        <img src="./assets/logo-udinus.png" alt="logo-udinus">
        <p class="title">POLY</p>
        <p class="define">Clinic Universitas Dian Nuswantoro</p>
    </div>
    <div class="top-right">
        <p class="page-title">
        <p>
            <b>Halaman Pembayaran</b>
            <br>
            Halo: <b><?php echo $_SESSION['username']; ?></b>
            <br>
            Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.
        </p>
        </p>
        <div class="logout-button">
            <a href="logout.php"><b>Logout</b></a>
        </div>
    </div>
    <div class="horizontal-menu">
        <img src="./assets/logo-udinus.png" alt="profile">
        <div class="nama">
            <h2><?php echo $_SESSION['username']; ?></h2>
            <h6><?php echo $_SESSION['level']; ?></h6>
        </div>
        <ul>
            <li><a href="halaman_admin.php">Home</a></li>
            <li><a href="manage_dokter.php">Dokter</a></li>
            <li><a href="manage_user.php">User</a></li>
            <li><a href="manage_pasien.php">Pasien</a></li>
            <li><a href="manage_pemeriksaan_pasien.php">Periksa</a></li>
        </ul>
    </div>

    <!-- Menyesuaikan margin agar pas dengan sidebar (15%) dan topbar (10%) -->
    <div
        style="margin-top: 140px; margin-left: calc(15% + 40px); padding: 20px; background-color: #ffffff; border-radius: 12px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05); margin-right: 40px; margin-bottom: 40px;">
        <h2 style="margin-bottom: 20px; color: #0C0B8B; border-bottom: 2px dashed #eaedeeff; padding-bottom: 10px;">
            Transaksi Pembayaran Pasien</h2>

        <?php if (isset($error)): ?>
            <div style="background-color: #fed7d7; color: #c53030; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="bayar.php" method="POST">
            <input type="hidden" name="id_daftar" value="<?php echo $data['id_daftar']; ?>">
            <input type="hidden" name="id_rekam_medis" value="<?php echo $id_rekam_medis; ?>">

            <!-- BAGIAN IDENTITAS PASIEN -->
            <div class="info-grid">
                <div class="info-label">No. Rekam Medis</div>
                <div class="info-value"><?php echo htmlspecialchars($data['no_rekam_medis'] ?? '-'); ?></div>
                <div class="info-label">Nama Pasien</div>
                <div class="info-value"><?php echo htmlspecialchars($data['nama_pasien']); ?></div>

                <div class="info-label">Dokter</div>
                <div class="info-value"><?php echo htmlspecialchars($data['nama_dokter']); ?></div>

                <div class="info-label">Tanggal</div>
                <div class="info-value"><?php echo date('d-m-Y', strtotime($data['tanggal_periksa'])); ?></div>
            </div>

            <!-- BAGIAN DAFTAR OBAT -->
            <h3 style="margin-bottom: 10px;">Daftar Obat</h3>

            <table class="table-payment">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_obat = 0;
                    if ($query_obat && mysqli_num_rows($query_obat) > 0):
                        while ($o = mysqli_fetch_array($query_obat)):
                            $subtotal = $o['harga_obat'] * $o['jumlah'];
                            $total_obat += $subtotal;
                            ?>
                            <tr>
                                <td class="bg-green"><?php echo htmlspecialchars($o['nama_obat']); ?></td>
                                <td class="bg-green">Rp <?php echo number_format($o['harga_obat'], 0, ',', '.'); ?></td>
                                <td class="bg-green"><?php echo htmlspecialchars($o['jumlah']); ?></td>
                                <td class="bg-green">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                            <?php
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="4" style="text-align:center; color:#888; font-style:italic; padding:12px;"
                                class="bg-green">Tidak ada obat yang diresepkan
                                <?php if (empty($id_rekam_medis)): ?>
                                    (rekam medis belum dibuat oleh dokter)
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php
                    $biaya_periksa = (int) ($data['biaya_periksa'] ?? 0);
                    $total_bayar = $biaya_periksa + $total_obat;
                    ?>

                    <!-- Biaya Pemeriksaan -->
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: 500;">Biaya Pemeriksaan</td>
                        <td class="bg-green">Rp <?php echo number_format($biaya_periksa, 0, ',', '.'); ?></td>
                    </tr>
                    <!-- Total Obat -->
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: 500;">Total Obat</td>
                        <td class="bg-green">Rp <?php echo number_format($total_obat, 0, ',', '.'); ?></td>
                    </tr>
                    <!-- Total Bayar -->
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold; color: #1b5e20;">Total Bayar</td>
                        <td class="bg-green" style="font-size: 16px;">Rp
                            <?php echo number_format($total_bayar, 0, ',', '.'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Hidden inputs to submit values -->
            <input type="hidden" name="biaya_periksa" value="<?php echo $biaya_periksa; ?>">
            <input type="hidden" name="total_obat" value="<?php echo $total_obat; ?>">
            <input type="hidden" name="total_bayar" value="<?php echo $total_bayar; ?>">

            <!-- METODE BAYAR -->
            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 15px;">
                <label style="margin-bottom: 0;">Metode Bayar:</label>
                <select name="metode_bayar" class="select-payment" required>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="QRIS">QRIS</option>
                    <option value="BPJS">BPJS</option>
                </select>
            </div>

            <!-- BUTTON BAYAR SEKARANG -->
            <div style="margin-top: 15px;">
                <button type="submit" name="bayar_sekarang" class="btn-pay-now">Bayar Sekarang</button>
            </div>
        </form>
    </div>
</body>

</html>