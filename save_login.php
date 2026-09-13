<?php
	// Load file koneksi.php
	include "koneksi.php";
	
	// Ambil Data yang Dikirim dari Form
	$nama = mysqli_real_escape_string($connect, $_POST['nama']);
	$username = mysqli_real_escape_string($connect, $_POST['username']);
	$password = mysqli_real_escape_string($connect, $_POST['password']);
	$level = strtolower(trim($_POST['level']));
	// Proses simpan ke Database
	$query = "INSERT INTO user (nama, username, password, level) VALUES ('".$nama."', '".$username."', '".$password."', '".$level."')";
	$sql = mysqli_query($connect,$query); // Eksekusi/ Jalankan query dari variabel $query

	// Jika insert user gagal, tampilkan error dan hentikan (jangan timpa error dengan query lain)
	if (!$sql) {
		echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
		echo "<br><strong>Query:</strong> " . htmlspecialchars($query);
		echo "<br><strong>MySQL errno:</strong> " . mysqli_errno($connect);
		echo "<br><strong>MySQL error:</strong> " . mysqli_error($connect);
		echo "<br><a href='index.php'>Kembali Ke Form</a>";
		exit;
	}

	// Proses simpan ke Tabel Pasien (hanya untuk level pasien)
	$sql1 = true;
	$createPasienResult = true;
	if ($level === 'pasien') {
		$createPasien = "CREATE TABLE IF NOT EXISTS pasien (
			id_pasien INT(11) AUTO_INCREMENT PRIMARY KEY,
			nama_pasien VARCHAR(100) NOT NULL,
			username_pasien VARCHAR(255) NULL
		)";
		$createPasienResult = mysqli_query($connect, $createPasien);

		$cekKolomUsername = mysqli_query($connect, "SHOW COLUMNS FROM pasien LIKE 'username_pasien'");
		if (mysqli_num_rows($cekKolomUsername) === 0) {
			mysqli_query($connect, "ALTER TABLE pasien ADD username_pasien VARCHAR(255) NULL AFTER nama_pasien");
		}

		$query1 = "INSERT INTO pasien (nama_pasien, username_pasien) VALUES ('".$nama."', '".$username."')";
		$sql1 = mysqli_query($connect, $query1); // Eksekusi/ Jalankan query dari variabel $query
	}

	if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
		// Jika Sukses, Lakukan :
		header("location: index.php"); // Redirect ke halaman index.php
	} else {
		// Jika Gagal, Lakukan :
		echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
		echo "<br><strong>Query:</strong> " . htmlspecialchars($query);
		echo "<br><strong>MySQL errno:</strong> " . mysqli_errno($connect);
		echo "<br><strong>MySQL error:</strong> " . mysqli_error($connect);
		echo "<br><strong>createPasienResult:</strong> " . var_export($createPasienResult, true);
		echo "<br><strong>insertPasienResult:</strong> " . var_export($sql1, true);
		echo "<br><a href='index.php'>Kembali Ke Form</a>";
	}
	?>