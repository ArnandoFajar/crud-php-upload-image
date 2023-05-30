<?php
require_once('db.php');
$upload_dir = 'uploads/';

if (isset($_GET['npm'])) {
  $npm = $_GET['npm'];
  $sql = "select * from tbl_mahasiswa where npm=" . $npm;
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  } else {
    $errorMsg = 'Could not Find Any Record';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>PHP CRUD</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" charset="utf-8"></script>
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
        <div class="card">
          <div class="card-header">
            Detail Data Mahasiswa
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <img src="<?php echo $upload_dir . $row['foto'] ?>" height="200">
              </div>
              <div class="col-md-9">
                <form class="mb-4">
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">NPM</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['npm'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['nama'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Program Studi</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['program_studi'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jenis Kelamin</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['jenis_kelamin'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Alamat</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['alamat'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Email</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": <?php echo $row['email'] ?>">
                    </div>
                  </div>
                </form>
                <div class="d-flex">
                  <a class="btn btn-outline-danger mr-4" href="index.php"><i class="fas fa-arrow-left"></i> <span>Kembali</span></a>
                  <a href="edit.php?npm=<?php echo $row['npm'] ?>" class="btn btn-outline-info ml-4">Ubah <i class="fa fa-user-edit"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  <script src="js/bootstrap.min.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
</body>

</html>