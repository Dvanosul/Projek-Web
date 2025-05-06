<!DOCTYPE html>
<html>

<head>
    <title>Pilih User</title>
    <!-- Tambahkan link CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .header {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Silahkan Pilih User</h1>
        </div>

        <div class="row justify-content-center">
        <div class="col-md-2">
                <a href="admin/login_admin.php" class="btn btn-primary btn-lg btn-block">Admin</a>
            </div>
            <div class="col-md-2">
                <a href="user/login_user.php" class="btn btn-primary btn-lg btn-block">Pelanggan</a>
            </div>
        </div>
    </div>

    <!-- Tambahkan script JS Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>