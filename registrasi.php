<!DOCTYPE html>
<html>
<head>
	<title>Halaman Registrasi</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
 
		<?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan']=="gagal"){
			echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
		}
	}
	?>
 
	<div class="kotak_login">
		<p class="tulisan_login">Registrasi User</p>
 
		<form action="save_login.php" method="post">
			<label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama .." required="required">
			
			<label>Username</label>
			<input type="text" name="username" class="form_login" placeholder="Username .." required="required">
 
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Password .." required="required">
 
 			<label>Level</label>
			<select name="level" class="form_login" required>
				<option value="" disabled selected>-- Pilih Level --</option>
				<option value="admin">Admin</option>
				<option value="dokter">Dokter</option>
				<option value="pasien">Pasien</option>
			</select>
			
			<input type="submit" class="tombol_login" value="SAVE">
 
			<br/>

		</form>
		
	</div>
 
 
</body>
</html>