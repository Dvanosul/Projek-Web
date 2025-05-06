<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nama'])) {
  // Jika tidak, alihkan ke halaman login atau lakukan tindakan lain
  header('Location: login_user.php'); // Gunakan relative path
  exit;
}

// Koneksi ke database
include '../koneksi.php';

// Ambil data pengguna dari database
$nama = $_SESSION['nama'];

// Update informasi foto profil pengguna di database
$updateSql = "UPDATE pelanggan SET profil = NULL WHERE nama = $1";
$result = pg_query_params($conn, $updateSql, [$nama]);

if($result) {
  $_SESSION['success'] = 'Foto profil berhasil dihapus.';
} else {
  $_SESSION['error'] = 'Gagal menghapus foto profil: ' . pg_last_error($conn);
}

header('Location: akun.php'); // Gunakan relative path
exit;
?>