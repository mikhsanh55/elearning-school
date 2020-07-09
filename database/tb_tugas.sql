-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2020 at 02:50 PM
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
-- Table structure for table `tb_tugas`
--

CREATE TABLE `tb_tugas` (
  `id` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_kelas` int(6) DEFAULT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_tugas`
--

INSERT INTO `tb_tugas` (`id`, `keterangan`, `id_kelas`, `id_mapel`, `id_guru`, `end_date`) VALUES
(1, 'Tugas ketika liur', 3, 0, 0, '2020-04-20 23:59:00'),
(23, 'test', 37, 0, 0, '2020-06-02 00:00:00'),
(24, 'test 2324', 37, 0, 0, '2020-06-02 00:00:00'),
(25, 'Adwada', 37, 0, 0, '2020-06-06 00:00:00'),
(26, 'test', 1, 0, 0, '2020-06-16 20:00:00'),
(27, 'Tugas Harian', 38, 0, 0, '2020-06-17 08:12:00'),
(28, 'Kerjakan tugas Integral', 40, 0, 0, '2020-06-27 03:44:00'),
(29, 'Kerjakan hanya 1 jam', 45, 0, 0, '2020-06-28 02:00:00'),
(30, 'Harus selesai hari ini', 51, 0, 0, '2020-07-03 14:00:00'),
(36, 'Kimia asiik part 1', 62, 67, 52, '2020-07-11 14:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
