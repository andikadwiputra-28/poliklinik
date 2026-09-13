<!DOCTYPE html>
<html>

<head>
	<title>Halaman Dokter</title>

	<link rel="stylesheet" href="style_sheet.css">
	<link rel="stylesheet" href="style_daftar_periksa.css">
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
	<!--
	<h1>Halaman Admin</h1>

	<p>Halo <b><?php echo $_SESSION['username']; ?></b> Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.</p>
	<a href="logout.php">LOGOUT</a>

	<br/>
	<br/>

	<a><a href="https://www.malasngoding.com/membuat-login-multi-user-level-dengan-php-dan-mysqli">Membuat Login Multi Level Dengan PHP</a> - www.malasngoding.com</a>
	-->

	<div class="top-left">
		<img src="./assets/logo-udinus.png" alt="logo-udinus">
		<p class="title">
			POLY </p>
		<p class="define">
			Clinic Universitas Dian Nuswantoro </p>
	</div>
	<div class="top-right">
		<p class="page-title">
		<p>
			<b>Halaman Pasien </b>
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
				<b> Logout </b> </a>
		</div>
	</div>
	<div class="horizontal-menu">
		<img src="./assets/logo-udinus.png" alt="profile">
		<div class="nama">
			<h2><?php getNama($username) ?></h2>
			<h6><?php getLevel($level) ?></h6>
		</div>
		<ul>
			<li><a href="halaman_admin.php">Home</a></li>
			<li><a href="manage_dokter.php">Dokter</a></li>
			<li><a href="manage_user.php">User</a></li>
			<li><a href="manage_pasien.php">Pasien</a></li>
			<li><a href="manage_pemeriksaan_pasien.php">Periksa</a></li>
		</ul>
	</div>

	<div style="margin-top:100px;margin-left:250px">
		<?php
		// session_start();
		include "koneksi.php";

		//cek login
		if ($_SESSION['level'] == "") {
			header("location:index.php?pesan=gagal");
		}

		//tanggal default hari ini
		$tanggal = date("Y-m-d");

		if (isset($_GET['tanggal'])) {
			$tanggal = $_GET['tanggal'];
		}

		//ambil data antrian
		$query = mysqli_query(
			$connect,
			"SELECT daftar.*,pasien.nama_pasien,dokter.nama_dokter,poli.nama_poli
					FROM daftar,dokter,pasien,poli
					WHERE daftar.id_pasien = pasien.id_pasien
					AND daftar.id_dokter = dokter.id_dokter
					AND dokter.id_poli = poli.id_poli
					AND daftar.tanggal_periksa = '$tanggal'
					AND daftar.status_periksa = 'menunggu'
					"
		);

		?>
		<div style="margin-top:100px;margin-left:25px">
			<h2>Daftar Antrian Pasien</h2>
		</div>
		<div class="container">
			<div class="filter">
				<form method="GET">
					Tanggal Pemeriksaan :
					<input type="date" name="tanggal" value="<?php echo $tanggal; ?>">
					<button type="submit" class="btn">Tampilkan</button>
				</form>
			</div>
			<table>
				<tr>
					<th>No</th>
					<th>No Antrian</th>
					<th>Nama Pasien</th>
					<th>Nama Dokter</th>
					<th>Poli</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
				<?php
				$no = 1;
				while ($data = mysqli_fetch_array($query)) {
					?>
					<tr>
						<td>
							<?php echo $no++; ?>
						</td>
						<td>
							<span class="nomor">
								A-
								<?php
								echo str_pad(
									$data['nomor_antrian'],
									2,
									"0",
									STR_PAD_LEFT
								);
								?>
							</span>
						</td>
						<td>
							<?php
							echo $data['nama_pasien'];
							?>
						</td>
						<td>
							<?php
							echo $data['nama_dokter'];
							?>
						</td>
						<td>
							<?php
							echo $data['nama_poli'];
							?>
						</td>
						<td>
							<?php
							echo date("d-m-Y", strtotime($data['tanggal_periksa']));
							?>
						</td>
						<td>
							<span class="status">
								<?php
								echo $data['status_periksa'];
								?>
							</span>
						</td>
						<td>
							<a href="form_pemeriksaan_admin.php?id_daftar=
							<?php echo $data['id_daftar']; ?>" class="btn">
								Periksa
							</a>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>

</body>

</html>