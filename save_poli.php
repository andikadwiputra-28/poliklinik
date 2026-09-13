<?php
include 'koneksi.php';

$nama = isset($_POST['nama_poli']) ? $_POST['nama_poli'] : '';
$ket = isset($_POST['keterangan_poli']) ? $_POST['keterangan_poli'] : '';

$q = "INSERT INTO poli (nama_poli, keterangan_poli) VALUES ('".mysqli_real_escape_string($connect,$nama)."','".mysqli_real_escape_string($connect,$ket)."')";
mysqli_query($connect, $q);
header('Location: manage_poli.php?status=sukses');
