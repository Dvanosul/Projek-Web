<?php
include '../koneksi.php';

if ($_POST) {
    // Mendapatkan data yang dikirim melalui POST
    $pesananId = $_POST['pesanan_id'];
    $statusId = $_POST['status_id'];

    // Verifikasi nilai status_id ada di tabel status
    $checkStatusQuery = "SELECT * FROM status WHERE id = $statusId";
    $checkStatusResult = pg_query($conn, $checkStatusQuery);

    if (pg_num_rows($checkStatusResult) == 0) {
        echo "Status ID tidak valid.";
        exit;
    }

    // Memperbarui status pesanan di database
    $query = "UPDATE pesanan SET status_id = $statusId WHERE id = $pesananId";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "Status pesanan berhasil diperbarui.";
        header('Location: pesanan2.php');
        exit;
    } else {
        echo "Gagal memperbarui status pesanan. Error: " . pg_last_error($conn);
    }
}
?>
