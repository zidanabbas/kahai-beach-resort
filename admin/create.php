<?php
session_start();
// error_reporting(0);

require '../koneksi.php';


if (!isset($_SESSION['admin'])) {
    header('location:../login.php');
} else {
    $user = $_SESSION['admin'];
    $title = 'Tambah Data';
}

require '../function.php';

if (isset($_POST['data_kamar'])) {
    if (data_kamar($_POST) > 0) {
        header("location: index.php");
    }
}

if (isset($_POST['data_fasilitas_kamar'])) {
    if (data_fasilitas_kamar($_POST) > 0) {
        header('location: fasilitas-kamar.php');
    }
}

if (isset($_POST['data_fasilitas_hotel'])) {
    if (data_fasilitas_hotel($_POST) > 0) {
        header('location: fasilitas-hotel.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './heading.php'; ?>

    <!-- CDN CKEDITOR -->
    <script src="//cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-none topbar mb-4 static-top shadow">

                    <a href="index.php" class="navbar-brand text-dark">Krakatau Kahai Beach Resort</a>


                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item">
                                <a class="nav-link" href="./index.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-bed"></i> Kamar</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="./fasilitas-kamar.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-bath"></i> Fasilitas Kamar</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="./fasilitas.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-sm-none d-lg-inline text-gray-600"><i class="fas fa-building"></i> Fasilitas Hotel</span>
                                </a>
                            </li>

                            <div class="topbar-divider d-none d-lg-block"></div>

                            <?php
                            if ($user == "") {
                            ?>
                                <li class="nav-item my-auto">
                                    <a href="" class="btn">Daftar</a>
                                    <a href="../login.php" class="btn btn-success">Masuk</a>
                                </li>
                            <?php
                            } elseif ($user != "") {
                                $sql = mysqli_query($conn, "SELECT * FROM user WHERE username = '$user' ");
                                $data = mysqli_fetch_assoc($sql);
                            ?>

                                <!-- Nav Item - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600">
                                            <?= $data['username'] ?>
                                        </span>
                                        <img class="img-profile rounded-circle d-none d-lg-inline" src="../layout/img/undraw_profile.svg">
                                        <button class="btn btn-link d-md-none rounded-circle">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Profile
                                        </a>

                                        <div class="dropdown-divider d-md-none"></div>

                                        <a class="dropdown-item d-md-none" href="./index.php">
                                            <i class="fas fa-bed fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Kamar
                                        </a>
                                        <a class="dropdown-item d-md-none" href="./fasilitas-kamar.php">
                                            <i class="fas fa-bath fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Fasilitas Kamar
                                        </a>
                                        <a class="dropdown-item d-md-none" href="./fasilitas.php">
                                            <i class="fas fa-building fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Fasilitas Hotel
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>

                            <?php
                            }
                            ?>

                        </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="min-height: 450px;">

                    <?php

                    $cek = $_GET['cek'];
                    if ($cek == 'kamar') {
                        $cek = "kamar";
                    } elseif ($cek == 'fasilitas kamar') {
                        $cek = "fasilitas kamar";
                    } elseif ($cek == 'fasilitas hotel') {
                        $cek = "fasilitas hotel";
                    }

                    ?>

                    <h1 class="h3 mb-4 text-gray-800 text-center">Tambah data <?= $cek ?></h1>

                    <!-- DataTales Example -->
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" class="" enctype="multipart/form-data">

                                        <?php
                                        $cek = $_GET['cek'];
                                        if ($cek == 'kamar') {
                                        ?>
                                            <a href="./index.php" class="btn btn-info btn-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                            <hr>

                                            <div class="mb-4">
                                                <label for="tipe" class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="tipe_kamar" id="tipe" maxlength="100" placeholder="Masukkan tipe kamar" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="jumlah" class="form-label">Jumlah Kamar <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="jumlah_kamar" id="jumlah" maxlength="100" placeholder="Masukkan jumlah kamar" required>
                                            </div>
                                            <div class="mb-4">
                                                <label for="jumlah" class="form-label">Kamar Tersedia<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="kamar_tersedia" id="jumlah" maxlength="100" placeholder="Masukkan jumlah kamar tersedia" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="harga" class="form-label">Harga Kamar <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="harga_kamar" id="harga" maxlength="100" placeholder="Masukkan harga kamar" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="banner" class="form-label">Upload Gambar Banner Kamar <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="banner" id="banner" required>
                                            </div>

                                            <div class="pt-2 text-center fill">
                                                <input type="submit" class="btn btn-primary w-100 mb-3" name="data_kamar" value="Tambah">
                                            </div>

                                        <?php
                                        } elseif ($cek == 'fasilitas kamar') {
                                        ?>
                                            <a href="./fasilitas-kamar.php" class="btn btn-info btn-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                            <hr>

                                            <div class="mb-4">
                                                <label for="tipe" class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                                                <select name="tipe_kamar" id="tipe_kamar" class="form-control" required>
                                                    <?php
                                                    $sql_kamar = mysqli_query($conn, "SELECT * FROM kamar ORDER BY tipe_kamar ASC");
                                                    while ($kamar = mysqli_fetch_assoc($sql_kamar)) {
                                                    ?>
                                                        <option value="<?= $kamar['tipe_kamar'] ?>"><?= $kamar['tipe_kamar'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label for="fasilitas_kamar" class="form-label">Fasilitas Kamar <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="fasilitas_kamar" id="fasilitas_kamar" maxlength="100" placeholder="Masukkan nama fasilitas kamar" required>
                                            </div>

                                            <div class="pt-2 text-center fill">
                                                <input type="submit" class="btn btn-primary w-100 mb-3" name="data_fasilitas_kamar" value="Tambah">
                                            </div>

                                        <?php
                                        } elseif ($cek == 'fasilitas hotel') {
                                        ?>
                                            <a href="./fasilitas-hotel.php" class="btn btn-info btn-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                            <hr>

                                            <div class="mb-4">
                                                <label for="fasilitas_hotel" class="form-label">Nama Fasilitas Hotel <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="fasilitas_hotel" id="fasilitas_hotel" maxlength="100" placeholder="Masukkan nama fasilitas hotel" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="keterangan" class="form-label">Keterangan Fasilitas Hotel <span class="text-danger">*</span></label>
                                                <!-- <input type="text" class="form-control" name="keterangan" id="keterangan" maxlength="100" placeholder="Masukkan keterangan fasilitas hotel" required> -->
                                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan keterangan fasilitas hotel" required></textarea>
                                                <script>
                                                    CKEDITOR.replace('keterangan');
                                                </script>
                                            </div>

                                            <div class="mb-4">
                                                <label for="image" class="form-label">Upload Gambar Fasilitas Hotel <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="image" required>
                                            </div>

                                            <div class="pt-2 text-center fill">
                                                <input type="submit" class="btn btn-primary w-100 mb-3" name="data_fasilitas_hotel" value="Tambah">
                                            </div>

                                        <?php
                                        }
                                        ?>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include './js.php';
    ?>

</body>

</html>