<?php
include '../koneksi.php';

if ($_POST) {
  if (!empty($_POST["nama"]) && !empty($_POST["harga"]) && !empty($_POST["stok"]) && !empty($_POST["jumlah_beli"]) && !empty($_FILES["gambar"]["name"])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $grosir_id = $_POST['jumlah_beli']; // Ini adalah grosir_id

    $grosirMapping = [
      'aa' => 'GR001', // Satuan menjadi GR001
      'bb' => 'GR002'  // Pack menjadi GR002
    ];
    
    if (isset($grosirMapping[$grosir_id])) {
      $grosir_id = $grosirMapping[$grosir_id];
    }

    $validGrosirIds = ["GR001", "GR002", "GR003", "GR004"];
    if (!in_array($grosir_id, $validGrosirIds)) {
      echo "<script>alert('ID Grosir tidak valid. Harap pilih salah satu dari GR001, GR002, GR003, atau GR004.'); window.history.back();</script>";
      exit;
    }

    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../Gambar/produk/' . $gambar; 

    if (!file_exists('../Gambar/produk/')) {
      mkdir('../Gambar/produk/', 0777, true);
    }

    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
      $checkSeq = "SELECT setval('barang_id_seq', (SELECT COALESCE(MAX(id),0) FROM barang))";
      pg_query($conn, $checkSeq);

      $query = "INSERT INTO barang (id, nama_barang, deskripsi, harga, grosir_id, gambar, stok) 
                VALUES (nextval('barang_id_seq'), $1, $2, $3, $4, $5, $6)";

      if (pg_query_params($conn, $query, [$nama, $deskripsi, $harga, $grosir_id, $gambar, $stok])) {
        echo "<script>alert('Data produk berhasil disimpan.'); window.location.href='produk.php';</script>";
        exit;
      } else {
        echo "<script>alert('Terjadi kesalahan dalam menyimpan data produk: " . pg_last_error($conn) . "');</script>";
      }
    } else {
      echo "<script>alert('Gagal mengunggah gambar.');</script>";
    }
  } else {
    echo "<script>alert('Silakan isi semua field.');</script>";
  }
}

pg_close($conn);
?>