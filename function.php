<?php
require 'koneksi.php';
require 'midtrans-php-master/Midtrans.php';

function data_kamar()
{
    global $conn;

    $tipe_kamar = $_POST['tipe_kamar'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $kamar_tersedia = $_POST['kamar_tersedia'];
    $harga_kamar = $_POST['harga_kamar'];

    // CEK TIPE KAMAR
    $sql = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar = '$tipe_kamar' ");
    if (mysqli_fetch_assoc($sql)) {
        echo "
        <script>
            alert('Tipe kamar sudah terdaftar');
        </script>";
    } else {

        // CEK DATA BANNER
        $nama_file = $_FILES['banner']['name'];
        $ukuran_file = $_FILES['banner']['size'];
        $tipe_file = $_FILES['banner']['type'];
        $tmp_file = $_FILES['banner']['tmp_name'];

        // Set path folder tempat menyimpan gambarnya
        $path = "gambar/" . $nama_file;

        if ($tipe_file == "image/jpeg" || $tipe_file == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
            // Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :
            if ($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
                // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
                // Proses upload
                if (move_uploaded_file($tmp_file, $path)) { // Cek apakah gambar berhasil diupload atau tidak
                    // Jika gambar berhasil diupload, Lakukan :	
                    // Proses simpan ke Database
                    $sql = mysqli_query($conn, "INSERT INTO kamar VALUES ('','$tipe_kamar','$jumlah_kamar', '$jumlah_kamar','$kamar_tersedia', '$harga_kamar','$nama_file') ");

                    if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
                        // Jika Sukses, Lakukan :
                        echo "Data berhasil di tambahkan!";
                        header('location:index.php');
                    } else {
                        // Jika Gagal, Lakukan :
                        echo "<script>alert('Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data.')</script>";
                    }
                } else {
                    // Jika gambar gagal diupload, Lakukan :
                    echo "<script>alert('Maaf, Gambar gagal diupload!.')</script>";
                }
            } else {
                // Jika ukuran file lebih dari 1MB, lakukan :
                echo "Maaf, Ukuran gambar yang diupload tidak boleh lebih dari 1MB";
            }
        } else {
            // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
            echo "Maaf, Tipe gambar yang diupload harus JPG / JPEG / PNG.";
        }
        return mysqli_affected_rows($conn);
    }
}

function data_fasilitas_kamar()
{
    global $conn;

    $tipe_kamar = $_POST['tipe_kamar'];
    $fasilitas_kamar = $_POST['fasilitas_kamar'];

    mysqli_query($conn, "INSERT INTO fasilitas_kamar VALUES('','$tipe_kamar','$fasilitas_kamar')");
    return mysqli_affected_rows($conn);
}

function data_fasilitas_hotel()
{
    global $conn;

    $fasilitas_hotel = $_POST['fasilitas_hotel'];
    $keterangan = $_POST['keterangan'];

    // CEK DATA BANNER
    $nama_file = $_FILES['image']['name'];
    $ukuran_file = $_FILES['image']['size'];
    $tipe_file = $_FILES['image']['type'];
    $tmp_file = $_FILES['image']['tmp_name'];

    // Set path folder tempat menyimpan gambarnya
    $path = "gambar/" . $nama_file;

    if ($tipe_file == "image/jpeg" || $tipe_file == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
        // Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :
        if ($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
            // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
            // Proses upload
            if (move_uploaded_file($tmp_file, $path)) { // Cek apakah gambar berhasil diupload atau tidak
                // Jika gambar berhasil diupload, Lakukan :	
                // Proses simpan ke Database
                $sql = mysqli_query($conn, "INSERT INTO fasilitas_hotel VALUES ('','$fasilitas_hotel','$keterangan','$nama_file') ");

                if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
                    // Jika Sukses, Lakukan :
                    echo "Data berhasil di tambahkan!";
                    header('location:fasilitas-hotel.php');
                } else {
                    // Jika Gagal, Lakukan :
                    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data.";
                }
            } else {
                // Jika gambar gagal diupload, Lakukan :
                echo "Maaf, Gambar gagal untuk diupload.";
            }
        } else {
            // Jika ukuran file lebih dari 1MB, lakukan :
            echo "Maaf, Ukuran gambar yang diupload tidak boleh lebih dari 1MB";
        }
    } else {
        // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
        echo "Maaf, Tipe gambar yang diupload harus JPG / JPEG / PNG.";
    }
    return mysqli_affected_rows($conn);
}


