<!DOCTYPE html>
<html>
<head>
	<title>Halaman Dokter</title>
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
			<b>Halaman Pasien </b>
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
			<li><a href="manage_pasien.php">Pasien</a></li>
			<li><a href="manage_daftar.php">Daftar</a></li>		
			<li><a href="manage_antrian_daftar_pasien.php">Antrian</a></li>
			<li><a href="manage_pemeriksaan_pasien.php">pemriksaan</a></li>
			
        </ul>
    </div>

    <div style="margin-top:100px;margin-left:250px">
	
		<?php
			include "koneksi.php";
			$username =	$_SESSION['username'];
			$level = $_SESSION["level"];
			$cariPasien = mysqli_query($connect,"SELECT id_pasien,nama_pasien FROM pasien WHERE nama_pasien = '$username'");
			$pasien = mysqli_fetch_array($cariPasien);
			$id_pasien = $pasien['id_pasien'];
        	$query1 = mysqli_query($connect ,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'");
		    while($data1=mysqli_fetch_array($cariPasien))
            	{
					if ($level !== "pasien")
         				{
							echo "<h4><a href='tambah_pasien.php'>Tambah Data Pasien</a></h4>";
						} 
						else
						{ echo "pasien";
						  echo $level;	
						}
		 		}
		?>
        <table width="1027" style=" padding: 15px;">
            <tr style="background-color: #04AA6D;
                color: white;">
                <th width="109">
                    Id Pasien               </th>
                <th width="282">
                    Nama Pasien             </th>
                <th width="489">
                    Alamat Pasien            </th>
				<th width="489">
                    Nomor KTP                </th>	
				<th width="489">
                    Nomor HP                </th>	
				<th width="489">
                    Nomor Rekam Medis        </th>	
                <th width="127">
                    Action                </th>
            </tr>
            
                
                <?php 
				include "koneksi.php";
				$username =	$_SESSION['username'];
				if ($level == "pasien")
         				{
                		$query = mysqli_query($connect ,"SELECT * FROM pasien WHERE nama_pasien = '$username'");
						}
				if ($level !== "pasien")
						{
						$query = mysqli_query($connect ,"SELECT * FROM pasien");
						}
						
							
                    	while($data=mysqli_fetch_array($query))
                        {
                            ?>
                             <tr>
                                     <td>
                                         <?php echo $data['id_pasien'];?>
                                     </td>
                                     <td>
                                         <?php echo $data['nama_pasien'];?>
                                     </td>
                                     <td>
                                         <?php echo $data['alamat_pasien'];?>
                                     </td>
                                     <td>
                                         <?php echo $data['noktp_pasien'];?>
                                     </td>
                                     <td>
                                         <?php echo $data['nohp_pasien'];?>
                                     </td>
                                     <td>
                                         <?php echo $data['norm_pasien'];?>
                                     </td>
                                     <td>
                                         <?php 
										echo "<a href='edit_pasien.php?id_pasien=".$data['id_pasien']."'>Edit||</a>";
										echo "<a href='hapus_pasien.php?id_pasien=".$data['id_pasien']."'>Hapus</a>";
										?>
                                     </td>
                             </tr>
                            <?php
                        }
                ?>
            
      </table>
    </div>

</body>
</html>