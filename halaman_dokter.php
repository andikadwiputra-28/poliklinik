<!DOCTYPE html>
<html>

<head>
	<title>Halaman Dokter</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="icon" type="image/png" href="assets/logo-udinus.png">
</head>

<body>
	<?php
	session_start();

	// cek apakah yang mengakses halaman ini sudah login
	if ($_SESSION['level'] == "") {
		header("location:index.php?pesan=gagal");
	}

	?>
	<div class="top-left">
		<img src="./assets/logo-udinus.png" alt="logo-udinus">
		<p class="title">
			POLIKLINIK
		</p>
		<p class="define">
			Clinic Universitas Dian Nuswantoro
		</p>

	</div>
	<div class="top-right">
		<p class="page-title">
		<p>
			<b>Halaman Dokter</b>
			<br>
			Halo : <b><?php echo $_SESSION['username'];
			$username = $_SESSION["username"];
			function GetNama($username)
			{
				print $username;
			}
			?></b>
			<br>
			</b> Anda telah login sebagai <b><?php echo $_SESSION['level'];
			$level = $_SESSION["level"];
			function GetLevel($level)
			{
				print $level;
			}
			?></b>.
		</p>
		</p>

		<div class="logout-button">
			<a href="logout.php">
				<b> Logout </b>
			</a>
		</div>
	</div>
	<div class="horizontal-menu">
		<img src="./assets/logo-udinus.png" alt="profile">
		<div class="nama">
			<h2><?php getNama($username) ?></h2>
			<h6><?php getLevel($level) ?></h6>
		</div>
		<ul>
			<li><a href="halaman_dokter.php">Home</a></li>
			<li><a href="perbaikan_manage_data_dokter.php">Update</a></li>
			<li><a href="manage_pemeriksaan_dokter.php">Pemeriksaan</a></li>
		</ul>
	</div>

	<div id="data-dokter" style="margin-top:100px;margin-left:250px">
		<h4>Daftar Dokter</h4>
		<table border="1" cellpadding="8" style="border-collapse:collapse;">
			<tr style="background:#04AA6D;color:#fff;">
				<th>Id</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>No HP</th>
				<th>Keterangan</th>
				<th>Poli</th>
				<th>Foto</th>
			</tr>
		</table>
	</div>
</body>

</html>