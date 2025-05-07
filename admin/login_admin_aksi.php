<?php
include '../koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Catatan: Password belum di-hash di sini (lihat catatan di bawah)
$sql = "SELECT * FROM kasir WHERE username = '$username' AND password = '$password'";
$result = pg_query($conn, $sql);

if (pg_num_rows($result) == 1) {
    $row = pg_fetch_assoc($result);
    $_SESSION['nama'] = $row['nama'];
    header("Location: home2.php");
    exit;
} else {
    echo "Login gagal. Silakan coba lagi.";
}
?>
