<?php
// Koneksi ke database ODBC
include '../koneksi.php';

// Cek apakah ada data yang dikirim melalui metode POST
if ($_POST) {
    if (!empty($_POST["nama"]) && !empty($_POST["harga"]) && !empty($_POST["stok"]) && !empty($_POST["jumlah_beli"])) {
        // Ambil data dari form
        $id = $_GET['id'];
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $jumlah_beli = $_POST['jumlah_beli'];

// Mendapatkan gambar sebelumnya
$query_get_previous_image = "SELECT gambar FROM barang WHERE id = '$id'";
$result_get_previous_image = odbc_exec($conn, $query_get_previous_image);
$row_get_previous_image = odbc_fetch_array($result_get_previous_image);
$previous_image = $row_get_previous_image['gambar'];

// Proses upload gambar jika ada perubahan
if (isset($_FILES["gambar"]["name"]) && !empty($_FILES["gambar"]["name"])) {
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../Gambar/produk/' . $gambar; // Ganti dengan path direktori upload yang sesuai
    $result = move_uploaded_file($gambar_tmp, $gambar_path);

    if (!$result) {
        echo 'Gagal mengunggah gambar.';
        exit;
    }

    // Perbarui gambar hanya jika ada perubahan
    if ($gambar != $previous_image) {
        // Query untuk perbarui data produk beserta gambar
        $query = "UPDATE barang SET
                    nama_barang = '$nama',
                    deskripsi = '$deskripsi',
                    harga = '$harga',
                    stok = '$stok',
                    grosir_id = '$jumlah_beli',
                    gambar = '$gambar'
                  WHERE id = '$id'";
    }
} else {
    // Jika tidak ada perubahan gambar, gunakan query tanpa perbarui gambar
    $query = "UPDATE barang SET
                nama_barang = '$nama',
                deskripsi = '$deskripsi',
                harga = '$harga',
                stok = '$stok',
                grosir_id = '$jumlah_beli'
              WHERE id = '$id'";
}

        // Eksekusi query
        if (odbc_exec($conn, $query)) {
            echo "Data produk berhasil diperbarui.";
            header('location: /admin/produk.php');
        } else {
            echo "Terjadi kesalahan dalam memperbarui data produk.";
        }
    } else {
        // Field tidak lengkap, tampilkan pesan kesalahan atau tindakan lainnya
        $error_message = "Silakan isi semua field.";
    }
}
?>
