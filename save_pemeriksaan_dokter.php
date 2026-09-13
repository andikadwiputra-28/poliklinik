<?php
// Load file koneksi.php
include "koneksi.php";

// Ambil Data yang Dikirim dari Form
$id_rekam_medis = $_POST['id_rekam_medis'];
$id_daftar = $_POST['id_daftar'];
$id_pasien = $_POST['id_pasien'];
$id_dokter = $_POST['id_dokter'];
$tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
$keluhan = $_POST['keluhan'];
$hasil_diagnosa = $_POST['hasil_diagnosa'];
$tindakan = $_POST['tindakan'];
$tekanan_darah = $_POST['tekanan_darah'];
$berat_badan = $_POST['berat_badan'];
$tinggi_badan = $_POST['tinggi_badan'];
$id_obat = $_POST['id_obat'];
$jumlah = $_POST['jumlah'];
$aturan_pakai = $_POST['aturan_pakai'];
$tanggal = date('Y-m-d H:i:s');

// Escape inputs for database security
$id_rekam_medis = mysqli_real_escape_string($connect, $id_rekam_medis);
$id_daftar = mysqli_real_escape_string($connect, $id_daftar);
$id_pasien = mysqli_real_escape_string($connect, $id_pasien);
$id_dokter = mysqli_real_escape_string($connect, $id_dokter);
$keluhan = mysqli_real_escape_string($connect, $keluhan);
$hasil_diagnosa = mysqli_real_escape_string($connect, $hasil_diagnosa);
$tindakan = mysqli_real_escape_string($connect, $tindakan);
$tekanan_darah = mysqli_real_escape_string($connect, $tekanan_darah);
$berat_badan = mysqli_real_escape_string($connect, $berat_badan);
$tinggi_badan = mysqli_real_escape_string($connect, $tinggi_badan);

$berat_badan_val = ($berat_badan === '' || $berat_badan === null) ? "NULL" : "'$berat_badan'";
$tinggi_badan_val = ($tinggi_badan === '' || $tinggi_badan === null) ? "NULL" : "'$tinggi_badan'";

// Cek apakah data rekam medis sudah ada
$cek_rm = mysqli_query($connect, "SELECT id_rekam_medis FROM rekam_medis WHERE id_daftar = '$id_daftar'");
if ($cek_rm && mysqli_num_rows($cek_rm) > 0) {
    // Jika sudah ada, lakukan UPDATE
    $rm_row = mysqli_fetch_assoc($cek_rm);
    $id_rekam_medis = $rm_row['id_rekam_medis'];
    $update = mysqli_query(
        $connect,
        "UPDATE rekam_medis 
         SET keluhan = '$keluhan', tindakan = '$tindakan', hasil_diagnosa = '$hasil_diagnosa'
         WHERE id_rekam_medis='$id_rekam_medis'"
    );
} else {
    // Jika belum ada (misal proses pemeriksaan fisik oleh admin terlewat), lakukan INSERT
    $query_insert = "INSERT INTO rekam_medis (id_daftar, id_pasien, id_dokter, tanggal_pemeriksaan, keluhan, hasil_diagnosa, tindakan, tekanan_darah, berat_badan, `tinggi badan`) 
                     VALUES ('$id_daftar', '$id_pasien', '$id_dokter', '$tanggal', '$keluhan', '$hasil_diagnosa', '$tindakan', '$tekanan_darah', $berat_badan_val, $tinggi_badan_val)";
    $update = mysqli_query($connect, $query_insert);
    if ($update) {
        $id_rekam_medis = mysqli_insert_id($connect);
    }
}

if ($update && !empty($id_obat) && !empty($jumlah)) {

    // Kembalikan stok obat lama sebelum dihapus (hindari stok berkurang terus)
    $cek_detail = mysqli_query($connect, "SELECT id_obat, jumlah FROM detail_rekam_medis WHERE id_rekam_medis = '$id_rekam_medis'");
    while ($detail_lama = mysqli_fetch_assoc($cek_detail)) {
        mysqli_query($connect, "UPDATE obat SET stok_obat = stok_obat + '{$detail_lama['jumlah']}' WHERE id_obat = '{$detail_lama['id_obat']}'");
    }

    // Hapus detail obat lama untuk rekam medis ini (ganti dengan yang baru)
    mysqli_query($connect, "DELETE FROM detail_rekam_medis WHERE id_rekam_medis = '$id_rekam_medis'");

    // INSERT detail obat yang baru
    mysqli_query(
        $connect,
        "INSERT INTO detail_rekam_medis (id_rekam_medis, id_obat, jumlah, aturan_pakai)
         VALUES ('$id_rekam_medis', '$id_obat', '$jumlah', '$aturan_pakai')"
    );

    // Kurangi stok obat baru
    mysqli_query(
        $connect,
        "UPDATE obat SET stok_obat = stok_obat - '$jumlah' WHERE id_obat = '$id_obat'"
    );
}

// Tentukan aksi: 'bayar' atau 'save'
$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : 'save';

if ($update) {
    if ($aksi === 'bayar') {
        // Langsung redirect ke halaman bayar
        header("location: bayar.php?id_daftar=$id_daftar");
    } else {
        // Redirect ke manage setelah Save biasa
        header("location: manage_pemeriksaan_dokter.php");
    }
} else {
    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
    echo "<br><a href='manage_pemeriksaan_dokter.php'>Kembali Ke Form</a>";
}
?>