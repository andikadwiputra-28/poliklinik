<?php
session_start();
include 'koneksi.php';

// cek apakah yang mengakses halaman ini sudah login
if($_SESSION['level']==""){
	header("location:index.php?pesan=gagal");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Poli</title>
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
		<h4>Manage Poli</h4>
		<?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'){ ?>
			<p style="color:green;"><strong>Data poli berhasil disimpan.</strong></p>
		<?php } ?>
		<table width="900" border="1" cellpadding="8" style="border-collapse:collapse;">
			<tr style="background:#04AA6D;color:#fff;">
				<th>Id Poli</th>
				<th>Nama Poli</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
			<?php
			$nomor = 1;
			$q = mysqli_query($connect, "SELECT * FROM poli ORDER BY id_poli ASC");
			if(!$q){
				echo '<tr><td colspan="4">Query error: '.htmlspecialchars(mysqli_error($connect)).'</td></tr>';
			} else {
				while($data = mysqli_fetch_assoc($q)){
					echo '<tr>';
					echo '<td>'.htmlspecialchars($nomor++).'</td>';
					echo '<td>'.htmlspecialchars($data['nama_poli']).'</td>';
					echo '<td>'.htmlspecialchars($data['keterangan_poli']).'</td>';
					echo '<td><a href="edit_poli.php?id_poli='.$data['id_poli'].'">Edit</a> | <a href="hapus_poli.php?id_poli='.$data['id_poli'].'" onclick="return confirm(\'Hapus poli ini?\')">Hapus</a></td>';
					echo '</tr>';
				}
			}
			?>
		</table>
	</div>
</body>
</html>
