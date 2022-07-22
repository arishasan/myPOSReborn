-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2022 at 02:16 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projek_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `path` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kode`, `nama`, `parent`, `depth`, `path`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'MKN', 'MAKANAN', 0, NULL, '/1', 1, '2022-07-06 13:20:04', '2022-07-06 13:21:09'),
(2, 'MNM', 'MINUMAN', 0, NULL, '/2', 1, '2022-07-06 13:20:17', '2022-07-06 13:20:17'),
(3, 'MINST', 'Mie Instant', 1, NULL, '/1/3', 1, '2022-07-06 13:21:19', '2022-07-06 13:21:36'),
(4, NULL, 'Test ss', 0, NULL, '/4', 1, '2022-07-21 08:52:00', '2022-07-21 08:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Pcs', 1, '2022-07-08 11:07:13', '2022-07-08 11:07:13', 1),
(2, 'Dus', 1, '2022-07-08 11:08:19', '2022-07-08 11:11:39', 1),
(3, 'Kilogram', 1, '2022-07-12 17:31:07', '2022-07-12 17:31:21', 1),
(4, 'Gram', 1, '2022-07-12 17:31:12', '2022-07-12 17:31:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `telepon`, `mobile_phone`, `email`, `pic`, `catatan`, `created_by`, `created_at`, `edited_by`, `updated_at`) VALUES
(1, 'CV. Mekar Jaya', 'Cianjur', '63002000', '0848808001', 'test@email.com', 'Asep Ramdhan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent est nibh, molestie vitae ornare eu, feugiat et ex. Nullam maximus elit metus, varius egestas augue semper eget. Donec placerat eros blandit, dignissim arcu sit amet, elementum risus. Nam vehicula dui a risus eleifend suscipit. In commodo posuere pulvinar. Nullam dapibus aliquet lorem non congue. Donec sit amet magna imperdiet, pulvinar leo vitae, pulvinar urna. Suspendisse vitae tristique risus. Duis ut orci vitae odio vehicula scelerisque at at lectus. Suspendisse rutrum convallis dui, eget congue urna tristique nec. Donec ac nisi nunc. Integer suscipit, augue vitae dignissim aliquam, sapien sem viverra odio, nec fermentum quam erat sit amet tellus. Sed dictum nibh ac augue luctus, sollicitudin vehicula sem tempus. Ut vitae pharetra erat. Phasellus semper eu urna eu pulvinar. Vivamus non leo nec nulla mattis cursus a nec enim.', NULL, NULL, 1, '2021-11-26 11:37:10'),
(5, 'Adam Supply', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-07-15 16:51:58', NULL, '2022-07-15 16:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_aktivitas_barang`
--

