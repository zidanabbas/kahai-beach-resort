<?php

require './koneksi.php';

if (isset($_POST['btn_submit'])) {
    global $conn;

    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = 'admin';

    mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password','','','','$level') ");
}

if (isset($_POST['btn_update'])) {
    global $conn;

    $id = $_GET['id'];

    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn, "UPDATE user SET username = '$username', password = '$password' WHERE id = '$id' ");
}

if ($_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM user WHERE id = '$id' ");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Hebat | CRUD PHP NATIVE</title>

    <!-- Custom fonts for this template-->
    <link href="./layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="./layout/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./style/main.css">
</head>

<body>
    <div class="container py-5">
        <h1>Daftar Akun</h1>
        <p>Jangan salah memasukkan data</p>

        <?php
        if ($_GET['id'] != '') {
            $id = $_GET['id'];

            $sql = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id' ");
            $data = mysqli_fetch_assoc($sql);

            $username = $data['username'];
            $password = $data['password'];
        } else {
            $username = '';
            $password = '';
        }
        ?>

        <form action="" method="post">
            <label class="" for="">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $username ?>" required>

            <label for="">Password</label>

            <!-- Tambahkan Ini Setelah Istirahat ! -->
            <div class="input-group">
                <input type="password" class="form-control" name="password" value="<?= $password ?>" id="iPW" style="border-right: none;" required>
                <i class="fas fa-eye" style="cursor: pointer; width: 10px; padding-top: 10px; padding-right:20px; border-right:none;" id="iPWC"></i>
            </div>

            <!-- <input type="submit" name="btn_submit" value="Tambah"> -->
            <button type="submit" class="btn btn-primary mt-3 d-inline" name="btn_submit"><i class="fas fa-plus"></i> Tambah</button>


            <button type="submit" class="btn btn-warning mt-3 d-inline" name="btn_update"><i class="fas fa-edit"></i> Update</button>

            <a href="./create.php" class="btn btn-success my-1"><i class="fas fa-refresh"></i> Refresh</a>

        </form>

        <a href="./cetakbaru.php" class="btn btn-sm btn-danger"><i class="fas fa-print"></i> Cetak Laporan</a>

        <table class="table mt-5">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            $sql = mysqli_query($conn, "SELECT * FROM user WHERE level = 'admin' ");
            while ($data = mysqli_fetch_assoc($sql)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['username'] ?></td>
                    <td><?= $data['password'] ?></td>
                    <td><?= $data['level'] ?></td>
                    <td>
                        <a href="./create.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                        <a href="./create.php?id=<?= $data['id'] ?>&aksi=hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <script>
        const iPW = document.getElementById('iPW');
        const iPWC = document.getElementById('iPWC');

        iPWC.addEventListener('click', function() {
            if (iPW.type == 'password') {
                iPW.setAttribute('type', 'text');
                iPWC.setAttribute('class', 'fas fa-eye-slash');
            } else {
                iPW.setAttribute('type', 'password');
                iPWC.setAttribute('class', 'fas fa-eye');
            }
        })
    </script>
</body>

</html>