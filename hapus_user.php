<?php
// include database connection file
include("koneksi.php");
 // Get id from URL to delete that user
$id = $_GET['id'];
 $data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT nama, username, level FROM user WHERE id=" . intval($id)));
 // Delete user row from table based on given id
$query="DELETE FROM user WHERE id=$id";
$result = mysqli_query($connect,$query);
if ($result && $data && strtolower($data['level']) === 'pasien') {
	mysqli_query($connect, "DELETE FROM pasien WHERE username_pasien='" . mysqli_real_escape_string($connect, $data['username']) . "' OR nama_pasien='" . mysqli_real_escape_string($connect, $data['nama']) . "'");
}
 // After delete redirect to Home, so that latest user list will be displayed.
header("Location:manage_user.php");
?>