CREATE TABLE `tb_aktivitas_barang` (
  `id_aktivitas_barang` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_aktivitas_barang`
--

INSERT INTO `tb_aktivitas_barang` (`id_aktivitas_barang`, `id_barang`, `status`, `qty`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 2, 'Masuk', 100, '2022-07-08 14:00:37', '2022-07-08 14:00:37', 1),
(3, 2, 'Masuk', 50, '2022-07-09 14:54:04', '2022-07-09 14:54:04', 1),
(4, 2, 'Keluar', 50, '2022-07-09 14:59:51', '2022-07-09 14:59:51', 1),
(5, 2, 'Masuk', 10, '2022-07-09 15:05:06', '2022-07-09 15:05:06', 1),
(6, 2, 'Masuk', 5, '2022-07-09 15:05:22', '2022-07-09 15:05:22', 1),
(7, 2, 'Masuk', 50, '2022-07-09 15:05:35', '2022-07-09 15:05:35', 1),
(8, 2, 'Masuk', 55, '2022-07-09 15:05:46', '2022-07-09 15:05:46', 1),
(9, 2, 'Keluar', 105, '2022-07-09 15:05:54', '2022-07-09 15:05:54', 1),
(10, 2, 'Masuk', 100, '2022-07-09 15:07:55', '2022-07-09 15:07:55', 1),
(11, 2, 'Masuk', 10, '2022-07-09 15:07:59', '2022-07-09 15:07:59', 1),
(12, 2, 'Keluar', 7, '2022-07-09 16:25:57', '2022-07-09 16:25:57', 1),
(13, 2, 'Keluar', 10, '2022-07-09 16:26:52', '2022-07-09 16:26:52', 1),
(14, 2, 'Keluar', 93, '2022-07-09 16:27:31', '2022-07-09 16:27:31', 1),
(15, 2, 'Masuk', 5, '2022-07-12 17:28:22', '2022-07-12 17:28:22', 1),
(16, 2, 'Keluar', 5, '2022-07-12 17:28:26', '2022-07-12 17:28:26', 1),
(17, 4, 'Masuk', 26, '2022-07-12 17:32:18', '2022-07-12 17:32:18', 1),
(18, 4, 'Masuk', 8.8, '2022-07-12 17:38:36', '2022-07-12 17:38:36', 1),
(19, 4, 'Keluar', 8.8, '2022-07-12 17:44:03', '2022-07-12 17:44:03', 1),
(20, 4, 'Masuk', 5.5, '2022-07-12 17:44:11', '2022-07-12 17:44:11', 1),
(21, 4, 'Keluar', 5.3, '2022-07-12 17:45:17', '2022-07-12 17:45:17', 1),
(22, 5, 'Masuk', 15.8, '2022-07-12 17:47:53', '2022-07-12 17:47:53', 1),
(23, 2, 'Masuk', 10.5, '2022-07-12 18:25:34', '2022-07-12 18:25:34', 1),
(24, 2, 'Keluar', 0.5, '2022-07-12 18:25:43', '2022-07-12 18:25:43', 1),
(25, 5, 'Keluar', 5, '2022-07-12 21:41:22', '2022-07-12 21:41:22', 1),
(26, 5, 'Keluar', 5, '2022-07-13 18:54:43', '2022-07-13 18:54:43', 1),
(27, 5, 'Masuk', 2, '2022-07-13 20:10:35', '2022-07-13 20:10:35', 1),
(28, 5, 'Keluar', 0.8, '2022-07-13 20:17:37', '2022-07-13 20:17:37', 1),
(29, 1, 'Keluar', 10, '2022-07-13 20:55:08', '2022-07-13 20:55:08', 1),
(30, 1, 'Keluar', 2.8, '2022-07-13 20:55:08', '2022-07-13 20:55:08', 1),
(33, 5, 'Keluar', 2.2, '2022-07-13 21:03:17', '2022-07-13 21:03:17', 1),
(34, 2, 'Keluar', 15, '2022-07-13 21:03:17', '2022-07-13 21:03:17', 1),
(35, 5, 'Keluar', 1.2, '2022-07-13 21:06:42', '2022-07-13 21:06:42', 1),
(36, 4, 'Keluar', 16.2, '2022-07-13 21:06:42', '2022-07-13 21:06:42', 1),
(37, 6, 'Masuk', 100, '2022-07-13 21:09:04', '2022-07-13 21:09:04', 1),
(38, 7, 'Masuk', 50, '2022-07-13 21:10:06', '2022-07-13 21:10:06', 1),
(39, 5, 'Masuk', 2, '2022-07-14 11:37:38', '2022-07-14 11:37:38', 1),
(40, 5, 'Masuk', 2, '2022-07-14 11:37:45', '2022-07-14 11:37:45', 1),
(41, 5, 'Masuk', 1.2, '2022-07-14 11:42:46', '2022-07-14 11:42:46', 1),
(42, 4, 'Masuk', 16.2, '2022-07-14 11:42:46', '2022-07-14 11:42:46', 1),
(43, 5, 'Masuk', 2.2, '2022-07-14 11:44:30', '2022-07-14 11:44:30', 1),
(44, 2, 'Masuk', 15, '2022-07-14 11:44:30', '2022-07-14 11:44:30', 1),
(45, 7, 'Keluar', 10, '2022-07-14 12:08:05', '2022-07-14 12:08:05', 1),
(46, 6, 'Keluar', 6, '2022-07-14 12:08:05', '2022-07-14 12:08:05', 1),
(47, 5, 'Keluar', 3.2, '2022-07-14 15:55:05', '2022-07-14 15:55:05', 1),
(48, 7, 'Keluar', 20, '2022-07-14 15:55:05', '2022-07-14 15:55:05', 1),
(49, 5, 'Masuk', 3.2, '2022-07-14 15:56:09', '2022-07-14 15:56:09', 1),
(50, 7, 'Masuk', 20, '2022-07-14 15:56:09', '2022-07-14 15:56:09', 1),
(51, 7, 'Keluar', 10, '2022-07-14 16:22:19', '2022-07-14 16:22:19', 1),
(52, 5, 'Keluar', 1.4, '2022-07-14 16:22:19', '2022-07-14 16:22:19', 1),
(53, 2, 'Keluar', 25, '2022-07-14 16:22:19', '2022-07-14 16:22:19', 1),
(54, 7, 'Keluar', 5, '2022-07-14 16:35:49', '2022-07-14 16:35:49', 1),
(55, 7, 'Masuk', 5, '2022-07-15 20:09:26', '2022-07-15 20:09:26', 1),
(56, 7, 'Masuk', 8, '2022-07-15 20:10:23', '2022-07-15 20:10:23', 1),
(57, 6, 'Masuk', 9, '2022-07-15 20:10:23', '2022-07-15 20:10:23', 1),
(58, 7, 'Keluar', 3, '2022-07-15 21:17:54', '2022-07-15 21:17:54', 1),
(59, 6, 'Keluar', 4, '2022-07-15 21:17:54', '2022-07-15 21:17:54', 1),
(60, 2, 'Masuk', 10, '2022-07-15 21:23:49', '2022-07-15 21:23:49', 1),
(61, 4, 'Masuk', 18, '2022-07-15 21:23:49', '2022-07-15 21:23:49', 1),
(62, 5, 'Masuk', 13, '2022-07-15 21:23:49', '2022-07-15 21:23:49', 1),
(63, 6, 'Masuk', 150, '2022-07-15 21:23:49', '2022-07-15 21:23:49', 1),
(64, 2, 'Keluar', 5, '2022-07-15 21:25:53', '2022-07-15 21:25:53', 1),
(65, 4, 'Keluar', 9, '2022-07-15 21:25:53', '2022-07-15 21:25:53', 1),
(66, 5, 'Keluar', 7, '2022-07-15 21:25:53', '2022-07-15 21:25:53', 1),
(67, 6, 'Keluar', 75, '2022-07-15 21:25:53', '2022-07-15 21:25:53', 1),
(68, 8, 'Masuk', 100, '2022-07-17 16:03:29', '2022-07-17 16:03:29', 1),
(69, 2, 'Masuk', 100, '2022-07-21 16:35:34', '2022-07-21 16:35:34', 1),
(70, 4, 'Masuk', 100, '2022-07-21 16:35:34', '2022-07-21 16:35:34', 1),
(71, 4, 'Masuk', 25, '2022-07-21 16:59:25', '2022-07-21 16:59:25', 10),
(72, 6, 'Masuk', 100, '2022-07-21 17:03:20', '2022-07-21 17:03:20', 1),
(73, 7, 'Masuk', 50, '2022-07-21 17:03:20', '2022-07-21 17:03:20', 1),
(74, 2, 'Masuk', 10, '2022-07-21 18:39:35', '2022-07-21 18:39:35', 1),
(75, 2, 'Masuk', 50, '2022-07-21 18:39:39', '2022-07-21 18:39:39', 1),
(76, 2, 'Keluar', 60, '2022-07-21 18:40:01', '2022-07-21 18:40:01', 1),
(77, 2, 'Masuk', 100, '2022-07-21 18:40:01', '2022-07-21 18:40:01', 1),
(78, 5, 'Keluar', 13, '2022-07-21 18:40:45', '2022-07-21 18:40:45', 1),
(79, 5, 'Masuk', 20, '2022-07-21 18:40:45', '2022-07-21 18:40:45', 1),
(80, 6, 'Keluar', 274, '2022-07-21 18:40:45', '2022-07-21 18:40:45', 1),
(81, 6, 'Masuk', 134, '2022-07-21 18:40:45', '2022-07-21 18:40:45', 1),
(82, 7, 'Keluar', 5, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(83, 5, 'Keluar', 3, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(84, 7, 'Keluar', 2, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(85, 8, 'Keluar', 39, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(86, 9, 'Masuk', 100, '2022-07-22 18:32:46', '2022-07-22 18:32:46', 1),
(87, 8, 'Keluar', 11, '2022-07-22 19:15:08', '2022-07-22 19:15:08', 1),
(88, 9, 'Keluar', 20, '2022-07-22 19:15:08', '2022-07-22 19:15:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `photo_url` text DEFAULT NULL,
  `kode_barang` varchar(100) DEFAULT NULL,
  `nama_barang` varchar(200) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  `expired_date_status` int(1) DEFAULT 0,
  `qty_min_grosir` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `id_kategori`, `id_satuan`, `photo_url`, `kode_barang`, `nama_barang`, `keterangan`, `status`, `expired_date_status`, `qty_min_grosir`, `created_at`, `updated_at`, `created_by`) VALUES
(2, 1, 1, 'uploads/barang/1_deskripsi-test_2.png', 'BR.07.001', 'Beng Beng', 'Deskripsi Test', 1, 0, 10, '2022-07-08 14:00:37', '2022-07-21 15:46:21', 1),
(4, 1, 3, 'assets/logo/noimage.png', 'BR.07.002', 'Gula Putih', NULL, 1, 0, 10, '2022-07-12 17:32:17', '2022-07-12 17:32:17', 1),
(5, 1, 3, 'assets/logo/noimage.png', 'BR.07.003', 'Gula Merah', NULL, 1, 0, 10, '2022-07-12 17:47:53', '2022-07-12 17:47:53', 1),
(6, 3, 1, 'assets/logo/noimage.png', 'BR.07.004', 'Lemonilo', NULL, 1, 0, 6, '2022-07-13 21:09:04', '2022-07-13 21:09:04', 1),
(7, 2, 1, 'assets/logo/noimage.png', 'BR.07.005', 'Ale-Ale', NULL, 1, 0, 10, '2022-07-13 21:10:06', '2022-07-13 21:10:06', 1),
(8, 2, 1, 'assets/logo/noimage.png', 'BR.07.006', 'Pino Ice Cup', 'Testttt', 1, 0, 30, '2022-07-17 16:03:28', '2022-07-17 16:03:28', 1),
(9, 4, 1, 'assets/logo/noimage.png', '13050012', 'Test Nama Barang sss', 'Test Deskripsi', 1, 0, 50, '2022-07-22 18:32:46', '2022-07-22 18:35:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_det_po`
--

CREATE TABLE `tb_det_po` (
  `id` int(11) NOT NULL,
  `id_po` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `qty_dipesan` int(11) DEFAULT 0,
  `qty_tersedia` int(11) DEFAULT 0,
  `qty_retur` int(11) DEFAULT 0,
  `harga_satuan` double DEFAULT 0,
  `is_exp_date` int(1) DEFAULT 0,
  `exp_date` date DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_det_po`
--

INSERT INTO `tb_det_po` (`id`, `id_po`, `id_barang`, `qty_dipesan`, `qty_tersedia`, `qty_retur`, `harga_satuan`, `is_exp_date`, `exp_date`, `created_at`, `updated_at`, `created_by`) VALUES
(9, 4, 2, 100, 100, 0, 1000, 0, '2022-07-21', '2022-07-21 16:02:39', '2022-07-21 16:03:36', 1),
(10, 4, 4, 100, 100, 0, 11000, 0, '2022-07-21', '2022-07-21 16:02:39', '2022-07-21 16:03:36', 1),
(11, 5, 4, 100, 50, 25, 15000, 0, '2022-07-21', '2022-07-21 16:36:25', '2022-07-21 16:48:54', 1),
(12, 6, 6, 100, 100, 0, 8000, 0, '2022-07-21', '2022-07-21 17:01:33', '2022-07-21 17:02:06', 1),
(13, 6, 7, 50, 50, 0, 1000, 0, '2022-07-21', '2022-07-21 17:01:34', '2022-07-21 17:02:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_det_stok_opname`
--

CREATE TABLE `tb_det_stok_opname` (
  `id` int(11) NOT NULL,
  `id_stok_opname` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jml_stok_nyata` double DEFAULT NULL,
  `stok_system` double DEFAULT NULL,
  `akumulasi` double DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_det_stok_opname`
--

INSERT INTO `tb_det_stok_opname` (`id`, `id_stok_opname`, `id_barang`, `jml_stok_nyata`, `stok_system`, `akumulasi`, `catatan`, `created_at`, `updated_at`) VALUES
(11, 6, 2, 100, 60, 40, 'Ada penambahan barang', '2022-07-21 18:40:01', '2022-07-21 18:40:01'),
(12, 7, 5, 20, 13, 7, 'test', '2022-07-21 18:40:45', '2022-07-21 18:40:45'),
(13, 7, 6, 134, 274, -140, 'dulu', '2022-07-21 18:40:45', '2022-07-21 18:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_det_transaksi`
--

CREATE TABLE `tb_det_transaksi` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_stok_barang` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `harga_satuan_barang` double DEFAULT NULL COMMENT 'Ambil harga dari harga grosir apabila QTY lebih dari 6, kurang dari 6 ambil dari harga eceran',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_det_transaksi`
--

INSERT INTO `tb_det_transaksi` (`id`, `id_barang`, `id_transaksi`, `id_stok_barang`, `qty`, `harga_satuan_barang`, `created_at`, `updated_at`, `created_by`) VALUES
(32, 7, 8, 23, 5, 2000, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(33, 5, 8, 0, 3, 15000, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(34, 7, 8, 16, 2, 2000, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(35, 8, 8, 0, 39, 6000, '2022-07-21 18:55:33', '2022-07-21 18:55:33', 1),
(36, 8, 9, 0, 11, 7000, '2022-07-22 19:09:40', '2022-07-22 19:09:40', 9),
(37, 9, 9, 0, 20, 7000, '2022-07-22 19:14:50', '2022-07-22 19:14:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_harga_barang`
--

CREATE TABLE `tb_harga_barang` (
  `id_harga_barang` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `harga_beli` float DEFAULT 0,
  `harga_jual_eceran` float DEFAULT NULL,
  `harga_jual_grosir` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_harga_barang`
--

INSERT INTO `tb_harga_barang` (`id_harga_barang`, `id_barang`, `harga_beli`, `harga_jual_eceran`, `harga_jual_grosir`, `created_at`, `updated_at`, `created_by`) VALUES
(6, 2, 1000, 2000, 1500, '2022-07-09 14:24:18', '2022-07-09 14:24:18', 1),
(7, 4, 15000, 18000, 17000, '2022-07-12 17:32:18', '2022-07-12 17:32:18', 1),
(8, 5, 10000, 15000, 12000, '2022-07-12 17:47:53', '2022-07-12 17:47:53', 1),
(9, 6, 5000, 9000, 7000, '2022-07-13 21:09:04', '2022-07-13 21:09:04', 1),
(10, 7, 1000, 2000, 1500, '2022-07-13 21:10:06', '2022-07-13 21:10:06', 1),
(11, 8, 1000, 2000, 1500, '2022-07-17 16:03:29', '2022-07-17 16:03:29', 1),
(12, 8, 900, 1500, 1000, '2022-07-17 16:04:19', '2022-07-17 16:04:19', 1),
(13, 8, 5000, 7000, 6000, '2022-07-17 18:28:40', '2022-07-17 18:28:40', 1),
(14, 9, 5000, 7000, 6000, '2022-07-22 18:32:46', '2022-07-22 18:32:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_keranjang_belanja`
--

CREATE TABLE `tb_keranjang_belanja` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `is_barang_has_expired_date` int(1) DEFAULT NULL,
  `id_stok_barang` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_keranjang_belanja`
--

INSERT INTO `tb_keranjang_belanja` (`id`, `id_barang`, `is_barang_has_expired_date`, `id_stok_barang`, `qty`, `created_at`, `updated_at`, `created_by`) VALUES
(36, 9, 0, 0, 60, '2022-07-22 19:07:32', '2022-07-22 19:08:46', 1),
(37, 8, 0, 0, 30, '2022-07-22 19:08:58', '2022-07-22 19:08:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_logs_activity`
--

CREATE TABLE `tb_logs_activity` (
  `id_log` int(11) NOT NULL,
  `table` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `main_data` longtext DEFAULT NULL,
  `data_detail` longtext DEFAULT NULL,
  `where` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_logs_activity`
--

INSERT INTO `tb_logs_activity` (`id_log`, `table`, `action`, `main_data`, `data_detail`, `where`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"WvHvXV5zePUkMVFVYxmVAPZUeEsdoofzX16Bsucn\",\"id_merk\":\"1\",\"id_kategori\":\"5\",\"nama_barang\":\"Asus ROG G513FU\",\"deskripsi\":\"Laptop Asus ROG G513\\r\\nSPEC :\\r\\n- RAM 8 GB\\r\\n- SSD 512 GB\\r\\n- 1060Ti 6 GB GDDR5\",\"harga_perolehan\":\"15000000\",\"tanggal_perolehan\":\"14-01-2022\",\"harga_jual\":\"16000000\",\"diskon\":\"0\",\"kondisi\":\"BARU\",\"stok\":\"100\",\"berat\":\"5000\",\"status\":\"AKTIF\",\"foto\":{},\"gallery\":[{},{},{}]}', '\"\"', '\"\"', '2022-01-14 06:08:19', NULL, 1),
(2, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"WvHvXV5zePUkMVFVYxmVAPZUeEsdoofzX16Bsucn\",\"id_merk\":\"1\",\"id_kategori\":\"5\",\"nama_barang\":\"Asus ROG G513FU\",\"deskripsi\":\"Laptop Asus ROG G513\\r\\nSPEC :\\r\\n- RAM 8 GB\\r\\n- SSD 512 GB\\r\\n- 1060Ti 6 GB GDDR5\",\"harga_perolehan\":\"15000000\",\"tanggal_perolehan\":\"14-01-2022\",\"harga_jual\":\"16000000\",\"diskon\":\"0\",\"kondisi\":\"BARU\",\"stok\":\"100\",\"berat\":\"5000\",\"status\":\"AKTIF\",\"foto\":{},\"gallery\":[{},{},{}]}', '\"\"', '\"\"', '2022-01-14 06:09:00', NULL, 1),
(3, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"WvHvXV5zePUkMVFVYxmVAPZUeEsdoofzX16Bsucn\",\"id_merk\":\"1\",\"id_kategori\":\"5\",\"nama_barang\":\"Asus ROG G513FU\",\"deskripsi\":\"Laptop Asus ROG G513\\r\\nSPEC :\\r\\n- RAM 8 GB\\r\\n- SSD 512 GB\\r\\n- 1060Ti 6 GB GDDR5\",\"harga_perolehan\":\"15000000\",\"tanggal_perolehan\":\"14-01-2022\",\"harga_jual\":\"16000000\",\"diskon\":\"0\",\"kondisi\":\"BARU\",\"stok\":\"100\",\"berat\":\"5000\",\"status\":\"AKTIF\",\"foto\":{},\"gallery\":[{},{},{}]}', '\"\"', '\"\"', '2022-01-14 06:09:43', NULL, 1),
(4, 'kategori', 'Menyimpan data kategori baru.', '{\"id_kategori\":null,\"method\":\"new\",\"parent_kategori\":\"0\",\"nama_kategori\":\"Makanan\",\"kode_kategori\":\"MKN\"}', '\"\"', '\"\"', '2022-07-06 13:20:05', NULL, 1),
(5, 'kategori', 'Menyimpan data kategori baru.', '{\"id_kategori\":null,\"method\":\"new\",\"parent_kategori\":\"0\",\"nama_kategori\":\"MINUMAN\",\"kode_kategori\":\"MNM\"}', '\"\"', '\"\"', '2022-07-06 13:20:17', NULL, 1),
(6, 'kategori', 'Mengubah data kategori.', '{\"id_kategori\":\"1\",\"method\":\"edit\",\"parent_kategori\":\"0\",\"nama_kategori\":\"MAKANAN\",\"kode_kategori\":\"MKN\"}', '\"\"', '{\"id\":\"1\"}', '2022-07-06 13:21:09', NULL, 1),
(7, 'kategori', 'Menyimpan data kategori baru.', '{\"id_kategori\":null,\"method\":\"new\",\"parent_kategori\":\"0\",\"nama_kategori\":\"Mie Instant\",\"kode_kategori\":\"MINST\"}', '\"\"', '\"\"', '2022-07-06 13:21:20', NULL, 1),
(8, 'kategori', 'Mengubah data kategori.', '{\"id_kategori\":\"3\",\"method\":\"edit\",\"parent_kategori\":\"1\",\"nama_kategori\":\"Mie Instant\",\"kode_kategori\":\"MINST\"}', '\"\"', '{\"id\":\"3\"}', '2022-07-06 13:21:36', NULL, 1),
(9, 'supplier', 'Menambahkan supplier baru.', '{\"_token\":\"rVkMXuyOeVBaQeBtr3TYdkMAV1QkryFG6cal8wAE\",\"nama\":\"Test\",\"alamat\":null,\"telepon\":null,\"hp\":null,\"email\":null,\"pic\":null,\"catatan\":null}', '\"\"', '\"\"', '2022-07-06 13:34:39', NULL, 1),
(10, 'supplier', 'Update data supplier.', '{\"_token\":\"rVkMXuyOeVBaQeBtr3TYdkMAV1QkryFG6cal8wAE\",\"id\":\"4\",\"nama\":\"Test zxczxc\",\"alamat\":null,\"telepon\":null,\"hp\":null,\"email\":null,\"pic\":null,\"catatan\":null}', '\"\"', '{\"id\":\"4\"}', '2022-07-06 13:34:51', NULL, 1),
(11, 'supplier', 'Menghapus data supplier.', '\"\"', '\"\"', '{\"id\":\"a87ff679a2f3e71d9181a67b7542122c\"}', '2022-07-06 13:34:56', NULL, 1),
(12, 'user', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"1\",\"name\":\"Admin\",\"mobile_number\":\"0000\",\"password\":null}', '\"\"', '{\"user_id\":null}', '2022-07-07 04:05:10', NULL, 1),
(13, 'user', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"1\",\"name\":\"Admin\",\"mobile_number\":\"0000\",\"password\":\"123\"}', '\"\"', '{\"user_id\":null}', '2022-07-07 04:05:18', NULL, 1),
(14, 'user', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"1\",\"name\":\"Admin\",\"mobile_number\":\"0000\",\"password\":\"admin\"}', '\"\"', '{\"user_id\":null}', '2022-07-07 04:05:32', NULL, 1),
(15, 'user', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"1\",\"name\":\"Admin\",\"mobile_number\":\"0000\",\"password\":null,\"foto\":{}}', '\"\"', '{\"user_id\":null}', '2022-07-07 04:06:28', NULL, 1),
(16, 'users', 'Menambahkan user baru.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":\"admin\"}', '\"\"', '\"\"', '2022-07-07 04:56:14', NULL, 1),
(17, 'users', 'Menambahkan user baru.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"test\",\"mobile_number\":\"123123\",\"username\":\"123\",\"email\":\"123@123.com\",\"password\":\"123\"}', '\"\"', '\"\"', '2022-07-07 04:58:15', NULL, 1),
(18, 'users', 'Menambahkan user baru.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"123123123\",\"mobile_number\":\"123123\",\"username\":\"123\",\"email\":\"123@123.com\",\"password\":\"123\"}', '\"\"', '\"\"', '2022-07-07 04:58:46', NULL, 1),
(19, 'users', 'Menghapus data user.', '\"\"', '\"\"', '{\"id\":\"1679091c5a880faf6fb5e6087eb1b2dc\"}', '2022-07-07 04:58:49', NULL, 1),
(20, 'users', 'Menambahkan user baru.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":\"admin\",\"foto\":{}}', '\"\"', '\"\"', '2022-07-07 04:59:18', NULL, 1),
(21, 'users', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":null,\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 05:31:46', NULL, 1),
(22, 'users', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":null,\"status\":\"Non-Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 05:32:26', NULL, 1),
(23, 'users', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":null,\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 05:32:29', NULL, 1),
(24, 'users', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":\"pemilik\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 05:32:34', NULL, 1),
(25, 'users', 'Mengubah user.', '{\"_token\":\"jZ51YgL6Lvw01wU3uQSAUvCpmKIiDaa8iv3dX4s2\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":null,\"status\":\"Aktif\",\"foto\":{}}', '\"\"', '{\"id\":null}', '2022-07-07 05:32:57', NULL, 7),
(26, 'users', 'Menambahkan user baru.', '{\"_token\":\"aZQR5v2tX7uhYmHGZmgd6lnHe7N8q2MolGDBKdea\",\"role\":\"Supplier\",\"id_supplier\":\"1\",\"name\":\"User Supplier 1\",\"mobile_number\":\"1234\",\"username\":\"supplier1\",\"email\":\"user1@supplier.com\",\"password\":\"admin\"}', '\"\"', '\"\"', '2022-07-07 10:29:09', NULL, 1),
(27, 'users', 'Mengubah user.', '{\"_token\":\"aZQR5v2tX7uhYmHGZmgd6lnHe7N8q2MolGDBKdea\",\"user_id\":\"8\",\"role\":\"Admin\",\"id_supplier\":\"1\",\"name\":\"User Supplier 1\",\"mobile_number\":\"1234\",\"username\":\"supplier1\",\"email\":\"user1@supplier.com\",\"password\":null,\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 10:30:31', NULL, 1),
(28, 'users', 'Mengubah user.', '{\"_token\":\"aZQR5v2tX7uhYmHGZmgd6lnHe7N8q2MolGDBKdea\",\"user_id\":\"8\",\"role\":\"Supplier\",\"id_supplier\":\"1\",\"name\":\"User Supplier 1\",\"mobile_number\":\"1234\",\"username\":\"supplier1\",\"email\":\"user1@supplier.com\",\"password\":null,\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-07 10:30:36', NULL, 1),
(29, 'satuan', 'Menambahkan satuan baru.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"nama\":\"Pcs\"}', '\"\"', '\"\"', '2022-07-08 04:07:13', NULL, 1),
(30, 'satuan', 'Menambahkan satuan baru.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"nama\":\"ree\"}', '\"\"', '\"\"', '2022-07-08 04:08:19', NULL, 1),
(31, 'satuan', 'Update data satuan.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"id\":\"2\",\"nama\":\"ree\",\"status\":\"0\"}', '\"\"', '{\"id\":\"2\"}', '2022-07-08 04:11:27', NULL, 1),
(32, 'satuan', 'Update data satuan.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"id\":\"2\",\"nama\":\"ree\",\"status\":\"1\"}', '\"\"', '{\"id\":\"2\"}', '2022-07-08 04:11:33', NULL, 1),
(33, 'satuan', 'Update data satuan.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"id\":\"2\",\"nama\":\"Dus\",\"status\":\"1\"}', '\"\"', '{\"id\":\"2\"}', '2022-07-08 04:11:39', NULL, 1),
(34, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Ale Ale 200 ml\",\"deskripsi\":null,\"harga_beli\":\"0\",\"harga_grosir\":\"0\",\"harga_eceran\":\"0\",\"qty_grosir\":\"0\",\"is_expiracy\":\"0\",\"tgl_kadaluarsa\":\"2022-07-08\",\"stok\":\"0\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-08 06:54:08', NULL, 1),
(35, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"jwFLJ2ADgob5PnQVdjrUzF2THTSdbWIs1OcmCBDA\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"harga_beli\":\"1,000\",\"harga_grosir\":\"1,500\",\"harga_eceran\":\"2,000\",\"qty_grosir\":\"8\",\"is_expiracy\":\"1\",\"tgl_kadaluarsa\":\"2023-11-02\",\"stok\":\"100\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-08 07:00:37', NULL, 1),
(36, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_satuan\":\"2\",\"id_kategori\":\"3\",\"nama_barang\":\"Mie Lemonilo\",\"deskripsi\":\"AWhawhwah\",\"harga_beli\":\"5,000\",\"harga_grosir\":\"7,000\",\"harga_eceran\":\"9,000\",\"qty_grosir\":\"5\",\"is_expiracy\":\"1\",\"tgl_kadaluarsa\":\"2025-01-01\",\"stok\":\"200\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-09 03:48:59', NULL, 1),
(37, 'barang', 'Menghapus data barang.', '\"\"', '\"\"', '{\"id\":\"eccbc87e4b5ce2fe28308fd9f2a7baf3\"}', '2022-07-09 03:49:35', NULL, 1),
(38, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"2\",\"id_kategori\":\"2\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"8\"}', '\"\"', '\"\"', '2022-07-09 05:00:03', NULL, 1),
(39, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"8\"}', '\"\"', '\"\"', '2022-07-09 05:00:12', NULL, 1),
(40, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Beng Beng 2\",\"deskripsi\":\"Deskripsi Test 3\",\"is_expiracy\":\"0\",\"status\":\"0\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 05:00:28', NULL, 1),
(41, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 05:00:38', NULL, 1),
(42, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 05:00:41', NULL, 1),
(43, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 05:01:03', NULL, 1),
(44, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 05:01:12', NULL, 1),
(45, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\",\"foto\":{}}', '\"\"', '\"\"', '2022-07-09 05:58:41', NULL, 1),
(46, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 06:21:36', NULL, 1),
(47, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 07:17:30', NULL, 1),
(48, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 07:20:39', NULL, 1),
(49, 'tb_harga_barang', 'Delete harga barang.', '\"\"', '\"\"', '{\"id_harga_barang\":\"5\"}', '2022-07-09 07:23:23', NULL, 1),
(50, 'tb_harga_barang', 'Add harga barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"harga_beli\":\"1,000\",\"harga_grosir\":\"1,500\",\"harga_eceran\":\"2,000\"}', '\"\"', '\"\"', '2022-07-09 07:24:19', NULL, 1),
(51, 'tb_harga_barang', 'Delete harga barang.', '\"\"', '\"\"', '{\"id_harga_barang\":\"4\"}', '2022-07-09 07:24:24', NULL, 1),
(52, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"tgl_kadaluarsa\":\"2023-04-07\",\"stok\":\"50\"}', '\"\"', '\"\"', '2022-07-09 07:54:05', NULL, 1),
(53, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 07:54:18', NULL, 1),
(54, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 07:56:19', NULL, 1),
(55, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"3\"}', '2022-07-09 07:59:51', NULL, 1),
(56, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-09\",\"stok\":\"10\"}', '\"\"', '\"\"', '2022-07-09 08:05:06', NULL, 1),
(57, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-09\",\"stok\":\"5\"}', '\"\"', '\"\"', '2022-07-09 08:05:22', NULL, 1),
(58, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-10\",\"stok\":\"50\"}', '\"\"', '\"\"', '2022-07-09 08:05:35', NULL, 1),
(59, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-10\",\"stok\":\"55\"}', '\"\"', '\"\"', '2022-07-09 08:05:46', NULL, 1),
(60, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"5\"}', '2022-07-09 08:05:54', NULL, 1),
(61, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 08:07:47', NULL, 1),
(62, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-09\",\"stok\":\"100\"}', '\"\"', '\"\"', '2022-07-09 08:07:55', NULL, 1),
(63, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-09\",\"stok\":\"10\"}', '\"\"', '\"\"', '2022-07-09 08:07:59', NULL, 1),
(64, 'barang', 'Mengupdate data barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"1\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-09 08:08:06', NULL, 1),
(65, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"mXX1qvAYK54hVYgpeOqeuzct9yObQ4WGRzZ5XQAi\",\"id\":\"6\",\"id_barang\":\"2\",\"stok\":\"7\"}', '\"\"', '{\"id_stok_barang\":\"6\"}', '2022-07-09 09:25:57', NULL, 1),
(66, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"7\"}', '2022-07-09 09:26:52', NULL, 1),
(67, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"6\"}', '2022-07-09 09:27:31', NULL, 1),
(68, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-12\",\"stok\":\"5\"}', '\"\"', '\"\"', '2022-07-12 10:28:23', NULL, 1),
(69, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"8\"}', '2022-07-12 10:28:26', NULL, 1),
(70, 'satuan', 'Menambahkan satuan baru.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"nama\":\"Kg\"}', '\"\"', '\"\"', '2022-07-12 10:31:08', NULL, 1),
(71, 'satuan', 'Menambahkan satuan baru.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"nama\":\"Gram\"}', '\"\"', '\"\"', '2022-07-12 10:31:13', NULL, 1),
(72, 'satuan', 'Update data satuan.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id\":\"3\",\"nama\":\"Kilogram\",\"status\":\"1\"}', '\"\"', '{\"id\":\"3\"}', '2022-07-12 10:31:21', NULL, 1),
(73, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_satuan\":\"3\",\"id_kategori\":\"1\",\"nama_barang\":\"Gula Putih\",\"deskripsi\":null,\"harga_beli\":\"15,000\",\"harga_grosir\":\"17,000\",\"harga_eceran\":\"18,000\",\"qty_grosir\":\"10\",\"is_expiracy\":\"0\",\"tgl_kadaluarsa\":\"2022-07-12\",\"stok\":\"25.5\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-12 10:32:18', NULL, 1),
(74, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_barang\":\"4\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-12\",\"stok\":\"8.8\"}', '\"\"', '\"\"', '2022-07-12 10:38:36', NULL, 1),
(75, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"10\"}', '2022-07-12 10:44:03', NULL, 1),
(76, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_barang\":\"4\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-12\",\"stok\":\"5.5\"}', '\"\"', '\"\"', '2022-07-12 10:44:12', NULL, 1),
(77, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id\":\"11\",\"id_barang\":\"4\",\"stok\":\"5.3\"}', '\"\"', '{\"id_stok_barang\":\"11\"}', '2022-07-12 10:45:17', NULL, 1),
(78, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_satuan\":\"3\",\"id_kategori\":\"1\",\"nama_barang\":\"Gula Merah\",\"deskripsi\":null,\"harga_beli\":\"10,000\",\"harga_grosir\":\"12,000\",\"harga_eceran\":\"15,000\",\"qty_grosir\":\"10\",\"is_expiracy\":\"0\",\"tgl_kadaluarsa\":\"2022-07-12\",\"stok\":\"15.8\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-12 10:47:53', NULL, 1),
(79, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2022-07-30\",\"stok\":\"10.5\"}', '\"\"', '\"\"', '2022-07-12 11:25:34', NULL, 1),
(80, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id\":\"13\",\"id_barang\":\"2\",\"stok\":\"0.5\"}', '\"\"', '{\"id_stok_barang\":\"13\"}', '2022-07-12 11:25:44', NULL, 1),
(81, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"3.8\"}', '\"\"', '\"\"', '2022-07-12 13:05:32', NULL, 1),
(82, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"4\",\"qty\":\"3\"}', '\"\"', '\"\"', '2022-07-12 13:55:15', NULL, 1),
(83, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"1.2\"}', '\"\"', '\"\"', '2022-07-12 14:06:53', NULL, 1),
(84, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2\"}', '\"\"', '\"\"', '2022-07-12 14:07:56', NULL, 1),
(85, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"4\",\"qty\":\"2\"}', '\"\"', '\"\"', '2022-07-12 14:08:30', NULL, 1),
(86, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"1\",\"qty\":\"50\"}', '\"\"', '\"\"', '2022-07-12 14:08:40', NULL, 1),
(87, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"4\"}', '2022-07-12 14:18:12', NULL, 1),
(88, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"3\"}', '2022-07-12 14:18:16', NULL, 1),
(89, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"2\"}', '2022-07-12 14:18:18', NULL, 1),
(90, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"1\"}', '2022-07-12 14:18:20', NULL, 1),
(91, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-12 14:18:37', NULL, 1),
(92, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"4\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-12 14:18:48', NULL, 1),
(93, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-12 14:19:47', NULL, 1),
(94, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"1\",\"qty\":\"50\"}', '\"\"', '\"\"', '2022-07-12 14:20:18', NULL, 1),
(95, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"13\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-12 14:20:26', NULL, 1),
(96, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"13\"}', '\"\"', '\"\"', '2022-07-12 14:41:02', NULL, 1),
(97, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"WZ11ExYTgzp5ooNg3tfTuIaUYzZfZHVB0jcdPd6D\",\"id\":\"12\",\"id_barang\":\"5\",\"stok\":\"5\"}', '\"\"', '{\"id_stok_barang\":\"12\"}', '2022-07-12 14:41:22', NULL, 1),
(98, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"5\"}', '2022-07-12 14:41:48', NULL, 1),
(99, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"4\"}', '\"\"', '\"\"', '2022-07-12 14:41:55', NULL, 1),
(100, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"12.2\"}', '\"\"', '\"\"', '2022-07-13 00:06:33', NULL, 1),
(101, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-13 00:07:25', NULL, 1),
(102, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-13 00:07:36', NULL, 1),
(103, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"10\"}', '2022-07-13 00:07:50', NULL, 1),
(104, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"1\",\"qty\":\"50\"}', '\"\"', '\"\"', '2022-07-13 04:07:35', NULL, 1),
(105, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"11\"}', '2022-07-13 04:07:45', NULL, 1),
(106, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-13 04:07:52', NULL, 1),
(107, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"0.8\"}', '\"\"', '\"\"', '2022-07-13 04:08:00', NULL, 1),
(108, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2.2\"}', '\"\"', '\"\"', '2022-07-13 05:21:07', NULL, 1),
(109, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"4\",\"qty\":\"3\"}', '\"\"', '\"\"', '2022-07-13 05:21:46', NULL, 1),
(110, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"13\"}', '2022-07-13 05:22:05', NULL, 1),
(111, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"1\",\"qty\":\"2\"}', '\"\"', '\"\"', '2022-07-13 05:30:58', NULL, 1),
(112, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"3.8\"}', '\"\"', '\"\"', '2022-07-13 05:31:13', NULL, 1),
(113, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2.8\"}', '\"\"', '\"\"', '2022-07-13 05:39:14', NULL, 1),
(114, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"13\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-13 11:46:35', NULL, 1),
(115, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"8\"}', '\"\"', '\"\"', '2022-07-13 11:54:30', NULL, 1),
(116, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"AEa1Wdsc9AHcUNZmHUdsdUbzW1C1l5uZ50HmQuF3\",\"id\":\"12\",\"id_barang\":\"5\",\"stok\":\"5\"}', '\"\"', '{\"id_stok_barang\":\"12\"}', '2022-07-13 11:54:43', NULL, 1),
(117, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"17\"}', '2022-07-13 11:55:18', NULL, 1),
(118, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2.8\"}', '\"\"', '\"\"', '2022-07-13 11:55:25', NULL, 1),
(119, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"13\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-13 11:56:25', NULL, 1),
(120, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"AEa1Wdsc9AHcUNZmHUdsdUbzW1C1l5uZ50HmQuF3\",\"id_barang\":\"5\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-13\",\"stok\":\"2\"}', '\"\"', '\"\"', '2022-07-13 13:10:35', NULL, 1),
(121, 'tb_stok_barang', 'Mengeluarkan stok barang.', '{\"_token\":\"AEa1Wdsc9AHcUNZmHUdsdUbzW1C1l5uZ50HmQuF3\",\"id\":\"12\",\"id_barang\":\"5\",\"stok\":\"0.8\"}', '\"\"', '{\"id_stok_barang\":\"12\"}', '2022-07-13 13:17:38', NULL, 1),
(122, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2.2\"}', '\"\"', '\"\"', '2022-07-13 14:01:01', NULL, 1),
(123, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"4\",\"qty\":\"15\"}', '\"\"', '\"\"', '2022-07-13 14:01:11', NULL, 1),
(124, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"1.2\"}', '\"\"', '\"\"', '2022-07-13 14:06:16', NULL, 1),
(125, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"16.2\"}', '\"\"', '\"\"', '2022-07-13 14:06:27', NULL, 1),
(126, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"AEa1Wdsc9AHcUNZmHUdsdUbzW1C1l5uZ50HmQuF3\",\"id_satuan\":\"1\",\"id_kategori\":\"3\",\"nama_barang\":\"Lemonilo\",\"deskripsi\":null,\"harga_beli\":\"5,000\",\"harga_grosir\":\"7,000\",\"harga_eceran\":\"9,000\",\"qty_grosir\":\"6\",\"is_expiracy\":\"1\",\"tgl_kadaluarsa\":\"2023-08-25\",\"stok\":\"100\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-13 14:09:04', NULL, 1),
(127, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"AEa1Wdsc9AHcUNZmHUdsdUbzW1C1l5uZ50HmQuF3\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Ale-Ale\",\"deskripsi\":null,\"harga_beli\":\"1,000\",\"harga_grosir\":\"1,500\",\"harga_eceran\":\"2,000\",\"qty_grosir\":\"10\",\"is_expiracy\":\"1\",\"tgl_kadaluarsa\":\"2023-09-22\",\"stok\":\"50\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-13 14:10:06', NULL, 1),
(128, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"9\"}', '\"\"', '\"\"', '2022-07-13 14:11:11', NULL, 1),
(129, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-13 14:11:16', NULL, 1),
(130, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"6\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"15\",\"qty\":\"3\"}', '\"\"', '\"\"', '2022-07-13 14:12:17', NULL, 1),
(131, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"6\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"15\",\"qty\":\"3\"}', '\"\"', '\"\"', '2022-07-13 14:12:24', NULL, 1),
(132, 'users', 'Menambahkan user baru.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"role\":\"Pembeli\",\"id_supplier\":\"0\",\"name\":\"Pembeli Test\",\"mobile_number\":\"0123000\",\"username\":\"pembeli\",\"email\":\"user@pembeli.com\",\"password\":\"admin\"}', '\"\"', '\"\"', '2022-07-14 02:14:37', NULL, 1),
(133, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"6\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"15\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 02:15:40', NULL, 9),
(134, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"2\"}', '\"\"', '\"\"', '2022-07-14 02:15:51', NULL, 9),
(135, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":[\"6\",\"7\"],\"id_stok_barang\":[\"15\",\"16\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Saya akan ambil nanti siang\",\"cart_total\":\"49,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"49,000\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-49,000\"}', '\"\"', '\"\"', '2022-07-14 02:18:42', NULL, 9),
(136, 'users', 'Mengubah user.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":\"admin\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-14 02:26:50', NULL, 1),
(137, 'users', 'Mengubah user.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"user_id\":\"8\",\"role\":\"Supplier\",\"id_supplier\":\"1\",\"name\":\"User Supplier 1\",\"mobile_number\":\"1234\",\"username\":\"supplier1\",\"email\":\"user1@supplier.com\",\"password\":\"admin\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-14 02:26:53', NULL, 1),
(138, 'tb_transaksi', 'Update status transaksi.', '{\"status\":\"Cancel\"}', '\"\"', '{\"id\":4}', '2022-07-14 04:07:53', NULL, 1),
(139, 'tb_transaksi', 'Update status transaksi.', '{\"status\":\"VOID\"}', '\"\"', '{\"id\":3}', '2022-07-14 04:09:52', NULL, 1),
(140, 'tb_stok_barang', 'Delete stok barang.', '\"\"', '\"\"', '{\"id_stok_barang\":\"14\"}', '2022-07-14 04:33:04', NULL, 1),
(141, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":\"5\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-14\",\"stok\":\"2\"}', '\"\"', '\"\"', '2022-07-14 04:37:39', NULL, 1),
(142, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":\"5\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-14\",\"stok\":\"2\"}', '\"\"', '\"\"', '2022-07-14 04:37:46', NULL, 1),
(143, 'tb_transaksi', 'Update status transaksi.', '{\"status\":\"VOID\"}', '\"\"', '{\"id\":3}', '2022-07-14 04:42:46', NULL, 1),
(144, 'tb_transaksi', 'Update status transaksi.', '{\"status\":\"VOID\"}', '\"\"', '{\"id\":2}', '2022-07-14 04:44:30', NULL, 1),
(145, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":[\"7\",\"6\"],\"id_stok_barang\":[\"16\",\"15\"],\"nama_pembeli\":\"Mawar\",\"keterangan\":\"Testtt\",\"cart_total\":\"57,000\",\"cart_diskon\":\"6,000\",\"cart_sub\":\"51,000\",\"cart_dibayarkan\":\"55,000\",\"cart_kembalian\":\"4,000\"}', '\"\"', '\"\"', '2022-07-14 05:08:05', NULL, 1),
(146, 'tb_transaksi', 'Menghapus data transaksi.', '\"\"', '\"\"', '{\"id\":\"c81e728d9d4c2f636f067f89cc14862c\"}', '2022-07-14 05:22:08', NULL, 1),
(147, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-14 07:46:34', NULL, 1),
(148, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-14 07:49:07', NULL, 1),
(149, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"12\"}', '2022-07-14 07:54:08', NULL, 1),
(150, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 07:54:21', NULL, 1),
(151, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"13\"}', '2022-07-14 08:15:05', NULL, 1),
(152, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-14 08:15:17', NULL, 1),
(153, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"14\"}', '2022-07-14 08:16:59', NULL, 1),
(154, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:17:05', NULL, 1),
(155, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:17:12', NULL, 1),
(156, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:18:07', NULL, 1),
(157, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:19:34', NULL, 1),
(158, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"18\"}', '2022-07-14 08:19:41', NULL, 1),
(159, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-14 08:20:57', NULL, 1),
(160, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"19\"}', '2022-07-14 08:21:02', NULL, 1),
(161, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"17\"}', '2022-07-14 08:23:28', NULL, 1),
(162, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":null,\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:23:38', NULL, 1),
(163, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"20\"}', '2022-07-14 08:23:44', NULL, 1),
(164, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:25:11', NULL, 1),
(165, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 08:25:17', NULL, 1),
(166, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"22\"}', '2022-07-14 08:25:27', NULL, 1),
(167, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"21\"}', '2022-07-14 08:25:29', NULL, 1),
(168, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"1\"}', '\"\"', '\"\"', '2022-07-14 08:27:15', NULL, 1),
(169, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"29\"}', '\"\"', '\"\"', '2022-07-14 08:30:44', NULL, 1),
(170, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-14 08:31:01', NULL, 1),
(171, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"2.2\"}', '\"\"', '\"\"', '2022-07-14 08:31:10', NULL, 1),
(172, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"6.2\"}', '\"\"', '\"\"', '2022-07-14 08:31:28', NULL, 1),
(173, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"3.2\"}', '\"\"', '\"\"', '2022-07-14 08:54:23', NULL, 1),
(174, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"20\"}', '\"\"', '\"\"', '2022-07-14 08:54:42', NULL, 1),
(175, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_transaksi\":\"4\",\"id_barang\":[\"5\",\"7\"],\"id_stok_barang\":[\"0\",\"16\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Saya akan ambil nanti siang\",\"cart_total\":\"78,000\",\"cart_diskon\":\"1,000\",\"cart_sub\":\"77,000\",\"cart_dibayarkan\":\"100,000\",\"cart_kembalian\":\"23,000\"}', '\"\"', '{\"id\":\"4\"}', '2022-07-14 08:55:05', NULL, 1),
(176, 'tb_transaksi', 'Update status transaksi.', '{\"status\":\"VOID\"}', '\"\"', '{\"id\":4}', '2022-07-14 08:56:09', NULL, 1),
(177, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-14 08:57:26', NULL, 9),
(178, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"1.4\"}', '\"\"', '\"\"', '2022-07-14 08:57:32', NULL, 9),
(179, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":[\"7\",\"5\"],\"id_stok_barang\":[\"16\",\"0\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Akan saya ambil, pasti.\",\"cart_total\":\"36,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"36,000\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-36,000\"}', '\"\"', '\"\"', '2022-07-14 08:57:42', NULL, 9),
(180, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_transaksi\":\"6\",\"id_barang\":[\"7\",\"5\"],\"id_stok_barang\":[\"16\",\"0\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Akan saya ambil, pasti. Bohonggg\",\"cart_total\":\"36,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"36,000\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-36,000\"}', '\"\"', '{\"id\":\"6\"}', '2022-07-14 08:58:09', NULL, 9),
(181, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"4\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"3.2\"}', '\"\"', '\"\"', '2022-07-14 08:58:25', NULL, 9),
(182, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_transaksi\":\"6\",\"id_barang\":[\"7\",\"5\",\"4\"],\"id_stok_barang\":[\"16\",\"0\",\"0\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Akan saya ambil, pasti. Bohonggg\",\"cart_total\":\"93,600\",\"cart_diskon\":\"0\",\"cart_sub\":\"93,600\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-93,600\"}', '\"\"', '{\"id\":\"6\"}', '2022-07-14 08:58:51', NULL, 9),
(183, 'tb_det_transaksi', 'Delete item dari list detail transaksi.', '\"\"', '\"\"', '{\"id\":\"29\"}', '2022-07-14 09:21:17', NULL, 9),
(184, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"2\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"1\",\"qty\":\"25\"}', '\"\"', '\"\"', '2022-07-14 09:21:53', NULL, 1),
(185, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_transaksi\":\"6\",\"id_barang\":[\"7\",\"5\",\"2\"],\"id_stok_barang\":[\"16\",\"0\",\"1\"],\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Akan saya ambil, pasti. Bohonggg\",\"cart_total\":\"73,500\",\"cart_diskon\":\"2,500\",\"cart_sub\":\"71,000\",\"cart_dibayarkan\":\"75,000\",\"cart_kembalian\":\"4,000\"}', '\"\"', '{\"id\":\"6\"}', '2022-07-14 09:22:19', NULL, 1),
(186, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 09:33:10', NULL, 1),
(187, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-14 09:34:12', NULL, 9),
(188, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_barang\":[\"7\"],\"id_stok_barang\":[\"16\"],\"tgl_trx\":\"2021-08-01T16:33:47\",\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"WE\",\"cart_total\":\"10,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"10,000\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-10,000\"}', '\"\"', '\"\"', '2022-07-14 09:34:33', NULL, 9),
(189, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"MooiylA17uIhX2KB7CMDtAwrYu6pfxwx5xlM3zaM\",\"id_transaksi\":\"7\",\"id_barang\":[\"7\"],\"id_stok_barang\":[\"16\"],\"tgl_trx\":\"2022-07-14T16:33:47\",\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"WE\",\"cart_total\":\"10,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"10,000\",\"cart_dibayarkan\":\"10,000\",\"cart_kembalian\":\"0\"}', '\"\"', '{\"id\":\"7\"}', '2022-07-14 09:35:49', NULL, 1),
(190, 'tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '\"\"', '\"\"', '{\"id\":\"30\"}', '2022-07-14 09:36:06', NULL, 1),
(191, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"id_vendor\":\"1\",\"tanggal_po\":\"15-07-2022\",\"catatan\":\"<p>Testttt<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.001 - Beng Beng (Pcs)\"],\"id_barang\":[\"2\"],\"qty\":[\"1\"]}', '\"\"', '\"\"', '2022-07-15 04:37:38', NULL, 1),
(192, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"id_vendor\":\"1\",\"tanggal_po\":\"15-07-2022\",\"catatan\":\"<p>Pemesanan untuk nanti<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.001 - Beng Beng (Pcs)\",\"BR.07.002 - Gula Putih (Kilogram)\",\"BR.07.004 - Lemonilo (Pcs)\"],\"id_barang\":[\"2\",\"4\",\"6\"],\"qty\":[\"16.22\",\"20\",\"600\"]}', '\"\"', '\"\"', '2022-07-15 05:00:32', NULL, 1),
(193, 'tb_po', 'Menghapus data PO.', '\"\"', '\"\"', '{\"id\":\"c4ca4238a0b923820dcc509a6f75849b\"}', '2022-07-15 09:28:34', NULL, 1),
(194, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"id_vendor\":\"1\",\"tanggal_po\":\"15-07-2022\",\"catatan\":\"<p>Testtt<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.005 - Ale-Ale (Pcs)\",\"BR.07.004 - Lemonilo (Pcs)\"],\"id_barang\":[\"7\",\"6\"],\"qty\":[\"10\",\"10\"]}', '\"\"', '\"\"', '2022-07-15 09:40:19', NULL, 1),
(195, 'supplier', 'Menambahkan supplier baru.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"nama\":\"Adam Supply\",\"alamat\":null,\"telepon\":null,\"hp\":null,\"email\":null,\"pic\":null,\"catatan\":null}', '\"\"', '\"\"', '2022-07-15 09:51:58', NULL, 1),
(196, 'users', 'Menambahkan user baru.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"role\":\"Supplier\",\"id_supplier\":\"5\",\"name\":\"Adam Supply User\",\"mobile_number\":\"0828388\",\"username\":\"adamsupply\",\"email\":\"adam@supply.com\",\"password\":\"admin\"}', '\"\"', '\"\"', '2022-07-15 09:52:32', NULL, 1),
(197, 'tb_det_po', 'Menghapus data item PO.', '\"\"', '\"\"', '{\"id\":\"a87ff679a2f3e71d9181a67b7542122c\"}', '2022-07-15 10:23:07', NULL, 1),
(198, 'tb_po', 'Mengupdate PO.', '{\"_token\":\"JP37Zuu2i3BQ4UkX4SHYcf7I2ynErjWzCH78iMw2\",\"id\":\"3\",\"id_supplier\":\"1\",\"tanggal_po\":\"16-07-2022\",\"catatan\":\"<p>Testtt aweee<\\/p>\",\"files\":null,\"catatan_supplier\":null}', '\"\"', '\"\"', '2022-07-15 10:34:20', NULL, 1),
(199, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"id_barang\":\"7\",\"is_kadaluarsa_active\":\"1\",\"tgl_kadaluarsa\":\"2023-07-30\",\"stok\":\"5\"}', '\"\"', '\"\"', '2022-07-15 13:09:27', NULL, 1),
(200, 'users', 'Mengubah user.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"user_id\":\"7\",\"role\":\"Pemilik\",\"id_supplier\":\"0\",\"name\":\"Pemilik\",\"mobile_number\":\"081\",\"username\":\"pemilik\",\"email\":\"user@pemilik.com\",\"password\":\"admin\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-15 14:27:15', NULL, 1);
INSERT INTO `tb_logs_activity` (`id_log`, `table`, `action`, `main_data`, `data_detail`, `where`, `created_at`, `updated_at`, `created_by`) VALUES
(201, 'users', 'Mengubah user.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"user_id\":\"9\",\"role\":\"Pembeli\",\"id_supplier\":\"0\",\"name\":\"Pembeli Test\",\"mobile_number\":\"0123000\",\"username\":\"pembeli\",\"email\":\"user@pembeli.com\",\"password\":\"admin\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-15 14:27:27', NULL, 1),
(202, 'users', 'Mengubah user.', '{\"_token\":\"YpdGFmr8hq35SwZ724d97AvsBzTZTsi7SIN4egQ7\",\"user_id\":\"10\",\"role\":\"Supplier\",\"id_supplier\":\"5\",\"name\":\"Adam Supply User\",\"mobile_number\":\"0828388\",\"username\":\"adamsupply\",\"email\":\"adam@supply.com\",\"password\":\"admin\",\"status\":\"Aktif\"}', '\"\"', '{\"id\":null}', '2022-07-15 14:27:35', NULL, 1),
(203, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"23\",\"qty\":\"5\"}', '\"\"', '\"\"', '2022-07-15 15:04:23', NULL, 1),
(204, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"5\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"3\"}', '\"\"', '\"\"', '2022-07-15 15:04:31', NULL, 1),
(205, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"7\",\"is_barang_has_expired_date\":\"1\",\"id_stok_barang\":\"16\",\"qty\":\"2\"}', '\"\"', '\"\"', '2022-07-15 23:24:54', NULL, 1),
(206, 'tb_stok_opname', 'Menambahkan data stok opname baru.', '{\"_token\":\"UXFTTd9uC5utFzilvHvZVrO5MFy9OzJSToZxQpMc\",\"tgl_opname\":\"2022-07-16\",\"id_barang\":[\"2\",\"5\"],\"qty_system\":[\"105\",\"13\"],\"qty_real\":[\"90\",\"5\"],\"qty_varian\":[\"-15\",\"-8\"],\"keterangan\":[\"Beng Beng beberapa kadaluarsa\",\"Gula merah dimakan semut sebagian\"]}', '\"\"', '\"\"', '2022-07-16 07:19:02', NULL, 1),
(207, 'tb_stok_opname', 'Menghapus data stok opname.', '\"\"', '\"\"', '{\"id\":\"c4ca4238a0b923820dcc509a6f75849b\"}', '2022-07-16 07:42:56', NULL, 1),
(208, 'tb_stok_opname', 'Menambahkan data stok opname baru.', '{\"_token\":\"UXFTTd9uC5utFzilvHvZVrO5MFy9OzJSToZxQpMc\",\"tgl_opname\":\"2022-07-16\",\"id_barang\":[\"2\",\"4\",\"5\",\"6\",\"7\"],\"qty_system\":[\"105\",\"35.2\",\"13\",\"174\",\"35\"],\"qty_real\":[\"30\",\"12.2\",\"10\",\"55\",\"22\"],\"qty_varian\":[\"-75.0\",\"-23.0\",\"-3.0\",\"-119.0\",\"-13.0\"],\"keterangan\":[\"test\",\"dulu\",\"saja\",\"ayo\",\"testa\"]}', '\"\"', '\"\"', '2022-07-16 07:53:08', NULL, 1),
(209, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"6UFIwxS6PlUaeOW23KM3nwEMh82UdGRhf2zzhlWe\",\"id_satuan\":\"1\",\"id_kategori\":\"2\",\"nama_barang\":\"Pino Ice Cup\",\"deskripsi\":\"Testttt\",\"harga_beli\":\"1,000\",\"harga_grosir\":\"1,500\",\"harga_eceran\":\"2,000\",\"qty_grosir\":\"30\",\"is_expiracy\":\"0\",\"tgl_kadaluarsa\":\"2022-07-17\",\"stok\":\"100\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-17 09:03:29', NULL, 1),
(210, 'tb_harga_barang', 'Add harga barang.', '{\"_token\":\"6UFIwxS6PlUaeOW23KM3nwEMh82UdGRhf2zzhlWe\",\"id_barang\":\"8\",\"harga_beli\":\"900\",\"harga_grosir\":\"1,000\",\"harga_eceran\":\"1,500\"}', '\"\"', '\"\"', '2022-07-17 09:04:19', NULL, 1),
(211, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"8\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-17 09:07:51', NULL, 1),
(212, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"8\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"30\"}', '\"\"', '\"\"', '2022-07-17 09:08:01', NULL, 1),
(213, 'tb_harga_barang', 'Add harga barang.', '{\"_token\":\"Ogy0tD2udRHSmTeJjQMHUX70rmp8WpUMbOWwvjaS\",\"id_barang\":\"8\",\"harga_beli\":\"5,000\",\"harga_grosir\":\"6,000\",\"harga_eceran\":\"7,000\"}', '\"\"', '\"\"', '2022-07-17 11:28:40', NULL, 1),
(214, 'tb_stok_opname', 'Menambahkan data stok opname baru.', '{\"_token\":\"N74yaFrCMS7PCr81hHBgDvVENgZyOWW6MSnRxZDi\",\"tgl_opname\":\"2022-07-19\",\"id_barang\":[\"2\",\"4\"],\"qty_system\":[\"105\",\"35.2\"],\"qty_real\":[\"10\",\"20\"],\"qty_varian\":[\"-95.0\",\"-15.2\"],\"keterangan\":[\"Test\",\"Akan diupdate\"]}', '\"\"', '\"\"', '2022-07-18 23:08:48', NULL, 1),
(215, 'barang', 'Mengupdate data barang.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id\":\"2\",\"id_satuan\":\"1\",\"id_kategori\":\"1\",\"nama_barang\":\"Beng Beng\",\"deskripsi\":\"Deskripsi Test\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"10\"}', '\"\"', '\"\"', '2022-07-21 08:46:21', NULL, 1),
(216, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"8\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"-1\"}', '\"\"', '\"\"', '2022-07-21 08:50:09', NULL, 1),
(217, 'kategori', 'Menyimpan data kategori baru.', '{\"id_kategori\":null,\"method\":\"new\",\"parent_kategori\":\"0\",\"nama_kategori\":\"Test\",\"kode_kategori\":null}', '\"\"', '\"\"', '2022-07-21 08:52:01', NULL, 1),
(218, 'kategori', 'Mengubah data kategori.', '{\"id_kategori\":\"4\",\"method\":\"edit\",\"parent_kategori\":\"0\",\"nama_kategori\":\"Test ss\",\"kode_kategori\":null}', '\"\"', '{\"id\":\"4\"}', '2022-07-21 08:52:06', NULL, 1),
(219, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_vendor\":\"5\",\"tanggal_po\":\"21-07-2022\",\"catatan\":\"<p>Testtt<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.001 - Beng Beng (Pcs)\",\"BR.07.002 - Gula Putih (Kilogram)\"],\"id_barang\":[\"2\",\"4\"],\"qty\":[\"100\",\"100\"]}', '\"\"', '\"\"', '2022-07-21 09:02:39', NULL, 1),
(220, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_vendor\":\"5\",\"tanggal_po\":\"21-07-2022\",\"catatan\":\"<p>Testtt<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.002 - Gula Putih (Kilogram)\"],\"id_barang\":[\"4\"],\"qty\":[\"100\"]}', '\"\"', '\"\"', '2022-07-21 09:36:25', NULL, 1),
(221, 'tb_po', 'Menambahkan PO baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_vendor\":\"5\",\"tanggal_po\":\"21-07-2022\",\"catatan\":\"<p>testtt<\\/p>\",\"files\":null,\"det_nama\":[\"BR.07.004 - Lemonilo (Pcs)\",\"BR.07.005 - Ale-Ale (Pcs)\"],\"id_barang\":[\"6\",\"7\"],\"qty\":[\"100\",\"50\"]}', '\"\"', '\"\"', '2022-07-21 10:01:34', NULL, 1),
(222, 'tb_stok_opname', 'Menghapus data stok opname.', '\"\"', '\"\"', '{\"id\":\"a87ff679a2f3e71d9181a67b7542122c\"}', '2022-07-21 11:28:28', NULL, 1),
(223, 'tb_stok_opname', 'Menghapus data stok opname.', '\"\"', '\"\"', '{\"id\":\"c81e728d9d4c2f636f067f89cc14862c\"}', '2022-07-21 11:28:30', NULL, 1),
(224, 'tb_stok_opname', 'Menghapus data stok opname.', '\"\"', '\"\"', '{\"id\":\"e4da3b7fbbce2345d7772b0674a318d5\"}', '2022-07-21 11:39:25', NULL, 1),
(225, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-21\",\"stok\":\"10\"}', '\"\"', '\"\"', '2022-07-21 11:39:35', NULL, 1),
(226, 'tb_stok_barang', 'Add stok barang.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_barang\":\"2\",\"is_kadaluarsa_active\":\"0\",\"tgl_kadaluarsa\":\"2022-07-21\",\"stok\":\"50\"}', '\"\"', '\"\"', '2022-07-21 11:39:39', NULL, 1),
(227, 'tb_stok_opname', 'Menambahkan data stok opname baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"tgl_opname\":\"2022-07-21\",\"id_barang\":[\"2\"],\"qty_system\":[\"60\"],\"qty_real\":[\"100\"],\"qty_varian\":[\"40.0\"],\"keterangan\":[\"Ada penambahan barang\"]}', '\"\"', '\"\"', '2022-07-21 11:40:01', NULL, 1),
(228, 'tb_stok_opname', 'Menambahkan data stok opname baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"tgl_opname\":\"2022-07-21\",\"id_barang\":[\"5\",\"6\"],\"qty_system\":[\"13\",\"274\"],\"qty_real\":[\"20\",\"134\"],\"qty_varian\":[\"7.0\",\"-140.0\"],\"keterangan\":[\"test\",\"dulu\"]}', '\"\"', '\"\"', '2022-07-21 11:40:45', NULL, 1),
(229, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"Lk60YakMxPNGfmMtSql4G1yQaVthgAUtvrz6tlCs\",\"id_barang\":[\"7\",\"5\",\"7\",\"8\"],\"id_stok_barang\":[\"23\",\"0\",\"16\",\"0\"],\"tgl_trx\":\"2022-07-21T18:55:10\",\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"Keterangan\",\"cart_total\":\"293,000\",\"cart_diskon\":\"5,000\",\"cart_sub\":\"288,000\",\"cart_dibayarkan\":\"300,000\",\"cart_kembalian\":\"12,000\"}', '\"\"', '\"\"', '2022-07-21 11:55:33', NULL, 1),
(230, 'barang', 'Menambahkan barang baru.', '{\"_token\":\"0Zk1SFm0Ob4IbkhqiJDaNGPhoH2cRhhS7CtO51Ny\",\"id_satuan\":\"1\",\"id_kategori\":\"4\",\"nama_barang\":\"Test Nama Barang\",\"kode_barang\":\"130500\",\"deskripsi\":\"Test Deskripsi\",\"harga_beli\":\"5,000\",\"harga_grosir\":\"6,000\",\"harga_eceran\":\"7,000\",\"qty_grosir\":\"50\",\"is_expiracy\":\"0\",\"tgl_kadaluarsa\":\"2022-07-22\",\"stok\":\"100\",\"status\":\"1\"}', '\"\"', '\"\"', '2022-07-22 11:32:46', NULL, 1),
(231, 'barang', 'Mengupdate data barang.', '{\"_token\":\"0Zk1SFm0Ob4IbkhqiJDaNGPhoH2cRhhS7CtO51Ny\",\"kode_barang\":\"130500\",\"id\":\"9\",\"id_satuan\":\"1\",\"id_kategori\":\"4\",\"nama_barang\":\"Test Nama Barang sss\",\"deskripsi\":\"Test Deskripsi\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"50\"}', '\"\"', '\"\"', '2022-07-22 11:35:26', NULL, 1),
(232, 'barang', 'Mengupdate data barang.', '{\"_token\":\"0Zk1SFm0Ob4IbkhqiJDaNGPhoH2cRhhS7CtO51Ny\",\"kode_barang\":\"13050012\",\"id\":\"9\",\"id_satuan\":\"1\",\"id_kategori\":\"4\",\"nama_barang\":\"Test Nama Barang sss\",\"deskripsi\":\"Test Deskripsi\",\"is_expiracy\":\"0\",\"status\":\"1\",\"qty_grosir\":\"50\"}', '\"\"', '\"\"', '2022-07-22 11:35:41', NULL, 1),
(233, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"9\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"50\"}', '\"\"', '\"\"', '2022-07-22 12:07:32', NULL, 1),
(234, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"9\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"10\"}', '\"\"', '\"\"', '2022-07-22 12:08:46', NULL, 1),
(235, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"8\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"30\"}', '\"\"', '\"\"', '2022-07-22 12:08:58', NULL, 1),
(236, 'tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', '{\"id_barang\":\"8\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"11\"}', '\"\"', '\"\"', '2022-07-22 12:09:34', NULL, 9),
(237, 'tb_transaksi', 'Menambahkan transaksi baru.', '{\"_token\":\"0Zk1SFm0Ob4IbkhqiJDaNGPhoH2cRhhS7CtO51Ny\",\"id_barang\":[\"8\"],\"id_stok_barang\":[\"0\"],\"tgl_trx\":\"2022-07-22T19:09:25\",\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"testtt\",\"cart_total\":\"77,000\",\"cart_diskon\":\"0\",\"cart_sub\":\"77,000\",\"cart_dibayarkan\":\"0\",\"cart_kembalian\":\"-77,000\"}', '\"\"', '\"\"', '2022-07-22 12:09:40', NULL, 9),
(238, 'tb_det_transaksi', 'Menambahkan item ke detail transaksi.', '{\"id_barang\":\"9\",\"is_barang_has_expired_date\":\"0\",\"id_stok_barang\":\"0\",\"qty\":\"20\"}', '\"\"', '\"\"', '2022-07-22 12:14:51', NULL, 1),
(239, 'tb_transaksi', 'Update transaksi.', '{\"_token\":\"0Zk1SFm0Ob4IbkhqiJDaNGPhoH2cRhhS7CtO51Ny\",\"id_transaksi\":\"9\",\"id_barang\":[\"8\",\"9\"],\"id_stok_barang\":[\"0\",\"0\"],\"tgl_trx\":\"2022-07-22T19:09:25\",\"nama_pembeli\":\"Pembeli Test\",\"keterangan\":\"testtt\",\"cart_total\":\"217,000\",\"cart_diskon\":\"1,000\",\"cart_sub\":\"216,000\",\"cart_dibayarkan\":\"500,000\",\"cart_kembalian\":\"284,000\"}', '\"\"', '{\"id\":\"9\"}', '2022-07-22 12:15:08', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_po`
--

CREATE TABLE `tb_po` (
  `id` int(11) NOT NULL,
  `kode_po` varchar(100) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `tgl_po` date DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `catatan_supplier` text DEFAULT NULL,
  `catatan_retur` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL COMMENT 'Baru, Diproses, Selesai, Retur',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_po`
--

INSERT INTO `tb_po` (`id`, `kode_po`, `id_supplier`, `tgl_po`, `catatan_admin`, `catatan_supplier`, `catatan_retur`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(4, 'PO001', 5, '2022-07-21', '<p>Testtt</p>', '<p>Oke</p>', NULL, 'SELESAI', '2022-07-21 16:02:39', '2022-07-21 16:35:34', 1),
(5, 'PO002', 5, '2022-07-21', '<p>Testtt</p>', '<p>Testtttt</p>', '<p>Retur sebagian dulu</p>', 'RETUR SELESAI', '2022-07-21 16:36:25', '2022-07-21 16:59:25', 1),
(6, 'PO003', 5, '2022-07-21', '<p>testtt</p>', '<p>oke</p>', NULL, 'SELESAI', '2022-07-21 17:01:33', '2022-07-21 17:03:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok_barang`
--

CREATE TABLE `tb_stok_barang` (
  `id_stok_barang` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `stok` double DEFAULT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stok_barang`
--

INSERT INTO `tb_stok_barang` (`id_stok_barang`, `id_barang`, `stok`, `tgl_kadaluarsa`, `created_at`, `updated_at`, `created_by`) VALUES
(9, 4, 10, '2022-07-12', '2022-07-12 17:32:18', '2022-07-13 21:06:42', 1),
(11, 4, 0, '2022-07-12', '2022-07-12 17:44:11', '2022-07-13 21:06:42', 1),
(16, 7, 25, '2023-09-22', '2022-07-13 21:10:06', '2022-07-14 16:35:49', 1),
(20, 4, 16.2, '2022-07-14', '2022-07-14 11:42:46', '2022-07-14 11:42:46', 1),
(23, 7, 10, '2023-07-30', '2022-07-15 20:09:27', '2022-07-15 21:17:54', 1),
(26, 4, 9, '2022-07-15', '2022-07-15 21:23:49', '2022-07-15 21:25:53', 1),
(29, 8, 50, '2022-07-17', '2022-07-17 16:03:30', '2022-07-22 19:15:08', 1),
(31, 4, 100, '2022-07-21', '2022-07-21 16:35:34', '2022-07-21 16:35:34', 1),
(32, 4, 25, '2022-07-21', '2022-07-21 16:59:25', '2022-07-21 16:59:25', 10),
(34, 7, 43, '2022-07-21', '2022-07-21 17:03:20', '2022-07-21 18:55:33', 1),
(37, 2, 100, '2022-07-21', '2022-07-21 18:40:01', '2022-07-21 18:40:01', 1),
(38, 5, 17, '2022-07-21', '2022-07-21 18:40:45', '2022-07-21 18:55:33', 1),
(39, 6, 134, '2022-07-21', '2022-07-21 18:40:45', '2022-07-21 18:40:45', 1),
(40, 9, 80, '2022-07-22', '2022-07-22 18:32:46', '2022-07-22 19:15:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok_opname`
--

CREATE TABLE `tb_stok_opname` (
  `id` int(11) NOT NULL,
  `tgl_opname` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stok_opname`
--

INSERT INTO `tb_stok_opname` (`id`, `tgl_opname`, `created_at`, `updated_at`, `created_by`) VALUES
(6, '2022-07-21', '2022-07-21 18:40:01', '2022-07-21 18:40:01', 1),
(7, '2022-07-21', '2022-07-21 18:40:44', '2022-07-21 18:40:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(100) DEFAULT NULL,
  `nama_pembeli` varchar(200) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah_harga` double DEFAULT NULL,
  `diskon_nominal` double DEFAULT NULL,
  `nominal_bayar` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `kode_transaksi`, `nama_pembeli`, `keterangan`, `jumlah_harga`, `diskon_nominal`, `nominal_bayar`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(8, 'TRX-202207-POLOOX', 'Pembeli Test', 'Keterangan', 293000, 5000, 300000, 'PAID', '2022-07-21 18:55:10', '2022-07-21 18:55:33', 1),
(9, 'TRX-202207-SEX6PL', 'Pembeli Test', 'testtt', 217000, 1000, 500000, 'PAID', '2022-07-22 19:09:25', '2022-07-22 19:15:08', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_supplier` int(11) DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '"Admin, Supplier, Pemilik, Pembeli"',
  `last_login` datetime DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `photo_url`, `id_supplier`, `name`, `email`, `email_verified_at`, `username`, `password`, `mobile_number`, `otp`, `remember_token`, `created_by`, `created_at`, `updated_at`, `role`, `last_login`, `status`) VALUES
(1, 'uploads/foto/_0000.jpg', 0, 'Admin', 'admin@admin.com', NULL, 'admin', '$2y$10$UWk0FFdd41NwCO.dmHxV/.CVznBWDYSRcmcOgbIahtR2eyRpE7Ifu', '0000', NULL, NULL, 0, NULL, '2022-07-22 19:09:46', 'Admin', '2022-07-22 19:09:46', 'Aktif'),
(7, 'uploads/foto/1_081.jpg', 0, 'Pemilik', 'user@pemilik.com', NULL, 'pemilik', '$2y$10$kAlyrW.Qn7/MhRZn4hRJ4uPtlPT8YwNcSvU.Mdf25rGs3n9Bzlq4G', '081', NULL, NULL, 1, '2022-07-07 11:59:18', '2022-07-21 20:44:37', 'Pemilik', '2022-07-21 20:44:37', 'Aktif'),
(8, 'assets/logo/noimage.png', 1, 'User Supplier 1', 'user1@supplier.com', NULL, 'supplier1', '$2y$10$qPXoFjP7/IS/puh4wvO4/ekRcDi7IJsdwVmvOFtRiB7IKYeHnpzCu', '1234', NULL, NULL, 1, '2022-07-07 17:29:09', '2022-07-15 21:37:13', 'Supplier', '2022-07-15 21:37:13', 'Aktif'),
(9, 'assets/logo/noimage.png', 0, 'Pembeli Test', 'user@pembeli.com', NULL, 'pembeli', '$2y$10$bAYVen7EkjQ5aw/v1aiciOXMEtfV1S2bJd8uLn3rAJBtf1i/UwDnS', '0123000', NULL, NULL, 1, '2022-07-14 09:14:37', '2022-07-22 19:09:23', 'Pembeli', '2022-07-22 19:09:23', 'Aktif'),
(10, 'assets/logo/noimage.png', 5, 'Adam Supply User', 'adam@supply.com', NULL, 'adamsupply', '$2y$10$kCxrN.gspRsujNbH1z2pbOuIRtuGQguBvpCOvv.02Wkmob6gN5p7m', '0828388', NULL, NULL, 1, '2022-07-15 16:52:32', '2022-07-21 21:00:35', 'Supplier', '2022-07-21 21:00:35', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_path` (`path`),
  ADD KEY `idx_kode` (`kode`),
  ADD KEY `idx_parent` (`parent`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_aktivitas_barang`
--
ALTER TABLE `tb_aktivitas_barang`
  ADD PRIMARY KEY (`id_aktivitas_barang`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_det_po`
--
ALTER TABLE `tb_det_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_det_stok_opname`
--
ALTER TABLE `tb_det_stok_opname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_det_transaksi`
--
ALTER TABLE `tb_det_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_harga_barang`
--
ALTER TABLE `tb_harga_barang`
  ADD PRIMARY KEY (`id_harga_barang`);

--
-- Indexes for table `tb_keranjang_belanja`
--
ALTER TABLE `tb_keranjang_belanja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_logs_activity`
--
ALTER TABLE `tb_logs_activity`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `tb_po`
--
ALTER TABLE `tb_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_stok_barang`
--
ALTER TABLE `tb_stok_barang`
  ADD PRIMARY KEY (`id_stok_barang`);

--
-- Indexes for table `tb_stok_opname`
--
ALTER TABLE `tb_stok_opname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_aktivitas_barang`
--
ALTER TABLE `tb_aktivitas_barang`
  MODIFY `id_aktivitas_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_det_po`
--
ALTER TABLE `tb_det_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_det_stok_opname`
--
ALTER TABLE `tb_det_stok_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_det_transaksi`
--
ALTER TABLE `tb_det_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_harga_barang`
--
ALTER TABLE `tb_harga_barang`
  MODIFY `id_harga_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_keranjang_belanja`
--
ALTER TABLE `tb_keranjang_belanja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_logs_activity`
--
ALTER TABLE `tb_logs_activity`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `tb_po`
--
ALTER TABLE `tb_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_stok_barang`
--
ALTER TABLE `tb_stok_barang`
  MODIFY `id_stok_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_stok_opname`
--
ALTER TABLE `tb_stok_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
