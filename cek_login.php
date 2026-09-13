<?php 
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($connect,"select * from user where username='$username' and password='$password'");

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

	$data = mysqli_fetch_assoc($login);

	// cek jika user login sebagai admin
	if($data['level']=="admin"){

		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		// alihkan ke halaman dashboard admin
		header("location:halaman_admin.php");

	// cek jika user login sebagai dokter
	}else if($data['level']=="dokter"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "dokter";
		// alihkan ke halaman dashboard dokter
		header("location:halaman_dokter.php");

	// cek jika user login sebagai pasien	
	}else if($data['level']=="pasien"){
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "pasien";
		// alihkan ke halaman dashboard pasien
		header("location:halaman_pasien.php");	

	}else{

		// alihkan ke halaman login kembali
		header("location:index.php?pesan=gagal");
	}

	
}else{
	header("location:index.php?pesan=gagal");
}


?>
