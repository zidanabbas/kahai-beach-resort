<?php
session_start();
error_reporting(0);

$title = 'Beranda';
require './koneksi.php';

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

if (isset($_POST['btn_pesan'])) {
    $user = $_SESSION['user'];
    $tgl_cekin = $_POST['cek_in'];
    $tgl_cekout = $_POST['cek_out'];
    $jumlah = $_POST['jumlah'];
    $jml_tamu = $_POST['jml_tamu'];
    $today = date('Y-m-d');
    // CEK TANGGAL CEK IN DAN CEK OUT
    if ($tgl_cekin < $tgl_cekout) {
        if (($tgl_cekin >= $today) and ($tgl_cekout >= $today)) {
            if ($jumlah >= 5) {
                echo "<script>alert('Jumlah kamar tidak boleh lebih dari 5, Silahkan periksa kembali pesanan anda !!');</script>";
            } elseif ($jml_tamu >= 10) {
                echo "<script>alert('Jumlah tamu tidak boleh lebih dari 10, Silahkan periksa kembali pesanan anda !!');</script>";
            } else {
                $_SESSION['user'] = $user;
                $_SESSION['tgl_cekin'] = $tgl_cekin;
                $_SESSION['tgl_cekout'] = $tgl_cekout;
                $_SESSION['jumlah'] = $jumlah;
                $_SESSION['jml_tamu'] = $jml_tamu;
                header('location:./pemesan/pesanan.php');
            }
        } else {
            echo "<script>alert('Tanggal Cek In tidak boleh kurang dari tanggal hari ini, Silahkan periksa kembali pesanan anda !!');</script>";
        }
    } else {
        echo "<script>alert('Tanggal Cek Out tidak boleh sama atau kurang dari tanggal Cek In, Silahkan periksa kembali pesanan anda !!');</script>";
    }
}

