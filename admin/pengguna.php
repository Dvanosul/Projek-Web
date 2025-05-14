<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
      <a class="navbar-brand ml-5" href="#"><b>Panel Admin Toko ATeKa</b></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="home2.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="pengguna.php">Pengguna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="produk.php">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="pesanan2.php">Pesanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mx-2" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten -->

  <div class="container">
    <div class="row">
      <h1>Daftar Pengguna</h1>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Telepon</th>
            <th scope="col">Kode Pos</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menghubungkan ke database menggunakan ODBC
          include '../koneksi.php';

          // Mengambil data pengguna dari tabel pengguna
          $query = "SELECT * FROM pelanggan";
          $result = pg_query($conn, $query);
          // Menampilkan data pengguna dalam tabel
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>" . $row['id'] . "</th>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['alamat'] . "</td>";
            echo "<td>" . $row['telepon'] . "</td>";
            echo "<td>" . $row['kode_pos'] . "</td>";
            echo "<td>";
            ?>
          <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pengguna-<?php echo $row['id'] ?>" style="width:100px;">Edit</a>
            <?php
            echo "</td>";
            echo "</tr>";
            ?>
             <!-- Modal Edit Pengguna-->
        <div class="modal fade" id="pengguna-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modal-<?php echo $row['id']; ?>-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-<?php echo $row['id']; ?>-label">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit produk -->
                        <form action="edit_pengguna.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data">
                            <!-- Input nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                            </div>
                            
                            <!-- Input deskripsi -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                            </div>
                            
                            <!-- Input harga -->
                            <div class="mb-3">
                                <label for="Alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                            </div>
                            
                            <!-- Input stok -->
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="number" class="form-control" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" required>
                            </div>
                            
                            <!-- Tombol simpan -->
                            <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Batal</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
            <?php
          }
          pg_close($conn);
          ?>
        </tbody>
      </table>
    </div>
    <div class="row">
      <h1>Daftar Admin</h1>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Telepon</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menghubungkan ke database menggunakan ODBC
          include '../koneksi.php';

          // Mengambil data pengguna dari tabel pengguna
          $query = "SELECT * FROM kasir";
          $result = pg_query($conn, $query);

          // Menampilkan data pengguna dalam tabel
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>" . $row['id'] . "</th>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['alamat'] . "</td>";
            echo "<td>" . $row['telepon'] . "</td>";
            echo "<td>";
            echo "<a href='#' class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#kasir-". $row['id'] ."' style='width:100px'>Edit</a>";
          
            echo "</td>";
            echo "</tr>";
            ?>
                         <!-- Modal edit-->
        <div class="modal fade" id="kasir-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modal-<?php echo $row['id']; ?>-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kasir-<?php echo $row['id']; ?>-label">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit produk -->
                        <form action="edit_kasir.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data">
                            <!-- Input nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                            </div>
                            
                            <!-- Input Alamat -->
                            <div class="mb-3">
                                <label for="Alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                            </div>
                            
                            <!-- Input Telepon -->
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="number" class="form-control" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" required>
                            </div>
                            
                            <!-- Tombol simpan -->
                            <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Batal</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <?php
          }
          pg_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div> <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></>
  
</body>

</html>