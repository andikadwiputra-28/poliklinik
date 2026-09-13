<?php
// -------------------------------------------------------
//  update_pasien.php
//  Memperbarui data pasien
// -------------------------------------------------------

// Tampilkan semua error PHP (bantu debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Aktifkan report MySQLi error
// Aktifkan report MySQLi error (optional, removed for compatibility)

// -----------------------------------------------------------------
// 1. Sertakan file koneksi
// -----------------------------------------------------------------
include("koneksi.php");   // file ini harus menghasilkan var $connect

// -----------------------------------------------------------------
// 2. Pastikan semua data POST dikirim
// -----------------------------------------------------------------
$required = [
    'id_pasien',
    'nama_pasien',
    'alamat_pasien',
    'noktp_pasien',
    'nohp_pasien',
    'norm_pasien'
];

foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        die("Error: field <b>{$field}</b> tidak ada atau kosong.");
    }
}

// -----------------------------------------------------------------
// 3. Ambil nilai dari POST
// -----------------------------------------------------------------
$id_pasien = $_POST['id_pasien'];
$nama_pasien = $_POST['nama_pasien'];
$alamat_pasien = $_POST['alamat_pasien'];
$noktp_pasien = $_POST['noktp_pasien'];
$nohp_pasien = $_POST['nohp_pasien'];
$norm_pasien = $_POST['norm_pasien'];

// -----------------------------------------------------------------
// 4. Persiapkan statement (prepared statement) – menghindari SQL‑Injection
// -----------------------------------------------------------------
$stmt = mysqli_prepare(
    $connect,
    "UPDATE pasien SET
        nama_pasien   = ?,
        alamat_pasien = ?,
        noktp_pasien  = ?,
        nohp_pasien   = ?,
        norm_pasien   = ?
     WHERE id_pasien = ?"
);
if (!$stmt) {
    die("Prepare gagal: " . mysqli_error($connect));
}

// ikat parameter – tipe: s = string, i = integer
mysqli_stmt_bind_param(
    $stmt,
    "sssssi",
    $nama_pasien,
    $alamat_pasien,
    $noktp_pasien,
    $nohp_pasien,
    $norm_pasien,
    $id_pasien
);

// -----------------------------------------------------------------
// 5. Jalankan statement
// -----------------------------------------------------------------
if (!mysqli_stmt_execute($stmt)) {
    die("Eksekusi gagal: " . mysqli_stmt_error($stmt));
}

// Tutup statement
mysqli_stmt_close($stmt);

// -----------------------------------------------------------------
// 6. Arahkan kembali ke halaman daftar pasien
// -----------------------------------------------------------------
header("Location: manage_pasien.php");
exit();
?>