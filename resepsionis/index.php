<?php
session_start();
// error_reporting(0);

require '../koneksi.php';
require '../function.php';

if (!isset($_SESSION['resepsionis'])) {
    header('location:../login.php');
} else {
    $user = $_SESSION['resepsionis'];
    $title = 'Beranda';
}

date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

setStatus();

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
                                        <a class="dropdown-item" href="">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Profile
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

                    <div class="row py-4">
                        <div class="d-sm-flex col-6">
                            <h1 class="h3 mb-0 text-gray-800">Data Reservasi</h1>
                        </div>
                        <div class="col-6 text-right mt-2">
                            <span class="">Today : <?= date('l, j F Y') ?></span>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-sm-5 col-md-5 row">
                                    <div class="col-5">
                                    <form action="" id="filter_data" method="post" class="d-flex">
                                        <select name="filter" onchange="filterdata()" class="form-control">
                                            <option value="">-- Filter Data --</option>
                                            <?php 
                                                 $sql = mysqli_query($conn, "SELECT DISTINCT `status` FROM pemesanan");
                                                 while ($data = mysqli_fetch_assoc($sql)) {
                                                    ?>
                                                    <option value="<?= $data['status'] ?>"><?= $data['status'] ?></option>
                                                    <?php
                                                 }
                                            ?>
                                        </select>
                                        
                                    </form>
                                    </div>
                                    <div class="col-7">
                                    <form action="" method="post" class="d-flex">
                                        <input type="date" name="cari_tanggal" style="border-radius: 8px 0 0 8px;" class="form-control">
                                        <input type="submit" name="btn_cari_tanggal" style="border-radius: 0 8px 8px 0;" class="btn btn-sm btn-success col-sm-3 col-md-2" style="font-weight: bold;" value="Cari">
                                    </form>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <form action="" method="post" class="d-flex">
                                        <input type=" text" name="cari_tamu" class="form-control" style="border-radius: 8px 0 0 8px;" placeholder="Search by nama tamu...">
                                        <input type="submit" name="btn_cari_tamu" style="border-radius: 0 8px 8px 0;" class="btn btn-sm btn-success col-sm-3 col-md-2" style="font-weight: bold;" value="Cari">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pemesanan</th>
                                            <th>Nama Tamu</th>
                                            <th>Tipe Kamar</th>
                                            <th>Tanggal Cek In</th>
                                            <th>Tanggal Cek Out</th>
                                            <th>Status</th>
                                            <th>Status Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <?php
                                        $no = 0;

                                        $sql = mysqli_query($conn, "SELECT * FROM pemesanan ORDER BY tgl_cekin DESC");

                                        if (isset($_POST['btn_cari_tanggal'])) {
                                            $tanggal = $_POST['cari_tanggal'];

                                            $sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE tgl_cekin = '$tanggal' ORDER BY  tgl_cekin DESC ");
                                        }

                                        if (isset($_POST['btn_cari_tamu'])) {
                                            $nama = $_POST['cari_tamu'];

                                            $sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE nama_tamu like '%$nama%' ORDER BY tgl_cekin DESC ");
                                        }

                                        if (isset($_POST['filter'])) {
                                            $filter = $_POST['filter'];

                                            $sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE `status`='$filter' ORDER BY tgl_cekin DESC ");
                                        }

                                        while ($data = mysqli_fetch_assoc($sql)) {
                                            $no++;
                                            $status = $data['status'];
                                        ?>
                                            <tr class="col">
                                                <th scope="row"><?= $no ?></th>
                                                <td class="col-2"><?= $data['kode_pemesanan'] ?></td>
                                                <td class="col-2"><?= $data['nama_tamu'] ?></td>
                                                <td class="col-2"><?= $data['tipe_kamar'] ?></td>
                                                <td class="col-2"><?= $data['tgl_cekin'] ?></td>
                                                <td class="col-2"><?= $data['tgl_cekout'] ?></td>
                                                <td>
                                                    <?php

                                                    // CEK STATUS AKSI
                                                    if ($status == 'Menunggu Pembayaran') {
                                                        echo '<span class="btn btn-sm btn-warning" style="cursor: auto;">'.$status.'</span>';
                                                    } elseif ($status == 'Booked') {
                                                        echo '<span class="btn btn-sm btn-info px-3" style="cursor: auto;">'.$status.'</span>';
                
                                                    } elseif ($status == 'Check In') {
                                                        echo '<span class="btn btn-sm btn-success px-3" style="cursor: auto;">'.$status.'</span>';
                
                                                    }elseif ($status == 'Check Out') {
                                                        echo '<span class="btn btn-sm btn-secondary" style="cursor: auto;">'.$status.'</span>';
                                                    }elseif ($status == 'Dibatalkan sistem') {
                                                        echo '<span class="btn btn-sm btn-danger" style="cursor: auto;">'.$status.'</span>';
                                                    }

                                                    // // UPDATE STATUS DATA PEMESANAN
                                                    // if ($today >= $data['tgl_cekout'] and ($data['status']) != 'Done') {
                                                    //     mysqli_query($conn, "UPDATE pemesanan SET status = 'Check Out' WHERE id_pemesanan = '$data[id_pemesanan]' ");
                                                    // }

                                                    // if ($data['status'] == 'Check Out') {

                                                    //     // UPDATE DATA KAMAR TERSEDIA DI SAAT SUDAH CEK OUT
                                                    //     $sql_kamar = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar = '$data[tipe_kamar]' ");
                                                    //     $kamar = mysqli_fetch_assoc($sql_kamar);
                                                    //     $kamar_tersedia = $kamar['kamar_tersedia'] + $data['jumlah'];

                                                    //     mysqli_query($conn, "UPDATE kamar SET kamar_tersedia = '$kamar_tersedia' WHERE tipe_kamar = '$data[tipe_kamar]' ");

                                                    //     // UPDATE STATUS MENJADI DONE
                                                    //     mysqli_query($conn, "UPDATE pemesanan SET status = 'Done' WHERE id_pemesanan = '$data[id_pemesanan]' ");
                                                    // }
                                                    ?>
                                                </td>
                                                <td class="col-2"><?= $data['payment_status'] ?></td>
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

<script>
    const filterdata = () => {
        document.getElementById("filter_data").submit();
    }
</script>

</body>

</html>