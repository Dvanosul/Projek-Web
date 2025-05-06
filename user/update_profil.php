<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_POST) {
    include '../koneksi.php';

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $kodepos = $_POST['kode_pos'];
    $bio = $_POST['bio'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    
    // Ubah jenis kelamin menjadi 1 karakter saja (L/P)
    $jenis_kelamin = $_POST['jenis_kelamin'];
    if (strtolower($jenis_kelamin) === 'laki-laki' || strtolower($jenis_kelamin) === 'pria') {
        $jenis_kelamin = 'L';
    } elseif (strtolower($jenis_kelamin) === 'perempuan' || strtolower($jenis_kelamin) === 'wanita') {
        $jenis_kelamin = 'P';
    }
    
    // Ambil karakter pertama saja jika lebih dari 1 karakter
    if (strlen($jenis_kelamin) > 1) {
        $jenis_kelamin = substr($jenis_kelamin, 0, 1);
    }
    
    $warga_negara = $_POST['warga'];

    // Update data profil ke database dengan parameterized query untuk keamanan
    $sql = "UPDATE pelanggan SET 
            telepon = $1, 
            alamat = $2, 
            kode_pos = $3, 
            bio = $4, 
            tgl_lahir = $5, 
            agama = $6, 
            jenis_kelamin = $7, 
            warga = $8 
            WHERE nama = $9 AND username = $10";
            
    $result = pg_query_params(
        $conn, 
        $sql, 
        [
            $telepon,
            $alamat,
            $kodepos, 
            $bio, 
            $tgl_lahir, 
            $agama, 
            $jenis_kelamin,
            $warga_negara,
            $nama,
            $username
        ]
    );

    if ($result) {
        // Pembaruan berhasil
        $_SESSION['success'] = 'Profil berhasil diperbarui.';
        header('Location: akun.php');
        exit();
    } else {
        // Pembaruan gagal
        $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui profil: ' . pg_last_error($conn);
        header('Location: akun.php');
        exit();
    }
} else {
    header('Location: akun.php');
    exit();
}
?>