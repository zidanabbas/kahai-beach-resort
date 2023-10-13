<?php
require './koneksi.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data User</title>

    <!-- Custom fonts for this template-->
    <link href="./layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="./layout/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./style/main.css">
</head>

<style>
    .table-border tr td {
        border: 2px solid #000 !important;
    }

    .table-border tr th {
        border: 2px solid #000;
    }

    .color-dark {
        border: 2px solid #000 !important;
    }
</style>

<body class="container p-5">

    <h1 class="text-center">LAPORAN HOTEL HEBAT</h1>
    <hr class="color-dark">
    <div class="col-12">
        <div class="w-100">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM user");
            ?>

            <table class="table table-border mt-5">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                </tr>

                <?php
                $no = 1;
                while ($data = mysqli_fetch_assoc($sql)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['username'] ?></td>
                        <td><?= $data['password'] ?></td>
                        <td><?= $data['level'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <div class="col-12 pt-5">
                <div class="col-3">
                    <span>Resepsionis</span>
                    <br>
                    <br>
                    <br>
                    <span class="pt-1" style="border-top: 2px solid #000 !important;">Fauzi Aditya Pratama</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>