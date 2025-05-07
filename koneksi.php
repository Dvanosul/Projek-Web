<?php
$servername = "localhost";
$username = "postgres";
$password = "admin";
$dbname = "toko_atk";


$conn = pg_connect("host=$servername port=5432 dbname=$dbname user=$username password=$password");

if (!$conn) {
    die("Koneksi GAGAL " . pg_last_error());
}
?>