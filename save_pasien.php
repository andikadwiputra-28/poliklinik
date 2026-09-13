<?php
	// Load file koneksi.php
	include "koneksi.php";
	
	// Ambil Data yang Dikirim dari Form
	$nama_pasien = $_POST['nama_pasien'];
	$alamat_pasien = $_POST['alamat_pasien'];
	$noktp_pasien = $_POST['noktp_pasien'];
	$nohp_pasien = $_POST['nohp_pasien'];
	$norm_pasien = $_POST['norm_pasien'];
	// Proses simpan ke Database (menggunakan nama kolom secara eksplisit)
	$query = "INSERT INTO pasien (nama_pasien, alamat_pasien, noktp_pasien, nohp_pasien, norm_pasien) 
	          VALUES ('".$nama_pasien."', '".$alamat_pasien."', '".$noktp_pasien."', '".$nohp_pasien."', '".$norm_pasien."')";
	$sql = mysqli_query($connect,$query); // Eksekusi/ Jalankan query dari variabel $query
	
	// Proses simpan ke Database
	$level="pasien";
	$query1 = "INSERT INTO user VALUES('', '".$nama_pasien."', '".$nama_pasien."', '".$nama_pasien."', '".$level."')";
	$sql1 = mysqli_query($connect,$query1); // Eksekusi/ Jalankan query dari variabel $query
	
	if($sql){ // Cek jika proses simpan ke database sukses atau tidak
	// Jika Sukses, Lakukan :
	header("location: manage_pasien.php"); // Redirect ke halaman index.php
	}else{
	// Jika Gagal, Lakukan :
	echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
	echo "<br><a href='manage_pasien.php'>Kembali Ke Form</a>";
	}
	?>