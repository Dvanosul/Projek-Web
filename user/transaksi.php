<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Pesanan Saya</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    .container {
      margin-top: 20px;
    }

    h1 {
      margin-bottom: 20px;
    }

    .btn-primary {
      width: 100px;
    }

    .table {
      margin-top: 20px;
    }

    .modal-lg {
      max-width: 800px;
    }

    .modal-title {
      font-size: 20px;
    }

    .modal-body {
      margin-bottom: 20px;
    }

    .modal-footer {
      justify-content: flex-end;
    }

    .nota-container {
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 5px;
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
            <a class="nav-link text-white mx-3" href="akun.php">Akun</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-3  " href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h1 class="mt-4">Pesanan Saya</h1>

<?php
// Mengambil data pesanan dan barang dari tabel
include '../koneksi.php';
$nama = $_SESSION['nama'];

// Changed to use pg_query_params for parameterized query
$query = "SELECT DISTINCT pesanan.id, pesanan.waktu, pesanan.status_id, pesanan.alamat_detail, status.status, 
          pesanan.nama_penerima, pesanan.alamat_detail, jasa_kirim.jasa_kirim, jasa_kirim.ongkir
          FROM pesanan
          INNER JOIN jasa_kirim ON pesanan.kirim_id=jasa_kirim.id
          INNER JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
          LEFT JOIN status ON pesanan.status_id=status.id
          WHERE pelanggan.nama = $1";
$result = pg_query_params($conn, $query, [$nama]);

// Check if there are any results
if ($result && pg_num_rows($result) > 0) {
  while ($row = pg_fetch_assoc($result)) {
    echo "<table class='table table-bordered mt-4 text-center'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>No. Pesanan</th>";
    echo "<th>Nama Penerima</th>";
    echo "<th>Tanggal Pesanan</th>";
    echo "<th>Status</th>";
    echo "<th>Jumlah</th>";
    echo "<th>Barang</th>";
    echo "<th>Nota</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $queryBarang = "SELECT barang.nama_barang, pesanan_barang.jumlah
                    FROM pesanan_barang
                    INNER JOIN barang ON pesanan_barang.barang_id = barang.id
                    WHERE pesanan_barang.pesanan_id = $1";
    $resultBarang = pg_query_params($conn, $queryBarang, [$row['id']]);

    $rowspan = pg_num_rows($resultBarang);
    $count = 0;

    while ($rowBarang = pg_fetch_assoc($resultBarang)) {
      echo "<tr>";
      if ($count === 0) {
        echo "<td rowspan='" . $rowspan . "'>" . $row['id'] . "</td>";
        echo "<td rowspan='" . $rowspan . "'>" . $row['nama_penerima'] . "</td>";
        echo "<td rowspan='" . $rowspan . "'>" . $row['waktu'] . "</td>";
        if (is_null($row['status_id'])) {
          echo "<td rowspan='" . $rowspan . "'>Menunggu Konfirmasi</td>";
        } else {
          echo "<td rowspan='" . $rowspan . "'>" . $row['status'] . "</td>";
        }
      }
      echo "<td>" . $rowBarang['jumlah'] . "</td>";
      echo "<td>" . $rowBarang['nama_barang'] . "</td>";

      if ($count === 0) {
        if (is_null($row['status_id']) ) {
          echo "<td rowspan='" . $rowspan . "'>Menunggu Konfirmasi</td>";
        } elseif($row['status_id'] == '234') {
          echo "<td rowspan='" . $rowspan . "'>Transaksi Gagal</td>";
        }
        else {
          echo "<td rowspan='" . $rowspan . "'><a href='#' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#pesanan-" . $row['id'] . "' style='width:100px'>Lihat</a></td>";
        }
      }

      echo "</tr>";
      $count++;
    }

    echo "</tbody>";
    echo "</table>";

    
  // Modal untuk menampilkan nota
  echo "<div class='modal fade' id='pesanan-" . $row['id'] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>";
  echo "<div class='modal-dialog modal-dialog-centered modal-lg'>";
  echo "<div class='modal-content'>";
  echo "<div class='modal-header'>";
  echo "<h5 class='modal-title' id='modalLabel'>Nota Pesanan #" . $row['id'] . "</h5>";
  echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
  echo "</div>";
  echo "<div class='modal-body'>";
  echo "<div class='nota-container'>";

  // Informasi nama pembeli dan alamat tujuan
  echo "<p><strong>Nama Penerima:</strong> " . $row['nama_penerima'] . "</p>";
  echo "<p><strong>Alamat Tujuan:</strong> " . $row['alamat_detail'] . "</p>";
  echo "<p><strong>Jasa Kirim:</strong> " . $row['jasa_kirim'] . "</p>";
  echo "<p><strong>Tanggal Pesanan:</strong> " . $row['waktu'] . "</p>";


  // Query untuk mengambil informasi nota
  $queryNota = "SELECT pesanan_barang.jumlah, barang.nama_barang, barang.harga
              FROM pesanan_barang
              INNER JOIN barang ON pesanan_barang.barang_id = barang.id
              WHERE pesanan_barang.pesanan_id = $1";
  $resultNota = pg_query_params($conn, $queryNota, [$row['id']]);

  echo "<table class='table table-bordered'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Nama Barang</th>";
  echo "<th>Jumlah</th>";
  echo "<th>Harga Satuan</th>";
  echo "<th>Total</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  $total = 0;

  while ($rowNota = pg_fetch_assoc($resultNota)) {
      echo "<tr>";
      echo "<td>" . $rowNota['nama_barang'] . "</td>";
      echo "<td>" . $rowNota['jumlah'] . "</td>";
      echo "<td>Rp " . number_format($rowNota['harga'], 0, ',', '.') . "</td>";
      $subtotal = $rowNota['jumlah'] * $rowNota['harga'];
      echo "<td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>";
      echo "</tr>";
      $total += $subtotal;
  }

  echo "</tbody>";
  echo "<tfoot>";
  echo "<tr>";
  echo "<th colspan='3' class='text-end'>Ongkir</th>";
  echo "<td>Rp " . number_format($row['ongkir'], 0, ',', '.') . "</td>";
  echo "</tr>";
  $total=$total + $row['ongkir'];
  echo "<tr>";
  echo "<th colspan='3' class='text-end'>Total</th>";
  echo "<th>Rp " . number_format($total, 0, ',', '.') . "</th>";
  echo "</tr>";
  echo "</tfoot>";
  echo "</table>";

  echo "</div>"; // end nota-container

  echo "</div>";
  echo "<div class='modal-footer'>";
  echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Tutup</button>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  }
} else {
  // Display a message if no orders are found
  echo "<div class='alert alert-info'>Anda belum memiliki pesanan.</div>";
}
?>


  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>