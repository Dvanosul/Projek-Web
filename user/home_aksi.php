<?php
include '../koneksi.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$namaPelanggan = $_POST['nama_pelanggan'];
$idBarang = $_POST['id_barang'];
$pengiriman = $_POST['jasa_kirim'];
$jumlahProduk = $_POST['jumlah_produk'];

// Query untuk mendapatkan harga barang berdasarkan ID barang
$queryHargaBarang = "SELECT harga FROM barang WHERE id = $1";
$resultHargaBarang = pg_query_params($conn, $queryHargaBarang, [$idBarang]);

if (!$resultHargaBarang) {
    die("Error saat mengambil harga barang: " . pg_last_error($conn));
}

$rowHargaBarang = pg_fetch_assoc($resultHargaBarang);

// Ambil harga barang
$hargaBarang = $rowHargaBarang['harga'];
$nama = $_SESSION['nama'];

// Query untuk mendapatkan ID pelanggan berdasarkan nama pelanggan
$queryIdPelanggan = "SELECT id, sudah_pernah_transaksi FROM pelanggan WHERE nama = $1";
$resultIdPelanggan = pg_query_params($conn, $queryIdPelanggan, [$nama]);

if (!$resultIdPelanggan) {
    die("Error saat mengambil ID pelanggan: " . pg_last_error($conn));
}

$rowIdPelanggan = pg_fetch_assoc($resultIdPelanggan);

// Ambil ID pelanggan dan status transaksi
$idPelanggan = $rowIdPelanggan['id'];
$sudahTransaksi = $rowIdPelanggan['sudah_pernah_transaksi'];

// Jika pengguna belum melakukan transaksi sebelumnya
if ($sudahTransaksi == FALSE) {
    // Buat transaksi baru dengan ID manual berbasis timestamp
    $idTransaksi = time(); // Atau bisa menggunakan: $idTransaksi = mt_rand(1000000000, 9999999999);
    
    // Perbaikan: Sertakan kolom id dalam query
    $queryTambahTransaksi = "INSERT INTO transaksi (id, pelanggan_id) VALUES ($1, $2)";
    $resultTambahTransaksi = pg_query_params($conn, $queryTambahTransaksi, [$idTransaksi, $idPelanggan]);
    
    if (!$resultTambahTransaksi) {
        die("Error saat membuat transaksi baru: " . pg_last_error($conn));
    }
    
    $_SESSION['transaksi_id'] = $idTransaksi;

    // Setel kolom sudah_transaksi menjadi TRUE untuk pengguna
    $querySetSudahTransaksi = "UPDATE pelanggan SET sudah_pernah_transaksi = TRUE WHERE id = $1";
    pg_query_params($conn, $querySetSudahTransaksi, [$idPelanggan]);

    // Tambahkan item baru ke transaksi
    $total = (float) $hargaBarang * $jumlahProduk;
    $queryTambahTransaksiBarang = "INSERT INTO transaksi_barang (transaksi_id, barang_id, jumlah, sub_total) VALUES ($1, $2, $3, $4)";
    $resultTambahBarang = pg_query_params($conn, $queryTambahTransaksiBarang, [$idTransaksi, $idBarang, $jumlahProduk, $total]);
    
    if (!$resultTambahBarang) {
        die("Error saat menambahkan barang ke transaksi: " . pg_last_error($conn));
    }
} else {
    // Jika pengguna telah melakukan transaksi sebelumnya, gunakan ID transaksi sebelumnya
    if (!isset($_SESSION['transaksi_id'])) {
        // Kode untuk mengambil ID transaksi
        $ambil_transaksi_id = "SELECT t.id FROM transaksi t INNER JOIN pelanggan p ON t.pelanggan_id=p.id WHERE p.nama = $1 LIMIT 1";
        $hasil_ambil = pg_query_params($conn, $ambil_transaksi_id, [$nama]);
        
        if (!$hasil_ambil || pg_num_rows($hasil_ambil) == 0) {
            // Jika tidak ada transaksi sebelumnya, buat baru
            $idTransaksi = time(); // Atau gunakan mt_rand(1000000000, 9999999999);
            $queryTambahTransaksi = "INSERT INTO transaksi (id, pelanggan_id) VALUES ($1, $2)";
            $resultTambahTransaksi = pg_query_params($conn, $queryTambahTransaksi, [$idTransaksi, $idPelanggan]);
            
            if (!$resultTambahTransaksi) {
                die("Error saat membuat transaksi baru: " . pg_last_error($conn));
            }
        } else {
            $row_ambil = pg_fetch_assoc($hasil_ambil);
            $idTransaksi = $row_ambil['id'];
        }
    } else {
        $idTransaksi = $_SESSION['transaksi_id'];
    }
 
    // Periksa apakah barang dengan ID yang sama sudah ada dalam transaksi
    $queryCekBarang = "SELECT * FROM transaksi_barang WHERE transaksi_id = $1 AND barang_id = $2";
    $resultCekBarang = pg_query_params($conn, $queryCekBarang, [$idTransaksi, $idBarang]);

    // Jika barang sudah ada, update jumlahnya
    if (pg_num_rows($resultCekBarang) > 0) {
        $queryUpdateJumlah = "UPDATE transaksi_barang SET jumlah = jumlah + $1, sub_total = (jumlah + $1) * $2 WHERE transaksi_id = $3 AND barang_id = $4";
        $resultUpdate = pg_query_params($conn, $queryUpdateJumlah, [$jumlahProduk, $hargaBarang, $idTransaksi, $idBarang]);
        
        if (!$resultUpdate) {
            die("Error saat memperbarui jumlah barang: " . pg_last_error($conn));
        }
    } else {
        // Barang belum ada, tambahkan item baru ke transaksi
        $total = (float) $hargaBarang * $jumlahProduk;
        $queryTambahTransaksiBarang = "INSERT INTO transaksi_barang (transaksi_id, barang_id, jumlah, sub_total) VALUES ($1, $2, $3, $4)";
        $resultTambah = pg_query_params($conn, $queryTambahTransaksiBarang, [$idTransaksi, $idBarang, $jumlahProduk, $total]);
        
        if (!$resultTambah) {
            die("Error saat menambahkan barang baru ke transaksi: " . pg_last_error($conn));
        }
    }
}

// Set session transaksi_id
$_SESSION['transaksi_id'] = $idTransaksi;

// Redirect ke halaman pesanan
header("Location: pesanan.php");
exit;
?>