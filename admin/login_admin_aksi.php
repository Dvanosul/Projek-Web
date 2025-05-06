<?php
include '../koneksi.php';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM kasir WHERE username='$username' AND password='$password'";
$result = odbc_exec($conn, $sql);

if (odbc_num_rows($result) == 1) {

    while ($row = odbc_fetch_array($result)) {
        $_SESSION['nama'] = $row['nama'];
    }

    header("location:home2.php");
} else {
    echo "Login gagal. Silakan coba lagi.";
}

?>