function konfirmasi_pesanan()
{
    global $conn;

    // MEMBUAT KODE TRANSAKSI OTOMATIS
    $sql = mysqli_query($conn, "SELECT max(id_pemesanan) as maxID FROM pemesanan");
    $data = mysqli_fetch_assoc($sql);

    $kode = $data['maxID'];
    $kode++;
    $ket = "RSV";
    $id_pemesanan = 'RSV' . sprintf("%07d", mt_rand(1, 9999999));

    $user = $_SESSION['user'];
    $username = $_POST['username'];
    $nama_tamu = $_POST['nama_tamu'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $jumlah = $_POST['jumlah'];
    $jml_tamu = $_POST['jml_tamu'];
    $id_user  = $_POST['id_user'];
    $email  = $_POST['email'];
    $no_telpon  = $_POST['no_telpon'];


    date_default_timezone_set('Asia/Jakarta');

    $tgl_pesan = date('Y-m-d');

    $tgl_cekin = $_POST['tgl_cekin'].' 14:00:00';
    $tgl_cekout = $_POST['tgl_cekout'].' 12:00:00';
    $datediff =  strtotime($tgl_cekout) - strtotime($tgl_cekin);
    $days = round($datediff / (60 * 60 * 24));

    // MENG-UPDATE DATA KAMAR TERSEDIA DI TABEL KAMAR
    $sql = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar = '$tipe_kamar' ");
    $kamar = mysqli_fetch_assoc($sql);
    $kamar_tersedia = $kamar['kamar_tersedia'] - $jumlah;
    mysqli_query($conn, "UPDATE kamar SET kamar_tersedia = '$kamar_tersedia' WHERE tipe_kamar = '$tipe_kamar' ");

    // MENGECEK STATUS YANG AKAN DI MASUKKAN KE DATA KAMAR
    // $today = date('Y-m-d');
    // if ($tgl_cekin < $today) {
    //     $status = 'Booking';
    // } elseif ($tgl_cekin >= $today) {
    //     $status = 'Cek In';
    // }
    
    // $status_transaksi = $_POST['status_transaksi'];
    // $today = date('Y-m-d');
    // if ($status_transaksi == 'Belum Bayar') {
    //     $status = 'Belum Bayar';
    // } elseif ($status_transaksi == 'Sudah Bayar' && $tgl_cekin > $today) {
    //     $status = 'Booking';
    // } elseif ($status_transaksi == 'Sudah Bayar' && $tgl_cekin <= $today && $tgl_cekout > $today) {
    //     $status = 'Cek In';
    // } elseif ($status_transaksi == 'Sudah Bayar' && $tgl_cekout <= $today) {
    //     $status = 'Check Out';
    // } else {
    //     $status = 'Menunggu Pembayaran';
    // }

    $format_amount = str_replace(".", "", $kamar['harga_kamar']);
    $total_amount = intval($format_amount*$days*$jumlah);

    $req = [
        'days' => $days,
        'jumlah' => $jumlah,
        'id_pemesanan' => $id_pemesanan,
        'nama_tamu' => $nama_tamu,
        'harga_kamar' => $format_amount,
        'id_user' => $id_user,
        'email' => $email,
        'no_telpon' => $no_telpon,
        'tipe_kamar' => $tipe_kamar
    ];


    // MEMASUKKAN DATA KONFIRMASI PESANAN
    $token = payment($req);
    mysqli_query($conn, "INSERT INTO pemesanan VALUES('','$id_pemesanan', '$username', '$nama_tamu','$tipe_kamar','$jumlah','$jml_tamu','$tgl_cekin','$tgl_cekout','Menunggu Pembayaran', '$token', 'Menunggu Pembayaran', '$days', '$total_amount') ");
    return mysqli_affected_rows($conn);
    mysqli_query($conn, "SELECT * FROM pemesanan 
                LEFT JOIN pembayaran 
                ON pemesanan.id_pemesanan = pembayaran.id_pemesanan 
                WHERE pemesanan.id_pemesanan = '$id_pemesanan'");

    return mysqli_affected_rows($conn);
}


// 
// FUNCTION UBAH DATA
// 

function ubah_kamar()
{
    global $conn;

    $id = $_POST['id'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $kamar_tersedia = $_POST['kamar_tersedia'];
    $harga_kamar = $_POST['harga_kamar'];
    $filesize = $_FILES['banner']['size'];
    if ($filesize == 0) {
        mysqli_query($conn, "UPDATE kamar SET tipe_kamar = '$tipe_kamar', jumlah_kamar = '$jumlah_kamar', kamar_tersedia = '$kamar_tersedia', harga_kamar = '$harga_kamar' WHERE id = '$id' ");
    } else {
        // CEK DATA BANNER
        $nama_file = $_FILES['banner']['name'];
        $ukuran_file = $_FILES['banner']['size'];
        $tipe_file = $_FILES['banner']['type'];
        $tmp_file = $_FILES['banner']['tmp_name'];
        // Set path folder tempat menyimpan gambarnya
        $path = "gambar/" . $nama_file;
        if ($tipe_file == "image/jpeg" || $tipe_file == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
            // Jika tipe file yang diupload JPG / JPEG / PNG, lakukan :
            if ($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
                // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
                // Proses upload
                if (move_uploaded_file($tmp_file, $path)) { // Cek apakah gambar berhasil diupload atau tidak
                    // Jika gambar berhasil diupload, Lakukan :	
                    // Proses simpan ke Database
                    $sql = mysqli_query($conn, "UPDATE kamar SET tipe_kamar = '$tipe_kamar', jumlah_kamar = '$jumlah_kamar', banner = '$nama_file' WHERE id = '$id' ");
                    if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
                        // Jika Sukses, Lakukan :
                        echo "Data berhasil di tambahkan!";
                        header('location:index.php');
                    } else {
                        // Jika Gagal, Lakukan :
                        echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data.";
                    }
                } else {
                    // Jika gambar gagal diupload, Lakukan :
                    echo "Maaf, Gambar gagal untuk diupload.";
                }
            } else {
                // Jika ukuran file lebih dari 1MB, lakukan :
                echo "Maaf, Ukuran gambar yang diupload tidak boleh lebih dari 1MB";
            }
        } else {
            // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
            echo "Maaf, Tipe gambar yang diupload harus JPG / JPEG / PNG.";
        }
    }
    return mysqli_affected_rows($conn);
}

function ubah_fasilitas_hotel()
{
    global $conn;
    $id = $_POST['id'];
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $keterangan = $_POST['keterangan'];
    $filesize = $_FILES['image']['size'];
    if ($filesize == 0) {
        mysqli_query($conn, "UPDATE fasilitas_hotel SET nama_fasilitas = '$nama_fasilitas', keterangan = '$keterangan' WHERE id = '$id' ");
    } else {
        // CEK DATA BANNER
        $nama_file = $_FILES['image']['name'];
        $ukuran_file = $_FILES['image']['size'];
        $tipe_file = $_FILES['image']['type'];
        $tmp_file = $_FILES['image']['tmp_name'];

        // Set path folder tempat menyimpan gambarnya
        $path = "gambar/" . $nama_file;
        if ($tipe_file == "image/jpeg" || $tipe_file == "image/png") {
            if ($ukuran_file <= 1000000) {
                if (move_uploaded_file($tmp_file, $path)) {
                    $sql = mysqli_query($conn, "UPDATE fasilitas_hotel SET nama_fasilitas = '$nama_fasilitas', keterangan = '$keterangan', image = '$nama_file' WHERE id = '$id' ");
                    if ($sql) {
                        echo "<script>alert('Data Fasilitas Kamar Berhasil Ditambahkan!'); window.location.href = 'fasilitas-hotel.php';</script>";
                    }else {
                        echo "<script>alert('Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data.');</script>";
                    }
                } else {
                    echo "<script>alert('Maaf, Gambar gagal di upload! Pastikan size dan format sesuai ketentuan jpg, jpeg, png.');</script>";
                }
            } else {
                echo "<script>alert('Maaf, Ukuran gambar yang diupload tidak boleh lebih dari 1MB');</script>";
            }
        } else {
            echo "<script>alert('Maaf, Tipe gambar yang diupload harus JPG / JPEG / PNG.');</script>"; 
        }
    }
    return mysqli_affected_rows($conn);
}

function ubah_fasilitas_kamar()
{
    global $conn;
    $id = $_POST['id'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $fasilitas_kamar = $_POST['fasilitas_kamar'];
    mysqli_query($conn, "UPDATE fasilitas_kamar SET tipe_kamar = '$tipe_kamar', nama_fasilitas = '$fasilitas_kamar' WHERE id = '$id' ");
    return mysqli_affected_rows($conn);
}

function hapus_riwayat($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM pemesanan WHERE id = '$id' ");
    return mysqli_affected_rows($conn);
}

//
// FUNCTION HAPUS DATA
// 

function hapus_kamar($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM kamar WHERE id = '$id' ");

    return mysqli_affected_rows($conn);
}

function hapus_fasilitas_kamar($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM fasilitas_kamar WHERE id = '$id' ");

    return mysqli_affected_rows($conn);
}

function hapus_fasilitas_hotel($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM fasilitas_hotel WHERE id = '$id' ");

    return mysqli_affected_rows($conn);
}

function payment($req){
    /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
    composer require midtrans/midtrans-php
                                
    Alternatively, if you are not using **Composer**, you can download midtrans-php library 
    (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
    the file manually.   

    require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

    //SAMPLE REQUEST START HERE

    // Set your Merchant Server Key
    \Midtrans\Config::$serverKey = 'SB-Mid-server-XKKsEckFkmZmGgu8lzzJ86S_';
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;

    $price_detail = intval($req['harga_kamar']*$req['days']);

    $name = explode(" ", $req['nama_tamu']);
    if(sizeof($name) > 1){
        $firstname = $name[0];
        $lastname = $name[1];
    }else{
        $firstname = $name[0];
        $lastname = $name[0];
    }

    $params = array(
        'transaction_details' => array(
            'order_id' => $req['id_pemesanan'],
        ),
        'customer_details' => array(
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $req['email'],
            'phone' => $req['no_telpon'],
        ),
        'item_details' => [[
            'id' => $req['id_pemesanan'],
            'price' => $price_detail,
            'quantity' => $req['jumlah'],
            'name' => 'Kamar tipe '.$req['tipe_kamar'].' selama '.$req['days'].' hari.',
        ]],
    );

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    echo $snapToken;
    return $snapToken;
}

function trx_status($order_id){

    $auth = base64_encode("SB-Mid-server-XKKsEckFkmZmGgu8lzzJ86S_:");

    $url = 'https://api.sandbox.midtrans.com/v2/'.$order_id.'/status';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic '.$auth
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $data = curl_exec($curl);
    curl_close($curl);

    $decode = json_decode($data);
    
    return $decode;
}

function setStatus(){
    global $conn;

    date_default_timezone_set("Asia/Jakarta");
    $now = strtotime(date("Y-m-d h:i:s"));
    $query = mysqli_query($conn, "SELECT * FROM pemesanan");
    while($data=mysqli_fetch_assoc($query)){
        $payment_status = $data['payment_status'];
        $tgl_cekin = strtotime($data['tgl_cekin']);
        $tgl_cekout = strtotime($data['tgl_cekout']);
        $order_id = $data['kode_pemesanan'];
        if($payment_status == "Menunggu Pembayaran"){
            $trx_status = trx_status($order_id);
            if(isset($trx_status) && $trx_status->status_code != 404){
                mysqli_query($conn, "UPDATE pemesanan SET payment_status='$trx_status->transaction_status' WHERE kode_pemesanan='$order_id'");
                $payment_status = $trx_status->transaction_status;
            }
        }
        if($payment_status !== 'settlement' && $tgl_cekin < $now ){
            $status = 'Dibatalkan sistem';
        }else if($payment_status !== 'settlement' && $tgl_cekin > $now ){
            $status = 'Menunggu Pembayaran';
        }else if($payment_status === 'settlement' && $tgl_cekin < $now && $tgl_cekout > $now){
            $status = 'Check in';
        }else if($payment_status === 'settlement' && $tgl_cekin < $now && $tgl_cekout < $now){
            $status = 'Check Out';
        }else if($payment_status === 'settlement' && $tgl_cekin > $now ){
            $status = 'Booked';
        }
        
        mysqli_query($conn, "UPDATE pemesanan SET `status`='$status' WHERE kode_pemesanan='$order_id'");

    }

}