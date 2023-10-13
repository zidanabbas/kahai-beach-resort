<?php
session_start();
// error_reporting(0);

$title = 'Pembayaran';
require '../koneksi.php';

if (isset($_SESSION['pemesan'])) {
    $user = $_SESSION['pemesan'];
} elseif (!isset($_SESSION['pemesan'])) {
    if (isset($_SESSION['admin'])) {
        header('location:./admin/index.php');
    } elseif (isset($_SESSION['resepsionis'])) {
        header('location:./resepsionis/index.php');
    }
}


if ($user == "") {
    $user == "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './heading.php'; ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-none topbar static-top shadow">
                    <a href="../index.php" class="navbar-brand text-dark">Krakatau Kahai Beach Resort</a>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-home"></i> Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../kamar-hotel.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-bed"></i> Kamar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../fasilitas.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-building"></i> Fasilitas</span>
                            </a>
                        </li>
                        <div class="topbar-divider d-none d-lg-block"></div>
                        <?php
                        if ($user == "") {
                        ?>
                            <li class="nav-item my-auto d-none d-lg-inline">
                                <a href="./daftar.php" class="btn">Daftar</a>
                                <a href="./login.php" class="btn btn-success">Masuk</a>
                            </li>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle d-md-none" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <button class="btn btn-link d-md-none rounded-circle">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <div class="dropdown-divider d-md-none"></div>
                                    <a class="dropdown-item d-md-none" href="../index.php">
                                        <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Beranda
                                    </a>
                                    <a class="dropdown-item d-md-none" href="../kamar-hotel.php">
                                        <i class="fas fa-bed fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kamar
                                    </a>
                                    <a class="dropdown-item d-md-none" href="../fasilitas.php">
                                        <i class="fas fa-building fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Fasilitas
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <div class="p-1 d-md-none">
                                        <a class="btn" href="./daftar.php">
                                            Daftar
                                        </a>
                                        <a class="btn btn-success" href="./login.php">
                                            Masuk
                                        </a>
                                    </div>

                                </div>
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
                                    <a class="dropdown-item" href="../riwayat.php">
                                        <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Riwayat Pemesanan
                                    </a>

                                    <div class="dropdown-divider d-md-none"></div>

                                    <a class="dropdown-item d-md-none" href="../index.php">
                                        <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Beranda
                                    </a>
                                    <a class="dropdown-item d-md-none" href="../kamar.php">
                                        <i class="fas fa-bed fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kamar
                                    </a>
                                    <a class="dropdown-item d-md-none" href="../fasilitas.php">
                                        <i class="fas fa-building fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Fasilitas
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

                <img src="../img/hero-pict.jpg" alt="banner" class="d-block w-100 object-fit-cover" style="height: 400px;">
                <!-- Begin Page Content -->
                <div class="container-fluid" style="min-height: 450px;">

                    <!-- BANNER -->

                    <div class="container-fluid py-3">
                        <div class="row justify-content-center">
                            <h1 class="p-1 text-dark" style="font-weight: bold;">Pembayaran</h1>
                            <form action="">
                                
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2023</span>
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