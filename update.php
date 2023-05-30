<?php
//inisialisasi
session_start();
$upload_dir = 'uploads/';
//import file koneksi database
require_once('db.php');

//inisialisasi penampung pesan error dalam bentuk array
$pesanError = [];

//get record data berdasarkan npm
if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];
    $sql = "select * from tbl_mahasiswa where npm=" . $npm;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        array_push($pesanError, "tidak menemukan data dari npm" . $npm);
    }
}

//jika user melakukan submit edit data
if (isset($_POST['Submit'])) {

    //mengumpulkan data input
    $oldnpm = $_POST['old_npm'];
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $programstudi = $_POST['program_studi'];
    $jeniskelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    /**
     * fungsi upload foto
     * karena fungsi ini dipakai 2x maka dibuat menjadi fungsi supaya tidak terjadi duplikat
     * @param string $upload_directory
     * @param string $row_fotolama
     * @return string nama foto
     */
    function uploadFoto($upload_directory, $row_fotolama)
    {
        //jika $result kosong maka lanjut upload foto
        $imgName = $_FILES['image']['name'];
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgSize = $_FILES['image']['size'];

        if ($imgName) {

            $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

            $allowExt  = array('jpeg', 'jpg', 'png', 'gif');

            $fotobaru = time() . '_' . rand(1000, 9999) . '.' . $imgExt;

            if (in_array($imgExt, $allowExt)) {

                if ($imgSize < 5000000) {
                    unlink($upload_directory . $row_fotolama);
                    move_uploaded_file($imgTmp, $upload_directory . $fotobaru);
                } else {
                    //input pesan error ke dalam array
                    array_push($pesanError, 'File Gambar terlalu besar');
                }
            } else {
                //input pesan error ke dalam array
                array_push($pesanError, 'Format gambar tidak valid');
            }
            return $fotobaru;
        } else {
            return $row_fotolama;
        }
    }

    //check apakah npm diganti ?
    if ($oldnpm != $npm) {

        //npm harus unique karena npm primary key jadi dicheck apakah sudah digunakan ?
        $sql = "SELECT npm FROM tbl_mahasiswa WHERE npm='" . $npm . "'";
        $result = mysqli_query($conn, $sql);
        //jika $result mendapatkan record npm sudah digunakan, maka error
        if ($result->num_rows > 0) {
            array_push($pesanError, 'NPM sudah Digunakan');
        } else {
            //jika $result kosong maka lanjut upload foto
            $foto = uploadFoto($upload_dir, $row['foto']);
        }
    } else {
        //jika npm tidak diganti maka lanjut upload foto
        $foto = uploadFoto($upload_dir, $row['foto']);
    }


    //jika $pesanError kosong maka lanjut ke proses ubah data
    if ($pesanError == null) {
        $sql = "update tbl_mahasiswa
				set npm = '" . $npm . "',
                    nama = '" . $nama . "',
				    program_studi = '" . $programstudi . "',
                    jenis_kelamin = '" . $jeniskelamin . "',
                    alamat = '" . $alamat . "',
                    email = '" . $email . "',
					foto = '" . $foto . "'
					where npm=" . $oldnpm;
        $result = mysqli_query($conn, $sql);
        if ($result) {
            // Menyimpan pesan berhasil dalam session
            $_SESSION['success_message'] = "Data mahasiswa berhasil diubah";
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

        // Redirect kembali ke halaman edit
        header('Location: edit.php?npm=' . $row['npm']);
        exit; // Penting untuk menghentikan eksekusi script setelah melakukan redirect

    }
}
