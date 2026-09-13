<?php 
// Database connection
$host = "localhost"; // Host name
$username = "root"; // Username
$password = ""; // Password (if any)
$database = "multi_user"; // Database name
$connect = mysqli_connect($host, $username, $password, $database);
if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Periksa dan tambahkan kolom norm_pasien jika belum ada di database
$cekPasienTable = mysqli_query($connect, "SHOW TABLES LIKE 'pasien'");
if ($cekPasienTable && mysqli_num_rows($cekPasienTable) > 0) {
    $cekKolomNorm = mysqli_query($connect, "SHOW COLUMNS FROM pasien LIKE 'norm_pasien'");
    if ($cekKolomNorm && mysqli_num_rows($cekKolomNorm) === 0) {
        mysqli_query($connect, "ALTER TABLE pasien ADD norm_pasien VARCHAR(255) NULL");
    }
}
?>