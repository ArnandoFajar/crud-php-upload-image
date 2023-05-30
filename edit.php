<?php
include('update.php');
// Memeriksa apakah ada pesan error dalam session
if (isset($_SESSION['error_message'])) {
  $errorMessage = $_SESSION['error_message'];
  //jika melakukan ubah data namun gagal maka mengembalikan input post sebelumnya
  if (!isset($row)) {
    $row = $_SESSION['post'];
  }
  // Hapus pesan error dari session
  unset($_SESSION['error_message']);
  unset($_SESSION['post']);
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
</head>

<style>
  #preview-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: fit-content;
    height: 200px;
    border: 1px solid #ccc;
  }

  #preview-image {
    max-width: 100%;
    max-height: 100%;
  }
</style>

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
      <div class="col-md-8">
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($errorMessage)) : ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Gagal Ubah data</strong> Mohon periksa inputan data anda kembali
            <ul>
              <!-- karena $errorMessage bentuk array maka dilakukan iterasi dan mengambil nilai di dalam index -->
              <?php foreach ($errorMessage as $value) : ?>
                <li><?php echo ($value) ?></li>
              <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <div class="card">
          <div class="card-header">
            Edit Data Mahasiswa
          </div>
          <div class="card-body">
            <form class="" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" name="old_npm" value="<?php echo $row['npm'] ?>">
              <div class="form-group">
                <label for="npm">NPM</label>
                <input type="number" class="form-control" name="npm" placeholder="Masukkan NPM" value="<?php echo $row['npm'] ?>">
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" value="<?php echo $row['nama'] ?>">
              </div>
              <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" name="program_studi" required>
                  <option value="">Pilih Program Studi</option>
                  <option value="D3 Farmasi" <?= ($row['program_studi'] == "D3 Farmasi") ?  "selected" : "" ?>>D3 Farmasi</option>
                  <option value="D3 Kebidanan" <?= ($row['program_studi'] == "D3 Kebidanan") ?  "selected" : "" ?>>D3 Kebidanan</option>
                  <option value="D3 Keprawatan" <?= ($row['program_studi'] == "D3 Keprawatan") ?  "selected" : "" ?>>D3 Keprawatan</option>
                  <option value="D3 Laboratorium Sains" <?= ($row['program_studi'] == "D3 Laboratorium Sains") ?  "selected" : "" ?>>D3 Laboratorium Sains</option>
                  <option value="S1 Biologi" <?= ($row['program_studi'] == "S1 Biologi") ?  "selected" : "" ?>>S1 Biologi</option>
                  <option value="S1 Fisika" <?= ($row['program_studi'] == "S1 Fisika") ?  "selected" : "" ?>>S1 Fisika</option>
                  <option value="S1 Kimia" <?= ($row['program_studi'] == "S1 Kimia") ?  "selected" : "" ?>>S1 Kimia</option>
                  <option value="S1 Matematika" <?= ($row['program_studi'] == "S1 Matematika") ?  "selected" : "" ?>>S1 Matematika</option>
                  <option value="S1 Statistika" <?= ($row['program_studi'] == "SI Statistika") ?  "selected" : "" ?>>S1 Statistika</option>
                  <option value="S1 Geofisika" <?= ($row['program_studi'] == "S1 Geofisika") ?  "selected" : "" ?>>S1 Geofisika</option>
                  <option value="S1 Farmasi" <?= ($row['program_studi'] == "S1 Farmasi") ?  "selected" : "" ?>>S1 Farmasi</option>
                  <option value="S2 Kimia" <?= ($row['program_studi'] == "S2 Kimia") ?  "selected" : "" ?>>S2 Kimia</option>
                  <option value="S2 Statistika" <?= ($row['program_studi'] == "S2 Statistika") ?  "selected" : "" ?>>S2 Statistika</option>
                  <option value="S2 Biologi" <?= ($row['program_studi'] == "S2 Biologi") ?  "selected" : "" ?>>S2 Biologi</option>
                </select>
              </div>
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" required>
                  <option value="">Pilih Jenis kelamin</option>
                  <option value="laki-laki" <?= ($row['jenis_kelamin'] == "laki-laki") ?  "selected" : "" ?>>Laki-Laki</option>
                  <option value="perempuan" <?= ($row['jenis_kelamin'] == "perempuan") ?  "selected" : "" ?>>Perempuan</option>
                </select>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat" value="<?php echo $row['alamat'] ?>">
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan Email" value="<?php echo $row['email'] ?>">
              </div>
              <div class="form-group">
                <label for="image">Foto</label>
                <input type="hidden" name="foto" value="<?php echo $row['foto'] ?>">
                <input type="file" class="form-control" id="image-input" name="image" value="">
              </div>
              <div id="preview-container" class="mb-3">
                <img id="preview-image" src="<?= isset($row['foto']) ? "uploads/" . $row['foto'] : "uploads/preview.png" ?> " alt="Preview Gambar">
              </div>
              <div class="form-group d-flex justify-content-between">
                <a class="btn btn-outline-danger mr-4" href="index.php"><i class="fas fa-arrow-left"></i> <span>Kembali</span></a>
                <button type="submit" name="Submit" class="btn btn-primary waves">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap.min.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" charset="utf-8"></script>
  <script>
    //jika class alert di clik maka akan menyembunyikan element 
    $('.alert').click(() => {
      $('.alert').hide()
    })
    // Fungsi untuk menampilkan gambar pada preview saat dipilih
    function previewImage(event) {
      var input = event.target;
      var previewImage = document.getElementById('preview-image');

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          previewImage.src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    // Mendaftarkan event listener saat gambar dipilih
    document.getElementById('image-input').addEventListener('change', previewImage);
  </script>
</body>

</html>