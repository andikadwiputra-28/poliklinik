<?php
include 'koneksi.php';

$id = isset($_POST['id_poli']) ? (int)$_POST['id_poli'] : 0;
$nama = isset($_POST['nama_poli']) ? $_POST['nama_poli'] : '';
$ket = isset($_POST['keterangan_poli']) ? $_POST['keterangan_poli'] : '';

$q = "UPDATE poli SET nama_poli='".mysqli_real_escape_string($connect,$nama)."', keterangan_poli='".mysqli_real_escape_string($connect,$ket)."' WHERE id_poli='".mysqli_real_escape_string($connect,$id)."'";
mysqli_query($connect, $q);
header('Location: manage_poli.php');
