<?php
// Mulai sesi dan koneksi ke database
session_start();
include '../koneksi.php';

// Validasi: Pastikan method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap ID dari URL (GET), dan data dari form (POST)
    $id = $_GET['id'];
    $nama = pg_escape_string($conn, $_POST['nama']);
    $alamat = pg_escape_string($conn, $_POST['alamat']);
    $telepon = pg_escape_string($conn, $_POST['telepon']);
    $username = pg_escape_string($conn, $_POST['username']);

    // Query UPDATE
    $sql = "UPDATE pelanggan 
            SET nama='$nama', alamat='$alamat', telepon='$telepon', username='$username' 
            WHERE id='$id'";

    // Eksekusi query
    if (pg_query($conn, $sql)) {
        // Redirect ke halaman pengguna (pastikan path benar)
        header('Location: pengguna.php');
        exit(); // Penting untuk menghentikan eksekusi
    } else {
        echo "Gagal memperbarui data: " . pg_last_error($conn);
    }
} else {
    echo "Metode tidak diizinkan.";
}
?>
