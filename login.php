<?php

session_start();

$title = "Masuk";
require 'koneksi.php';

if (isset($_SESSION['admin'])) {
    header('location:index.php');
} elseif (isset($_SESSION['resepsionis'])) {
    header('location:index.php');
}


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password' ");
    $hasil = mysqli_fetch_assoc($result);

    // Cek Username dan password
    if (mysqli_num_rows($result) === 1) {
        // set session
        if ($hasil['level'] == 'admin') {
            $_SESSION['admin'] = $hasil['username'];
            // header('location:./admin/index.php');
            echo "<script>alert('Login Berhasil!'); window.location.href = './admin/index.php';</script>";
        } elseif ($hasil['level'] == 'resepsionis') {
            $_SESSION['resepsionis'] = $hasil['username'];
            // header('location:./resepsionis/index.php');
            echo "<script>alert('Login Berhasil!'); window.location.href = './resepsionis/index.php';</script>";
        } elseif ($hasil['level'] == 'pemesan') {
            $_SESSION['pemesan'] = $hasil['username'];
            // header('location:index.php');
            echo "<script>alert('Login Berhasil!'); window.location.href = './index.php';</script>";
        }
    }

    $error = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './layouts/heading.php'; ?>
</head>

<body>
    <div class="col-md-12" style="padding-top: 100px;">


        <div class="card card-rounded border-light mx-auto shadow" style="width: 30rem;">
            <a href="./index.php" class="btn btn-info btn-sm w-25 m-3 mb-0"><i class="fas fa-arrow-left mr-2"></i>Beranda</a>
            <h3 class="text-center fw-bold">MASUK</h3>
            <div class="mx-5 pb-5">

                <?php if (isset($error)) : ?>
                    <?php
                    echo "<script>
                            alert('username atau password salah, silahkan di cek kembali');
                        </script>"
                    ?>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password anda" required>
                    </div>
                    <div class="pt-2 text-center fill">
                        <input type="submit" class="btn btn-primary w-100 mb-3" name="login" value="Masuk">
                    </div>
                    <hr>
                    <div class="col-md-12 text-center">
                        <a href="./daftar.php" class="text-gray">Daftar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include './layouts/js.php';
    ?>

</body>

</html>