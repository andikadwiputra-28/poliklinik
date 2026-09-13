<?php
include 'koneksi.php';
$id = isset($_GET['id_poli']) ? (int)$_GET['id_poli'] : 0;
$row = null;
if($id){
	$res = mysqli_query($connect, "SELECT * FROM poli WHERE id_poli='".mysqli_real_escape_string($connect,$id)."'");
	$row = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Poli</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="icon" type="image/png" href="assets/logo-udinus.png">
</head>
<body>
	<div style="margin-top:100px;margin-left:250px;margin-right:250px">
		<div class="kotak_login">
			<p class="tulisan_login">Update Poli</p>
			<form action="update_poli.php" method="post">
				<input type="hidden" name="id_poli" value="<?php echo htmlspecialchars($row['id_poli'] ?? ''); ?>">

				<label>Nama Poli</label>
				<input type="text" name="nama_poli" class="form_login" value="<?php echo htmlspecialchars($row['nama_poli'] ?? ''); ?>" required>

				<label>Keterangan Poli</label>
				<input type="text" name="keterangan_poli" class="form_login" value="<?php echo htmlspecialchars($row['keterangan_poli'] ?? ''); ?>" required>

				<input type="submit" class="tombol_login_baru" value="UPDATE">
			</form>
		</div>
	</div>
</body>
</html>
