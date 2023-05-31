<?php
session_start();
include('db.php');
$upload_dir = 'uploads/';

if (isset($_GET['delete'])) {
    $npm = base64_decode($_GET['delete']);
    $sql = "select * from tbl_mahasiswa where npm = '" . $npm . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];
        unlink($upload_dir . $foto);
        $sql = "delete from tbl_mahasiswa where npm='" . $npm . "'";
        if (mysqli_query($conn, $sql)) {
            // Menyimpan pesan berhasil dalam session
            $_SESSION['success_message'] = "Data mahasiswa berhasil dihapus";
            header('location:index.php');
            exit;
        } else {
            // Menyimpan pesan gagal dalam session
            $_SESSION['error_message'] = "Data mahasiswa gagal dihapus";
            header('location:index.php');
            exit;
        }
    }
}
