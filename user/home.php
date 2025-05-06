<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko ATeKa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .zoomable-image {
      transition: transform 0.3s ease-in-out;
    }

    .zoomed-image {
      transform: scale(1.2);
    }

    .zoomable-image:not(:hover) {
      transform: scale(1);
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
            <a class="nav-link text-white mx-3">
              <table>
                <tr>
                  <th>Jumlah Pembelian:</th>
                  <td>
                    <form action="" method="post">
                      <select name="jumlah_beli" onchange="this.form.submit()" class="mx-auto">
                        <option value="aa" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'aa')
                          echo 'selected'; ?>>Satuan</option>
                        <option value="bb" <?php if (isset($_POST['jumlah_beli']) && $_POST['jumlah_beli'] == 'bb')
                          echo 'selected'; ?>>Pack</option>
                      </select>
                    </form>
                  </td>
                </tr>
              </table>
            </a>
          </li>

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

  <div class="container-fluid mt-5">
    <center>
      <h1>Featured Products</h1>
    </center>
    <div class="row justify-content-center">
    <?php
      include "../koneksi.php";

      // Debugging: Cek koneksi database
      if (!$conn) {
          echo "Error koneksi database: " . pg_last_error();
          exit;
      }

      $jumlah_beli = isset($_POST['jumlah_beli']) ? $_POST['jumlah_beli'] : 'aa'; 

      // Tentukan grosir_id berdasarkan jumlah_beli
      if ($jumlah_beli == 'aa') {
          $grosir_id = 'GR001'; 
      } else if ($jumlah_beli == 'bb') {
          $grosir_id = 'GR002'; 
      } else {
          $grosir_id = 'GR001'; 
      } // Kurung kurawal penutup yang diperlukan!

      // Debugging: Tampilkan query yang akan dieksekusi
      echo "<!-- Debug: Query dengan grosir_id = $grosir_id -->";

      $sql = "SELECT * FROM barang WHERE grosir_id = $1";
      $result = pg_query_params($conn, $sql, [$grosir_id]);

      // Debugging: Cek error query
      if (!$result) {
          echo "Error query: " . pg_last_error($conn);
          exit;
      }

      // Cek jumlah data yang ditemukan
      $num_rows = pg_num_rows($result);
      if ($num_rows == 0) {
          echo '<div class="alert alert-info col-12">Tidak ada produk yang tersedia untuk kategori ini.</div>';
      }

        // Menampilkan data barang
        while ($row = pg_fetch_assoc($result)) {
            // Kode menampilkan produk tetap sama seperti sebelumnya
        ?>  
        <div class="col-md-3 m-2">
          <div class="card text-center m-1 p-6" style="width: 18rem; border: 2px solid #ddd; border-radius: 25px;">
            <div class="card-img-container"
              style="border-radius: 23px; overflow: hidden; padding: 10px; background-color: #fff;">
              <div class="zoomable-image-container"
                style="width: 100%; height: 0; padding-bottom: 100%; position: relative; overflow: hidden;">
                <img src="../Gambar/produk/<?php echo $row['gambar'] ?>" class="card-img-top zoomable-image"
                  alt="<?php echo $row['nama_barang'] ?>"
                  style="border-radius: 25px; width: 100%; height: auto; cursor: pointer; transition: transform 0.3s;">
              </div>
            </div>
            <div class="card-body">
              <h5 class="title">
                <?php echo $row['nama_barang'] ?>
              </h5>
              <p class="card-text">Stok:
                <?php echo $row['stok'] ?>
              </p>
              <div class="price">
                <?php
                if ($jumlah_beli == 'bb') {
                  echo "<td> Rp." . number_format($row['harga'], 2, ',', '.') . "/Pack </td>";

                } elseif ($jumlah_beli == 'aa') {
                  echo "<td> Rp." . number_format($row['harga'], 2, ',', '.') . "/Biji </td>";

                }
                ?>
              </div>
              <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row['id'] ?>"
                style="width: 100%;">Beli</a>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <form action="home_aksi.php" method="post">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Produk</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <img src="../Gambar/produk/<?php echo $row['gambar'] ?>" alt="<?php echo $row['nama_barang'] ?>"
                        width="500px">
                    </div>
                    <div class="col-md-6">
                      <h2>
                        <?php echo $row['nama_barang'] ?>
                      </h2>
                      <p>
                        <?php echo $row['deskripsi'] ?>
                      </p>
                      <input type="hidden" name="id_barang" value="<?php echo $row['id'] ?>">
                      <input type="hidden" name="nama_pelanggan" value="<?php echo $nama ?>">
                      <table class="table table-borderless">
                        <tr>
                          <th>Stok:</th>
                          <td>
                            <?php echo $row['stok'] ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Harga:</th>
                          <td><strong>
                              <?php echo "Rp." . number_format($row['harga'], 2, ',', '.') ?>
                            </strong></td>
                        </tr>
                        <tr>
                          <th>Pilihan Pengiriman:</th>
                          <td>
                            <select name="jasa_kirim">
                              <option value="11">POS Indonesia</option>
                              <option value="22">JNE Express</option>
                              <option value="33">J&T Express</option>
                              <option value="44">Anter Aja</option>
                              <option value="55">SiCepat</option>
                              <option value="66">Ninja Express</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <th>Jumlah:</th>
                          <td>
                            <input type="number" name="jumlah_produk" value="1" min="1" max="<?php echo $row['stok'] ?>">
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="width: 10%;">Batal</button>
                  <button type="submit" class="btn btn-primary" style="width: 10%;" name="beli">Beli</button>
                </div>
            </form>
          </div>
        </div>
      </div>


      <?php
      }
      ?>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const zoomableImages = document.querySelectorAll('.zoomable-image');

      zoomableImages.forEach(function (image) {
        image.addEventListener('mouseenter', function () {
          this.style.transform = 'scale(1.2)';
        });

        image.addEventListener('mouseleave', function () {
          this.style.transform = 'scale(1)';
        });
      });
    });
  </script>
</body>

</html>