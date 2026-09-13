<?php
	// Load file koneksi.php
	include "koneksi.php";
	
	// Ambil Data yang Dikirim dari Form
	$id_daftar = $_POST['id_daftar'];
	$id_pasien = $_POST['id_pasien'];
	$id_dokter = $_POST['id_dokter'];
	$tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
	$tekanan_darah = $_POST['tekanan_darah'];
	$berat_badan = $_POST['berat_badan'];
	$tinggi_badan = $_POST['tinggi_badan'];
	$tanggal = date('Y-m-d H:i:s');
			
	$id_rekam_medis = mysqli_insert_id($connect);
	$query = "INSERT INTO rekam_medis VALUES('".$id_rekam_medis."', '".$id_daftar."', '".$id_pasien."', '".$id_dokter."', 
			 '".$tanggal."', '', '', '', '".$tekanan_darah."', '".$berat_badan."', '".$tinggi_badan."')";
	$sql = mysqli_query($connect,$query);
	
	
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$level = $_POST['level'];
	
	if($sql){ // Cek jika proses simpan ke database sukses atau tidak
	// Jika Sukses, Lakukan :
	header("location: manage_pemeriksaan_pasien.php"); // Redirect ke halaman index.php
	}else{
	// Jika Gagal, Lakukan :
	echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
	echo "<br><a href='manage_pemeriksaan_pasien.php'>Kembali Ke Form</a>";
	}
	?>
