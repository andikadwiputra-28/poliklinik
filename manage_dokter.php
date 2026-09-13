<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Dokter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_sheet.css">
</head>

<body>
    <div class="top-left">
        <img src="./assets/logo-udinus.png" alt="logo-udinus">
        <p class="title">
            POLIKLINIK
        </p>
        <p class="define">
            Clinic Universitas Dian Nuswantoro
        </p>

    </div>
    <div class="horizontal-menu">
        <img src="./assets/logo-udinus.png" alt="profile">
        <ul>
            <li><a href="halaman_dokter.php">Home</a></li>
            <li><a href="tambah_dokter.php">Tambah Dokter</a></li>
            <li><a href="manage_user.php">Manage User</a></li>
        </ul>
    </div>

    <div style="margin-top:100px;margin-left:250px">
        <h4>Manage Dokter</h4>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses') { ?>
            <p style="color:green;"><strong>Data dokter berhasil ditambahkan dan langsung tampil di tabel.</strong></p>
        <?php } ?>
        <table width="900" border="1" cellpadding="8" style="border-collapse:collapse;">
            <tr style="background:#04AA6D;color:#fff;">
                <th>Id Dokter</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Keterangan</th>
                <th>Poli</th>
                <th>Foto</th>
                <th>Action</th>
            </tr>
            <?php
            $nomor = 1;
            $q = mysqli_query($connect, "SELECT d.*, p.nama_poli AS poli_name FROM dokter d LEFT JOIN poli p ON d.id_poli = p.id_poli ORDER BY d.id_dokter ASC");
            if (!$q) {
                echo '<tr><td colspan="8">Query error: ' . htmlspecialchars(mysqli_error($connect)) . '</td></tr>';
            } else {
                while ($data = mysqli_fetch_assoc($q)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($nomor++) . '</td>';
                    echo '<td>' . htmlspecialchars($data['nama_dokter']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['alamat_dokter']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['nohp_dokter']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['keterangan_dokter']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['poli_name']) . '</td>';
                    if (!empty($data['foto_dokter']) && file_exists('foto/' . $data['foto_dokter'])) {
                        echo '<td><img src="foto/' . htmlspecialchars($data['foto_dokter']) . '" width="50" height="50"></td>';
                    } else {
                        echo '<td>-</td>';
                    }
                    echo '<td><a href="edit_dokter.php?id_dokter=' . $data['id_dokter'] . '">Edit</a> | <a href="hapus_dokter.php?id_dokter=' . $data['id_dokter'] . '" onclick="return confirm(\'Hapus dokter ini?\')">Hapus</a></td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </div>
</body>

</html>