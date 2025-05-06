<!DOCTYPE html>
<html>
<head>
  <title>Halaman Admin</title>
  <!-- Tambahkan link ke CSS Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  <div class="container">
    <h1 class="mt-4">Daftar Pesanan Pelanggan</h1>

    <table class="table table-bordered mt-4 text-center">
      <thead class="thead-dark">
        <tr>
          <th>ID Pesanan</th>
          <th>Nama User</th>
          <th>Nama Penerima</th>
          <th>Status</th>
          <th>Total harga</th>
          <th>Daftar Barang</th>
          <th>Bukti Pembayaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Mengambil data pesanan dari database
        include '../koneksi.php';
        $query = "SELECT pesanan.id, pesanan.nama_penerima, pelanggan.nama AS nama_pelanggan,pesanan.status_id, pesanan.bukti, status.status, pesanan.total
        FROM pesanan
        INNER JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
        LEFT JOIN status ON pesanan.status_id = status.id";
        $result = odbc_exec($conn, $query);

        while ($row = odbc_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['nama_pelanggan'] . "</td>";
          echo "<td>" . $row['nama_penerima'] . "</td>";
          echo "<td>";
          
          // Menampilkan status pesanan
         

          if (is_null($row['status_id'])) {
            echo 'Menunggu Konfirmasi';
          } else {
            echo $row['status'];
          }

          
          
          
          echo "<td>";
          echo "Rp." . number_format($row['total'], 2, ',', '.') . "";
          echo "</td>";
          
          // Mengambil daftar barang yang dibeli dalam pesanan
          $queryBarang = "SELECT barang.nama_barang
                          FROM pesanan_barang
                          INNER JOIN barang ON pesanan_barang.barang_id = barang.id
                          WHERE pesanan_barang.pesanan_id = " . $row['id'];
          $resultBarang = odbc_exec($conn, $queryBarang);
          
          // Menampilkan daftar barang dalam satu sel
          echo "<td>";
          while ($rowBarang = odbc_fetch_array($resultBarang)) {
            echo $rowBarang['nama_barang'] . "<br>";
          }
          echo "</td>";
          
          echo "<td><button type='button' class='btn btn-primary'data-toggle='modal' data-target='#modalBukti" . $row['id'] . "'>Lihat Gambar</button></td>";
          echo "<td><button type='button' class='btn btn-primary'style='width:100%;' data-toggle='modal' data-target='#modalEdit" . $row['id'] . "'>Edit</button></td>";
          echo "</tr>";
          
          // Modal untuk tampilan gambar bukti pembayaran
          echo "<div class='modal fade' id='modalBukti" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='modalBuktiLabel" . $row['id'] . "' aria-hidden='true'>";
          echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
          echo "<div class='modal-content'>";
          echo "<div class='modal-header'>";
          echo "<h5 class='modal-title' id='modalBuktiLabel" . $row['id'] . "'>Bukti Pembayaran</h5>";
          echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
          echo "<span aria-hidden='true'>&times;</span>";
          echo "</button>";
          echo "</div>";
          echo "<div class='modal-body'>";
          echo "<img src='../Gambar/bukti/" . $row['bukti'] . "' alt='Bukti Pembayaran' class='img-fluid'>";
          echo "</div>";
          echo "<div class='modal-footer'>";
          echo "<a href='../Gambar/bukti/" . $row['bukti'] . "' download class='btn btn-primary'>Download</a>";
          echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          
          // Modal untuk edit status pesanan
          echo "<div class='modal fade' id='modalEdit" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='modalEditLabel" . $row['id'] . "' aria-hidden='true'>";
          echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
          echo "<div class='modal-content'>";
          echo "<div class='modal-header'>";
          echo "<h5 class='modal-title' id='modalEditLabel" . $row['id'] . "'>Edit Status</h5>";
          echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
          echo "<span aria-hidden='true'>&times;</span>";
          echo "</button>";
          echo "</div>";
          echo "<div class='modal-body'>";
          echo "<form action='edit_status.php' method='POST'>";
          echo "<input type='hidden' name='pesanan_id' value='" . $row['id'] . "'>";
          echo "<div class='form-group'>";
          echo "<label for='statusSelect'>Status Baru:</label>";
          echo "<select class='form-control' id='statusSelect' name='status_id'>";
          echo "<option value='213'>Sedang Diproses</option>";
          echo "<option value='123'>Dalam Pengiriman</option>";
          echo "<option value='321'>Sudah Diterima</option>";
          echo "<option value='234'>Transaksi Gagal</option>";
          echo "</select>";
          echo "</div>";
          echo "<button type='submit' class='btn btn-primary'>Simpan</button>";
          echo "</form>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script t src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
