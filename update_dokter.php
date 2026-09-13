<?php
// include database connection file
include("koneksi.php");

// Protect from direct GET access
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_dokter'])) {
    header("Location: manage_dokter.php");
    exit;
}

// Check if form is submitted for user update, then redirect to homepage after update
$id_dokter = $_POST["id_dokter"];
$nama_dokter = isset($_POST["nama_dokter"]) ? $_POST["nama_dokter"] : "";
$alamat_dokter = isset($_POST["alamat_dokter"]) ? $_POST["alamat_dokter"] : "";
$nohp_dokter = isset($_POST["nohp_dokter"]) ? $_POST["nohp_dokter"] : "";
$id_poli = isset($_POST["id_poli"]) ? $_POST["id_poli"] : "";
$keterangan_dokter = isset($_POST["keterangan_dokter"]) ? $_POST["keterangan_dokter"] : "";
$foto_dokter_lama = isset($_POST["foto_dokter_lama"]) ? $_POST["foto_dokter_lama"] : "";
$biaya_periksa = isset($_POST["biaya_periksa"]) ? $_POST["biaya_periksa"] : 0;
$status = 0;

if (!isset($_FILES['foto_dokter']) || $_FILES['foto_dokter']['error'] == 4) {
    $nama_baru = $foto_dokter_lama;
} else {
    // Folder penyimpanan
    $folder = "foto/";

    // Buat folder jika belum ada
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // Ambil nama file
    $nama_file = $_FILES['foto_dokter']['name'];

    // File sementara
    $tmp_file = $_FILES['foto_dokter']['tmp_name'];

    // Ambil ekstensi
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);

    // Buat nama baru agar tidak sama
    $nama_baru = time() . "_" . rand(100, 999) . "." . $ext;

    $extensigambarvalid = array('png', 'jpg', 'jpeg');
    $extensigambar = explode('.', $nama_file);
    $extensi = strtolower(end($extensigambar));

    // Cek apakah ekstensi file diperbolehkan
    if (!in_array($extensi, $extensigambarvalid)) {
        echo "Maaf, hanya file dengan ekstensi PNG, JPG, atau JPEG yang diperbolehkan.";
        echo "<br><a href='edit_dokter.php?id_dokter=" . htmlspecialchars($id_dokter) . "'>Kembali Ke Form</a>";
        exit;
    }

    move_uploaded_file($tmp_file, $folder . $nama_baru); // Proses upload file ke folder tujuan
}

// update user data with escaped strings for database security
$nama_dokter_esc = mysqli_real_escape_string($connect, $nama_dokter);
$alamat_dokter_esc = mysqli_real_escape_string($connect, $alamat_dokter);
$nohp_dokter_esc = mysqli_real_escape_string($connect, $nohp_dokter);
$id_poli_esc = mysqli_real_escape_string($connect, $id_poli);
$keterangan_dokter_esc = mysqli_real_escape_string($connect, $keterangan_dokter);
$nama_baru_esc = mysqli_real_escape_string($connect, $nama_baru);
$biaya_periksa_esc = mysqli_real_escape_string($connect, $biaya_periksa);
$id_dokter_esc = mysqli_real_escape_string($connect, $id_dokter);

$query = "UPDATE dokter SET 
          nama_dokter='$nama_dokter_esc', 
          alamat_dokter='$alamat_dokter_esc', 
          nohp_dokter='$nohp_dokter_esc', 
          id_poli='$id_poli_esc', 
          keterangan_dokter='$keterangan_dokter_esc', 
          foto_dokter='$nama_baru_esc', 
          biaya_periksa='$biaya_periksa_esc' 
          WHERE id_dokter='$id_dokter_esc'";

$result = mysqli_query($connect, $query);

// Redirect to homepage to display updated user in list
header("Location: manage_dokter.php");