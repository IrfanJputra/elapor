<?php 
 
$conn = mysqli_connect("localhost","root","mysql","db_lapor");
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
 
?>