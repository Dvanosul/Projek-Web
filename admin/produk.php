<?php
// File koneksi dan inisialisasi lainnya jika diperlukan
// Jangan mencampur tag PHP dengan HTML seperti pada baris pertama
$baseUrl = "../"
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Produk Admin</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
 
  <style>
    .form-group-gambar {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-gap: 10px;
      align-items: center;
    }

    .form-group-gambar img {
      max-width: 160px;
    }

    .form-group-gambar .btn-batal {
      font-size: 10px;
      padding: 2px 2px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand ml-5" href="#"><b>Panel Admin Toko ATeKa</b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="home2.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="pengguna.php">Pengguna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="produk.php">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="pesanan2.php">Pesanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <h2>Daftar Produk</h2>
    <div class="row">
      <div class="col-md-6">
        <table>
          <tr>
            <th>Jumlah Pembelian:</th>
            <td>
            <form action="" method="post">
              <select name="jumlah_beli" onchange="this.form.submit()" class="mx-auto">
                <option value="GR001" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'GR001') echo 'selected'; ?>>10-49 (Satuan)</option>
                <option value="GR002" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'GR002') echo 'selected'; ?>>50-99 (Pack)</option>
                <option value="GR003" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'GR003') echo 'selected'; ?>>100-499</option>
                <option value="GR004" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'GR004') echo 'selected'; ?>>500+</option>
              </select>
            </form>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 text-right">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_produk">Tambah Produk</button>
      </div>
    </div>

    <div class="row">
      <?php
      // Koneksi ke database
      include '../koneksi.php';
      $jumlah_beli = isset($_POST['jumlah_beli']) ? $_POST['jumlah_beli'] : 'GR001';
      $query = "SELECT barang.* FROM barang INNER JOIN grosir ON barang.grosir_id = grosir.id WHERE grosir_id = $1";
      $result = pg_query_params($conn, $query, [$jumlah_beli]);

      // Menampilkan data produk dalam bentuk card
      while ($row = pg_fetch_assoc($result)) {
        echo "<div class='col-md-2 mt-3 justify-content-center'>";
        echo "<div class='card'>";
        echo "<img src='" . $baseUrl . "Gambar/produk/" . $row['gambar'] . "' class='card-img-top' alt='Gambar Produk'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row['nama_barang'] . "</h5>";
        echo "<p class='card-text'>Stok: " . $row['stok'] . "</p>";
        if ($jumlah_beli == 'GR001') {
          echo "<p class='card-text'>Rp." . number_format($row['harga'], 2, ',', '.') . "/Biji</p>";
        } elseif ($jumlah_beli == 'GR002') {
          echo "<p class='card-text'>Rp." . number_format($row['harga'], 2, ',', '.') . "/Pack</p>";
        } elseif ($jumlah_beli == 'GR003') {
          echo "<p class='card-text'>Rp." . number_format($row['harga'], 2, ',', '.') . "/Lusin</p>";
        } elseif ($jumlah_beli == 'GR004') {
          echo "<p class='card-text'>Rp." . number_format($row['harga'], 2, ',', '.') . "/Gross</p>";
        }
      ?>
        <div class="d-flex justify-content-between">
          <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row['id'] ?>" style="width:100px;">Edit</a>
          <a href="hapus_produk.php?id=<?php echo $row['id'] ?>" class="btn btn-danger" style="width:100px;">Hapus</a>
        </div>
      <?php
        echo "</div>";
        echo "</div>";
        echo "</div>";
      ?>
        <!-- Modal -->
        <div class="modal fade" id="modal-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modal-<?php echo $row['id']; ?>-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-<?php echo $row['id']; ?>-label">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit produk -->
                        <form action="edit_produk.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data">
                            <!-- Input nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama_barang']; ?>" required>
                            </div>
                            
                            <!-- Input deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $row['deskripsi']; ?></textarea>
                            </div>
                            
                            <!-- Input harga -->
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $row['harga']; ?>" required>
                            </div>
                            
                            <!-- Input stok -->
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $row['stok']; ?>" required>
                            </div>
                            
                            <!-- Input gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            </div>
                            
                            <!-- Input jumlah_beli -->
                            <input type="hidden" name="jumlah_beli" value="<?php echo $row['grosir_id']; ?>">

                            <!-- Tombol simpan -->
                            <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>

  <!--Modal Tambah produk-->
  <div class="modal fade" id="tambah_produk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form method="POST" action="tambah_produk_aksi.php" enctype="multipart/form-data">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <!-- Input nama produk -->
                <div class="form-group">
                  <label for="nama">Nama Produk :</label>
                  <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <!-- Select dropdown -->
                <div class="form-group">
                  <label for="jumlah_beli">Jumlah Pembelian :</label>
                  <select name="jumlah_beli" class="form-control">
                    <option value="GR001">10-49 (Satuan)</option>
                    <option value="GR002">50-99 (Pack)</option>
                    <option value="GR003">100-499</option>
                    <option value="GR004">500+</option>
                  </select>
                </div>
                <!-- Input harga produk -->
                <div class="form-group">
                  <label for="harga">Harga :</label>
                  <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                <!-- Input stok produk -->
                <div class="form-group">
                  <label for="stok">Stok :</label>
                  <input type="number" class="form-control" id="stok" name="stok" required>
                </div>
              </div>
              <div class="col-md-6">
                <!-- Input deskripsi produk -->
                <div class="form-group">
                  <label for="deskripsi">Deskripsi :</label>
                  <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                </div>
                <!-- Input gambar produk -->
                <div class="form-group-gambar">
                  <div>
                    <label for="gambar">Gambar:</label>
                    <input type="file" class="form-control-file" id="gambar" name="gambar" required>
                  </div>
                  <div>
                    <img id="preview" src="#" alt="Preview Gambar" style="display: none;">
                    <button type="button" id="btn-batal" class="btn btn-secondary" style="display: none;">Batal</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 10%;">Batal</button>
            <button type="submit" class="btn btn-primary ml-3" style="width: 20%;" name="beli">Tambah Produk</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Fungsi untuk menampilkan preview gambar saat dipilih
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        $('#preview').show();
        $('#btn-batal').show();
      }
    }

    // Fungsi untuk menghapus preview gambar
    function removePreview() {
      $('#preview').attr('src', '#');
      $('#gambar').val('');
      $('#preview').hide();
      $('#btn-batal').hide();
    }

    // Event listener untuk input gambar
    $('#gambar').change(function() {
      readURL(this);
    });

    // Event listener untuk tombol batal
    $('#btn-batal').click(function() {
      removePreview();
    });
  </script>
</body>
</html>