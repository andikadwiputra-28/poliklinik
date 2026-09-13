<?php
include 'koneksi.php';
 $id = isset($_GET['id_dokter']) ? (int)$_GET['id_dokter'] : 0;
 $row = null;
 if($id){
    $res = mysqli_query($connect, "SELECT * FROM dokter WHERE id_dokter='".mysqli_real_escape_string($connect,$id)."'");
    $row = mysqli_fetch_assoc($res);
 }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Dokter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_sheet.css">
</head>
<body>
    <div style="margin-top:100px;margin-left:250px;margin-right:250px">
        <div class="kota-login">
            <p class="tulisan_login">Update Dokter</p>
            <form action="update_dokter.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_dokter" value="<?php echo htmlspecialchars($row['id_dokter'] ?? ''); ?>">
                <input type="hidden" name="foto_dokter_lama" value="<?php echo htmlspecialchars($row['foto_dokter'] ?? ''); ?>">
                <label>Nama</label>
                <input type="text" name="nama_dokter" class="form_login" value="<?php echo htmlspecialchars($row['nama_dokter'] ?? ''); ?>" required>
                <label>Alamat</label>
                <input type="text" name="alamat_dokter" class="form_login" value="<?php echo htmlspecialchars($row['alamat_dokter'] ?? ''); ?>" required>
                <label>No HP</label>
                <input type="text" name="nohp_dokter" class="form_login" value="<?php echo htmlspecialchars($row['nohp_dokter'] ?? ''); ?>" required>
                <label>Keterangan</label>
                <input type="text" name="keterangan_dokter" class="form_login" value="<?php echo htmlspecialchars($row['keterangan_dokter'] ?? ''); ?>">
                <label>Biaya Periksa</label>
                <input type="number" name="biaya_periksa" class="form_login" value="<?php echo htmlspecialchars($row['biaya_periksa'] ?? ''); ?>" required>
                <label>Poli</label>
                <select name="id_poli" required>
                    <option value="">--Pilih Poli--</option>
                    <?php
                    $p = mysqli_query($connect, "SELECT * FROM poli");
                    while($pol = mysqli_fetch_assoc($p)){
                        $sel = (isset($row['id_poli']) && $row['id_poli']==$pol['id_poli'])? 'selected' : '';
                        echo '<option value="'.$pol['id_poli'].'" '.$sel.'>'.$pol['id_poli'].' - '.$pol['nama_poli'].'</option>';
                    }
                    ?>
                </select>
                <?php if(!empty($row['foto_dokter']) && file_exists('foto/'.$row['foto_dokter'])): ?>
                    <label>Foto Saat Ini</label>
                    <div><img src="foto/<?php echo htmlspecialchars($row['foto_dokter']); ?>" width="120"></div>
                <?php endif; ?>
                <label>Ganti Foto</label>
                <input type="file" name="foto_dokter" accept="image/*">
                <br>
                <input type="submit" class="tombol_login_baru" value="UPDATE">
            </form>
        </div>
    </div>
</body>
</html>
