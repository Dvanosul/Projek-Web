<?php
$servername = "localhost";
$username = "postgres";
$password = "zamzamakbar";
$dbname = "TOKO_ATK";
$konek = odbc_connect("DRIVER={PostgreSQL Unicode(x64)};Server=$servername;Database=$dbname;Port=5432;String Types=Unicode", $username, $password);

if (!$konek) {
    die("Koneksi Gagal: " );
}

?>