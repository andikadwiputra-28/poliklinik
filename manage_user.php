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
    <div style="margin-top:100px;margin-left:250px">
        <h4><a href="tambah_user.php">Tambah Data User</a></h4>
        <table width="1027" style=" padding: 15px;">
            <tr style="background-color: #04AA6D;
                color: white;">
                <th width="5%">
                    Id User               </th>
                    <th width="20%">
                        Nama User             </th>
                <th width="20%">
                    User Name            </th>
				<th width="20%">
                    Password                </th>	
				<th width="20%">
                    Level                </th>	
                <th width="15%">
                    Action                </th>
            </tr>
            
            
                <?php 
				include "koneksi.php";
                $query = mysqli_query($connect ,"select * from user");
                    while($data=mysqli_fetch_array($query))
                        {
                            ?>
                            <tr>
                                    <td>
                                        <?php echo $data['id'];?>
                                    </td>
                                    <td>
                                        <?php echo $data['nama'];?>
                                    </td>
                                    <td>
                                        <?php echo $data['username']?>
                                        </td>
                                        <td>
                                        <?php echo $data['password'];?>
                                        </td>
                                    <td>
                                        <?php echo $data['level'];?>
                                    </td>
									</td>
                                    <td>
                                        <?php 
										echo "<a href='edit_user.php?id=".$data['id']."'>Edit||</a>";
										echo "<a href='hapus_user.php?id=".$data['id']."'>Hapus</a>";

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