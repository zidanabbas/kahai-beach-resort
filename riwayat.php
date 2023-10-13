<?php
session_start();
// error_reporting(0);

$title = 'Riwayat Pemesanan';
require './koneksi.php';
require_once './midtrans-php-master/Midtrans.php';
require './function.php';

require './pemesan/js_pay.php';


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

$sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE pemesanan.username = '$user' ORDER BY pemesanan.id_pemesanan DESC");
                        // $sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE username = '$user' ORDER BY id_pemesanan DESC ");
while ($data = mysqli_fetch_assoc($sql)) {
    if (!$data['payment_status']) {
        $trx_status = trx_status($data['kode_pemesanan']);
        // var_dump($trx_status);
        $order_id = $data['kode_pemesanan'];
        if(isset($trx_status->transaction_status) == 'settlement'){
            mysqli_query($conn, "UPDATE pemesanan SET payment_status='$trx_status->transaction_status', `status`='Check In' WHERE kode_pemesanan='$order_id'");
        }
    }
}

setStatus();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './layouts/heading.php'; ?>
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
                    <a href="./index.php" class="navbar-brand text-dark">Krakatau Kahai Beach Resort</a>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 active"><i class="fas fa-home"></i> Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./kamar-hotel.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600"><i class="fas fa-bed"></i> Kamar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./fasilitas.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <a class="dropdown-item d-md-none" href="./index.php">
                                        <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Beranda
                                    </a>
                                    <a class="dropdown-item d-md-none" href="./kamar-hotel.php">
                                        <i class="fas fa-bed fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kamar
                                    </a>
                                    <a class="dropdown-item d-md-none" href="./fasilitas.php">
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
                                <a class="nav-link dropdown-toggle" style="margin-left: -33px;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600">
                                        <?= $data['username'] ?>
                                    </span>
                                    <img class="img-profile rounded-circle d-none d-lg-inline" src="./layout/img/undraw_profile.svg">
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
                                    <a class="dropdown-item" href="riwayat.php">
                                        <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Riwayat Pemesanan
                                    </a>
                                    <div class="dropdown-divider d-md-none"></div>
                                    <a class="dropdown-item d-md-none" href="./index.php">
                                        <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Beranda
                                    </a>
                                    <a class="dropdown-item d-md-none" href="./kamar-hotel.php">
                                        <i class="fas fa-bed fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kamar
                                    </a>
                                    <a class="dropdown-item d-md-none" href="./fasilitas.php">
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
                <!-- Begin Page Content -->
                <img src="./img/hero-pict.jpg" alt="banner" class="d-block w-100" style="height: 400px;">
                <div class="container-fluid" style="min-height: 450px;">
                    <!-- BANNER -->
                    <div class="container-fluid py-3">
                        <h3 class="p-1 text-dark fw-bold">Riwayat Pemesanan Anda</h3>
                        <?php
                        $sql = mysqli_query($conn, "SELECT pemesanan.*, pembayaran.status_transaksi FROM pemesanan LEFT JOIN pembayaran ON pemesanan.id_pemesanan = pembayaran.id_pemesanan WHERE pemesanan.username = '$user' ORDER BY pemesanan.id_pemesanan DESC");
                        // $sql = mysqli_query($conn, "SELECT * FROM pemesanan WHERE username = '$user' ORDER BY id_pemesanan DESC ");
                        while ($data = mysqli_fetch_assoc($sql)) {

                        ?>
                            <div class="card my-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li><span>Kode Pesanan : <?= $data['kode_pemesanan'] ?></span></li>
                                                        <li>Nama Tamu :<span class="text-uppercase"> <?= $data['nama_tamu'] ?></span></li>
                                                        <li><span>Tipe Kamar : <?= $data['tipe_kamar'] ?></span></li>
                                                        <li><span>Jumlah Kamar : <?= $data['jumlah'] ?> Kamar</span></li>
                                                        <li><span>Jumlah Tamu : <?= $data['jml_tamu'] ?> Tamu</span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <ul>
                                                        <!-- UBAH TANGGAL CEK IN -->
                                                        <?php
                                                        $tanggal = explode("-", $data['tgl_cekin']);
                                                        $tahun = $tanggal[0];
                                                        $bulan = $tanggal[1];
                                                        $tanggal = $tanggal[2];
                                                        $tanggal_cekin = $tanggal . "/" . $bulan . "/" . $tahun;
                                                        ?>
                                                        <li><span>Tanggal Cek In : <?= $tanggal_cekin ?></span></li>

                                                        <!-- UBAH TANGGAL CEK OUT -->
                                                        <?php
                                                        $tanggal = explode("-", $data['tgl_cekout']);
                                                        $tahun = $tanggal[0];
                                                        $bulan = $tanggal[1];
                                                        $tanggal = $tanggal[2];
                                                        $tanggal_cekout = $tanggal . "/" . $bulan . "/" . $tahun;
                                                        ?>
                                                        <li><span>Tanggal Cek Out : <?= $tanggal_cekout ?></span></li>
                                                        <li><span>Status Pesanan : 
                                                                <?php
                                                                if ($data['status'] == 'Menunggu Pembayaran') {
                                                                    echo '<span class="btn btn-sm btn-warning" style="cursor: auto;">'.$data['status'].'</span>';
                                                                } elseif ($data['status'] == 'Booked') {
                                                                    echo '<span class="btn btn-sm btn-info px-3" style="cursor: auto;">'.$data['status'].'</span>';
                            
                                                                } elseif ($data['status'] == 'Check In') {
                                                                    echo '<span class="btn btn-sm btn-success px-3" style="cursor: auto;">'.$data['status'].'</span>';
                            
                                                                }elseif ($data['status'] == 'Check Out') {
                                                                    echo '<span class="btn btn-sm btn-secondary" style="cursor: auto;">'.$data['status'].'</span>';
                                                                }elseif ($data['status'] == 'Dibatalkan sistem') {
                                                                    echo '<span class="btn btn-sm btn-danger" style="cursor: auto;">'.$data['status'].'</span>';
                                                                }
                                                                // $today = date('Y-m-d');
                                                                // $status = $data['status'];
                                                                // if ($status == 'Belum Bayar') {
                                                                //     echo '<span class="btn btn-sm btn-info" style="cursor: auto;">Booking</span>';
                                                                // } elseif ($status == 'Sudah Bayar') {
                                                                //     echo '<span class="btn btn-sm btn-success px-3" style="cursor: auto;">Cek In</span>';
                                                                //     mysqli_query($conn, "UPDATE pemesanan SET status = 'Check In' WHERE id_pemesanan = '$data[id_pemesanan]' ");
                                                                // } elseif ($status == 'Check In') {
                                                                //     echo '<span class="btn btn-sm btn-primary" style="cursor: auto;">Sedang Menginap</span>';
                                                                // } elseif ($status == 'Check Out') {
                                                                //     echo '<span class="btn btn-sm btn-danger" style="cursor: auto;">Cek Out</span>';
                                                                // }elseif ($status == 'Menunggu Pembayaran') {
                                                                //     echo '<span class="btn btn-sm btn-danger" style="cursor: auto;">Menunggu Pembayaran</span>';
                                                                // }
                                                                // $today = date('Y-m-d');
                                                                // // CEK STATUS AKSI
                                                                // if ($today < $data['tgl_cekin']) {
                                                                //     echo '<span class="btn btn-sm btn-info" style="cursor: auto;">Booking</span>';
                                                                // } elseif (($today >= $data['tgl_cekin']) and ($today < $data['tgl_cekout'])) {
                                                                //     echo '<span class="btn btn-sm btn-success px-3" style="cursor: auto;">Cek In</span>';
                                                                //     mysqli_query($conn, "UPDATE pemesanan SET status = 'Cek In' WHERE id_pemesanan = '$data[id_pemesanan]' ");
                                                                // } elseif ($today >= $data['tgl_cekout']) {
                                                                //     echo '<span class="btn btn-sm btn-danger" style="cursor: auto;">Cek Out</span>';
                                                                // }
                                                                ?>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-1"></div>
                                        <div class="col-sm-12 col-md-4">
                                            <span>Option :</span>
                                            <div class="d-flex">
                                                <?php
                                                
                                                if ($data['payment_status'] == 'settlement') {
                                                    
                                                    ?>
                                                            <a target="_blank" href="./cetak.php?id=<?= $data['id_pemesanan'] ?>" class="btn btn-sm btn-warning mr-2"><i class="fas fa-print mr-1"></i> Cetak pesanan</a>
                                                        <?php
                                                        } else {
                                                        
                                                if ($data['status'] == 'Menunggu Pembayaran') {
                                                ?>
                                                    <!-- <a target="_blank" href="./pemesan/pembayaran.php?id=<?= $data['id_pemesanan'] ?>" class="btn btn-sm btn-warning mr-2"><i class="fas fa-print mr-1"></i> Lakukan pembayaran</a> -->
                                                    <!-- <form action="" method="post">
                                                        <button type="submit" >Lakukan Pembayaran</button>
                                                    </form> -->
                                                    <button type="button" class="btn btn-sm btn-warning mr-2" onclick="payment('<?= $data['token_pay'] ?>')">Lakukan Pembayaran</button>
                                                    <button type="button" class="btn btn-sm btn-info mr-2" onclick='window.location.reload(true);'>Cek Status Pembayaran</button>

                                                <?php
                                                } elseif ($data['status'] == 'Dibatalkan sistem') {
                                                    ?>

                                                    <button type="button" class="btn btn-sm btn-secondary mr-2" disabled>Dibatalkan sistem</button>
                            
                                                    <!-- <a target="_blank" href="./pemesan/pembayaran.php?id=<?= $data['id_pemesanan'] ?>" class="btn btn-sm btn-warning mr-2"><i class="fas fa-print mr-1"></i> Lakukan pembayaran</a> -->
                                                    <?php
                                                    
                                                }elseif ($data['status'] == 'Check Out') {
                                                    ?>

                                                    <a class="btn btn-sm btn-success mr-2"><i class="fas fa-check mr-1"></i> Pesanan selesai</a>

                            
                                                    <!-- <a target="_blank" href="./pemesan/pembayaran.php?id=<?= $data['id_pemesanan'] ?>" class="btn btn-sm btn-warning mr-2"><i class="fas fa-print mr-1"></i> Lakukan pembayaran</a> -->
                                                    <?php
                                                    
                                                } elseif ($data['status'] == 'Check in'||$data['status'] == 'Booked') {
                                                ?>
                                                    
                                                    <a target="_blank" href="./cetak.php?id=<?= $data['id_pemesanan'] ?>" class="btn btn-sm btn-warning mr-2"><i class="fas fa-print mr-1"></i> Cetak pesanan</a>
                                                <?php
                                                }
                                            }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php
                        }
                        ?>
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
                    <a class="btn btn-primary" href="./logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include './layouts/js.php';
    ?>

</body>

</html>