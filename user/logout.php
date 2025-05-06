<?php
session_start(); // Memulai session

// Hapus semua data session
unset($_SESSION['nama']);
unset($_SESSION['transaksi_id']);

// Redirect ke halaman login atau halaman lain yang diinginkan
header("Location: ../index.php");

?>