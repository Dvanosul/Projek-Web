<?php
// koneksi database
session_start();
include '../koneksi.php';

// menangkap data yang dikirim dari form
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$username = $_POST['username'];
$password = $_POST['password'];

// query insert
$sql = "INSERT INTO kasir (nama, alamat, telepon, username, password) 
        VALUES ('$nama', '$alamat', '$telepon', '$username', '$password')";
$result = pg_query($conn, $sql);

// cek hasil query
if ($result) {
    echo "<script>alert('Data berhasil didaftarkan!'); window.location.href='login_admin.php';</script>";
} else {
    echo "<script>alert('Pendaftaran gagal: " . pg_last_error($conn) . "'); window.history.back();</script>";
}
?>
