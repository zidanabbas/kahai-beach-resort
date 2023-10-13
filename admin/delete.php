<?php

require '../function.php';

$cek = $_GET['cek'];

if ($cek == 'kamar') {
    $id = $_GET['id'];

    if (hapus_kamar($id) > 0) {
        header("location:./index.php");
    }
} elseif ($cek == 'fasilitas_kamar') {
    $id = $_GET['id'];

    if (hapus_fasilitas_kamar($id) > 0) {
        header("location:./fasilitas-kamar.php");
    }
} elseif ($cek == 'fasilitas_hotel') {
    $id = $_GET['id'];

    if (hapus_fasilitas_hotel($id) > 0) {
        header("location:./fasilitas-hotel.php");
    }
}
