<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'pasien') {
	echo "<script>alert('Halaman daftar periksa khusus pasien');window.location='halaman_pasien.php';</script>";
	exit;
}

// Ambil username pasien dari session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
if (empty($username)) {
	echo "<script>alert('Silakan login terlebih dahulu');window.location='index.php';</script>";
	exit;
}

// Cari id pasien
$escapedUsername = mysqli_real_escape_string($connect, $username);
$cariPasien = mysqli_query($connect, "SELECT * FROM pasien WHERE username_pasien='" . $escapedUsername . "' OR nama_pasien='" . $escapedUsername . "' LIMIT 1");
$pasien = mysqli_fetch_array($cariPasien);
if (!$pasien) {
	echo "<script>alert('Data pasien tidak ditemukan');window.location='manage_daftar.php';</script>";
	exit;
}
$id_pasien = $pasien['id_pasien'];

// Dokter dipilih
if (!isset($_GET['id_dokter'])) {
	echo "<script>alert('Dokter tidak dipilih');window.location='manage_daftar.php';</script>";
	exit;
}
$id_dokter = mysqli_real_escape_string($connect, $_GET['id_dokter']);
$tanggal = date('Y-m-d');

// Cek jumlah antrian
$cek = mysqli_query($connect, "SELECT COUNT(*) AS jumlah FROM daftar WHERE id_dokter='$id_dokter' AND tanggal_periksa='$tanggal'");
$data = mysqli_fetch_array($cek);
$jumlah = isset($data['jumlah']) ? (int)$data['jumlah'] : 0;

// Maksimal 10
if ($jumlah >= 10) {
	echo "<script>alert('Maaf antrian penuh');window.location='manage_daftar.php';</script>";
	exit;
}

// Nomor berikutnya
$nomor = $jumlah + 1;

// Simpan
$sql = "INSERT INTO daftar (id_pasien, id_dokter, tanggal_periksa, nomor_antrian) VALUES ('$id_pasien', '$id_dokter', '$tanggal', '$nomor')";
mysqli_query($connect, $sql);

echo "<script>alert('Berhasil daftar. Nomor antrian : $nomor');window.location='manage_daftar.php';</script>";