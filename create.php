<?php
//import file store.php
include('store.php');

// Memeriksa apakah ada pesan error dalam session
if (isset($_SESSION['error_message'])) {
  $errorMessage = $_SESSION['error_message'];
  $row = $_SESSION['post'];

  // Hapus pesan error dari session
  unset($_SESSION['error_message']);
  //hapus old post dari session
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
            <strong>Gagal Tambah Data</strong> Mohon periksa inputan data anda kembali
            <ul>
              <!-- karena $errorMessage bentuk array maka dilakukan iterasi dan mengambil nilai indexnya -->
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
          <div class="card-header">Tambah Data</div>
          <div class="card-body">
            <form class="" action="store.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="npm">NPM</label>
                <input type="text" class="form-control" name="npm" placeholder="Masukkan NPM" maxlength="15" value="<?= isset($row['npm']) ? $row['npm'] : ''  ?>">
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" value="<?= isset($row['nama']) ? $row['nama'] : ''  ?>">
              </div>
              <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" name="program_studi" required>
                  <option value="">Pilih Program Studi</option>
                  <option value="D3 Farmasi" <?= (isset($row['program_studi']) == "D3 Farmasi") ? 'selected' : ''  ?>>D3 Farmasi</option>
                  <option value="D3 Kebidanan" <?= (isset($row['program_studi']) == "D3 Kebidanan") ? 'selected' : ''  ?>>D3 Kebidanan</option>
                  <option value="D3 Keprawatan" <?= (isset($row['program_studi']) == "D3 Keprawatan") ? 'selected' : ''  ?>>D3 Keprawatan</option>
                  <option value="D3 Laboratorium Sains" <?= (isset($row['program_studi']) == "D3 Laboratorium Sains") ? 'selected' : ''  ?>>D3 Laboratorium Sains</option>
                  <option value="S1 Biologi" <?= (isset($row['program_studi']) == "S1 Biologi") ? 'selected' : ''  ?>>S1 Biologi</option>
                  <option value="S1 Fisika" <?= (isset($row['program_studi']) == "S1 Fisika") ? 'selected' : ''  ?>>S1 Fisika</option>
                  <option value="S1 Kimia" <?= (isset($row['program_studi']) == "S1 Kimia") ? 'selected' : ''  ?>>S1 Kimia</option>
                  <option value="S1 Matematika" <?= (isset($row['program_studi']) == "S1 Matematika") ? 'selected' : ''  ?>>S1 Matematika</option>
                  <option value="S1 Statistika" <?= (isset($row['program_studi']) == "S1 Statistika") ? 'selected' : ''  ?>>S1 Statistika</option>
                  <option value="S1 Geofisika" <?= (isset($row['program_studi']) == "S1 Geofisika") ? 'selected' : ''  ?>>S1 Geofisika</option>
                  <option value="S1 Farmasi" <?= (isset($row['program_studi']) == "S1 Farmasi") ? 'selected' : ''  ?>>S1 Farmasi</option>
                  <option value="S2 Kimia" <?= (isset($row['program_studi']) == "S2 Kimia") ? 'selected' : ''  ?>>S2 Kimia</option>
                  <option value="S2 Statistika" <?= (isset($row['program_studi']) == "S2 Statistika") ? 'selected' : ''  ?>>S2 Statistika</option>
                  <option value="S2 Biologi" <?= (isset($row['program_studi']) == "S2 Biologi") ? 'selected' : ''  ?>>S2 Biologi</option>
                </select>
              </div>
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" required>
                  <option value="">Pilih Jenis kelamin</option>
                  <option value="laki-laki" <?= (isset($row['jenis_kelamin']) == "laki-laki") ? 'selected' : ''  ?>>Laki-Laki</option>
                  <option value="perempuan" <?= (isset($row['jenis_kelamin']) == "perempuan") ? 'selected' : ''  ?>>Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat" value="<?= isset($row['alamat']) ? $row['alamat'] : ''  ?>">
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan Email" value="<?= isset($row['email']) ? $row['email'] : ''  ?>">
              </div>
              <div class="form-group">
                <label for="image">Foto</label>
                <input type="file" class="form-control" id="image-input" name="image" value="" required>
              </div>
              <div id="preview-container" class="mb-3">
                <img id="preview-image" src="uploads/preview.png" alt="Preview Gambar">
              </div>
              <div class="form-group justify-content-between d-flex">
                <a class="btn btn-outline-danger mr-4" href="index.php"><i class="fas fa-arrow-left"></i> <span>Kembali</span></a>
                <button type="submit" name="Submit" class="btn btn-primary waves">Submit <i class="fa fa-user-plus"></i></button>
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