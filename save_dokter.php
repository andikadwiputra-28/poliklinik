<?php
include "koneksi.php";

// Ambil Data yang Dikirim dari Form (gunakan nama input dari form)
$nama = isset($_POST['nama_dokter']) ? $_POST['nama_dokter'] : '';
$alamat = isset($_POST['alamat_dokter']) ? $_POST['alamat_dokter'] : '';
$nohp = isset($_POST['nohp_dokter']) ? $_POST['nohp_dokter'] : '';
$keterangan = isset($_POST['keterangan_dokter']) ? $_POST['keterangan_dokter'] : '';
$id_poli = isset($_POST['id_poli']) ? $_POST['id_poli'] : '';
$biaya_periksa = isset($_POST['biaya_periksa']) ? $_POST['biaya_periksa'] : 0;

/*
UPLOAD FOTO
*/

// Folder penyimpanan
$folder = "foto/";

// Buat folder jika belum ada
if(!file_exists($folder))
{
    mkdir($folder,0777,true);
}

// Ambil nama file
$nama_file = $_FILES['foto_dokter']['name'];

// File sementara
$tmp_file = $_FILES['foto_dokter']['tmp_name'];

// Ambil ekstensi
$ext = pathinfo($nama_file, PATHINFO_EXTENSION);

// Buat nama baru agar tidak sama
$nama_baru = time()."_".rand(100,999).".".$ext;

// Lokasi simpan
$path_simpan = $folder.$nama_baru;

if(!empty($tmp_file))
{
    if(move_uploaded_file($tmp_file, $path_simpan))
    {
        $nama_file = $nama_baru;
    }
}

// Simpan ke tabel dokter (asumsi tabel bernama 'dokter' dengan kolom sesuai)
$query = "INSERT INTO dokter (nama_dokter, alamat_dokter, nohp_dokter, keterangan_dokter, id_poli, foto_dokter, biaya_periksa) VALUES('".
	mysqli_real_escape_string($connect, $nama) ."','".
	mysqli_real_escape_string($connect, $alamat) ."','".
	mysqli_real_escape_string($connect, $nohp) ."','".
	mysqli_real_escape_string($connect, $keterangan) ."','".
	mysqli_real_escape_string($connect, $id_poli) ."','".
	mysqli_real_escape_string($connect, $nama_file) ."','".
	mysqli_real_escape_string($connect, $biaya_periksa) ."')";

$sql = mysqli_query($connect, $query);

if($sql){
	header("Location: manage_dokter.php?status=sukses");
} else {
	echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
	echo "<br><strong>MySQL error:</strong> " . mysqli_error($connect);
	echo "<br><strong>Query:</strong> " . htmlspecialchars($query);
	echo "<br><strong>Upload info:</strong> <pre>" . htmlspecialchars(print_r(
		$_FILES, true)) . "</pre>";
	echo "<br><a href='tambah_dokter.php'>Kembali Ke Form</a>";
}
?>