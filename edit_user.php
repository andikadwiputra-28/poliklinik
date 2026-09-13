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
            <li><a href="manage_dokter.php">Manage Dokter</a></li>
        </ul>
    </div>
	<?php
// Display selected user data based on id
// Getting id from url
include "koneksi.php";
$id = $_GET['id'];
 
// Fetech user data based on id
$query="SELECT * FROM user WHERE id='$id'";
$sql = mysqli_query($connect,$query);
 
while($data = mysqli_fetch_array($sql))
{
    $id = $data['id'];
	$nama = $data['nama'];
    $username = $data['username'];
	$password = $data['password'];
	$level = $data['level'];
    $foto = isset($data['foto_dokter']) ? $data['foto_dokter'] : '';
}
?>
		<div style="margin-top:100px;margin-left:250px;margin-right:250px">
	    <div class="kota-login">
        <p class="tulisan_login">Update User</p>

		<form action="update_user.php" method="post" enctype="multipart/form-data">
			<label>Identitas User</label>	
			<input type="text" name="id" class="form_login" placeholder="Identitas User.." required="required" value="<?php echo $id;?>">
		
			<label>Nama User</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama User.." required="required" value="<?php echo $nama;?>">
			
			<label>User Name</label>
			<input type="text" name="username" class="form_login" placeholder="Username User .." required="required" value="<?php echo $username;?>">
 			
			<label>Password</label>
			<input type="text" name="password" class="form_login" placeholder="Password User .." required="required" value="<?php echo $password;?>">
			
			<label>Level</label>
			<input type="text" name="level" class="form_login" placeholder="Level User .." required="required" value="<?php echo $level;?>">
            
			<?php if(!empty($foto)){ ?>
				<label>Foto Saat Ini</label>
				<div><img src="Foto/<?php echo $foto;?>" width="100" alt="foto"></div>
			<?php } ?>

			<label>Ganti Foto</label>
			<input type="file" name="foto" class="form_login" accept="image/*">
			
			<input type="submit" class="tombol_login_baru" value="UPDATE"style="background-color: #04AA6D";style="background: #2aa7e2";>
 
			<br/>

		</form>
</div>		
</div>
</div>

</body>
</html>