<!DOCTYPE html>
<html>

<head>
	<title>Halaman admin</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="stylesheet" href="style_periksa.css">
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
			POLY
		</p>
		<p class="define">
			Clinic Universitas Dian Nuswantoro
		</p>

	</div>
	<div class="top-right">
		<p class="page-title">
		<p>
			<b>Halaman Admin</b>
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
			<li><a href="halaman_admin.php">Home</a></li>
			<li><a href="manage_dokter.php">Dokter</a></li>
			<li><a href="manage_user.php">User</a></li>
			<li><a href="manage_pasien.php">Pasien</a></li>
			<li><a href="manage_pemeriksaan_pasien.php">Periksa</a></li>
		</ul>
	</div>

	<?php
	include "koneksi.php";
	$id_daftar = isset($_GET['id_daftar']) ? mysqli_real_escape_string($connect, $_GET['id_daftar']) : '';
	$id_rekam_medis_get = isset($_GET['id_rekam_medis']) ? mysqli_real_escape_string($connect, $_GET['id_rekam_medis']) : '';
	
	$data = mysqli_fetch_array(
		mysqli_query(
			$connect,
			"SELECT rekam_medis.id_rekam_medis, rekam_medis.tekanan_darah, rekam_medis.berat_badan, rekam_medis.`tinggi badan` AS tinggi_badan,
			        daftar.*, COALESCE(NULLIF(TRIM(pasien.norm_pasien), ''), pasien.id_pasien) AS norm_pasien,
					pasien.nama_pasien, dokter.nama_dokter, poli.nama_poli
			 FROM daftar
			 JOIN pasien ON daftar.id_pasien = pasien.id_pasien
			 JOIN dokter ON daftar.id_dokter = dokter.id_dokter
			 JOIN poli ON dokter.id_poli = poli.id_poli
			 LEFT JOIN rekam_medis ON rekam_medis.id_daftar = daftar.id_daftar
			 WHERE daftar.id_daftar = '$id_daftar'"
		)
	);
	
	mysqli_query(
		$connect,
		"UPDATE daftar
         SET status_periksa='selesai'
         WHERE id_daftar='$id_daftar'"
	);
	?>
	<!--<div class="header"> -->
	<div style="margin-top:70px;margin-left:250px">
		<h2>
			Form Pemeriksaan Dokter
		</h2>
	</div>

	<!--<div class="container"> -->
	<div style="margin-top:10px;margin-left:250px">
		<form action="save_pemeriksaan_dokter.php" method="POST">
			<input type="hidden" name="id_rekam_medis" value="<?php echo $data['id_rekam_medis']; ?>">
			<input type="hidden" name="id_daftar" value="<?php echo $data['id_daftar']; ?>">

			<!-- IDENTITAS -->

			<div class="card">

				<div class="grid-2">

					<div>

						<label>No Antrian</label>

						<input type="text" value="<?php echo $data['nomor_antrian']; ?>" readonly>

					</div>

					<div>

						<label>No Rekam Medis</label>

						<input type="text" value="<?php echo $data['norm_pasien']; ?>" readonly>

					</div>

					<div>

						<label>Id. Pasien</label>

						<input type="text" name="id_pasien" value="<?php echo $data['id_pasien']; ?>" readonly>

					</div>

					<div>

						<label>Nama Pasien</label>

						<input type="text" value="<?php echo $data['nama_pasien']; ?>" readonly>

					</div>

					<div>

						<label>Id. Dokter</label>

						<input type="text" name="id_dokter" value="<?php echo $data['id_dokter']; ?>" readonly>

					</div>

					<div>

						<label>Nama Dokter</label>

						<input type="text" value="<?php echo $data['nama_dokter']; ?>" readonly>

					</div>

					<div>

						<label>Tanggal</label>

						<input type="text" name="tanggal_pemeriksaan" value="<?php echo date('d-m-Y'); ?>" readonly>

					</div>

				</div>
			</div>


			<!-- PROFILE KESEHATAN -->
			<div class="grid-2">

				<div>

					<label>Tekanan Darah</label>

					<input type="text" name="tekanan_darah"
						value="<?php echo htmlspecialchars($data['tekanan_darah'] ?? ''); ?>" readonly>

				</div>

				<div>

					<label>Tinggi Badan (cm)</label>

					<input type="number" name="tinggi_badan"
						value="<?php echo htmlspecialchars($data['tinggi_badan'] ?? ''); ?>" readonly>

				</div>

				<div>

					<label>Berat Badan (kg)</label>

					<input type="number" name="berat_badan"
						value="<?php echo htmlspecialchars($data['berat_badan'] ?? ''); ?>" readonly>
				</div>

			</div>

			<!-- PEMERIKSAAN -->

			<div class="card">

				<div class="section-title">

					Pemeriksaan

				</div>

				<label>Keluhan</label>

				<textarea name="keluhan">
		</textarea>

				<br><br>

				<label>Diagnosa</label>

				<textarea name="hasil_diagnosa">
		</textarea>

				<br><br>

				<label>Tindakan</label>

				<textarea name="tindakan">
		</textarea>

			</div>


			<!-- OBAT -->

			<div class="card">

				<div class="section-title">

					Obat

				</div>

				<table class="table">

					<tr>

						<th>Kode</th>
						<th>Obat</th>
						<th>Stok</th>
						<th>Satuan</th>
						<th>Harga</th>
						<th>Jumlah</th>

					</tr>

					<tr>

						<td>

							<select name="id_obat" id="id_obat" onChange="ambilObat()">

								<option value="">
									Pilih Obat
								</option>

								<?php

								$obat = mysqli_query(
									$connect,
									"SELECT * FROM obat"
								);

								while ($o = mysqli_fetch_array($obat)) {

									?>

									<option value="<?php echo $o['id_obat']; ?>" value="<?php echo $o['id_obat']; ?>"
										data-nama="<?php echo $o['nama_obat']; ?>"
										data-stok="<?php echo $o['stok_obat']; ?>"
										data-satuan="<?php echo $o['satuan_obat']; ?>"
										data-harga="<?php echo $o['harga_obat']; ?>">

										<?php echo $o['nama_obat']; ?>

									</option>

									<?php
								}
								?>

							</select>

						</td>

						<td>
							<input type="text" id="nama_obat" readonly>
						</td>
						<td>
							<input type="text" id="stok" readonly>
						</td>
						<td>
							<input type="text" id="satuan" readonly>
						</td>
						<td>
							<input type="text" id="harga" readonly>
						</td>
						<td>
							<input type="number" name="jumlah" id="jumlah" onKeyUp="hitungTotal()"
								onChange="hitungTotal()">
						</td>

					</tr>

				</table>
				<div style="margin-top:15px;">

					<label>Aturan Pakai</label>

					<input type="text" name="aturan_pakai">

				</div>

				<div class="total-box">

					Total :

					<span id="total_tampil">

						Rp 0

					</span>

				</div>

			</div>


			<div class="footer-action">

				<button type="submit" name="aksi" value="save" class="btn btn-save">
					Save
				</button>

				<button type="submit" name="aksi" value="bayar" class="btn btn-bayar">
					Bayar
				</button>

			</div>

		</form>

	</div>
	<script>

		function ambilObat() {

			let obat = document.getElementById('id_obat');
			let selected = obat.options[obat.selectedIndex];
			document.getElementById('nama_obat').value = selected.getAttribute('data-nama');
			document.getElementById('stok').value = selected.getAttribute('data-stok');
			document.getElementById('satuan').value = selected.getAttribute('data-satuan');
			document.getElementById('harga').value = selected.getAttribute('data-harga');
			hitungTotal();
		}
		//function hitungTotal()
		//{
		//	let harga = parseInt(document.getElementById('harga').value) || 0;
		//	let jumlah = parseInt(document.getElementById('jumlah').value) || 0;
		//	let total = harga*jumlah;
		//	document.getElementById('total_obat').value = total;
		//	document.getElementById('total_tampil').innerHTML = "Rp " +total.toLocaleString('id-ID');
		//}

		function hitungTotal() {

			let harga =
				parseInt(
					document.getElementById('harga').value
				) || 0;

			let jumlah =
				parseInt(
					document.getElementById('jumlah').value
				) || 0;

			console.log("Harga =", harga);
			console.log("Jumlah =", jumlah);

			let total = harga * jumlah;

			console.log("Total =", total);

			document.getElementById(
				'total_tampil'
			).innerHTML =
				"Rp " +
				total.toLocaleString('id-ID');

		}
	</script>
</body>

</html>