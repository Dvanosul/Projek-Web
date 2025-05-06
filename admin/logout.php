<?php
session_start(); // Memulai session

// Hapus semua data session
unset($_SESSION['nama']);


// Redirect ke halaman login atau halaman lain yang diinginkan
header("Location: ../index.php");

?>