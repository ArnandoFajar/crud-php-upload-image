<?php
//inisialisasi session
session_start();
//import file pengaturan koneksi database
require_once('db.php');
//inisialisasi file upload
$upload_dir = 'uploads/';

//jika pengguna melakukan Submit
if (isset($_POST['Submit'])) {

	//mengumpulkan data input
	$npm = $_POST['npm'];
	$nama = $_POST['nama'];
	$programstudi = $_POST['program_studi'];
	$jeniskelamin = $_POST['jenis_kelamin'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];

	//inisialisasi penampung pesan error dalam bentuk array
	$pesanError = [];

	//npm harus unique karena npm primary key jadi dicheck apakah sudah digunakan ?
	$sql = "SELECT npm FROM tbl_mahasiswa WHERE npm='" . $npm . "'";
	$result = mysqli_query($conn, $sql);
	//jika $result mendapatkan record npm sudah digunakan, maka error
	if ($result->num_rows > 0) {
		array_push($pesanError, 'NPM sudah Digunakan');
	} else {
		//jika $result kosong maka lanjut upload foto
		$imgName = $_FILES['image']['name'];
		$imgTmp = $_FILES['image']['tmp_name'];
		$imgSize = $_FILES['image']['size'];
		$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
		$allowExt  = array('jpeg', 'jpg', 'png', 'gif');
		$userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;
		if (in_array($imgExt, $allowExt)) {

			if ($imgSize < 5000000) {
				move_uploaded_file($imgTmp, $upload_dir . $userPic);
			} else {
				//input pesan error ke dalam array
				array_push($pesanError, 'File Gambar terlalu besar');
			}
		} else {
			//input pesan error ke dalam array
			array_push($pesanError, 'Format gambar harus jpeg,jpg,png,gif');
		}
	}


	//jika $pesanerror kosong maka lalu lanjut ke proses berikutnya
	if ($pesanError == null) {
		$sql = "insert into tbl_mahasiswa(npm,nama,program_studi,jenis_kelamin,alamat,email,foto)
					values('" . $npm . "', '" . $nama . "', '" . $programstudi . "', '" . $jeniskelamin . "', '" . $alamat . "', '" . $email . "', '" . $userPic . "')";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			// Menyimpan pesan berhasil dalam session
			$_SESSION['success_message'] = "Data mahasiswa berhasil ditambahkan";
			header('Location: index.php');
			exit;
		} else {
			$errorMsg = 'Error ' . mysqli_error($conn);
		}
	}
	//jika ada error maka tampilkan error 
	else {
		// Menyimpan data error dalam session
		$_SESSION['error_message'] = $pesanError;
		$_SESSION['post'] = $_POST;

		// Redirect kembali ke halaman create
		header('Location: create.php');
		exit; // Penting untuk menghentikan eksekusi script setelah melakukan redirect

	}
}
