<?php
include '../koneksi.php';

if ($_POST) {
  // Mendapatkan data yang dikirim melalui POST
  $pesananId = $_POST['pesanan_id'];
  $statusId = $_POST['status_id'];

  // Memperbarui status pesanan di database
  $query = "UPDATE pesanan SET status_id = $statusId WHERE id = $pesananId";
  $result = pg_query($conn, $query);

  if ($result) {
    echo "Status pesanan berhasil diperbarui.";
    header('LOcation:pesanan2.php');
  } else {
    echo "Gagal memperbarui status pesanan.";
  }
}
?>
`