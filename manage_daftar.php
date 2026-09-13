<!DOCTYPE html>
<html>
<head>
	<title>Halaman Dokter</title>
	<link rel="stylesheet" href="style_sheet.css">
	<link rel="stylesheet" href="style_katalog_kanan.css">
    <link rel="icon" type="image/png" href="assets/logo-udinus.png">
</head>
<body>
	<?php 
	session_start();

	// cek apakah yang mengakses halaman ini sudah login
	if($_SESSION['level']==""){
		header("location:index.php?pesan=gagal");
	}

	if($_SESSION['level'] !== 'pasien'){
		echo "<script>alert('Halaman daftar periksa khusus pasien');window.location='halaman_" . $_SESSION['level'] . ".php';</script>";
		exit;
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
            <li><a href="halaman_pasien.php">Home</a></li>
            <li><a href="manage_pasien.php">Manage Pasien</a></li>
			<li><a href="manage_daftar.php">Daftar Periksa</a></li>
        </ul>
    </div>

    <div style="margin-top:100px;margin-left:250px">
		<h4>Daftar Dokter Poliklinik</a></h4>
		<div class="katalog">
		<?php 
			include "koneksi.php";
			$query = mysqli_query($connect ,"SELECT dokter.id_dokter, dokter.foto_dokter, dokter.nama_dokter, poli.nama_poli FROM dokter, poli WHERE dokter.id_poli=poli.id_poli AND dokter.keterangan_dokter='Ada'");
                    while($data=mysqli_fetch_array($query))
                    {
					?>
					
					<div class="card">

						<img src="foto/<?php echo $data['foto_dokter'];?>" class="foto-dokter" alt="foto dokter">

						<div class="info">

							<div class="nama">

								<?php
									echo $data['nama_dokter'];
								?>

							</div>

							<div class="poli">

								Poli :
								<b>
									<?php echo $data['nama_poli'];?>
								</b>

							</div>

							<div class="status">

								Tersedia

							</div>

							<?php
							echo "  <a href='proses_daftar.php?id_dokter=".$data['id_dokter']."'  
							class='btn' onclick=\"return confirm('Daftar pemeriksaan')\">  
							Daftar Periksa  </a>  "; 
							?>

						</div>

					</div>

					<?php
						}
					?>
			</div>
	</div>
					
</body>
</html>