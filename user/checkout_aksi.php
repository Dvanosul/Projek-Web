<?php
session_start();
error_log("Checkout dimulai untuk transaksi ID: " . $_SESSION['transaksi_id']);
include '../koneksi.php';

// Memastikan form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $alamat = $_POST['alamat'];
  $jasaKirimId = $_POST['jasa_kirim'];
  $buktiPembayaran = $_FILES['bukti_pembayaran'];
  $total = $_POST['total_harga'];
  $penerima = $_POST['nama'];

  // Mengambil ID transaksi dari session
  $idTransaksi = $_SESSION['transaksi_id'];
  $nama = $_SESSION['nama'];
  
  // Menghapus tanda titik (.) dan koma (,) dari format angka
  $total = str_replace('.', '', $total);
  $total = str_replace(',', '.', $total);

  // Update data di tabel transaksi
  $sqlTransaksi = "UPDATE transaksi SET kirim_id = $1, total = $2, alamat_detail = $3 WHERE id = $4";
  $resultTransaksi = pg_query_params($conn, $sqlTransaksi, [$jasaKirimId, $total, $alamat, $idTransaksi]);
  
  if (!$resultTransaksi) {
    die("Error saat update transaksi: " . pg_last_error($conn));
  }

  // Simpan nama file bukti pembayaran ke dalam database
  $namaFileBukti = basename($buktiPembayaran['name']);
  $sqlBuktiPembayaran = "UPDATE transaksi SET bukti = $1 WHERE id = $2";
  $resultBukti = pg_query_params($conn, $sqlBuktiPembayaran, [$namaFileBukti, $idTransaksi]);
  
  if (!$resultBukti) {
    die("Error saat update bukti pembayaran: " . pg_last_error($conn));
  }

  // Simpan file bukti pembayaran ke dalam direktori uploads
  $uploadDir = '../Gambar/bukti/';
  // Buat direktori jika belum ada
  if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }
  
  $buktiPembayaranPath = $uploadDir . $namaFileBukti;
  if (!move_uploaded_file($buktiPembayaran['tmp_name'], $buktiPembayaranPath)) {
    die("Error saat upload file bukti pembayaran");
  }

  // Menduplikat data ke tabel pesanan
  $queryTransaksi = "INSERT INTO pesanan (id, pelanggan_id, kirim_id, alamat_detail, total, bukti)
                  SELECT id, pelanggan_id, kirim_id, alamat_detail, total, bukti
                  FROM transaksi WHERE id = $1";
  $resultPesanan = pg_query_params($conn, $queryTransaksi, [$idTransaksi]);
  
  if (!$resultPesanan) {
    die("Error saat insert ke tabel pesanan: " . pg_last_error($conn));
  }

  // Menduplikat data ke tabel pesanan_barang
  $queryTransaksiBarang = "INSERT INTO pesanan_barang (pesanan_id, barang_id, jumlah, sub_total)
                        SELECT transaksi_id, barang_id, jumlah, sub_total
                        FROM transaksi_barang WHERE transaksi_id = $1";
  $resultPesananBarang = pg_query_params($conn, $queryTransaksiBarang, [$idTransaksi]);
  
  if (!$resultPesananBarang) {
    die("Error saat insert ke tabel pesanan_barang: " . pg_last_error($conn));
  }

  // Update nama penerima di tabel pesanan
  $nama_penerima = "UPDATE pesanan SET nama_penerima = $1 WHERE id = $2";
  $resultNamaPenerima = pg_query_params($conn, $nama_penerima, [$penerima, $idTransaksi]);
  
  if (!$resultNamaPenerima) {
    die("Error saat update nama penerima: " . pg_last_error($conn));
  }

  // Mengurangi stok barang
  $queryUpdateStok = "UPDATE barang
  SET stok = stok - (
      SELECT jumlah
      FROM transaksi_barang
      WHERE transaksi_id = $1
        AND barang_id = barang.id
  )
  WHERE barang.id IN (
      SELECT barang_id
      FROM transaksi_barang
      WHERE transaksi_id = $1
  )";
  $resultUpdateStok = pg_query_params($conn, $queryUpdateStok, [$idTransaksi]);
  
  if (!$resultUpdateStok) {
    die("Error saat update stok barang: " . pg_last_error($conn));
  }
  
  // Hapus transaksi_id dari tabel transaksi_barang berdasarkan ID transaksi
  $queryHapustransaksibarang = "DELETE FROM transaksi_barang WHERE transaksi_id = $1";
  $resultHapusTransaksiBarang = pg_query_params($conn, $queryHapustransaksibarang, [$idTransaksi]);
  
  if (!$resultHapusTransaksiBarang) {
    die("Error saat hapus transaksi_barang: " . pg_last_error($conn));
  }
  
  // Hapus id dari tabel transaksi berdasarkan ID transaksi
  $queryHapustransaksiid = "DELETE FROM transaksi WHERE id = $1";
  $resultHapusTransaksi = pg_query_params($conn, $queryHapustransaksiid, [$idTransaksi]);
  
  if (!$resultHapusTransaksi) {
    die("Error saat hapus transaksi: " . pg_last_error($conn));
  }

  // Reset status transaksi pelanggan
  $updatetransaksi = "UPDATE pelanggan SET sudah_pernah_transaksi = false WHERE nama = $1";
  $resultUpdatePelanggan = pg_query_params($conn, $updatetransaksi, [$nama]);
  
  if (!$resultUpdatePelanggan) {
    die("Error saat update status pelanggan: " . pg_last_error($conn));
  }

  // Hapus session transaksi_id
  unset($_SESSION['transaksi_id']);
  
  // Redirect ke halaman transaksi
  header("Location: transaksi.php");
  exit();
} else {
  // Redirect ke halaman checkout jika form tidak disubmit
  header("Location: checkout.php");
  exit();
}
?>