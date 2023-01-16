<?php
$conn = mysqli_connect("localhost","root","mysql","db_lapor");


function tambah($data) {
	global $conn;
    $email = htmlspecialchars ($data["email"]);
    $judul = htmlspecialchars ($data["judul"]);
    $isi = htmlspecialchars ($data["isi"]);
    $tanggal  = ($data["tanggal"]);
    $lokasi = htmlspecialchars ($data["lokasi"]);
        // upload gambar
	$lampiran = upload();
	if( !$lampiran ) {
		return false;
	}
    
    $query = "INSERT INTO tb_laporan VALUES (NULL,'$email','$judul','$isi','$tanggal','$lokasi','$lampiran')";
    
    mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
    
}

function upload() {

	$namaFile = $_FILES['lampiran']['name'];
	$ukuranFile = $_FILES['lampiran']['size'];
	$error = $_FILES['lampiran']['error'];
	$tmpName = $_FILES['lampiran']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiFileValid = ['jpg', 'png', 'jpeg'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 10000000 ) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'upload/' . $namaFileBaru);

	return $namaFileBaru;
}
?>