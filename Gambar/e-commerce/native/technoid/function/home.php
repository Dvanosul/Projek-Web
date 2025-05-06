<?php
session_start();
include'koneksi.php';



function home()
{
    global $konek;

    $pd = odbc_exec($konek, "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 10");
    $produks = [];
    while ($produk = odbc_fetch_array($pd)) {
        $produks[] = $produk;
    }
    $data = [
        'judul' => 'Selamat Datang di TechnoId',
        'produk' => $produks,
    ];
    return $data;
}
