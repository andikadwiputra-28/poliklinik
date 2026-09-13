<?php
include "koneksi.php";

$nama = mysqli_real_escape_string($connect, $_POST['nama']);
$username = mysqli_real_escape_string($connect, $_POST['username']);
$password = mysqli_real_escape_string($connect, $_POST['password']);
$level = strtolower(trim($_POST['level']));

$foto_name = "";
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
	$ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
	$foto_name = time() . '_' . mt_rand(1000,9999) . '.' . $ext;
	if(!is_dir('Foto')){
		mkdir('Foto', 0755, true);
	}
	move_uploaded_file($_FILES['foto']['tmp_name'], 'Foto/' . $foto_name);
}

$cekKolomFoto = mysqli_query($connect, "SHOW COLUMNS FROM user LIKE 'foto_dokter'");
if (mysqli_num_rows($cekKolomFoto) === 0) {
	mysqli_query($connect, "ALTER TABLE user ADD foto_dokter VARCHAR(255) NULL AFTER level");
}

$query = "INSERT INTO user (nama, username, password, level, foto_dokter) VALUES('".
	mysqli_real_escape_string($connect, $nama)."','".
	mysqli_real_escape_string($connect, $username)."','".
	mysqli_real_escape_string($connect, $password)."','".
	mysqli_real_escape_string($connect, $level)."','".
	mysqli_real_escape_string($connect, $foto_name)."')";

$sql = mysqli_query($connect, $query);

if ($sql && $level === 'pasien') {
	mysqli_query($connect, "CREATE TABLE IF NOT EXISTS pasien (
		id_pasien INT(11) AUTO_INCREMENT PRIMARY KEY,
		nama_pasien VARCHAR(100) NOT NULL,
		username_pasien VARCHAR(255) NULL
	)");
	$cekKolomUsername = mysqli_query($connect, "SHOW COLUMNS FROM pasien LIKE 'username_pasien'");
	if (mysqli_num_rows($cekKolomUsername) === 0) {
		mysqli_query($connect, "ALTER TABLE pasien ADD username_pasien VARCHAR(255) NULL AFTER nama_pasien");
	}
	mysqli_query($connect, "INSERT INTO pasien (nama_pasien, username_pasien) VALUES ('".$nama."', '".$username."')");
}

if($sql){
	header("Location: manage_user.php");
} else {
	echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
	echo "<br><strong>MySQL error:</strong> " . mysqli_error($connect);
	echo "<br><strong>Query:</strong> " . htmlspecialchars($query);
	echo "<br><strong>Upload info:</strong> <pre>" . htmlspecialchars(print_r($_FILES, true)) . "</pre>";
	echo "<br><a href='index.php'>Kembali Ke Form</a>";
}
?>