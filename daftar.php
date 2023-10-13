<?php

session_start();

$title = "Daftar";
require 'koneksi.php';

if (isset($_SESSION['admin'])) {
    header('location:index.php');
} elseif (isset($_SESSION['resepsionis'])) {
    header('location:index.php');
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];

    // CEK USERNAME
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username' ");
    $hasil = mysqli_fetch_assoc($result);

    if ($hasil) {
        // Jika username sudah ada, tampilkan notifikasi
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password','$nama','$email','$no_telp','pemesan') ");
        // Jika berhasil mendaftar, tampilkan notifikasi dan redirect ke halaman login
        echo "<script>alert('Registrasi Berhasil!'); window.location.href = './login.php';</script>";
    }
}

// if (isset($_POST['login'])) {

//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     $nama = $_POST['nama'];
//     $email = $_POST['email'];
//     $no_telp = $_POST['no_telp'];

//     // CEK USERNAME
//     $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username' ");
//     $hasil = mysqli_fetch_assoc($result);

//     if ($hasil) {
//         $error = true;
//     } else {
//         mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password','$nama','$email','$no_telp','pemesan') ");
//         $correct = true;
//         header('location:./login.php');
//     }
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './layouts/heading.php'; ?>
</head>

<body>
    <div class="col-md-8 mx-auto" style="padding: 5% 0;">

        <div class="card card-rounded border-light mx-auto shadow">
            <a href=" ./index.php" class="btn btn-info btn-sm m-3 mb-0" style="width: 100px;"><i class="fas fa-arrow-left mr-2"></i>Beranda</a>
            <h3 class="text-center fw-bold">DAFTAR</h3>
            <div class="mx-5 pb-5">
                <form action="" method="post">
                    <div class="col-md-12">

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Masukkan username anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Masukkan password anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Masukkan email anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No Telpon</label>
                                    <input type="text" class="form-control" name="no_telp" placeholder="Masukkan nomor telpon anda" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center pt-2">
                                    <input type="submit" class="btn btn-primary w-100 mb-3" name="login" value="Daftar">
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="col-md-12 text-center">
                        <a href="./login.php" class="text-gray">Masuk</a>
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