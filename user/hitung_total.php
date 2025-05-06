<?php
session_start();
include '../koneksi.php';

// Periksa apakah ada ID transaksi dalam session
if (!isset($_SESSION['transaksi_id'])) {
    echo "0,00"; // Kembalikan 0 jika tidak ada transaksi
    exit;
}

$idTransaksi = $_SESSION['transaksi_id'];
$total_barang = 0;

// Mengambil total harga barang
$queryBarang = "SELECT SUM(sub_total) as total FROM transaksi_barang WHERE transaksi_id = $1";
$resultBarang = pg_query_params($conn, $queryBarang, [$idTransaksi]);

// Periksa apakah query berhasil dan ada data
if ($resultBarang && pg_num_rows($resultBarang) > 0) {
    $rowBarang = pg_fetch_assoc($resultBarang);
    // Periksa apakah 'total' tidak NULL
    $total_barang = $rowBarang['total'] ? $rowBarang['total'] : 0;
}

// Mengambil ongkir
$ongkir = 0;
if (isset($_POST['jasa_kirim'])) {
    $jasaKirimId = $_POST['jasa_kirim'];
    $sql = "SELECT ongkir FROM jasa_kirim WHERE id = $1";
    $hasil = pg_query_params($conn, $sql, [$jasaKirimId]);
    
    // Periksa apakah query berhasil dan ada data
    if ($hasil && pg_num_rows($hasil) > 0) {
        $hasil_total = pg_fetch_assoc($hasil);
        $ongkir = $hasil_total['ongkir'];
    } else {
        // Jika tidak ada data jasa kirim, set ongkir default
        $ongkir = 0;
    }
}

// Menghitung total
$total_harga = $total_barang + $ongkir;

// Mengembalikan hasil dalam format yang sesuai
echo number_format($total_harga, 2, ',', '.');
?>