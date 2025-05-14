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

// Menggunakan parameterized query untuk keamanan dan menambahkan ID yang dihasilkan
$sql = "INSERT INTO kasir (id, nama, alamat, telepon, username, password) 
        VALUES (nextval('kasir_id_seq'), $1, $2, $3, $4, $5)";
        
$result = pg_query_params($conn, $sql, [$nama, $alamat, $telepon, $username, $password]);

// cek hasil query
if ($result) {
    echo "<script>alert('Data berhasil didaftarkan!'); window.location.href='login_admin.php';</script>";
} else {
    echo "<script>alert('Pendaftaran gagal: " . pg_last_error($conn) . "'); window.history.back();</script>";
}
?>