if (isset($_POST['btn_cek'])) {
    echo "<script>alert('Anda belum memasukkan akun, silahkan masuk terlebih dahulu!!'); window.location.href = 'login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Krakatau Kahai Beach Resort | <?= $title ?></title>
    <!-- Logo -->
    <link rel="icon" href="./">
    <!-- Custom fonts for this template-->
    <link href="./layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Custom styles for this template-->
    <link href="./layout/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/main.css">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand navbar-light bg-transparant topbar fixed-top bg-white shadow-lg">
                    <a href="index.php" class="navbar-brand text-dark">Krakatau Kahai Beach Resort</a>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto px-2">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark active"><i class="fas fa-home"></i> Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./kamar-hotel.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark"><i class="fas fa-bed"></i> Kamar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./fasilitas.php" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark"><i class="fas fa-building"></i> Fasilitas</span>
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
                                <a class="nav-link dropdown-toggle d-md-none" style="margin-left: -33px;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <span class="mr-2 d-none d-lg-inline text-dark">
                                        <?= $data['username'] ?>
                                    </span>
                                    <img class="img-profile rounded-circle d-none d-lg-inline" src="./layout/img/undraw_profile.svg">
                                    <button class="btn btn-link d-sm-none rounded-circle">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <a class="dropdown-item" href="./riwayat.php">
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
                <!-- End of Navbar -->

                <!-- Begin Page Content -->
                <section>
                    <img src="./img/hero-pict.jpg" alt="banner" class="d-block w-100 object-fit-cover" style="height: 600px;">
                    <div class="container">
                        <?php
                        if ($user == "") {
                        ?>
                            <form action="" method="post" class="my-3 w-full border">
                                <div class="d-sm-flex justify-content-center">
                                    <div class="d-flex border-right sm-w-50 p-3 mx-2">
                                        <div class="col-6 border-right">
                                            <label for="">Check-in</label>
                                            <input type="date" class="form-control" name="cek_in">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Check-out</label>
                                            <input type="date" class="form-control" name="cek_out">
                                        </div>
                                    </div>
                                    <div class="row p-3 mx-2">
                                        <div class="md-d-flex d-flex">
                                            <div class="col-5 border-right">
                                                <label for="">Jumlah Kamar</label>
                                                <input type="number" class="form-control" name="jumlah">
                                            </div>
                                            <div class="col-5">
                                                <label for="">Jumlah Tamu</label>
                                                <input type="number" class="form-control" name="jml_tamu">
                                            </div>
                                            <input type="submit" class="btn btn-primary" style="margin-top: 32px;" name="btn_cek">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                        } elseif ($user != "") {
                        ?>
                            <form action="" method="post" class="my-3 border border-1 rounded-lg shadow-sm w-full">
                                <div class="d-md-flex justify-content-between">
                                    <div class="d-flex border-right p-3 mx-2">
                                        <div class="col-6 border-right">
                                            <label for="">Check-in</label>
                                            <input type="date" class="form-control" name="cek_in">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Check-out</label>
                                            <input type="date" class="form-control" name="cek_out">
                                        </div>
                                    </div>
                                    <div class="row p-3 mx-2">
                                        <div class="md-d-flex d-flex">
                                            <div class="col-5 border-right">
                                                <label for="">Jumlah Kamar</label>
                                                <input type="number" class="form-control" name="jumlah">
                                            </div>
                                            <div class="col-5">
                                                <label for="">Jumlah Tamu</label>
                                                <input type="number" class="form-control" name="jml_tamu">
                                            </div>
                                            <input type="submit" class="btn btn-primary" style="margin-top: 32px;" name="btn_pesan" value="Pesan">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- Begin Page Content -->
                    <div class="container-fluid pt-3 mt-5" style="min-height: 450px;">
                        <!-- <h1 class="text-center mb-3 p-2 text-dark" style="font-weight: bold;">Krakatau Kahai Beach Resort</h1> -->
                        <div class="container-fluid p-4 ">
                            <div class="row p-3 justify-content-between">
                                <div class="col-md-6 my-auto">
                                    <h3 class="font-weight-bold mb-4 border-bottom-dark text-center py-3">Krakatau Kahai Beach Resort</h3>
                                    <span class="d-block p-2">
                                        <p class="text-sm">Krakatau kahai beach hotel menawarkan akomodasi di Kalianda, Lampung Selatan dan berjarak 49 meter dari Pantai Kahai. Properti ini memiliki fasilitas akses WiFi gratis dan resepsionis 24 jam.
                                            Setiap kamar dilengkapi dengan AC dan layanan kamar 24 jam. Shower tersedia di kamar mandi.
                                            Tamu dapat menikmati makanan di restoran yang tersedia di properti atau dapat mengunjungi Rumah Makan Krakatau. Pilihan tempat makan lain juga tersedia di sekitar properti.
                                            Fasilitas lain yang tersedia di Krakatau kahai beach hotel adalah tersedia area parkir dan tersedia fasilitas meeting.
                                            Bandara terdekat adalah Bandar Udara Internasional Radin Inten II, 110 km dari properti.</p>
                                    </span>
                                </div>
                                <div class="col-md-5 text-center">
                                    <img src="img/hero/1.jpg" alt="" class="mx-auto img-thumbnail border-0 rounded-circle shadow-lg">
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="container-fluid pt-3 mt-5" style="min-height: 450px;">
                        <!-- <h1 class="text-center mb-3 p-2 text-dark" style="font-weight: bold;">Krakatau Kahai Beach Resort</h1> -->
                        <div class="container-fluid p-4 ">
                            <div class="row p-3 justify-content-between">
                                <div class="col-md-4 text-center">
                                    <img src="img/glamping.jpg" alt="" width="300px" class="mx-auto img-thumbnail border-0 rounded">
                                </div>
                                <div class="col-md-7 my-auto">
                                    <h3 class="font-weight-bold mb-4 border-bottom-dark text-center py-3">Glamping House</h3>
                                    <span class="p-2 d-block">
                                        <p class="text-sm">Tenda-tenda modern dan mewah yang ditawarkan tempat glamping di Indonesia satu ini hadir dengan berbagai ukuran dengan yang terluas mampu menampung hingga 6 orang, menjadikannya pilihan tempat glamping pas untuk kumpul bersama keluarga dan teman-teman terdekat.</p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <!-- Kamar -->
                    <section id="kamar">
                        <h1 class="p-3 text-center text-dark" style="font-weight: bold;">Tipe Kamar</h1>
                        <?php
                        $sql_kamar = mysqli_query($conn, "SELECT * FROM kamar");
                        $data_kamar = mysqli_fetch_assoc($sql_kamar);
                        ?>
                        <div class="container-fluid py-3">
                            <div class="container-fluid d-flex justify-content-center p-2">
                                <div class="row d-flex justify-content-center">
                                    <?php
                                    $query = "SELECT * FROM kamar ORDER BY tipe_kamar ASC";
                                    $result = mysqli_query($conn, $query);

                                    while ($data = mysqli_fetch_assoc($result)) {
                                        # code...
                                    ?>
                                        <div class="m-2" style="width: 18rem;">
                                            <img src="img/<?php echo $data['banner'] ?>" class="card-img-top object-fit-fill" alt="...">
                                            <div class="card-body shadow-lg">
                                                <h5 class="card-title fw-bold"><?php echo $data['tipe_kamar'] ?></h5>
                                                <i class="bi bi-person-fill mx-2"> 2 tamu</i>
                                                <i class="bi bi-wifi mx-2"> Free Wifi</i>
                                                <span class="p-2 d-block mb-2 fs-6">
                                                    <p class="card-text">Jumlah kamar: <?php echo $data['jumlah_kamar'] ?></p>
                                                    <p class="card-text">Kamar tersedia: <?php echo $data['kamar_tersedia'] ?></p>
                                                </span>
                                                <a href="kamar-hotel.php" class="btn btn-primary">Lihat detail kamar</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End Kamar -->

                    <!-- Fasilitas -->
                    <div class="container-fluid py-3">
                        <h1 class="text-center p-3 text-dark" style="font-weight: bold;">Fasilitas</h1>
                        <div class="container p-3 d-block justify-content-center">
                            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="img/hero/fasilitas3.jpg" class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>SWIMMING POOL</h5>
                                            <p>Some representative placeholder content for the first slide.</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/hero/fasilitas4.jpg" class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Second slide label</h5>
                                            <p>Some representative placeholder content for the second slide.</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/hero/fasilitas5.jpg" class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Third slide label</h5>
                                            <p>Some representative placeholder content for the third slide.</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev bg-transparent border-0" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button class="carousel-control-next bg-transparent border-0" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- EndFasilitas -->

                    <!-- Promo -->
                    <section id="promo">
                        <h2 class="p-3 mt-md-4 text-center text-dark" style="font-weight: bold;">Promo Hotel Terbaik Untukmu</h2>
                        <h5 class="text-center text-dark font-weight-bold">Lebih hemat dengan promo terbaik kami.</h5>
                        <div class="container-fluid py-3">
                            <div class="container-fluid p-4">
                                <div class="row justify-content-center">
                                    <div class="card m-2 p-4 shadow-lg" style="width: 20rem;">
                                        <img src="img/icon/discount.png" class="img-thumbnail mb-4 mx-auto rounded-circle" width="40%" alt="">
                                        <span class="text-lg text-center font-weight-bolder mb-2">Promo Menarik</span>
                                        <p class="text-sm text-center">Pesan lebih awal dijamin lebih hemat! Pas untuk rencana liburan dari jauh hari.</p>
                                    </div>
                                    <div class="card m-2 p-4 shadow-lg" style="width: 20rem;">
                                        <img src="img/icon/Clock.png" class="img-thumbnail mb-4 mx-auto rounded-circle" width="40%" alt="">
                                        <span class="text-lg text-center font-weight-bolder mb-2">Last Minute</span>
                                        <p class="text-sm text-center">Belum terlambat untuk liburan! Dapatkan diskon spesial untuk pemesanan dadakan!</p>
                                    </div>
                                    <div class="card m-2 p-4 shadow-lg" style="width: 20rem;">
                                        <img src="img/icon/home.png" class="img-thumbnail mb-4 mx-auto rounded-circle" width="40%" alt="">
                                        <span class="text-lg text-center font-weight-bolder mb-2">Hotel Now!</span>
                                        <p class="text-sm text-center">Nikmati harga spesial untuk pesan & check-in di hari yang sama.</p>
                                    </div>
                                    <div class="card m-2 p-4 shadow-lg" style="width: 20rem;">
                                        <img src="img/icon/Case.png" class="img-thumbnail mb-4 mx-auto rounded-circle" width="40%" alt="">
                                        <span class="text-lg text-center font-weight-bolder mb-2">Bonus Menginap</span>
                                        <p class="text-sm text-center">Pesan untuk beberapa malam dan dapatkan ekstra menginap 1 malam gratis!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- EndPromo -->
                </section>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2022</span>
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

    <script src="./layout/js/script.js"></script>
</body>

</html>