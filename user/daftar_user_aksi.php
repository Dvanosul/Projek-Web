<?php
    // koneksi database
    session_start();
    include '../koneksi.php';
    // menangkap data yang di kirim dari form

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $kode_pos = $_POST['kode_pos'];
    $username = $_POST['username'];
    $password = $_POST['password'];    
    
    $id = time(); 
    
    $sql = "INSERT INTO pelanggan (id, nama, alamat, telepon, kode_pos, username, password) 
            VALUES ($1, $2, $3, $4, $5, $6, $7)";
    
    $stmt = pg_prepare($conn, "insert_user", $sql);
    
    $result = pg_execute($conn, "insert_user", [$id, $nama, $alamat, $telepon, $kode_pos, $username, $password]);

    if (!$result) {
        die("Error in SQL query: " . pg_last_error($conn));
    }

    header("location:login_user.php");
?>