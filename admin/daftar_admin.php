<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center">DAFTAR ADMIN</h1>
        <form method="post" action="daftar_admin_aksi.php">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat">
                    </div>
                    <div class="form-group">
                        <label for="semester">Telepon</label>
                        <input type="text" class="form-control" name="telepon" id="telepon">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password">
                    </div>
                    <div class="text-center">
                        <a href="login_admin.php"><input type="submit" class="btn btn-secondary" value="Kembali"></a>
                        <input type="submit" class="btn btn-primary" value="Daftar">

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>