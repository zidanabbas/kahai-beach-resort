<?php

require '../function.php';

    if (hapus_riwayat($id) > 0) {
        header("location:riwayat.php");
    }