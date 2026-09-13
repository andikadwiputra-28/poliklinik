<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if($_SESSION['level']==""){
	header("location:index.php?pesan=gagal");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Poli</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="icon" type="image/png" href="assets/logo-udinus.png">
</head>
<body>
	<div class="top-left">
		<img src="./assets/logo-udinus.png" alt="logo-udinus">
		<p class="title">POLIKLINIK</p>
		<p class="define">Clinic Universitas Dian Nuswantoro</p>
	</div>
	<div class="horizontal-menu">
		<img src="./assets/logo-udinus.png" alt="profile">
		<ul>
			<li><a href="halaman_admin.php">Home</a></li>
			<li><a href="tambah_poli.php">Tambah Poli</a></li>
			<li><a href="manage_poli.php">Manage Poli</a></li>
			<li><a href="manage_dokter.php">Manage Dokter</a></li>
			<li><a href="manage_user.php">Manage User</a></li>
		</ul>
	</div>

	<div style="margin-top:100px;margin-left:250px">
		<div class="kotak_login">
			<p class="tulisan_login">Tambah Poli</p>
			<form action="save_poli.php" method="post">
				<label>Nama Poli</label>
				<input type="text" name="nama_poli" class="form_login" placeholder="Nama poli .." required>

				<label>Keterangan Poli</label>
				<input type="text" name="keterangan_poli" class="form_login" placeholder="Keterangan poli .." required>

				<input type="submit" class="tombol_login" value="SAVE">
			</form>
		</div>
	</div>
</body>
</html>
