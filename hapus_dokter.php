<?php
include 'koneksi.php';
 $id_dokter = isset($_GET['id_dokter']) ? $_GET['id_dokter'] : '';
 if($id_dokter != ''){
    $r = mysqli_query($connect, "SELECT foto_dokter FROM dokter WHERE id_dokter='".mysqli_real_escape_string($connect,$id_dokter)."'");
    $row = mysqli_fetch_assoc($r);
    if(!empty($row['foto_dokter']) && file_exists('foto/'. $row['foto_dokter'])){
        @unlink('foto/'. $row['foto_dokter']);
    }
    mysqli_query($connect, "DELETE FROM dokter WHERE id_dokter='".mysqli_real_escape_string($connect,$id_dokter)."'");
 }
header('Location: manage_dokter.php');
