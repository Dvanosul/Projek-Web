<?php
include '../koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['nama'])) {
  // Redirect to login page if not logged in
  header("Location: login_user.php");
  exit();
}

$nama = $_SESSION['nama'];

if (!isset($_SESSION['transaksi_id'])) {
  // Kode untuk mengambil ID transaksi
  $ambil_transaksi_id = "SELECT t.id FROM transaksi t INNER JOIN pelanggan p ON t.pelanggan_id=p.id WHERE p.nama=$1";
  $hasil_ambil = pg_query_params($conn, $ambil_transaksi_id, [$nama]);
  
  // Check if query returned results
  if ($hasil_ambil && pg_num_rows($hasil_ambil) > 0) {
    $row_ambil = pg_fetch_assoc($hasil_ambil);
    $idTransaksi = $row_ambil['id'];
  } else {
    // No existing transaction found, you might want to create a new one
    // For now, let's handle this by redirecting to home page
    echo "<div class='alert alert-info'>Keranjang masih kosong. Silakan tambahkan produk terlebih dahulu.</div>";
    $idTransaksi = null; // Set to null, will be handled below
  }
} else {
  $idTransaksi = $_SESSION['transaksi_id'];
}

// Initialize resultKeranjang outside the if block
$resultKeranjang = false;

// Only query the cart if we have a transaction ID
if ($idTransaksi) {
  // Mendapatkan data barang yang telah ditambahkan ke keranjang
  $queryKeranjang = "SELECT b.*, tb.jumlah as jumlah, g.jumlah as per, tb.sub_total, tb.barang_id FROM barang b 
                    INNER JOIN grosir g ON b.grosir_id = g.id 
                    INNER JOIN transaksi_barang tb ON b.id = tb.barang_id 
                    INNER JOIN transaksi t ON t.id = tb.transaksi_id 
                    INNER JOIN pelanggan p ON p.id = t.pelanggan_id 
                    WHERE t.id = $1";
  $resultKeranjang = pg_query_params($conn, $queryKeranjang, [$idTransaksi]);
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Keranjang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 12px 15px;
      text-align: center;
    }

    .btn-primary,
    .btn-success {
      margin-top: 20px;
    }

    .btn-danger {
      margin-right: 5px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand text-white mx-5" href="#">Toko ATeKa</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white mx-3" href="home.php">Toko</a>
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
            <a class="nav-link text-white mx-3 " href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h1>Keranjang</h1>
    
    <?php if (!$idTransaksi): ?>
      <div class="alert alert-info">Keranjang masih kosong. Silakan tambahkan produk terlebih dahulu.</div>
      <div class="text-center">
        <a href="home.php" class="btn btn-primary">Belanja Sekarang</a>
      </div>
    <?php else: ?>
    
    <table class="table table-bordered" style="border: 0;">
      <thead class="thead-dark">
        <tr>
          <th style="border-bottom: 1px solid #000;">Nama Barang</th>
          <th style="border-bottom: 1px solid #000;">Jumlah</th>
          <th style="border-bottom: 1px solid #000;">Per</th>
          <th style="border-bottom: 1px solid #000;">Sub Total</th>
          <th style="border-bottom: 1px solid #000;">Opsi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        if ($resultKeranjang && pg_num_rows($resultKeranjang) > 0) {
          while ($row = pg_fetch_assoc($resultKeranjang)) {
            echo "<tr>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . $row['jumlah'] . "</td>";
            echo "<td>" . $row['per'] . "</td>";
            echo "<td> Rp." . number_format($row['sub_total'], 2, ',', '.') . "</td>";
            echo "<td><a href='hapus_pesanan.php?id=" . $row['barang_id'] . "' class='btn btn-danger'>Hapus</a></td>";
            echo "</tr>";

            $total += $row['sub_total'];
          }
        } else {
          echo "<tr><td colspan='5' class='text-center'>Tidak ada item dalam keranjang</td></tr>";
        }
        ?>
        <?php if ($total > 0): ?>
        <tr>
          <td colspan="2"></td>
          <td style="border-left: none; border-right: none;"><strong>Jumlah Total:</strong></td>
          <td style="border-left: none; border-right: none;"><strong>Rp.
              <?php echo number_format($total, 2, ',', '.'); ?>
            </strong></td>
          <td></td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="text-center">
      <a href="home.php" class="btn btn-primary">Tambah Barang</a>
      <?php if ($total > 0): ?>
      <a href="checkout.php" class="btn btn-success">Checkout</a>
      <?php endif; ?>
    </div>
    
    <?php endif; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>