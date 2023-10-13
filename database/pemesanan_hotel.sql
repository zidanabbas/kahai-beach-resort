-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2023 at 02:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemesanan_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_hotel`
--

CREATE TABLE `fasilitas_hotel` (
  `id` int(11) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas_hotel`
--

INSERT INTO `fasilitas_hotel` (`id`, `nama_fasilitas`, `keterangan`, `image`) VALUES
(2, 'Swimming Pool', 'example', 'fasilitas5.jpg'),
(3, 'Exterior View', 'example', 'fasilitas4.jpg'),
(4, 'Sepeda Gantung', 'example', 'sepeda-gantung.png'),
(5, 'Kolam', 'example1', 'kolam.jpg'),
(6, 'Tempat Fitnes', '<p>example</p>', 'gym.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_kamar`
--

CREATE TABLE `fasilitas_kamar` (
  `id` int(11) NOT NULL,
  `tipe_kamar` varchar(100) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas_kamar`
--

INSERT INTO `fasilitas_kamar` (`id`, `tipe_kamar`, `nama_fasilitas`) VALUES
(1, 'Deluxe Rooms', 'TV 80 inch'),
(2, 'Deluxe Rooms', 'Coffee Maker'),
(3, 'Class Rooms', 'TV 24 inch'),
(4, 'Family Rooms', 'TV 54 inch'),
(5, 'Deluxe Rooms', 'Kamar berukuran luas 45 m2'),
(6, 'Deluxe Rooms', 'Kamar mandi shower dan Bath Tub'),
(7, 'Deluxe Rooms', 'Sofa'),
(8, 'Deluxe Rooms', 'AC'),
(9, 'Superior Rooms', 'Kamar berukuran luas 32 m2'),
(10, 'Superior Rooms', 'Kamar mandi shower'),
(11, 'Superior Rooms', 'Coffee Maker'),
(12, 'Superior Rooms', 'AC'),
(13, 'Superior Rooms', 'TV 40 inch');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` int(11) NOT NULL,
  `tipe_kamar` varchar(100) NOT NULL,
  `jumlah_kamar` varchar(100) NOT NULL,
  `kamar_tersedia` varchar(100) NOT NULL,
  `harga_kamar` varchar(20) NOT NULL,
  `total_harga` int(100) NOT NULL,
  `banner` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `tipe_kamar`, `jumlah_kamar`, `kamar_tersedia`, `harga_kamar`, `total_harga`, `banner`) VALUES
(3, 'Superior Rooms', '20', '28', '500.000', 0, 'kamar_superior.jpg'),
(11, 'Family Rooms', '20', '23', '180.000', 0, 'superior.jpg'),
(15, 'Deluxe Rooms', '20', '20', '200.000', 0, 'deluxeRoom.jpg'),
(16, 'Deluxe Single', '20', '40', '418.000', 0, 'deluxe single.png');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `status_transaksi` varchar(20) NOT NULL,
  `total_harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `kode_pemesanan` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama_tamu` varchar(100) NOT NULL,
  `tipe_kamar` varchar(100) NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `jml_tamu` varchar(100) NOT NULL,
  `tgl_cekin` date NOT NULL,
  `tgl_cekout` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `kode_pemesanan`, `username`, `nama_tamu`, `tipe_kamar`, `jumlah`, `jml_tamu`, `tgl_cekin`, `tgl_cekout`, `status`) VALUES
(36, 'RSV2920437', 'zidanabbas', 'zidane abbas', 'Family Rooms', '2', '3', '2023-03-11', '2023-03-12', 'Check Out'),
(62, 'RSV6728840', 'hadid', 'hadid wiranda', 'Family Rooms', '4', '4', '2023-03-14', '2023-03-15', 'Cek In'),
(70, 'RSV0978249', 'dian', 'dianwireksi', 'Deluxe Rooms', '4', '4', '2023-03-14', '2023-03-15', 'Cek In');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `no_telpon`, `level`) VALUES
(1, 'admin', 'admin', 'Admin', '', '', 'admin'),
(9, 'resepsionis', 'resepsionis', 'resepsionis', '', '', 'resepsionis'),
(10, 'zidanabbas', 'zidan123', 'zidane abbas', 'zidan.abbas28@gmail.com', '089654786299', 'pemesan'),
(15, 'dian', '123123', 'dianwireksi', 'diannih@gmail.com', '012321312', 'pemesan'),
(16, 'hadid', '123123', 'hadid wiranda', 'hadid@gmail.com', '0987654321', 'pemesan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fasilitas_hotel`
--
ALTER TABLE `fasilitas_hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_pemesanan` (`id_pemesanan`),
  ADD UNIQUE KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD UNIQUE KEY `id_pemesanan` (`kode_pemesanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitas_hotel`
--
ALTER TABLE `fasilitas_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
