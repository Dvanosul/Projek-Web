<?php
include '../koneksi.php';


  $barangId =$_GET['id'];

  // Hapus barang dari tabel transaksi_barang berdasarkan ID barang
  $queryHapusBarang ="DELETE FROM barang WHERE id = '$barangId'";
  $result = odbc_exec($conn, $queryHapusBarang);
  if(!$result){
    echo 'data tidak bisa dihapus';
  }
  header('location:/admin/produk.php');

  // Redirect kembali ke halaman keranjang
 // header("Location: /admin/produk.php");
?>
