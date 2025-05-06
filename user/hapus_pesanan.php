<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
  $barangId = $_GET['id'];

  // Hapus barang dari tabel transaksi_barang berdasarkan ID barang
  $queryHapusBarang = "DELETE FROM transaksi_barang WHERE barang_id = $barangId";
  odbc_exec($conn, $queryHapusBarang);

  // Redirect kembali ke halaman keranjang
  header("Location: /user/pesanan.php");
  exit();
}
?>
