<?php
    // koneksi database
    session_start();
    include '../koneksi.php';
    // menangkap data yang di kirim dari form

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $username = $_POST['username'];
    $password = $_POST['password'];    
    

    $sql = "INSERT INTO kasir (nama, alamat, telepon, username, password) Values 
    ('$nama','$alamat', '$telepon', '$username', '$password')";
    $result = odbc_exec($conn, $sql);


    header("location:login_admin.php");
?>