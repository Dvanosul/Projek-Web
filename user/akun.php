<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['nama'])) {
  header('Location: login_user.php');
  exit;
}

include '../koneksi.php';

$error = '';
$success = '';


if(isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']); 
}

if(isset($_SESSION['success'])) {
  $success = $_SESSION['success'];
  unset($_SESSION['success']); 
}

$nama = $_SESSION['nama'];
$sql = "SELECT * FROM pelanggan WHERE nama = $1";
$result = pg_query_params($conn, $sql, [$nama]);
$row = pg_fetch_assoc($result);

// Jika ada permintaan untuk mengunggah foto profil
if (isset($_FILES['profil']) && $_FILES['profil']['name'] != '') {
  // Cek folder target sudah ada atau belum
  $targetDir = '../Gambar/profil/';
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
  }
  
  // Setup target file
  $targetFile = $targetDir . basename($_FILES['profil']['name']);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  
  // Validasi file adalah gambar
  $check = getimagesize($_FILES['profil']['tmp_name']);
  if($check === false) {
    $error = "File bukan gambar yang valid.";
    $uploadOk = 0;
  }
  
  // Validasi format file
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $error = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
    $uploadOk = 0;
  }
  
  // Jika semua validasi berhasil, lanjutkan upload
  if ($uploadOk == 1) {
    if(move_uploaded_file($_FILES['profil']['tmp_name'], $targetFile)) {
      // Update informasi foto profil pengguna di database
      $profil = $_FILES['profil']['name'];
      $updateSql = "UPDATE pelanggan SET profil = $1 WHERE nama = $2";
      $updateResult = pg_query_params($conn, $updateSql, [$profil, $nama]);
      
      if($updateResult) {
        $success = "Foto profil berhasil diperbarui!";
        // Refresh halaman untuk memperbarui tampilan foto profil
        header('Location: akun.php');
        exit;
      } else {
        $error = "Terjadi kesalahan saat memperbarui database: " . pg_last_error($conn);
      }
    } else {
      $error = "Terjadi kesalahan saat mengunggah file.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #fafafa;
      font-family: Arial, sans-serif;
    }

    .profile-card {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-card h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .profile-card .profile-picture {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 30px;
    }

    .profile-card .profile-picture img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-card .edit-image {
      text-align: center;
      margin-top: 10px;
    }

    .profile-card .edit-image label {
      cursor: pointer;
      background-color: #f8f9fa;
      padding: 5px 10px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-right: 10px;
    }

    .profile-card .edit-image label:hover {
      background-color: #e9ecef;
    }

    .profile-card .form-group label {
      font-weight: bold;
      color: #666;
    }

    .profile-card .form-group input,
    .profile-card .form-group textarea {
      background-color: #fafafa;
      border: none;
      border-bottom: 1px solid #ccc;
      border-radius: 0;
      padding: 5px;
      font-size: 16px;
    }

    .profile-card .form-group input:focus,
    .profile-card .form-group textarea:focus {
      outline: none;
      box-shadow: none;
      border-color: #ccc;
    }

    .profile-card .btn {
      width: 100%;
      margin-top: 20px;
      font-size: 16px;
    }

    .btn-transparent {
      background-color: transparent;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand text-white mx-5 " href="#">Toko ATeKa</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item">
            <a class="nav-link text-white  mx-3 ps-3" href="home.php">Toko</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-3" href="pesanan.php">Keranjang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-3" href="transaksi.php">Pesanan Saya</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white  mx-3" href="akun.php">Akun</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-3  " href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="profile-card">
      <h2>Profil Pengguna</h2>
      
      <!-- Tampilkan pesan error/sukses -->
      <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <?php if(!empty($success)): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>
      
      <?php
      // Ambil data user terbaru (setelah update)
      $sql = "SELECT * FROM pelanggan WHERE nama = $1";
      $hasil = pg_query_params($conn, $sql, [$nama]);
      while ($row = pg_fetch_assoc($hasil)) {
        ?>

        <div class="profile-picture">
          <?php
          $profil = $row['profil'];

          if ($profil && file_exists("../Gambar/profil/" . $profil)) {
            // Jika ada foto profil dan file ada, tampilkan foto profil
            echo '<img src="../Gambar/profil/' . $profil . '" alt="' . $row['nama'] . '" id="profileImage">';
          } else {
            echo '<img src="../Gambar/profil/default.jpg" alt="Default Profile" id="profileImage">';
          }
          ?>
        </div>
        <div class="edit-image">
          <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" id="uploadImage" name="profil" style="display: none;" accept="image/*">
            <label for="uploadImage" class="btn-upload">Pilih Foto</label>
            <button type="submit" class="btn btn-sm btn-primary">Unggah</button>
          </form>
        </div>

        <form method="POST" action="update_profil.php" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                  value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username"
                  value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="telepon">Telepon:</label>
                <input type="tel" class="form-control" id="telepon" name="telepon" 
                  value="<?php echo htmlspecialchars($row['telepon'] ?? ''); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"
                  readonly><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></textarea>
              </div>
              <div class="form-group">
                <label for="kodepos">Kode Pos:</label>
                <input type="text" class="form-control" id="kodepos" name="kode_pos"
                  value="<?php echo htmlspecialchars($row['kode_pos'] ?? ''); ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="3" 
                  readonly><?php echo htmlspecialchars($row['bio'] ?? ''); ?></textarea>
              </div>
              <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir:</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                  value="<?php echo htmlspecialchars($row['tgl_lahir'] ?? ''); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="agama">Agama:</label>
                <input type="text" class="form-control" id="agama" name="agama" 
                  value="<?php echo htmlspecialchars($row['agama'] ?? ''); ?>" readonly>
              </div>
              <div class="form-group">
              <label for="jenis_kelamin">Jenis Kelamin:</label>
              <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" readonly>
                <option value="L" <?php echo ($row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?php echo ($row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
              </select>
            </div>
              <div class="form-group">
                <label for="warga_negara">Warga Negara:</label>
                <input type="text" class="form-control" id="warga_negara" name="warga" 
                  value="<?php echo htmlspecialchars($row['warga'] ?? ''); ?>" readonly>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-primary" id="editButton">Edit Profil</button>
          <button type="submit" class="btn btn-success" id="saveButton" style="display: none;">Simpan Perubahan</button>
          <a href="delete_profil.php" class="btn btn-danger" id="deleteImage">Hapus Foto Profil</a>
        </form>
        <?php
      }
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script>
    $(document).ready(function () {
      // Script untuk file upload
      $('#uploadImage').change(function() {
        var fileName = $(this).val().split('\\').pop();
        if(fileName) {
          $('.btn-upload').text(fileName);
        } else {
          $('.btn-upload').text('Pilih Foto');
        }
      });
      
      $('#jenis_kelamin').prop('disabled', true);
      
      // Script untuk enable/disable form saat edit
      $('#editButton').click(function () {
        // Aktifkan mode edit - hapus readonly dari semua input kecuali nama & username
        $('input').not('#nama, #username').removeAttr('readonly');
        $('textarea').removeAttr('readonly');
        
        // Enable select dropdown
        $('#jenis_kelamin').prop('disabled', false);
        
        // Tampilkan tombol Simpan
        $('#saveButton').show();
        
        $('#editButton').hide();
      });
    });
</script>
</body>
</html>