<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
    <a class="navbar-brand ml-5" href="#"><b>Panel Admin Toko ATeKa</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
  <div class="container mt-4">
    <h1>Selamat datang di Panel Admin</h1>
    <p>Ini adalah dashboard utama untuk mengelola website.</p>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Pengguna</h5>
            <p class="card-text">Kelola pengguna dan izin mereka.</p>
            <a href="pengguna.php" class="btn btn-primary">Pergi ke Pengguna</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Produk</h5>
            <p class="card-text">Kelola produk dan detailnya.</p>
            <a href="produk.php" class="btn btn-primary">Pergi ke Produk</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
