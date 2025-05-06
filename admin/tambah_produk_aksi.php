<?php
// Koneksi ke database ODBC
include '../koneksi.php';

// Cek apakah ada data yang dikirim melalui metode POST
if ($_POST) {
  if (!empty($_POST["nama"]) && !empty($_POST["harga"]) && !empty($_POST["stok"]) && !empty($_POST["jumlah_beli"]) && !empty($_FILES["gambar"]["name"])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jumlah_beli = $_POST['jumlah_beli'];

    // Proses upload gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../Gambar/produk/' . $gambar; // Ganti dengan path direktori upload yang sesuai

    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
      // Query untuk menyimpan data ke database
      $query = "INSERT INTO barang (nama_barang, deskripsi, harga, grosir_id, gambar, stok) 
            VALUES ('$nama', '$deskripsi', '$harga', '$jumlah_beli', '$gambar', '$stok')";

      // Eksekusi query
      if (odbc_exec($conn, $query)) {
        echo "Data produk berhasil disimpan.";
        header('location: /admin/produk.php');
        exit;
      } else {
        echo "Terjadi kesalahan dalam menyimpan data produk.";
      }
    } else {
      echo 'Gagal mengunggah gambar.';
    }
  } else {
    // Field tidak lengkap, tampilkan pesan kesalahan atau tindakan lainnya
    echo "Silakan isi semua field.";
  }
}

// Tutup koneksi ke database
odbc_close($conn);
?>
