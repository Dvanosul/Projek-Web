<?php
include '../koneksi.php';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

// Use prepared statement for security
$sql = "SELECT * FROM pelanggan WHERE username=$1 AND password=$2";
$result = pg_query_params($conn, $sql, [$username, $password]);

if ($result && pg_num_rows($result) == 1) {
    $row = pg_fetch_assoc($result);
    $_SESSION['nama'] = $row['nama'];
    // You may want to store more user information in session
    $_SESSION['user_id'] = $row['id'];
    
    header("location:home.php"); // Changed to relative path
    exit;
} else {
    echo "Login gagal. Silakan coba lagi.";
}
?>