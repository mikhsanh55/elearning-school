-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2020 at 03:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_trainer` int(6) DEFAULT NULL COMMENT 'Wali Kelas',
  `id_mapel` varchar(100) DEFAULT NULL COMMENT 'Mapel-mapel setiap kelas',
  `id_instansi` bigint(20) DEFAULT NULL COMMENT 'GAK KEPAKE DULU',
  `id_jurusan` bigint(20) DEFAULT NULL COMMENT 'GAK KEPAKE DULU\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama`, `keterangan`, `id_trainer`, `id_mapel`, `id_instansi`, `id_jurusan`) VALUES
(1, 'II Pelaut 2', 'Online', 1, '55', 1, 4),
(3, 'Dikreg7777', 'Kelas Reguler', 33, '59', 1, 6),
(6, 'Kewarganegaraan', 'Kewarganegaraan', 37, '62', 1, 8),
(34, 'Strategi Operasi Laut', '-', 38, '63', 1, 9),
(37, 'II Pelaut 1', 'Online', 1, '55', 1, 6),
(38, 'XI IPS 1', '-', 49, '71', 10, 11),
(39, 'XI IPA 1', '-', 46, '70', 10, 10),
(40, 'X IPA', 'X IPA', 53, '77', 11, 12),
(41, 'X IPa', 'X IPa', 53, '77', 11, 15),
(42, 'X MIPA 1', '', 66, '83', 11, 15),
(43, 'X IPA (Matematika 10)', '-', 68, '84', 12, 17),
(44, 'X IPS (Matematika 10)', '-', 68, '85', 12, 18),
(45, 'Belajar Psikologi', 'Sangat penting buat pengembangan diri!', 1, '59', 1, 7),
(46, 'Red Room', 'You know what Red Room mean right?', 1, '59', 1, 6),
(49, 'Dasar-dasar Hynoterapi', 'Bahas aja sebentar da', NULL, '59', 1, 4),
(50, 'Dasar-dasar Hynoterapi', 'Bahas aja sebentar da', NULL, '59', 1, 4),
(53, 'X MIPA 1', 'Kelas X MIPA 1\r\n', 85, '59', 1, NULL),
(54, 'X MIPA 2', 'Kelas X MIPA 2', 85, '59', 1, NULL),
(55, 'X MIPA 1', 'X MIPA 1 kelasnya di deket perpus', 22, '55,59,60,62,63', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
