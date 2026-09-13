<!DOCTYPE html>
<html>
<head>
	<title>Halaman admin</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style_sheet.css">
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
			<li><a href="manage_user.php">Manage User</a></li>
			<li><a href="manage_dokter.php">Manage Dokter</a></li>
        </ul>
    </div>
	<div class="kotak_login">
		<p class="tulisan_login">Tambah User</p>
		
		<form action="save_user.php" method="post" enctype="multipart/form-data">
			<label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama .." required="required">
			
			<label>Username</label>
			<input type="text" name="username" class="form_login" placeholder="Username .." required="required">
			
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Password .." required="required">
 
 			<label>Level</label>
			 <input type="text" name="level" class="form_login" placeholder="Input : Medis, Dokter, Pegawai, Apoteker, Pasien .." required="required">
            
            <label>Foto</label>
            <input type="file" name="foto" class="form_login" accept="image/*">
			
			<input type="submit" class="tombol_login" value="SAVE">
 
			<br/>

		</form>
		
	</div>
			</body>
			</html>