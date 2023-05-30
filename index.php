<?php
session_start();
include('db.php');
$upload_dir = 'uploads/';

if (isset($_GET['delete'])) {
  $npm = $_GET['delete'];
  $sql = "select * from tbl_mahasiswa where npm = " . $npm;
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $foto = $row['foto'];
    unlink($upload_dir . $foto);
    $sql = "delete from tbl_mahasiswa where npm=" . $npm;
    if (mysqli_query($conn, $sql)) {
      // Menyimpan pesan berhasil dalam session
      $_SESSION['success_message'] = "Data mahasiswa berhasil dihapus";
      header('location:index.php');
      exit;
    }
  }
}
// Memeriksa apakah ada pesan success dalam session
if (isset($_SESSION['success_message'])) {
  $successMessage = $_SESSION['success_message'];

  // Hapus pesan success dari session
  unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>PHP CRUD</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="index.php">Sistem Informasi Data Mahasiswa</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto"></ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($successMessage)) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <!-- card -->
        <div class="card">
          <div class="card-header">Data Mahasiswa</div>
          <div class="card-body">
            <a class="btn btn-primary mb-3" href="create.php">Tambah Data <i class="fa fa-user-plus"></i></a>
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "select * from tbl_mahasiswa";
                  $result = mysqli_query($conn, $sql);
                  $no = 1;
                  if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                      <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $row['npm'] ?></td>
                        <td><?php echo $row['nama'] ?></td>
                        <td><?php echo $row['program_studi'] ?></td>
                        <td><img src="<?php echo $upload_dir . $row['foto'] ?>" height="100"></td>
                        <td class="text-center">
                          <a href="show.php?npm=<?php echo $row['npm'] ?>" class="btn btn-success">Detail <i class="fa fa-eye"></i></a>
                          <a href="edit.php?npm=<?php echo $row['npm'] ?>" class="btn btn-info">Ubah <i class="fa fa-user-edit"></i></a>
                          <a href="index.php?delete=<?php echo $row['npm'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete this record?')">Hapus <i class="fa fa-trash-alt"></i></a>
                        </td>
                      </tr>
                  <?php
                      $no++;
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.min.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
    });
    //jika class alert di clik maka akan menyembunyikan element 
    $('.alert').click(() => {
      $('.alert').hide()
    })
  </script>
</body>

</html>