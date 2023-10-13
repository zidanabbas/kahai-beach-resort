<?php
session_start();
// error_reporting(0);

require '../koneksi.php';


if (!isset($_SESSION['admin'])) {
    header('location:../login.php');
} else {
    $user = $_SESSION['admin'];
    $title = 'Fasilitas Kamar';
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 active"><i class="fas fa-bath"></i> Fasilitas Kamar</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="./fasilitas-hotel.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
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
                                        <a class="dropdown-item d-md-none" href="./fasilitas-hotel.php">
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

                    <h1 class="h3 mb-4 text-gray-800">Data Fasilitas Kamar</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="./create.php?cek=fasilitas kamar" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="">
                                        <tr>
                                            <th class="col-1">No</th>
                                            <th>Tipe Kamar</th>
                                            <th>Fasilitas Kamar</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <?php
                                        $no = 0;

                                        $sql = mysqli_query($conn, "SELECT * FROM fasilitas_kamar ORDER BY tipe_kamar ASC");
                                        while ($data = mysqli_fetch_assoc($sql)) {
                                            $no++;
                                        ?>
                                            <tr class="col">
                                                <th scope="row"><?= $no ?></th>
                                                <td class="col-3"><?= $data['tipe_kamar'] ?></td>
                                                <td class="col-2"><?= $data['nama_fasilitas'] ?></td>
                                                <td class="col-2">
                                                    <a href="./edit.php?cek=fasilitas kamar&id=<?= $data['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="./delete.php?cek=fasilitas_kamar&id=<?= $data['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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