<!DOCTYPE html>
<html>
<head>
	<title>Daftar Periksa</title>
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
		<p class="title">POLY</p>
		<p class="define">Clinic Universitas Dian Nuswantoro</p>
	</div>
	<div class="top-right">
		<p class="page-title">
			<p>
				<b>Halaman Pasien</b>
				<br>
				Halo : <b><?php echo $_SESSION['username']; ?></b>
				<br>
				Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.
			</p>
		</p>
		<div class="logout-button">
			<a href="logout.php"><b>Logout</b></a>
		</div>
	</div>
	<div class="horizontal-menu">
		<img src="./assets/logo-udinus.png" alt="profile">
		<div class="nama">
			<h2><?php echo $_SESSION['username']; ?></h2>
			<h6><?php echo $_SESSION['level']; ?></h6>
		</div>
		<ul>
			<li><a href="halaman_pasien.php">Home</a></li>
			<li><a href="manage_pasien.php">Manage Pasien</a></li>
			<li><a href="daftar_periksa.php">Daftar Periksa</a></li>
			<li><a href="manage_daftar.php">Daftar Antrian</a></li>
		</ul>
	</div>

	<div style="margin-top:100px;margin-left:250px">
		<h4>Daftar Periksa Anda</h4>
		<table width="1027" style="padding: 15px;">
			<tr style="background-color: #04AA6D; color: white;">
				<th width="8%">Id Daftar</th>
				<th width="8%">Id Pasien</th>
				<th width="8%">Id Dokter</th>
				<th width="15%">Tanggal Periksa</th>
				<th width="12%">Nomor Antrian</th>
				<th width="12%">Status Periksa</th>
				<th width="17%">Waktu Daftar</th>
			</tr>
			<?php
				include "koneksi.php";

				$username = $_SESSION['username'];
				$cariPasien = mysqli_query($connect, "SELECT id_pasien FROM pasien WHERE nama_pasien='$username'");
				$pasien = mysqli_fetch_array($cariPasien);
				$id_pasien = $pasien ? $pasien['id_pasien'] : null;

				if ($id_pasien) {
					$query = mysqli_query($connect, "SELECT * FROM daftar WHERE id_pasien='$id_pasien' ORDER BY waktu_daftar DESC");
					while ($data = mysqli_fetch_array($query)) {
						?>
						<tr>
							<td><?php echo $data['id_daftar']; ?></td>
							<td><?php echo $data['id_pasien']; ?></td>
							<td><?php echo $data['id_dokter']; ?></td>
							<td><?php echo $data['tanggal_periksa']; ?></td>
							<td><?php echo $data['nomor_antrian']; ?></td>
							<td><?php echo $data['status_periksa']; ?></td>
							<td><?php echo $data['waktu_daftar']; ?></td>
						</tr>
						<?php
					}
				} else {
					?>
					<tr>
						<td colspan="7">Data pasien tidak ditemukan.</td>
					</tr>
					<?php
				}
			?>
		</table>
	</div>
</body>
</html>
