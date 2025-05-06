<!DOCTYPE html>
<html>

<head>
    <title>Data Mahasiswa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>
            <center>Halo Admin</center>
        </h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form action="login_admin_aksi.php" method="post">
                    <div class="form-group">
                        <label for="txtUserId">User Name</label>
                        <input name="username" type="text" class="form-control" id="txtUserId">
                    </div>
                    <div class="form-group">
                        <label for="txtPassword">Password</label>
                        <input name="password" type="password" class="form-control" id="txtPassword">
                    </div>
                    <div class="form-group">
                        <input name="btnLogin" type="submit" class="btn btn-primary" id="btnLogin" value="Masuk">
                        <a href="daftar_admin.php" class="btn btn-secondary">Daftar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>