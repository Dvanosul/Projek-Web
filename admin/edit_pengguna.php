<?php
    // koneksi database
    session_start();
    include '../koneksi.php';
    // menangkap data yang di kirim dari form
    $id=$_GET['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $username = $_POST['username'];
   
    

    $sql = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', telepon='$telepon', username='$username' WHERE id ='$id'";

        // Eksekusi query
        if (odbc_exec($conn, $sql)) {
            echo "Data produk berhasil diperbarui.";
            header('location: /admin/pengguna.php');
        } 


?>