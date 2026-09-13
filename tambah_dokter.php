<!DOCTYPE html>
<html>
<head>
	<title>Halaman dokter</title>
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
			<b>Halaman Dokter</b>
			<br>
			</b>.
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
            <li><a href="halaman_dokter.php">Home</a></li>
			<li><a href="manage_dokter.php">Manage Dokter</a></li>
        </ul>
    </div>
	<div class="kotak_login">
		<p class="tulisan_login">Tambah Dokter</p>
		
		<form action="save_dokter.php" method="post" enctype="multipart/form-data">
			<label>Nama</label>
			<input type="text" name="nama_dokter" class="form_login" placeholder="Nama .." required="required">
			
			<label>Alamat Dokter</label>
			<input type="text" name="alamat_dokter" class="form_login" placeholder="Alamat Dokter .." required="required">
			
			<label>Nomor Hp Dokter</label>
			<input type="text" name="nohp_dokter" class="form_login" placeholder="Nomor Hp Dokter .." required="required">
 
			<label>Keterangan</label>
			<br>
			<select name="keterangan_dokter" id="keterangan_dokter">
			  <option>--Pilih Keterangan--</option>
			  <option>Ada</option>
			  <option>Tidak</option>
		    </select>
			<br>
			<br>
			
			<label>Biaya Periksa</label>
			<input type="number" name="biaya_periksa" class="form_login" placeholder="Biaya Periksa .." required="required">
            		
            <label>Identitas Poli</label>
			<br>
	<select name="id_poli" id="id_poli" onChange="tampilPoli()" required>
       			<option value="">--Pilih Poli--</option>

        			<?php
						include("koneksi.php");
        				$sql = "SELECT * FROM poli";
        				$result = mysqli_query($connect, $sql);

        				while ($row = mysqli_fetch_assoc($result)) 
						{
            				echo "<option value='".$row['id_poli']."'>"
                    		.$row['id_poli']." - ".$row['nama_poli'].
                 			"</option>";
        				}
        			?>
		</select>
				<br>
				<br>
			<label>Nama Poli</label>
			<input type="text" name="nama_poli" class="form_login" id="nama_poli" readonly>

			<label>Foto Dokter</label><br>
			<input type="file" name="foto_dokter" accept="image/*" onChange="previewFoto(event)" required>
			<br>
			<img id="preview" width="100" height="100" style="display:none;">
			<br/>

			<input type="submit" class="tombol_login" value="SAVE">
		</form>
		
	</div>
			</body>
            <script>
                function tampilPoli() {

    // Ambil select
    var select = document.getElementById("id_poli");

    // Ambil text option yang dipilih
    var text = select.options[select.selectedIndex].text; 

    // Pisahkan ID dan nama jabatan
    var pecah = text.split(" - ");

    // Tampilkan nama jabatan
    if (pecah.length > 1) {
        document.getElementById("nama_poli").value = pecah[1];
    } else {
        document.getElementById("nama_poli").value = "";
    }
}

function previewFoto(event)
{

	var gambar = document.getElementById("preview");

	gambar.src = URL.createObjectURL(event.target.files[0]);

	gambar.style.display = "block";

}
            </script>
			</html>