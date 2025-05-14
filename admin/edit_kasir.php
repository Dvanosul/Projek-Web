<?php
    // koneksi database
    session_start();
    include '../koneksi.php';
    // menangkap data yang di kirim dari form
    $id=$_GET['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

   
    

    $sql = "UPDATE kasir SET nama='$nama', alamat='$alamat', telepon='$telepon' WHERE id ='$id'";

        // Eksekusi query
        if (pg_query($conn, $sql)) {
            echo "Data produk berhasil diperbarui.";
            header('location: pengguna.php');
        } 


?>