<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: manage_user.php");
    exit();
}

$id = mysqli_real_escape_string($connect, $_POST['id'] ?? '');
$nama = mysqli_real_escape_string($connect, $_POST['nama'] ?? '');
$username = mysqli_real_escape_string($connect, $_POST['username'] ?? '');
$password = mysqli_real_escape_string($connect, $_POST['password'] ?? '');
$level = mysqli_real_escape_string($connect, $_POST['level'] ?? '');

$fotoBaru = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $fotoBaru = time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    if (!is_dir('Foto')) {
        mkdir('Foto', 0755, true);
    }
    move_uploaded_file($_FILES['foto']['tmp_name'], 'Foto/' . $fotoBaru);
}

$dataLama = mysqli_query($connect, "SELECT foto_dokter FROM user WHERE id='$id' LIMIT 1");
$rowLama = $dataLama ? mysqli_fetch_assoc($dataLama) : null;
$fotoDisimpan = $fotoBaru !== '' ? $fotoBaru : ($rowLama['foto_dokter'] ?? '');

$query = "UPDATE user SET 
    nama='$nama',
    username='$username',
    password='$password',
    level='$level',
    foto_dokter='$fotoDisimpan'
WHERE id='$id'";

$result = mysqli_query($connect, $query);

if ($result) {
    header("Location: manage_user.php");
} else {
    header("Location: edit_user.php?id=$id&pesan=gagal");
}

exit();
?>