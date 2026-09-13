<!DOCTYPE html>
<html>
<head>
	<title>Halaman Dokter</title>
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/png" href="assets/logo-udinus.png">
</head>
<body>
	<?php 
	session_start();

	// cek apakah yang mengakses halaman ini sudah login
	if($_SESSION['level']==""){
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
			<b>Halaman Dokter</b>
			<br>
			<p>Halo: <b><?php echo $_SESSION['username']; ?></b> Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.</p>
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
            <h2><?php echo $_SESSION['username']; ?></h2>
            <h6><?php echo $_SESSION['level']; ?></h6>
        </div>
        <ul>
            <li><a href="halaman_admin.php">Home</a></li>
            <li><a href="manage_dokter.php">Manage Dokter</a></li>
        </ul>
    </div>
	<?php
// Display selected user data based on id
// Getting id from url
include "koneksi.php";
$id_pasien = $_GET['id_pasien'];
 
// Fetech user data based on id
$query="SELECT * FROM pasien WHERE id_pasien='$id_pasien'";
$sql = mysqli_query($connect,$query);
 
// Fetch patient data based on id
while($data = mysqli_fetch_array($sql)) {
    $id_pasien = $data['id_pasien'];
    $nama_pasien = $data['nama_pasien'];
    $username_pasien = $data['username_pasien'];
    $alamat_pasien = $data['alamat_pasien'];
    $nohp_pasien = $data['nohp_pasien'];
    $noktp_pasien = $data['noktp_pasien'];
    $norm_pasien = $data['norm_pasien']; // Assuming column exists
}
?>

	    <div class="kotak_login">
        <div class="antrian-container">
        <p class="tulisan_login">Update Pasien</p>

		<form action="update_pasien.php" method="post">
			<label>Identitas Pasien</label>	
			<input type="text" name="id_pasien" class="form_login" placeholder="Identitas Pasien.." required="required" value="<?php echo $id_pasien;?>">
		
			<label>Nama Pasien</label>
			<input type="text" name="nama_pasien" class="form_login" placeholder="Nama Pasien.." required="required" value="<?php echo $nama_pasien;?>">
			
			<label>Alamat Pasien</label>
			<input type="text" name="alamat_pasien" class="form_login" placeholder="Alamat Pasien .." required="required" value="<?php echo $alamat_pasien;?>">
 			
			<label>No. KTP Pasien</label>
			<input type="text" name="noktp_pasien" class="form_login" placeholder="No. KTP Pasien .." required="required" value="<?php echo $noktp_pasien;?>">
			
			<label>No. HP Pasien</label>
			<input type="text" name="nohp_pasien" class="form_login" placeholder="No. HP Pasien .." required="required" value="<?php echo $nohp_pasien;?>">
			<label>No. Rekam Medis Pasien</label>
			<input type="text" name="norm_pasien" class="form_login" placeholder="No. Rekam Medis Pasien .." required="required" value="<?php echo $norm_pasien;?>">
			
			<input type="submit" class="tombol_login_baru" value="UPDATE" style="background-color: #04AA6D; background: #2aa7e2;">
 
			<br/>

		</form>
</div>		
</div>
</div>

</body>
</html>