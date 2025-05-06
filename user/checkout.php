<?php
session_start();
include '../koneksi.php';

// Mengambil nama dari session
$nama = $_SESSION['nama'];

// Mengambil ID transaksi atau membuat ID baru jika belum ada
if (!isset($_SESSION['transaksi_id'])) {
  $ambil_transaksi_id = "SELECT t.id FROM transaksi t INNER JOIN pelanggan p ON t.pelanggan_id=p.id WHERE p.nama = $1";
  $hasil_ambil = pg_query_params($conn, $ambil_transaksi_id, [$nama]);
  if ($hasil_ambil && pg_num_rows($hasil_ambil) > 0) {
    $row_ambil = pg_fetch_assoc($hasil_ambil);
    $idTransaksi = $row_ambil['id'];
  } else {
    // Buat transaksi baru jika tidak ditemukan
    $idTransaksi = time();
  }
} else {
  $idTransaksi = $_SESSION['transaksi_id'];
}

// Mengambil data barang yang dibeli
$queryKeranjang = "SELECT b.*, tb.jumlah as jumlah, g.jumlah as per, tb.sub_total, tb.barang_id 
                   FROM barang b 
                   INNER JOIN grosir g ON b.grosir_id = g.id 
                   INNER JOIN transaksi_barang tb ON b.id = tb.barang_id 
                   INNER JOIN transaksi t ON t.id = tb.transaksi_id 
                   INNER JOIN pelanggan p ON p.id = t.pelanggan_id 
                   WHERE t.id = $1";
$resultKeranjang = pg_query_params($conn, $queryKeranjang, [$idTransaksi]);

// Menghitung total harga barang
$total_barang = 0;
while ($row = pg_fetch_assoc($resultKeranjang)) {
  $total_barang += $row['sub_total'];
}

// Mengambil ongkir dari pilihan jasa kirim jika sudah dipilih
$ongkir = 0;
if (isset($_POST['jasa_kirim'])) {
  $jasaKirimId = $_POST['jasa_kirim'];
  $sql = "SELECT ongkir FROM jasa_kirim WHERE id = $1";
  $hasil = pg_query_params($conn, $sql, [$jasaKirimId]);
  if ($hasil && pg_num_rows($hasil) > 0) {
    $hasil_total = pg_fetch_assoc($hasil);
    $ongkir = $hasil_total['ongkir'];
  }
}

// Menghitung total harga keseluruhan
$total_harga = $total_barang + $ongkir;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Halaman Checkout</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div id="loadingMessage" style="display: none;">
      <p>Mohon tunggu konfirmasi...</p>
    </div>
    <h1 class="mt-4">Checkout Barang</h1>

    <h2 class="mt-4">Daftar Barang yang Dibeli</h2>
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Per</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Eksekusi query ulang untuk mendapatkan hasil yang lengkap
        $resultKeranjang = pg_query_params($conn, $queryKeranjang, [$idTransaksi]); 
        while ($row = pg_fetch_assoc($resultKeranjang)) {
          echo "<tr>";
          echo "<td>" . $row['nama_barang'] . "</td>";
          echo "<td>" . $row['jumlah'] . "</td>";
          echo "<td>" . $row['per'] . "</td>";
          echo "<td> Rp." . number_format($row['sub_total'], 2, ',', '.') . "</td>";
          echo "</tr>";
        }
        ?>
        <tr>
          <td colspan="3"><strong>Jumlah Total Barang:</strong></td>
          <td><strong>Rp. <?php echo number_format($total_barang, 2, ',', '.'); ?></strong></td>
        </tr>
      </tbody>
    </table>

    <h2 class="mt-4">Informasi Pembelian</h2>
    <form enctype="multipart/form-data" method="post" action="checkout_aksi.php">
      <div class="form-group">
        <label for="nama">Nama Penerima:</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="form-group">
        <label for="alamat">Alamat Tujuan:</label>
        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
      </div>

      <div class="form-group">
        <label for="jasa_kirim">Pilihan Pengiriman:</label>
        <select class="form-control" id="jasa_kirim" name="jasa_kirim">
          <option value="11">POS Indonesia</option>
          <option value="22">JNE Express</option>
          <option value="33">J&T Express</option>
          <option value="44">Anter Aja</option>
          <option value="55">SiCepat</option>
          <option value="66">Ninja Express</option>
        </select>
      </div>

      <div class="form-group">
        <label for="jumlah_total">Jumlah Total:</label>
        <input type="hidden" id="total" name="total_harga" value="<?php echo $total_harga; ?>">
        <input type="text" id="total_display" value="Rp. <?php echo number_format($total_harga, 2, ',', '.'); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="transfer"> Transfer Ke : <br> BRI 081234909 a/n Admin <br>Shopeepay 081234909 a/n Admin <br>Gopay 081234909 a/n Admin <br>Dana 081234909 a/n Admin </label>
      </div>

      <div class="form-group">      
        <label for="bukti_pembayaran">Unggah Bukti Pembayaran:</label>
        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" required>
      </div>
      
      <a href="/user/pesanan.php" class="btn btn-secondary" data-bs-dismiss="modal" style="width:10%; margin-bottom:20px;">Batal</a>
      <button type="submit" class="btn btn-primary" id="beliBtn" style="width:10%; margin-bottom:20px; margin-left:20px;">Beli</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  $(document).ready(function() {
    $('#jasa_kirim').change(function() {
      var jasaKirimId = $(this).val();

      $.ajax({
        url: 'hitung_total.php',
        method: 'POST',
        data: { jasa_kirim: jasaKirimId },
        success: function(response) {
          $('#total').val(response); // Mengubah nilai pada input, bukan elemen teks
          $('#total_display').val('Rp. ' + response); // Menampilkan nilai pada elemen teks
        }
      });
    });
  });
  </script>
</body>
</html>