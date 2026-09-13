<?php
include 'koneksi.php';
$id_poli = isset($_GET['id_poli']) ? $_GET['id_poli'] : '';
if($id_poli != ''){
	mysqli_query($connect, "DELETE FROM poli WHERE id_poli='".mysqli_real_escape_string($connect,$id_poli)."'");
}
header('Location: manage_poli.php');
