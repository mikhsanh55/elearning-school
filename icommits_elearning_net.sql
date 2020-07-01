-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2020 at 11:30 AM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icommits_elearning_net`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_token`
--

CREATE TABLE `akses_token` (
  `id` int(11) NOT NULL,
  `status_token` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `akses_token`
--

INSERT INTO `akses_token` (`id`, `status_token`) VALUES
(3, 'Non Aktif'),
(1, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`) VALUES
(1, 'admin'),
(2, 'guru'),
(3, 'siswa'),
(4, 'instansi'),
(5, 'admin_instansi');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `urutan` int(3) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `link2` varchar(50) DEFAULT NULL,
  `link3` varchar(50) DEFAULT NULL,
  `link4` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `urutan`, `link`, `link2`, `link3`, `link4`, `icon`) VALUES
(1, 'Beranda', 1, 'beranda', NULL, NULL, '', 'fas fa-home mr-2'),
(2, 'Siswa', 6, 'pengusaha/data', NULL, NULL, '', 'fas fa-user-tie mr-2'),
(3, 'Guru', 5, 'trainer/data', NULL, NULL, '', 'fas fa-user-ninja mr-2'),
(4, 'Kurikulum', 4, 'dtest/data_mapel', 'Materi/lists', 'ujian', 'dtest/chats', 'fas fa-book-reader mr-2'),
(6, 'Tes Kemampuan', 12, 'soal/data', 'soal/m_soal', 'soal/m_ujian', '', 'fas fa-pen-alt mr-2'),
(7, 'Hasil Tes', 13, 'hasil/h_ujian', NULL, NULL, '', 'fas fa-paste mr-2'),
(9, 'Verifikasi Modul', NULL, 'materi/get_list_not_verify', NULL, NULL, '', 'fas fa-calendar-check mr-2'),
(10, 'Tes', 14, 'ujian/ikuti_ujian', 'ujian/ikut_ujian', 'ujian/sudah_selesai_ujian', '', 'fas fa-pen-alt mr-2'),
(15, 'Jenis Usaha', NULL, 'pengusaha/jenis_usaha', 'pengusaha/jenis_usaha', NULL, '', 'fas fa-sitemap mr-2'),
(16, 'Laporan', 15, 'laporan/', 'laporan/modul', 'laporan/ujian', 'laporan/akses', 'fas fa-file mr-2'),
(19, 'Lembaga', 15, 'instansi', NULL, NULL, NULL, 'fas fa-building mr-2'),
(20, 'Pengaturan', 16, 'setting', NULL, NULL, NULL, 'fas fa-cogs mr-2'),
(22, 'Jadwal ', 8, 'jadwal', NULL, NULL, NULL, 'fas fa-user-tie mr-2'),
(23, 'Jadwal ', 2, 'jadwal/kalender', NULL, NULL, NULL, 'fas fa-user-tie mr-2'),
(24, 'Akun Lembaga', 3, 'akunlembaga', NULL, NULL, NULL, 'fas fa-user-tie mr-2'),
(25, 'Tugas', 8, 'tugas', NULL, NULL, NULL, 'fas fa-user-tie mr-2'),
(26, 'Tugas', 8, 'tugas/daftar_tugas', '', NULL, NULL, 'fas fa-tasks mr-2'),
(27, 'Ujian', 8, 'ujian_real', 'ujian/uts', 'ujian/uts', NULL, 'fas fa-chalkboard mr-2'),
(28, 'Pengaturan', 20, 'setting_client', NULL, NULL, NULL, 'fas fa-cogs mr-2'),
(29, 'Admin Lembaga', 2, 'adminlembaga', NULL, NULL, NULL, 'fas fa-user-tie mr-2'),
(30, 'Beranda', 1, 'beranda', NULL, NULL, '', 'fas fa-building mr-2'),
(31, 'Tugas', 11, 'tugas_siswa', NULL, NULL, NULL, 'fas fa-building mr-2'),
(32, 'Guru', 5, 'trainer', NULL, NULL, NULL, 'fas fa-building mr-2'),
(33, 'Room', 7, 'kelas', NULL, NULL, NULL, 'fas fa-laptop mr-2'),
(34, 'Room', 7, 'kelas/siswa', NULL, NULL, NULL, 'fas fa-laptop mr-2'),
(35, 'Kelas', 3, 'jurusan', NULL, NULL, NULL, 'fas fa-building mr-2'),
(36, 'Room', 3, 'Kelas/guru', NULL, NULL, NULL, 'fas fa-laptop mr-2'),
(37, 'Penilaian Guru', 11, 'penilaian', NULL, NULL, NULL, 'fas fa-building mr-2'),
(40, 'Penilaian Guru', 14, 'penilaian', NULL, NULL, NULL, 'fas fa-building mr-2'),
(41, 'Lembaga', 2, 'instansi', NULL, NULL, NULL, 'fas fa-building mr-2'),
(42, 'Jurusan', 4, 'jurusan', NULL, NULL, NULL, 'fas fa-building mr-2'),
(44, 'Dimensi EDOPM', 9, 'dimensi', NULL, NULL, NULL, 'fas fa-th-list mr-2'),
(45, 'Soal EDOPM', 10, 'penilaian/paket_soal', NULL, NULL, NULL, 'fas fa-file mr-2'),
(46, 'Luaran EDOPM', 12, 'penilaian/luaran', NULL, NULL, NULL, 'fas fa-print mr-2'),
(47, 'Aktivitas Pengguna', 14, 'aktivitas', NULL, NULL, NULL, 'far fa-handshake mr-2'),
(49, 'Nilai Siswa', 5, 'rekaptulasi', NULL, NULL, NULL, 'fas fa-check mr-2');

-- --------------------------------------------------------

--
-- Table structure for table `m_admin`
--

CREATE TABLE `m_admin` (
  `id` int(6) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `level` enum('admin','guru','siswa','instansi','admin_instansi') NOT NULL,
  `kon_id` int(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `login_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_admin`
--

INSERT INTO `m_admin` (`id`, `user_id`, `username`, `password`, `level`, `kon_id`, `status`, `login_at`) VALUES
(1, 'admin', 'admin@learning', '2f09510dc280af449f3e631411429d1bde1435074eda3d80ab566feadec8314d06854153990cfc5f9ce8a0c0843541de7502eb1e3cdc70f8f079ffc621bed834Ap+Unn6n2fFSuTFJco8uZYXTSgi3Bc0NyderglpPo9s=', 'admin', 1, 0, '0000-00-00 00:00:00'),
(532, 'rohimat', 'rezharanmark@gmail.com', '4bb09cc3201f74c822e12eef52cb3e00bd1f365ae606a0f9b20f12998671c9cf160c567d06b5e49203ba7b37b5596dcf95b66554c7d8071daaccb656b4286c94ypdf22OuZ6IFv9I31gpE1et0WWXv1rc4INWRpgEUn10=', 'siswa', 526, 0, '0000-00-00 00:00:00'),
(534, 'rezha123', 'rezha@gmail.com', '3e0644f27789ebf2c63c55e1013e46dca5fd6188a097280f96d2c4044f17a8424945d28db77f20954d9d2c789ff801b291d4293c1c414613ce5f1490cc10a1eeKXEtazgXS49UisiY9MuDMPt5xFY9zrKU/FjDE6l5KIU=', 'guru', 1, 0, '0000-00-00 00:00:00'),
(538, 'adminseskoal', 'rezharanmarks@gmail.com', 'bc4fe91182365e95e46acce339ace0998f2b78650dbac9baad216a00972de0864ee516875a6dc934c946638d1ce9adbe0120e156db51496586ec14388d20a817HAbPxZXDYINlWoprUubCd0BlI/6PUITtbVyce43cofE=', 'instansi', 532, 0, '0000-00-00 00:00:00'),
(541, 'USHER', 'STASIUN', 'a5edbf065644ad3b10800d691af0f9e1951fd23154716c9410e7f67e0fac3c22b2b1b4561a61512fca54e9aaa04e43a0c5eca26329849eeee967a27b8db85421i39C6nadGpXtlLrLUcIwjTA/aiYHvaHISsmRffyy8b4=', 'instansi', 533, 0, '0000-00-00 00:00:00'),
(543, 'WKWKWK', 'WKWKWKCOBA@GMAIL.COM', '2f09510dc280af449f3e631411429d1bde1435074eda3d80ab566feadec8314d06854153990cfc5f9ce8a0c0843541de7502eb1e3cdc70f8f079ffc621bed834Ap+Unn6n2fFSuTFJco8uZYXTSgi3Bc0NyderglpPo9s=', 'instansi', 535, 0, '0000-00-00 00:00:00'),
(544, 'JKYCAKEP', 'kiyongkiyut@yahoo.com', '86c69113e0d4bc517887e5bbbeadb49e6d15cd7be0f0633af57f507032695f89a603155646a226fbebf26322cc5e400df1204d703658fd6d1ec5b83950b7a8af/Bsaq5NQYHMTMJPHgGvoLG5dPSOV/tPKYlvaPDJ0enw=', 'siswa', 529, 0, '0000-00-00 00:00:00'),
(565, 'dwi', 'dwi@gmail.com', '2f09510dc280af449f3e631411429d1bde1435074eda3d80ab566feadec8314d06854153990cfc5f9ce8a0c0843541de7502eb1e3cdc70f8f079ffc621bed834Ap+Unn6n2fFSuTFJco8uZYXTSgi3Bc0NyderglpPo9s=', 'guru', 22, 0, '0000-00-00 00:00:00'),
(570, 'indriawan22', 'iwan@gmail.com', 'a67762881c821196c0520bffe49f7d9a7ff3f9884939f6fabee5463032e9da4b58784bf94d0319c8d7f3791b65e8152874e6501e2165e062f85eec4f521e621fc+/ZPXoBOVrJoD6lMPhJPNRqBV8rCLVfu4GDb2UZXEM=', 'admin_instansi', 537, 0, '0000-00-00 00:00:00'),
(571, 'icommits', 'icommis@gmail.com', '2f09510dc280af449f3e631411429d1bde1435074eda3d80ab566feadec8314d06854153990cfc5f9ce8a0c0843541de7502eb1e3cdc70f8f079ffc621bed834Ap+Unn6n2fFSuTFJco8uZYXTSgi3Bc0NyderglpPo9s=', 'admin', 1, 0, '0000-00-00 00:00:00'),
(572, 'stafftu', 'smktu@gmail.com', '836381bea6ab9f0f529798f2857ef9af99b01640ed5bf0d18c79133e92e8d24db526177e8de44636f3a0ed8416bef9f70e85971497b3f684678148e55221da15TmnBOd3Tfc855UjoOB3kHQKBl2XPZkim/maPNMFlRmw=', 'instansi', 536, 0, '0000-00-00 00:00:00'),
(573, 'akademik', 'akademik@gmail.com', '925ee499a15ad0bd8192e07946cf2a9ba0216de4f410242a175fe9303e2dc4ea7e4848338cc2dfd8a3f7e91c31835712cccbcc09a3e550da25b81a554542869bx6MePo85IXqJWwIaVnorOonn1QI3m7KfySmgvxq+ZXo=', 'instansi', 537, 0, '0000-00-00 00:00:00'),
(574, 'ridwan', 'ridwan@gmail.com', '0ce35427f2eeb1636c415fa4ef73ffb42be4ffe5a85ca344964122887f27ae83453be8fe2d67c45ffb53156ffd7a58bec8e1668907596259f01a8d9f3436c87bwISopA/NpUBkkpCZIcVTBI2REif6vrmi+2U+gbsscOQ=', 'siswa', 531, 0, '0000-00-00 00:00:00'),
(575, 'kamil', 'kamil@gmal.com', 'd2d0ebd0bc445fd10bdf99c0f6b15e20fb14fac4a30a27bb91e4718c8e4db3109b7094bc32248c253a8eed809d00d0a7deeb0b88a3e9d778935304f0d2d9d5e3b+fvIDqLRzKA/p+2mFZ6V6bbqFQOKtPl9nu8ojOwvr0=', 'siswa', 532, 0, '0000-00-00 00:00:00'),
(576, 'guru1', 'guru1@gmail.com', '480253d89c33a851dcb2cad7f846f709ec40b98ca84737f0f7dbdaba4de6068960815ffe3cce91010a3ca6225519e1d589dfbd4599e9a07f17ec85c987611641TphIk1VGZY8xQeD/ER9zlcDq45TbEsxhvGvWs4T4Fwk=', 'guru', 23, 0, '0000-00-00 00:00:00'),
(577, 'dosen1', 'dosen1@gmail.com', '22072cd291142d663b7ebeda3bfd734a5ae0d22fe495a9883200250aa0084ba2c45e130f1a6ab043ca1da8dc98a262942db7001a0123eb2efece80b5838af034R8LKRBSw3WQ4xq/46Pnftz2631CZuxfDnxC36n6vdBU=', 'guru', 24, 0, '0000-00-00 00:00:00'),
(580, 'fahmi', 'fahmi@gmail.com', '9a076b814273dea6354ac65e5bf4e02855bb851cce0a7c4104eb793851b4a728819c9c102cae31bfac20d09311b26d910e7f2b7187c3cdb2aeea8fe616e7725bEYlF09Kmenwx01kHXoQlw7IPhh6mCtQ5SscoYF3bhRY=', 'guru', 26, 0, '0000-00-00 00:00:00'),
(582, 'fahmi', 'fahmi@gmail.com', '1d1e71d52b73e8b4293370f09c24f8fe186248f7223b9322cca24518881de36e3063a1bca6765c40a7f8e5914b89117c7f0acc1b1112fbbc65227e9ab63a4ecaZf5DqryI40aBsFaKfbQ5YHbEi9FKV3arPqenpIQxO8s=', 'guru', 28, 0, '0000-00-00 00:00:00'),
(585, 'ujangmantap', 'ujanglagi@gmail.com', 'e2f4da48b3e897d4df2a767813e5853bea4a0695dbd117b1590a96bf26471e6e3a92ce3455215992a909651dca66ba0446fcc017c3e5ac13fc88180b261bd538FcQvnW7MOTuq0Mx5NcY7coEDuFdyP8S4CzKMIl+q8i8=', 'guru', 32, 0, '0000-00-00 00:00:00'),
(586, 'ujangagain', 'ujanglagi@gmail.com', '79ea9785f75f8f03da68b4b329effd84c7c0b0590756b88a5991f20b8b9d7038db3234c33e8982d5c8e8db4998a6d43e1d1dd25cb7ad15ec9549ffb8e26ae603uYvArZxF2B69sqa45p5QKGzc7IQPJMlP6ZIRzUkZCFc=', 'guru', 31, 0, '0000-00-00 00:00:00'),
(587, 'ujanglagi', 'ujanglagi@gmail.com', '1f1421855e7ad58c3d09ac1accb601de201c96517e9d384bd8f20c86e77d281e1c4ee3521579dff6e229f9e95df00eddef536b4f0fe15e3246ec941889c5a48aaaKYLLWy9e/F8svFSqgMIEPLcMDakF1Dybli01w/Rgg=', 'guru', 30, 0, '0000-00-00 00:00:00'),
(588, 'saepudin', 'sapeudinnn@gmail.com', '2eb659bd8ceda9adb549d99e36f54910973050f9656388157fcb0c53a7955109e143f5233fcebf736c8143c29c0d1acad4a79bcbc3d7221ae431fef089e77b85o6MCA3JJJMBO04EKe3dl2puFUonzabf98UbUsJk5qm4=', 'siswa', 536, 0, '0000-00-00 00:00:00'),
(589, 'asep', 'asep@yahoo.com', 'dc855efb0dc7476760afaa1b281665f1', 'siswa', 537, 0, '0000-00-00 00:00:00'),
(590, 'asup', 'asup@iconn.com', 'a0a0b85a3ffa26ba5af82b5706cf774c', 'siswa', 538, 0, '0000-00-00 00:00:00'),
(591, 'asap', 'asap@gmail.com', '3d630eac057912717bba1bf6204e4e5d', 'siswa', 539, 0, '0000-00-00 00:00:00'),
(597, 'melmela', 'melmela3093@gmail.com', '0087523892b9a2b323b98a745984c43569ed0cb6b712d7de730a5bd1c9892b62506a8a2e67bca95323c7a225bbc7f1b0221d7911909bead3c00249ff14f597c2zv/u7Cri307YgkjNuCSbN+baZjVW/Pe/IZaOvGTkZvg=', 'siswa', 541, 0, '0000-00-00 00:00:00'),
(599, 'alel', 'alel@gmail.com', '9bc3e46da9871a8ad992e201a1dc3bc99f612bc7606617cb643e1ee166717537825fedb104c8104651b857dd721579fc7c9f67efaf929836b7260713b5cf347cckQpSFtmZoI3pO5UcB3mlrOHe9t7/papvDiVEMboRrY=', 'instansi', 540, 0, '0000-00-00 00:00:00'),
(602, 'aldilla', 'dwisurdiana88@gmail.co.id', 'd22ce6aa7c7f2d57c68c36964799e773d2f2f6e6c2ff05bcadf63c8a9c8bbef1f846d776e3b1dc7412b88bc31bdf7204a49430a1d02f64832ea55d76aa10f811S+41boZrb23OhvFXwp89K+QBFZWLrmIf84Kcer+WBp0=', 'guru', 38, 0, '0000-00-00 00:00:00'),
(603, 'febri', 'aldilla@tnial.mil.id', '08400173cde40917ae4edadd240b4e8c334db625bbe732a9163b580fc4cc9c2a8a5b05d4acb1abee215ad33938216576e276d397c5609317c110f8c00b75539avWjouRzfmWQvLdWgxgyArZ8wA7VMjq5pSuvSrjDsSKs=', 'siswa', 543, 0, '0000-00-00 00:00:00'),
(604, 'jazai', 'jazai@mars.ilegal', '2f09510dc280af449f3e631411429d1bde1435074eda3d80ab566feadec8314d06854153990cfc5f9ce8a0c0843541de7502eb1e3cdc70f8f079ffc621bed834Ap+Unn6n2fFSuTFJco8uZYXTSgi3Bc0NyderglpPo9s=', 'siswa', 544, 0, '0000-00-00 00:00:00'),
(607, 'siswatesting123', 'siswatesting123@gmail.com', 'cfd89e62250f8aacc73383e0a4d0b120', 'siswa', 545, 0, '0000-00-00 00:00:00'),
(608, 'siswatesting456', 'siswatesting456@gmail.com', '0f3254c66fdd4fb39fc619f0db59ee1c', 'siswa', 546, 0, '0000-00-00 00:00:00'),
(609, 'siswatesting789', 'siswatesting789@gmail.com', '6c3a8bc17131593ccd59e97d118dcae2', 'siswa', 547, 0, '0000-00-00 00:00:00'),
(610, 'adminaal', 'aal@tni.mil.id', '4ed8a676794d8346d88e3814c264e79f5fe6236e4810046d68b9d675d19009bab888cc6dcfd99a56d19c95bad5c4707f13b05a49a012ebfcb505e6205ce9b7d7PS5s9+PcAZ97VqzGF1RIYXf0wkn17chPxTyvsB8Xe3o=', 'instansi', 541, 0, '0000-00-00 00:00:00'),
(611, 'ari', 'ari_aal@yahoo.com', '77523aedbb1c811cae0c5ecb42d1eb593079f75c03f77513d3bd41c2482878dd9482925bf68049f5890074eeae3bb81d7005e1863df9966b19f0338f95c84f7dbcGP2dOXDXQ8AEiJxZXpqah2Hb0rkQSTrGradZtLO9E=', 'guru', 41, 0, '0000-00-00 00:00:00'),
(612, 'adminsman5bdg', 'sman5bdg@gmail.com', '25705549425442d49744c1c71b584fb2108ab0b35bcf5f4a342adf84c394d8f72b303ce2479d1f3d7c0fd39d281807812741d82c23648c133753cbf0846b1d20o3RgvemFOhO+RCkJs2dlM+RaAzXaHPkS8/kf7NOUnyM=', 'instansi', 542, 0, '0000-00-00 00:00:00'),
(613, 'admin1', 'admin1@gmail.com', '8f296019ac412f93bec40b1f47b70c217b102e9052b7025aa552cf63db97d5e3975608d8edbacbea714f588360fb9519b7c3b7f49b882e3ac4f9c325057a9d9atvozIY6BckSVDt5MXi40GNWfmdGKWF+v0JO8Mno197s=', 'admin_instansi', 538, 0, '0000-00-00 00:00:00'),
(614, 'guruekonomi', 'guruekonomi@gmail.com', '208db46798a2f949e266133f94fc499189fab809cb42b8ee5fc98961733288e3acc923c202d7ec78ecf97daf142561c0dd4c6847f81a471e6233617fe4fb9c8fLJUTtkCF2cke8oN/Uh5kb2d/Wl9v0pB/A4WueRWdZ9Y=', 'guru', 52, 0, '0000-00-00 00:00:00'),
(615, 'gurusejarah', 'gurusejarah@gmail.com', 'a675f2804e7a19c57e81398f53b480e286783003777f69b2447fbcdb3a6aed441a45248fbd2ac39ea5d1fb76863d333afd1394735fd343628ef1fe49834fdbfbHU8szNy5820b1Nzi5C7ZqSnIN7pIgaSaDZGuMPKUB5c=', 'guru', 51, 0, '0000-00-00 00:00:00'),
(616, 'gurusosiologi', 'gurusosiologi@gmail.com', 'c7c88328dc581c60a375ea4f3a8f65e803ac46775dd1c68af17daf602b891f9b25fa4727b255e4093c6bb6ad88130c2b80ca5cb08465a180b2b6f3063364ee5chlNBvlBIxx/Vdj8x7Ju5feRQW8ekBkvit9Eevg1+9cg=', 'guru', 50, 0, '0000-00-00 00:00:00'),
(617, 'gurugeografi', 'gurugeografi@gmail.com', '81f8eec7df26ac4a7c57f71d292c2eb676507dcc56defb183ffcdaa56c332bd1caa6c12dafb9b3aa3427bb559e3c8c45b6b0a7c92549218ec46eafe3f6810afan7lcdU/rQTegKjul70o89XVhUsGjFJAXetQSN6I6XXg=', 'guru', 49, 0, '0000-00-00 00:00:00'),
(618, 'siswa41', 'siswa41@gmail.com', '0c81d3ce45cffa89dc8d1b766043d5c5a97c245310c7a12daaa5430a89c00a9cb399fd953c8b57f35968b14fc7fcc465db4fa074e0d353276ab1e0e010fade30kIJEbtrVjObl4LEUyJgsccL5UtwhfcQU5damOu2mMqs=', 'siswa', 550, 0, '0000-00-00 00:00:00'),
(619, 'siswa42', 'siswa42@gmail.com', '32502c5408787bea117a1a3e7646fb4f4dcc84a2ec24dbab408a677bc4ed22aff75bf16ac16677b5a7cbcfd40337e807deddefa87c593cb92f32eb9d285d64b6jIVaz6y+/LyNMmmSxQIXroLd5Iix5PzHyierJPHrUCE=', 'siswa', 551, 0, '0000-00-00 00:00:00'),
(621, 'gurubiologi', 'gurubiologi@gmail.com', '323640c376239bbedb0944fbf2464a4644a4a5536a06263ea8b60d9f8e4d6d9f7f9d020b4ff2fc7710fb164278713fa702ec8aa418b0c2cea978428b73c724c9PcGhREt0OwI7T9t/o5hwruyAkd5PQxuMDKDBKuqEFXM=', 'guru', 46, 0, '0000-00-00 00:00:00'),
(622, 'gurubahasainggris', 'gurubahasainggris@gmail.com', '8e07d5960968597ac5067b8288452cb64a55ce87c92d998fc54b55820f135700f13eb221348cf9820f654b65ee824871cd103e0aa06a533309ff0e91bd06f480r5nv+XaIn1JAuMoQfEVGAFmBps5nZmoko85crry+OkxUHll608QOBslcJ1M1XeMA', 'guru', 48, 0, '0000-00-00 00:00:00'),
(623, 'gurubahasaindonesia', 'gurubahasaindonesia@gmail.com', '839f9b9af5c839086ddd9f8ff00cc32acab84731551af2374c927924cd2ef447347f07b36b6762bde545da4fd4da1a4b73e48a88c43d54cb9565daae8e77c539mS+MqXzCSiQNw3WNVw8NO/suJ3j2m2DCbvFhwsfbBt3/m76LYJJ1HjWVoDWwmy7k', 'guru', 47, 0, '0000-00-00 00:00:00'),
(624, 'gurufisika', 'gurufisika@gmail.com', '27fcb7f974336bb938f34f8c4319d992f58c48b152ca4bc004949f94a86f0c402c3072164700386dd1252f717b4f8324cedf43d00f4fe02fa3033f9e7c6cd3d95bj8Y3v5obaIT4t9ssFSfkCBRZTAXJj2PpThxrt/FvM=', 'guru', 45, 0, '0000-00-00 00:00:00'),
(625, 'gurukimia', 'gurukimia@gmail.com', '3d9cf16fd19504fa221cbd8f469b3e3bfed610d3732d329d9df2504cfa90c5eb47d859d859e8c9e77715f242aee26c4aa4a8793c03bd289a67a822bc7b371ba8s5LsmNQBMEydzk3posczmCR1+ngLRD5+8eDlDXjdf/w=', 'guru', 44, 0, '0000-00-00 00:00:00'),
(626, 'gurumatematika', '-', '3d5e67823648d7c5a01b78b5ad5f5a723eb752d810172758a6910ceb6b6aaee3558301b5526d0c0047e63ca82077bb519b3b188f893e822bd3c6027c8968aa5fQ2hTXB3aYhVu6CP0lOH+UOUWO4pdKVdCc4GICRF6tqM=', 'guru', 43, 0, '0000-00-00 00:00:00'),
(627, 'siswa43', 'siswa43@gmail.com', '2543f3ff302d5211f3460d3f5fb68163597606e3758ad9acff9f23773e33e4b0e0171a8daae35da7a2ebb9e26bf3aa5cf8bc55dab23b8e8c56f825ee6818d866UHorrW02aBcP9x6xrILIYunvM6xJuMCh79aHtcZaoT0=', 'siswa', 553, 0, '0000-00-00 00:00:00'),
(628, 'siswa44', 'siswa44@gmail.com', '62333b75e00342ff3f78a847e6bbc933d16961307683d7abcf35d2a133759014c55729482ac0e9c39f278d835b379a98c24e7e20c45257c3d4fc1a87ecc29db60WsLxoRMEem88EptBxL2YiQHcB2PHsr9+SVJx8qVkPk=', 'siswa', 554, 0, '0000-00-00 00:00:00'),
(629, 'adminsman21bdg', 'adminsman21bdg@gmail.com', 'de2db89d495f1c73923ec919d6e6e1ae55734a40fd615cd8380845463706d4b07552fd2e8253a9bafff4e530f8b9b377dd9f21c0aba85ba0fa5c3c04567904bdtWTi4pdJ9vTn8+ad+euwdesr/pGAHz8vy/zm3ukKL6Y=', 'instansi', 543, 0, '0000-00-00 00:00:00'),
(630, 'adminsman25bdg', 'adminsman25bdg@gmail.com', '21b06183c21acdf1c95225a2fba57d871351caa4eb4459436e09100801c0c5072e8502ec30019ce057bb979222ed6abde72297a851ac6db19c2bc68a61ea16e7OOpCAT0iD4cUKH06eKwnlqDkJ4yJ06yuS7lKvpOUNiA=', 'instansi', 544, 0, '0000-00-00 00:00:00'),
(631, 'sman21_guru_bsun', 'sman21_guru_bsun@gmail.com', '76e2b271635354defa486402a4cd148f355c9055418984206c6e58b1df4d44b68fa4814486a5196b8c04fcbdc492c988e3d905f7895718ee3c69a85fd4082d646CYf+HQDtlwhQosItw6amGfmHcRKk2i/1rksGs5Zq0ux2lFFO8LdBBo0XudvXHpW', 'guru', 63, 0, '0000-00-00 00:00:00'),
(632, 'sman21_guru_bingg', 'sman21_guru_bingg@gmail.com', '925bc0b917c35a7f2e4166dec810916d140aa82b1cfe53be87298b07493d664425463a6d9580bbc149682af505c423967e6370c994da95b201a99816d9cedecaiLrkTK1QjaasEpFAm1K/vvVprUpUe9eLPYDkUrLl7XL0E7xlep/jBdqSwvH+XLSR', 'guru', 62, 0, '0000-00-00 00:00:00'),
(633, 'sman21_guru_bindo', 'sman21_guru_bindo@gmail.com', '81147b25be2e731d5f4d82a2e8c5225279e7ea26989e3bc4234c33c7181449cccd335ecb090505a69d55ad225316e3342ca7c2079d14f8dcef46488110db0df6Cp/aEC3hcqHRy5gQo+0rDvoCnZt4ng0NwFv2Vf/JWpACoa0bc+dHLryIxmA+tvSQ', 'guru', 61, 0, '0000-00-00 00:00:00'),
(634, 'sman21_guru_sosiologi', 'sman21_guru_sosiologi@gmail.com', '35e4720c0a17d547a43b8fd5b997c56e405ba9324db46b94741c53f12fb5972d0d1324791b1f0c953e8029d3fff9782af06a6bd9d4686635f282c458dbbac6ddNriGZ4UFtkW0pspLkgysUZ83XGca2vSrxIn0sxU4gG+ULmVzHFUiDY3EoADdd1xp', 'guru', 60, 0, '0000-00-00 00:00:00'),
(635, 'sman21_guru_geografis', 'sman21_guru_geografis@gmail.com', 'bbeb2677e5c7eec68d9f8976d00475fca76905c050636de6ffd5582ac4d036c01aed349eeb78f5194cd7aff98aef27de69cb5a9c486707a7ddec5e1d2bf42116igJuxu7vJALMNKSrGd+j4I5g+uWCV3ejspmdtPd3c0q9hx98hAmm1WBFMMSV65KS', 'guru', 59, 0, '0000-00-00 00:00:00'),
(636, 'sman21_guru_sejarah', 'sman21_guru_sejarah@gmail.com', '025e64cb2ad3bcd6d89d70689a8e4f5c51bed6f3e41a98d2cdbf33206999c20aee108d16a8751449f61d19afeeacc1bb73ffa39bea2c554850513c73d0925428bPz5ekxBmgBayUT6eXKn3yleqouNalu0b7XjDovrOrdV/JrzjehoM/K3cXdc8l2j', 'guru', 58, 0, '0000-00-00 00:00:00'),
(637, 'sman21_guru_ekonomi', 'sman21_guru_ekonomi@gmail.com', 'f52099ec578328de5c641d27d96e78d201f6e2af8ce371b4cb2ab3862bcabc0451bc0a1c3280ddf58ff94812c79ffecf4a3fe0adb3f0b582f992e5c2fb397e96izxBlAHjPHH1u7idhj9KLotu8M8zcUU/ovKGHGe/T/ByRWiJUhj6XdpNGIVpOOAc', 'guru', 57, 0, '0000-00-00 00:00:00'),
(638, 'sman21_guru_biologi', 'sman21_guru_biologi@gmail.com', '9dd6bdedb183e8c0a2321151368e6b935e2ab9a49c6b1b5ff1c4556c80dc782127e2dbf8bd1eda3b94b61ab1369048c25b31115fff02a8a12d5fb14f4dd09bba958mJdt8okwLf03Dlkqc4gjcE2jRmxoZjBJ5880cNPbO+x02npcu0z8DWbXxx3Q5', 'guru', 56, 0, '0000-00-00 00:00:00'),
(639, 'sman21_guru_kimia', 'sman21_guru_kimia@gmail.com', '7468aaaf95fc4ac69935e3b186ba7125155dd0bd48efb53a48b0e023f7ca40020289ae3117bdff0524546f415619b0fd0fe7e243c98297c6611b25c562c0a8dcxBrN/JVguuFwEWkeZSCU88O+WusePE+sedyF2s4rMGCnBxZF5sgRHfjETolghRe0', 'guru', 55, 0, '0000-00-00 00:00:00'),
(640, 'sman21_guru_fisika', 'sman21_guru_fisika@gmail.com', '2d7718e9487dc92385c6f4799365f9d6cb5a87beadfa4fb5ae1200ae1f977f37fa02d7e14600f3c0adf6fbe2892b1158d3380499b2fad3b6e2b2f20d187e0e2dxKdAZ+6rXBIae9Lx1//nrFVhUN+Wj8ANcu9RUqjKB2RAC6Yd8/B+vGqXlZyRpcjp', 'guru', 54, 0, '0000-00-00 00:00:00'),
(641, 'sman21_guru_mtk', 'sman21_guru_mtk@gmail.com', '42359db449727b78f302ad61858e49f25180d9374ae56e764d1b6854a27b85b40a7f59293eb8b2a0d24197cc5d6bf9583d9dac5b0eb1101f3b015aff8a1bc0b72U5yK6tNKuFv2SMlJTJrni+/YntOp645YU5diAVQSQ0=', 'guru', 53, 0, '0000-00-00 00:00:00'),
(642, 'adityasman21bdg', 'adityasman21bdg@gmail.com', 'd31266158f79c9973805f81d0bcf0a5c589cc852cb94a1ed03d27afafc4d2f52c867bc93e145dbd53cb12f874463012f320864bcc32c6c91b93ff6ea87832bdbpayTq+7aCw2IqEr5KX8D1pzcSbZuSYjVsHecGknWU3o=', 'siswa', 555, 0, '0000-00-00 00:00:00'),
(643, 'ajisman21bdg', 'ajisman21bdg@gmail.com', '0dd9061d8aad98d2b5113991910372c1e2088d79f9661e153c913b1b8524d4864186e71cae8a938d32ee3bcca3c29d5202984922b230733e4a8857ddb6c612c0Got4Vi50uwk5PRlJgvGlmWWK9PlaLI3smZtY7tIBT1g=', 'siswa', 556, 0, '0000-00-00 00:00:00'),
(644, 'anindasman21bdg', 'anindasman21bdg@gmail.com', '4d2a5ccc78eabdc4941b0ef5e3923c6babaee42d9569e8193fbd01d51d887006882bf09c1421b263e599deecb7ccb553e0eb99827a0ab70e3568e3a0a2626c34qxZAWub50N5swyqcgeh+tsbf/GUjQcR6ekSrEzH21CU=', 'siswa', 557, 0, '0000-00-00 00:00:00'),
(645, 'annisasman21bdg', 'annisasman21bdg@gmail.com', 'ed8422131d297ddb05360d2b70b9fd1abc830ceef4950ca7e1535cf7b171055fb6c70967d496f17bd2a9690d15962fa25472c4701a9548e7744c5f94d93b347bVZNUE/gSaAb5AKi1Vmxbc0Y38/wuoTDsqht2e0mzbs0=', 'siswa', 558, 0, '0000-00-00 00:00:00'),
(646, 'bayusman21bdg', 'bayusman21bdg@gmail.com', '46630023cbf499af92ee770affc896499fb0aa7efcc50ef663bf66c9627a9fb203c9b0ee7879322df9e6cb5644e6a2631453ba13dc8908cc863db17908acdbfeI1Lg63Ujpj0e4l8BNSrf6s4/se3twV5ZW+Qz3E5XwAk=', 'siswa', 559, 0, '0000-00-00 00:00:00'),
(647, 'badrunsman21bdg', 'badrunsman21bdg@gmail.com', 'a6c32081524c30d516c7c34f036d98368987c60ddb93d25b972f46e358d944184298044e95abbe5bd7c8811a0db6ee22973bc2b6138b06bd77518725a04851487SndLL9r8qNmD9SxRifjujOBHRQLOBlsJbCxlXZ0cVU=', 'siswa', 560, 0, '0000-00-00 00:00:00'),
(648, 'bilqissman21bdg', 'bilqissman21bdg@gmail.com', 'a9ad4570834e812a2af804b7df6ab09977aadfdd2e067c697ccef2e40c6f0486f7a2268c9a9a97e9dd21ddcad5a056ab5d6e747c59a78a0d7f6015b647f1dce27pWNzcFTbg+TE/ESTEIdY88ntqfUMuoNRfhJKSkcjgs=', 'siswa', 561, 0, '0000-00-00 00:00:00'),
(649, 'bungasman21bdg', 'bungasman21bdg@gmail.com', 'e0eb147813808c701def00d6483e8816e3b7991be0ded735e81a632ee37196bcea015e0a72cf69e2aa68259c198443746ea8f8c5df66e51b3a8772ccfeebac72MZ6TTnjdKSMw+540rzDj7P+RsHM1vrcM1hoWkAM+xjg=', 'siswa', 562, 0, '0000-00-00 00:00:00'),
(650, 'cacasman21bdg', 'cacasman21bdg@gmail.com', '9c7e3cb611a79a67b5d4bcb2b8878061ce1d3a10276244b90e8c787eb2cec89861dec4ee2730811cc5a2c5e46c7a43b63996b8d270585832071baec855106e23Z/wIFgwA/SffqvZS6CrrKLPg5E5QguIfs1Sd6I21hso=', 'siswa', 563, 0, '0000-00-00 00:00:00'),
(651, 'chikasman21bdg', 'chikasman21bdg@gmail.com', '97074f4a994498989740b7693f0886eabdbcb4e6ea58284f25f737291dd317c75bb3e71a40bf90592d292a0529ca34eca849b0c36d1cf938f5d5751502cf64775n+fIeF+PeJe3TzBEsJJt7UPzVfYAE0j42mLGia+LOM=', 'siswa', 564, 0, '0000-00-00 00:00:00'),
(652, 'cokysman21bdg', 'cokysman21bdg@gmail.com', '5fc354a7a5822da77ba305f52a0536ed16fbafc0b1afdd3c084662959b7604010b3de0403148393b3ce7b0799eccc258a1db3c13964be62531ee39c276263491f8hm8go2PJfyPIKvNxVWYw0G5n5uVFkJ0dUqYtqU5xY=', 'siswa', 565, 0, '0000-00-00 00:00:00'),
(653, 'cakasman21bdg', 'cakasman21bdg@gmail.com', 'f4ba935ad0d6352373b0a618b640a5eb60b1a5e450e598fe381386e4c3f507be54e9180a5409bd1af557b9cd6a96b69ec29f03470e5e6ae338e10b970432f67115KiSrqsrYZXbJZC/OqpDRO9jNjChxjNkOB6FCUKtjM=', 'siswa', 566, 0, '0000-00-00 00:00:00'),
(654, 'dedesman21bdg', 'dedesman21bdg@gmail.com', '88655790e8ef615f68ddd547165b5bca8a4444480a387d7d5c01187cb834cfac77c9fb8e20d4ddae97142d30bfb01444a7fcd07ad2cee8cca07360124a31f32dcVlhbW9T2VFS06AILaIRS+PSbMqPr6kRYF/waMz599E=', 'siswa', 567, 0, '0000-00-00 00:00:00'),
(655, 'dedensman21bdg', 'dedensman21bdg@gmail.com', '332cd5c4cf50a5e2c1ab71afacc37ddc7c794307f1c099b6bc57613d5c2023b3b60f8e97683da450b0d90b2b750b1acdaf25834a26dc481f6f08d366ddebef84LJcIRuROdQk5lrGTUFmoLxMUEDfPd4Rj+Q1eqRH89tw=', 'siswa', 568, 0, '0000-00-00 00:00:00'),
(656, 'delvysman21bdg', 'delvysman21bdg@gmail.com', 'e42c22232dc1611531de6256a4430092427691258b31c3941638293a9316042bc757f1705f4966156e5ee3197dfabde0933383016cc4cd16f9a06e60ff29bdddTVQDBL+bQw6XIeTZovymQ2ruO0fr6FaIqwunRek5PZg=', 'siswa', 569, 0, '0000-00-00 00:00:00'),
(657, 'desisman21bdg', 'desisman21bdg@gmail.com', '020ad84b81cb30c94040c3a932920dc62ea83a79bae5508d119012b100acbfc33652fac8f6ce4939ce31136575891157f1d8f2b709fa8e63f6c760d63be8a9bf8Z+O0BwGx8otpjTV9lsKVVdGQ3Q4Kjgmmxgs185zL3I=', 'siswa', 570, 0, '0000-00-00 00:00:00'),
(658, 'gifarsman21bdg', 'gifarsman21bdg@gmail.com', 'b458e4e4b037457d618604bbbbd795b3ce55a984bc0325f715dc3796c7af1a160cd7c20e270b47523bffedb33f66f1be16495d33e84691c856102bc8f200976f0/+2+Tctra8lZ73ywY21ZhhJz1OIuW5as8NaNF5w/fI=', 'siswa', 571, 0, '0000-00-00 00:00:00'),
(659, 'geosman21bdg', 'geosman21bdg@gmail.com', '99387eb1d778c30978d219dec0febc08816048c9bba941e77a2209e29687c75e420f0d059ea40e5c567e3413f94e89c5b027d6a81d61af2e7c06e7bfbc901d93vYHwarTYX5vsO2AknmYa3WGvHA/egAg3H7VoP3pPcRA=', 'siswa', 572, 0, '0000-00-00 00:00:00'),
(660, 'gheasman21bdg', 'gheasman21bdg@gmail.com', '44aa8b7a79966cc36ddd85f8a8c26fa7947d1878ae90e99beb05b4a0b03ec55c8998cd9659576a82284ad66473c9717d70830b1eb702f93d28c4794873fbc5bdcqpiPK7ccmNB1hFludtpZ9AtzqY7kafZLBK+2l+n6Vw=', 'siswa', 573, 0, '0000-00-00 00:00:00'),
(661, 'giovannisman21bdg', 'giovannisman21bdg@gmail.com', '97e4550d8ce3331ef91e3b1aceaafc29137c94e5c1ca51c3f71cd45c007cd27460252d52a620d82d5bed5b96ad375b994f6a33e58b3e8c40e57fa779f1a4b027tmG176Txj4El1SeYwyCSsgI+QETckQHrIVWV7fQh5FvOxlVxf8fdwiW0juW7EQD5', 'siswa', 574, 0, '0000-00-00 00:00:00'),
(662, 'haikalsman21bdg', 'haikalsman21bdg@gmail.com', '883ebe0785b0551a1e4defabd36ae1158eb160daa6adfe01f69bbb4d473e5c52577504cac580631aa28a8951a26137ce29d43f98b1b200b2a12695f07bd41604Hb+EehJTIPjKWpy3BWsCl3M9blPxNeNaYuPkHDwx2bQ=', 'siswa', 575, 0, '0000-00-00 00:00:00'),
(663, 'husnisman21bdg', 'husnisman21bdg@gmail.com', 'b544f168b5b007d39a0b64db8e2441614701a0ddf72dc520672c20eece657bf665bdaf71033264d291a2ac79c1684057c9f75cdf6166ffb2ea537a1571f50594zI91wbCa3vVqjw4ri+8WDGHNrjDJRDXrsPNG56z1qCg=', 'siswa', 576, 0, '0000-00-00 00:00:00'),
(664, 'iissman21bdg', 'iissman21bdg@gmail.com', '975b6351cb4e2261c2f78c86fd235cfbd60fb8b7e4134effd688c91f0ae5b04cd2584fdced7108f3b0942d6fff13da38f9095d2705e87a6546f473e6aace5fc0McZFA7O6bSn2w29JLtQ9O1yMJvb9qeuucxzsYiCD+Vs=', 'siswa', 577, 0, '0000-00-00 00:00:00'),
(665, 'imassman21bdg', 'imassman21bdg@gmail.com', 'c7eb0cfb7bb333958527a51d3ccfe6ec52dd6d9aa2e86fa0b3eb9ac842d2248b2dfc9255544058d5096aefa27453f5dd35a04eb054dd615a0a1b3cf574aa2581jfEHjkzMSV+IwD8+RLP0JrT4orzasAmce3WWd35gW1k=', 'siswa', 578, 0, '0000-00-00 00:00:00'),
(666, 'herisuherman', 'dsdsdsds', '0f0f1607a397049e98133803516e8b378e18b279a7640146a8340e054b6cb8ed31e32fcb86401b746c502f90b10f75f07ac83ad4e804a3b54eb9c837f7ca8cd6KQ0K+mjSZfGVvHXojr6My9xQLr2bMJE1nrniRbRj8CU=', 'guru', 64, 0, '0000-00-00 00:00:00'),
(667, 'ika', 'dsdsds', 'b9d0556d805b9820db1dd1b7ca52e1a10f8acd3a55b7338dba65285773680a19a2adb5c7dcf91659e481df59c6674359a052b4e68c92bbad05224957941d28c5DRvPdHgdd3/XHVsT38rZawR5agxM+JPf/rx5qShUfko=', 'guru', 67, 0, '0000-00-00 00:00:00'),
(668, 'sarah', '6gdfgdg', 'a5263bbf258e1420bac07dc0510370781310b6c3a1c584eb6cff018fef37eb9022264a6279d26772c1a1540a1a653cbb53b7dfc36b08321c7cc7b5126cac5814hnFgDs2tDTOKRa7h+ku7qPvAsbUba9YA2RHIGAACYRA=', 'guru', 66, 0, '0000-00-00 00:00:00'),
(669, 'Aini', 'dsdsds', '2f379afc85ff07e523f45ee32e2700f18fb781590378bb31d40a07aacd97e6db684a4476c329c02b0d1a00ae3c7aadd1820d6f54a8694df563f3c3d8518d9dfcz2JZG7Xd4330iLybRyELIvTIjGMTyp5nS1KVUcZZYY4=', 'guru', 65, 0, '0000-00-00 00:00:00'),
(670, 'sman25_guru_bsun', 'sman25_guru_bsun@gmail.com', '8ec47ad5c6150bd101eb9df145e1e39c82f62978333261894c213dca94e395304d298c72589f68d40bedd5ebda3182ce3def648cc649c5c16637e81eff620810oQf039iH1FNbZTTO/+YqHRpr7hL2ETR5AouSUwnhj3JQcSjoIgw3wJtTId/sCACX', 'guru', 78, 0, '0000-00-00 00:00:00'),
(671, 'sman25_guru_bingg', 'sman25_guru_bingg@gmail.com', '7b37a9eeb3ba12b10210b590f31d608c79b0af885253a1ea67a3f9320bc1c89e76db421be10aab751f43e527fd0a15415e8626d898db78604e52aaff3fae59b4ImYqSewC3xDTXjd4tMp5ZMHBBODlcmqO56VyzDX57RYZcyrG13QCSpZfPjHAqGAM', 'guru', 77, 0, '0000-00-00 00:00:00'),
(672, 'sman25_guru_bindo', 'sman25_guru_bindo@gmail.com', '846035f19c9202d8992a405a9398a45bb2db8a55774737257e3865bcc2dabfa8b3fb3793ff696ce6b437a870f0a3e6aeb1e1fcf269cfde55160394c765979479uvE6RJCuFk15mgbexSAqfS6ikL+uSqns2iwNaKapJ0W1lauFHu1yzzbPW2pIMxqh', 'guru', 76, 0, '0000-00-00 00:00:00'),
(673, 'sman25_guru_sosiologi', 'sman25_guru_sosiologi@gmail.com', '24f446258fea82455896597e92bb04c4623e4553e93709e2b2a8eeb6f96b516f437fa6623637bb0c1ac9cc603df4b8e9abaceb57fa7a507b9c162b2219aa1f98SbLrq/EfrS9Rlz4LeY1SegDNXfU8ku5PAWEVVbxno8iqgT3T1bBcyIG+uUNfhAjV', 'guru', 75, 0, '0000-00-00 00:00:00'),
(674, 'sman25_guru_geografis', 'sman25_guru_geografis@gmail.com', 'db95ceef94401209c77bb6cfe7c29b9da105f94b65c355391c171142e8852a39a01592f6f5beb77964e68567266512d212bbf47174ca19486d0cfdaff8c6b368ZDZLb9tPMBTLdosiZsrzP3b6oVdV4rFtgGwlhXhbe6ej2nCfSYLea7X697tOc0Ql', 'guru', 74, 0, '0000-00-00 00:00:00'),
(675, 'sman25_guru_sejarah', 'sman25_guru_sejarah@gmail.com', 'cf253f3bd32c9304a103f4397a16ddb98279b75a31903d51e72b52cd6a9e5dd687361f4010397ae44e9d108343b7b0f98c48213df88cc65b240f856ebb8dbd31JjQcmn+iPMWj6PC5Zk3JaQR/PYyLvfpNdVYrOkY3FHRTFxXL36Xd+zrDL7/p5a2y', 'guru', 73, 0, '0000-00-00 00:00:00'),
(676, 'sman25_guru_ekonomi', 'sman25_guru_ekonomi@gmail.com', 'c6d7f2f7e5ca4454216275033346bfb0aa56951298f6bdcaafddbb0460091402575dedeac05d3dc97d1fbbce4a0f59e95d959e63557e943f0c2144d462f1a94bYwC5w+AHrsYyT43eTg7lUuwJQU+XD47zLQe3xE/faT8IxlAaY5+QLQpK4aHE1tj+', 'guru', 72, 0, '0000-00-00 00:00:00'),
(677, 'sman25_guru_biologi', 'sman25_guru_biologi@gmail.com', '836c91bf2f71ddd3ba341d45395b47ec51ad2d6a0849ee57fedb5d7681add19aabefeb6f4e8270098719ec0d0491f9645a18535dc8e27876ecefead67d7695c5Swq6zNfogctlrVKqf+uWgYLk2dnJXB9BhSuz31pHqrt3A+QGYgPDyJ2ueJfPtdn9', 'guru', 71, 0, '0000-00-00 00:00:00'),
(678, 'sman25_guru_kimia', 'sman25_guru_kimia@gmail.com', '15e547636853f1205a8a65593dcf2728bfb1cc89c4afcc326fd9ddecfd81ce6b80dbbd79c55e19c55302e55c8b409f2c13b8aeb8ac7beb6e396e01f19c6a4f582tqqyRW6XDFFW/WN6KTm0Fv4YZXgMyG3LvbpEULp9NcQnqp31bJKPzPcXTpfQv6X', 'guru', 70, 0, '0000-00-00 00:00:00'),
(679, 'sman25_guru_fisika', 'sman25_guru_fisika@gmail.com', '9991286ab8f0dd2d99eacb5aa132b57202dcdd3cf69cad629175ff55013e72c7622b396c7c0484564aa41b8e3c6ae70f6723971ccc702bfceab561eda72935ffS49Hb7cpcOM9SR5pTrnQjyD9cc4eXx900DUBAlg+5BXF0Oi0Pr/A2tTUq0m+Snsp', 'guru', 69, 0, '0000-00-00 00:00:00'),
(680, 'sman25_guru_mtk', 'sman25_guru_mtk@gmail.com', '137bdaf84e9cfd1b7e57cabe7b444e05156f8f0552b12b66cebeda47123076abc416ea438545156d99e471b7d1147daec73c2cba1f420e489ed24a55cdafbdc45CW7ayhLi9eN7z6x35SZo07/GIef1cPLBjNXKGobwFw=', 'guru', 68, 0, '0000-00-00 00:00:00'),
(681, 'adityasman25bdg', 'adityasman25bdg@gmail.com', '229aa94f036d65632bb51a7bb4cc4593', 'siswa', 579, 0, '0000-00-00 00:00:00'),
(682, 'ajisman25bdg', 'ajisman25bdg@gmail.com', '46cae77575aa9230b323f5010e6aa363', 'siswa', 580, 0, '0000-00-00 00:00:00'),
(683, 'anindasman25bdg', 'anindasman25bdg@gmail.com', 'b9f6aafb0e03a58fcf9829c44b5d7b7f', 'siswa', 581, 0, '0000-00-00 00:00:00'),
(684, 'annisasman25bdg', 'annisasman25bdg@gmail.com', 'd5ae309c4923b6ab8361fef86354eb82', 'siswa', 582, 0, '0000-00-00 00:00:00'),
(685, 'bayusman25bdg', 'bayusman25bdg@gmail.com', 'ebb1b2079d61e2038aa313e87171bb1b', 'siswa', 583, 0, '0000-00-00 00:00:00'),
(686, 'badrunsman25bdg', 'badrunsman25bdg@gmail.com', '189ac62c4bb1fc27af2b077b159fe341', 'siswa', 584, 0, '0000-00-00 00:00:00'),
(687, 'bilqissman25bdg', 'bilqissman25bdg@gmail.com', '809c8b159d9c1c505e1c3a0f8efd0397', 'siswa', 585, 0, '0000-00-00 00:00:00'),
(688, 'bungasman25bdg', 'bungasman25bdg@gmail.com', '6154bdec0a893fa0b53f29afaec4adb0', 'siswa', 586, 0, '0000-00-00 00:00:00'),
(689, 'cacasman25bdg', 'cacasman25bdg@gmail.com', '95867f7632b2756ba2a567d6f2e3acfd', 'siswa', 587, 0, '0000-00-00 00:00:00'),
(690, 'chikasman25bdg', 'chikasman25bdg@gmail.com', '91ac265fd83800a0a811dae8baa5621d', 'siswa', 588, 0, '0000-00-00 00:00:00'),
(691, 'cokysman25bdg', 'cokysman25bdg@gmail.com', '194e006bfce11e8db442c222140ac057', 'siswa', 589, 0, '0000-00-00 00:00:00'),
(692, 'cakasman25bdg', 'cakasman25bdg@gmail.com', '63eadc7ecdf75f0398be91f9116da014', 'siswa', 590, 0, '0000-00-00 00:00:00'),
(693, 'dedesman25bdg', 'dedesman25bdg@gmail.com', '76dccdefbee345ccedc397ec0488d96f', 'siswa', 591, 0, '0000-00-00 00:00:00'),
(694, 'dedensman25bdg', 'dedensman25bdg@gmail.com', '8e62789ccbc0d676b543918f0b7fb0fc', 'siswa', 592, 0, '0000-00-00 00:00:00'),
(695, 'delvysman25bdg', 'delvysman25bdg@gmail.com', '6016db05fd3fbd804c979989c46a5a13', 'siswa', 593, 0, '0000-00-00 00:00:00'),
(696, 'desisman25bdg', 'desisman25bdg@gmail.com', '5de1aac70da0cff77801ca4511d0c4a6', 'siswa', 594, 0, '0000-00-00 00:00:00'),
(697, 'gifarsman25bdg', 'gifarsman25bdg@gmail.com', 'fb185861b6e9fca8d22141b519a851af', 'siswa', 595, 0, '0000-00-00 00:00:00'),
(698, 'geosman25bdg', 'geosman25bdg@gmail.com', '186e35f9e716a81e532411b52f1e219c', 'siswa', 596, 0, '0000-00-00 00:00:00'),
(699, 'gheasman25bdg', 'gheasman25bdg@gmail.com', '1f945c2244f888a6923c621ae27f8a5e', 'siswa', 597, 0, '0000-00-00 00:00:00'),
(700, 'giovannisman25bdg', 'giovannisman25bdg@gmail.com', '99db5aa870ba706eea88e2eeaedc70f6', 'siswa', 598, 0, '0000-00-00 00:00:00'),
(701, 'haikalsman25bdg', 'haikalsman25bdg@gmail.com', 'b62554733ba26e3321afa320cf1db009', 'siswa', 599, 0, '0000-00-00 00:00:00'),
(702, 'husnisman25bdg', 'husnisman25bdg@gmail.com', '989ce7e1f8ce2dde264c41b944770b2f', 'siswa', 600, 0, '0000-00-00 00:00:00'),
(703, 'iissman25bdg', 'iissman25bdg@gmail.com', 'b5e3e154ecdf1614750905c42d792fb6', 'siswa', 601, 0, '0000-00-00 00:00:00'),
(704, 'imassman25bdg', 'imassman25bdg@gmail.com', '8ccedc66eef43adbfed88f92e8cd1194', 'siswa', 602, 0, '0000-00-00 00:00:00'),
(705, 'barabursa', 'barabursa@gmial.com', 'f0fb515ea349e5e3a4bdd8b60404c27398bb1ee6d038ffc11b5bb78b2652c202a5d14cc9c92c8a7263bd0a4755d7755a7d7f974bf10b890f1f66e51917071a6felsSN5tvgjauyp8IgOBikxDWs0pkY/2fcG1zZbsz4hU=', 'siswa', 603, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_guru`
--

CREATE TABLE `m_guru` (
  `id` int(6) NOT NULL,
  `tahun_akademik` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `nidn` varchar(50) NOT NULL,
  `nrp` varchar(50) NOT NULL,
  `instansi` bigint(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `jabatan_akademik` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `pendidikan_umum_terakhir` varchar(50) NOT NULL,
  `pendidikan_militer_terakhir` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL DEFAULT 1,
  `active_num` bigint(20) NOT NULL COMMENT 'Column untuk menghitung jumlah login untuk pengajar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_guru`
--

INSERT INTO `m_guru` (`id`, `tahun_akademik`, `username`, `nidn`, `nrp`, `instansi`, `nama`, `pangkat`, `jabatan_akademik`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `email`, `no_telpon`, `status`, `pendidikan_umum_terakhir`, `pendidikan_militer_terakhir`, `semester`, `active_num`) VALUES
(1, '2000', 'rezha123', '123456', '654321', 1, 'Rezha Ranmark', 'Tidak ada', 'Tidak ada', 'Bandung', '1992-03-30', 'Bandung', 'rezha@gmail.com', '081220970900', 'Aktif', 'Informatika', 'Informatika', 1, 0),
(22, '-', 'dwi', '12351', '41242141', 2, 'Dwi Surdiana', '-', '-', '-', '2017-12-31', '-', 'dwi@gmail.com', '08234234', '-', '-', '-', 1, 0),
(23, '2020', 'guru1', '091', '091', 3, 'Guru1 SMK', 'Guru dan Staff TU', 'Guru dan Staff TU', 'Bandung', '1980-01-01', 'Bandung', 'guru1@gmail.com', '0909', 'Aktif', 'S2', 'OK', 1, 0),
(24, '2020', 'dosen1', '012', '021', 4, 'Dosen 1 Kampus', 'dosen', 'dosen', 'Bandung', '1990-01-01', 'Bandung', 'dosen1@gmail.com', '0808', 'Aktif', 'S3', 'OK', 1, 0),
(25, '2020', 'indriawan', 'N101', 'N201', 6, 'Indriawan', 'KORPS1', 'Komandan', 'Bandung', '2000-11-11', 'Bandung', 'indriawan@gmail.com', '812121', 'Aktif', 'S2 OXFORD', 'Chef', 1, 0),
(26, '2020', 'fahmi', 'N102', 'N202', 6, 'Fahmi', 'KORPS1', 'Komandan', 'Bandung', '2001-11-11', 'Bandung', 'fahmi@gmail.com', '812122', 'Aktif', 'S2 PELHARBOUR', 'Asisten Chef', 1, 0),
(27, '2020', 'indriawan', 'N101', 'N201', 4, 'Indriawan', 'KORPS1', 'Komandan', 'Bandung', '2000-11-11', 'Bandung', 'indriawan@gmail.com', '812121', 'Aktif', 'S2 OXFORD', 'Chef', 1, 0),
(28, '2020', 'fahmi', 'N102', 'N202', 4, 'Fahmi', 'KORPS1', 'Komandan', 'Bandung', '2001-11-11', 'Bandung', 'fahmi@gmail.com', '812122', 'Aktif', 'S2 PELHARBOUR', 'Asisten Chef', 1, 0),
(30, '2020', 'ujanglagi', '123456789', '43562345', NULL, 'Ujang Lagi', 'Letnan', 'Gak Tau', 'Bandung', '1992-06-20', 'Bandung Raya', 'ujanglagi@gmail.com', '9876128716', 'Aktif', 'S1', 'Gak tau juga', 1, 0),
(31, '2021', 'ujangagain', '12342341', '4575367hh', NULL, 'Ujang Again', 'letnan1', 'Gak Tau1', 'Bandung1', '1993-06-20', 'Bandung Raya1', 'ujanglagi@gmail.com', '5643564365', 'Aktif', 'S2', 'Gak tau juga1', 1, 0),
(32, '2022', 'ujangmantap', '34533543', '6gfhgfdh', NULL, 'Ujang Mantap', 'Letnan2', 'Gak Tau2', 'Bandung2', '1994-06-20', 'Bandung Raya2', 'ujanglagi@gmail.com', '34564356435', 'Aktif', 'S3', 'Gak tau juga2', 1, 0),
(38, '2020', 'aldilla', '001', '22451/P', 1, 'Aldilla Mutaqien', 'Letkol Laut', 'Gumil Tetap', 'Bandung', '2020-06-04', 'Jakarta Timur', 'dwisurdiana88@gmail.co.id', '0828182918291', '-', 'S2', '-', 1, 0),
(41, '2020', 'ari', '4016097201', '197209161997032001', 9, 'Ari Tri Jurini, S.T.,M.T.', 'Pembina IV/a', 'Lektor muda', 'surabaya', '1972-09-16', 'Gunung anyar emas selatan IV/23', 'ari_aal@yahoo.com', '082140631020', 'Dosen Utama', 'S2', 'Dep Iptek', 2, 0),
(42, '2020', 'sekar', '4731127101', '19711231 199703 2 012', 9, 'Kustianing  Sekar Dijastuti, SE, MM', 'Pembina IV/a', 'Lektor muda', 'Nganjuk', '1971-12-31', 'Patria Permai V Blok BA No 1 Bambe Driyorejo Gresik', 'sekar.progaaal@gmail.com', '0818503155', 'Dosen Utama', 'S2', 'Deplai', 2, 0),
(43, '2020', 'gurumatematika', '001', '001', 10, 'Guru Matematika', '--', '--', '-', '2020-06-15', '---', '-', '0896123321', '-', '-', '-', 1, 0),
(44, '2020', 'gurukimia', '002', '002', 10, 'Guru kimia', '-', '-', '-', '2020-05-31', '--', 'gurukimia@gmail.com', '081234432', '-', '-', '-', 1, 0),
(45, '2020', 'gurufisika', '003', '003', 10, 'Guru Fisika', '-', '-', '-', '2020-06-01', '--', 'gurufisika@gmail.com', '098765431', '-', '-', '-', 1, 0),
(46, '2020', 'gurubiologi', '004', '004', 10, 'Guru Biologi', '-', '-', '-', '2020-06-02', '--', 'gurubiologi@gmail.com', '0813211123', '-', '-', '-', 1, 0),
(47, '2020', 'gurubahasaindonesia', '005', '005', 10, 'Guru Bahasa Indonesia', '-', '-', '-', '2020-06-04', '--', 'gurubahasaindonesia@gmail.com', '08123331234', '-', '-', '-', 1, 0),
(48, '2020', 'gurubahasainggris', '006', '006', 10, 'Guru Bahasa Inggris', '-', '-', '-', '2020-06-06', '--', 'gurubahasainggris@gmail.com', '12332123145', '-', '-', '-', 1, 0),
(49, '2020', 'gurugeografi', '007', '007', 10, 'Guru Geografi', '-', '-', '-', '2020-06-07', '--', 'gurugeografi@gmail.com', '081321321321', '-', '-', '-', 1, 0),
(50, '2020', 'gurusosiologi', '008', '008', 10, 'Guru Sosiologi', '-', '-', '-', '2020-06-08', '--', 'gurusosiologi@gmail.com', '09876543123456', '-', '-', '-', 1, 0),
(51, '2020', 'gurusejarah', '009', '009', 10, 'Guru Sejarah', '-', '-', '-', '2020-06-09', '--', 'gurusejarah@gmail.com', '762345678765456', '-', '-', '-', 1, 0),
(52, '2020', 'guruekonomi', '0010', '0010', 10, 'Guru Ekonomi', '-', '-', '-', '2020-06-10', '--', 'guruekonomi@gmail.com', '09876544231234', '-', '-', '-', 1, 0),
(53, '2020', 'sman21_guru_mtk', 'PTK200619001', 'P200619NIP001', 11, 'Guru Matematika', '32000101001', 'Guru Matematika', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_mtk@gmail.com', '821312312', 'ASN', 'S1 Pendidikan Matematika', '2013', 1, 0),
(54, '2020', 'sman21_guru_fisika', 'PTK200619002', 'P200619NIP002', 11, 'Guru Fisika', '32000101002', 'Guru Fisika', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_fisika@gmail.com', '821312313', 'ASN', 'S1 Pendidikan Fisika', '2013', 1, 0),
(55, '2020', 'sman21_guru_kimia', 'PTK200619003', 'P200619NIP003', 11, 'Guru Kimia', '32000101003', 'Guru Kimia', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_kimia@gmail.com', '821312314', 'ASN', 'S1 Pendidikan Kimia', '2013', 1, 0),
(56, '2020', 'sman21_guru_biologi', 'PTK200619004', 'P200619NIP004', 11, 'Guru Biologi', '32000101004', 'Guru Biologi', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_biologi@gmail.com', '821312315', 'ASN', 'S1 Pendidikan Biologi', '2013', 1, 0),
(57, '2020', 'sman21_guru_ekonomi', 'PTK200619005', 'P200619NIP005', 11, 'Guru Ekonomi', '32000101005', 'Guru Ekonomi', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_ekonomi@gmail.com', '821312316', 'ASN', 'S1 Pendidikan Ekonomi', '2013', 1, 0),
(58, '2020', 'sman21_guru_sejarah', 'PTK200619006', 'P200619NIP006', 11, 'Guru Sejarah', '32000101006', 'Guru Sejarah', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_sejarah@gmail.com', '821312317', 'ASN', 'S1 Pendidikan Sejarah', '2013', 1, 0),
(59, '2020', 'sman21_guru_geografis', 'PTK200619007', 'P200619NIP007', 11, 'Guru Geografis', '32000101007', 'Guru Geografis', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_geografis@gmail.com', '821312318', 'ASN', 'S1 Pendidikan Geografis', '2013', 1, 0),
(60, '2020', 'sman21_guru_sosiologi', 'PTK200619008', 'P200619NIP008', 11, 'Guru Sosiologi', '32000101008', 'Guru Sosiologi', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_sosiologi@gmail.com', '821312319', 'ASN', 'S1 Pendidikan Sosiologi', '2013', 1, 0),
(61, '2020', 'sman21_guru_bindo', 'PTK200619009', 'P200619NIP009', 11, 'Guru B. Indonesia', '32000101009', 'Guru B. Indonesia', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_bindo@gmail.com', '821312320', 'ASN', 'S1 Pendidikan Bahasa Indonesia', '2013', 1, 0),
(62, '2020', 'sman21_guru_bingg', 'PTK200619010', 'P200619NIP010', 11, 'Guru B. Inggris', '32000101010', 'Guru B. Inggris', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_bingg@gmail.com', '821312321', 'ASN', 'S1 Pendidikan Bahasa Inggris', '2013', 1, 0),
(63, '2020', 'sman21_guru_bsun', 'PTK200619011', 'P200619NIP011', 11, 'Guru B. Sunda', '32000101011', 'Guru B. Sunda', 'Bandung', '1990-03-03', 'Bandung', 'sman21_guru_bsun@gmail.com', '821312322', 'ASN', 'S1 Pendidikan Bahasa Sunda', '2013', 1, 0),
(64, '2020', 'herisuherman', '-', '-', 11, 'Heri Suherman', '-', 'Guru Prakarya', 'Karawang', '1993-06-15', 'Cipaganti', 'dsdsdsds', '433443', 'Janda', 'S1', 'Guru Prakarya', 1, 0),
(65, '2020', 'Aini', '', '', 11, 'Hikmatul Aini', '', 'Guru Matematiks', 'Bandung ', '2000-06-23', 'Bandung', 'dsdsds', '44343', 'kawin', 'S1', '', 0, 0),
(66, '2020', 'sarah', '-', '-', 11, 'Sarah Windika', '-', 'Guru Sejarah', 'Bandung ', '2001-06-23', 'Bandung', '6gdfgdg', '54543', 'kawin', 'S2', 'Guru Sejarah', 0, 0),
(67, '2020', 'ika', '-', '-', 11, 'Ika', '-', 'Guru Kimia', 'Bandung ', '2002-06-23', 'Bandung', 'dsdsds', '434', 'kawin', 'S3', 'Guru Kimia', 1, 0),
(68, '2020', 'sman25_guru_mtk', 'PTK200619001', 'P200619NIP001', 12, 'Guru Matematika', '32000101001', 'Guru Matematika', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_mtk@gmail.com', '821312312', 'ASN', 'S1 Pendidikan Matematika', '2013', 0, 0),
(69, '2020', 'sman25_guru_fisika', 'PTK200619002', 'P200619NIP002', 12, 'Guru Fisika', '32000101002', 'Guru Fisika', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_fisika@gmail.com', '821312313', 'ASN', 'S1 Pendidikan Fisika', '2013', 0, 0),
(70, '2020', 'sman25_guru_kimia', 'PTK200619003', 'P200619NIP003', 12, 'Guru Kimia', '32000101003', 'Guru Kimia', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_kimia@gmail.com', '821312314', 'ASN', 'S1 Pendidikan Kimia', '2013', 0, 0),
(71, '2020', 'sman25_guru_biologi', 'PTK200619004', 'P200619NIP004', 12, 'Guru Biologi', '32000101004', 'Guru Biologi', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_biologi@gmail.com', '821312315', 'ASN', 'S1 Pendidikan Biologi', '2013', 0, 0),
(72, '2020', 'sman25_guru_ekonomi', 'PTK200619005', 'P200619NIP005', 12, 'Guru Ekonomi', '32000101005', 'Guru Ekonomi', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_ekonomi@gmail.com', '821312316', 'ASN', 'S1 Pendidikan Ekonomi', '2013', 0, 0),
(73, '2020', 'sman25_guru_sejarah', 'PTK200619006', 'P200619NIP006', 12, 'Guru Sejarah', '32000101006', 'Guru Sejarah', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_sejarah@gmail.com', '821312317', 'ASN', 'S1 Pendidikan Sejarah', '2013', 0, 0),
(74, '2020', 'sman25_guru_geografis', 'PTK200619007', 'P200619NIP007', 12, 'Guru Geografis', '32000101007', 'Guru Geografis', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_geografis@gmail.com', '821312318', 'ASN', 'S1 Pendidikan Geografis', '2013', 0, 0),
(75, '2020', 'sman25_guru_sosiologi', 'PTK200619008', 'P200619NIP008', 12, 'Guru Sosiologi', '32000101008', 'Guru Sosiologi', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_sosiologi@gmail.com', '821312319', 'ASN', 'S1 Pendidikan Sosiologi', '2013', 0, 0),
(76, '2020', 'sman25_guru_bindo', 'PTK200619009', 'P200619NIP009', 12, 'Guru B. Indonesia', '32000101009', 'Guru B. Indonesia', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_bindo@gmail.com', '821312320', 'ASN', 'S1 Pendidikan Bahasa Indonesia', '2013', 0, 0),
(77, '2020', 'sman25_guru_bingg', 'PTK200619010', 'P200619NIP010', 12, 'Guru B. Inggris', '32000101010', 'Guru B. Inggris', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_bingg@gmail.com', '821312321', 'ASN', 'S1 Pendidikan Bahasa Inggris', '2013', 0, 0),
(78, '2020', 'sman25_guru_bsun', 'PTK200619011', 'P200619NIP011', 12, 'Guru B. Sunda', '32000101011', 'Guru B. Sunda', 'Bandung', '1990-03-03', 'Bandung', 'sman25_guru_bsun@gmail.com', '821312322', 'ASN', 'S1 Pendidikan Bahasa Sunda', '2013', 0, 0);

--
-- Triggers `m_guru`
--
DELIMITER $$
CREATE TRIGGER `hapus_guru` AFTER DELETE ON `m_guru` FOR EACH ROW BEGIN
DELETE FROM m_soal WHERE m_soal.id_guru = OLD.id;
DELETE FROM m_admin WHERE m_admin.level = 'guru' AND m_admin.kon_id = OLD.id;
DELETE FROM tr_guru_mapel WHERE tr_guru_mapel.id_guru = OLD.id;
DELETE FROM tr_guru_tes WHERE tr_guru_tes.id_guru = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_laporan`
--

CREATE TABLE `m_laporan` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` tinyint(5) NOT NULL COMMENT '0. Jenis Modul 1. Jumlah Akses IKM',
  `pengunjung` tinyint(10) NOT NULL,
  `hit` tinyint(10) NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_laporan`
--

INSERT INTO `m_laporan` (`id`, `id_mapel`, `id_user`, `type`, `pengunjung`, `hit`, `updated_at`) VALUES
(1, 9, 35, 0, 1, 0, '2019-11-12'),
(29, 9, 35, 0, 0, 1, '2019-11-13'),
(31, 8, 35, 0, 1, 0, '2019-11-13'),
(32, 7, 35, 0, 1, 0, '2019-11-13'),
(33, 9, 35, 0, 0, 1, '2019-11-13'),
(34, 7, 36, 0, 1, 0, '0000-00-00'),
(35, 9, 6, 0, 1, 0, '0000-00-00'),
(36, 9, 6, 0, 0, 1, '0000-00-00'),
(37, 9, 6, 0, 0, 1, '0000-00-00'),
(38, 5, 6, 0, 1, 0, '0000-00-00'),
(39, 9, 6, 0, 0, 1, '0000-00-00'),
(40, 5, 6, 0, 0, 1, '0000-00-00'),
(41, 5, 6, 0, 0, 1, '0000-00-00'),
(42, 5, 6, 0, 0, 1, '0000-00-00'),
(43, 5, 6, 0, 0, 1, '0000-00-00'),
(44, 5, 6, 0, 0, 1, '0000-00-00'),
(45, 9, 6, 0, 0, 1, '0000-00-00'),
(46, 9, 6, 0, 0, 1, '0000-00-00'),
(47, 9, 6, 0, 0, 1, '0000-00-00'),
(48, 7, 6, 0, 1, 0, '0000-00-00'),
(49, 5, 6, 0, 0, 1, '0000-00-00'),
(50, 9, 6, 0, 0, 1, '0000-00-00'),
(51, 20, 38, 0, 1, 0, '0000-00-00'),
(52, 20, 38, 0, 0, 1, '0000-00-00'),
(53, 20, 6, 0, 1, 0, '0000-00-00'),
(54, 20, 37, 0, 1, 0, '0000-00-00'),
(55, 7, 37, 0, 1, 0, '0000-00-00'),
(56, 20, 37, 0, 0, 1, '0000-00-00'),
(57, 20, 37, 0, 0, 1, '0000-00-00'),
(58, 5, 37, 0, 1, 0, '0000-00-00'),
(59, 7, 37, 0, 0, 1, '0000-00-00'),
(60, 9, 37, 0, 1, 0, '0000-00-00'),
(61, 20, 29, 0, 1, 0, '0000-00-00'),
(62, 9, 29, 0, 1, 0, '0000-00-00'),
(63, 7, 29, 0, 1, 0, '0000-00-00'),
(64, 5, 29, 0, 1, 0, '0000-00-00'),
(65, 31, 39, 0, 1, 0, '0000-00-00'),
(66, 31, 39, 0, 0, 1, '0000-00-00'),
(67, 30, 39, 0, 1, 0, '0000-00-00'),
(68, 31, 37, 0, 1, 0, '0000-00-00'),
(69, 30, 37, 0, 1, 0, '0000-00-00'),
(70, 30, 37, 0, 0, 1, '0000-00-00'),
(71, 30, 37, 0, 0, 1, '0000-00-00'),
(72, 31, 6, 0, 1, 0, '0000-00-00'),
(73, 31, 6, 0, 0, 1, '0000-00-00'),
(74, 31, 6, 0, 0, 1, '0000-00-00'),
(75, 27, 29, 0, 1, 0, '0000-00-00'),
(76, 31, 6, 0, 0, 1, '0000-00-00'),
(77, 30, 6, 0, 1, 0, '0000-00-00'),
(78, 29, 6, 0, 1, 0, '0000-00-00'),
(79, 31, 29, 0, 1, 0, '0000-00-00'),
(80, 30, 29, 0, 1, 0, '0000-00-00'),
(81, 31, 35, 0, 1, 0, '0000-00-00'),
(82, 31, 37, 0, 0, 1, '0000-00-00'),
(83, 31, 37, 0, 0, 1, '0000-00-00'),
(84, 27, 37, 0, 1, 0, '0000-00-00'),
(85, 31, 38, 0, 1, 0, '0000-00-00'),
(86, 31, 38, 0, 0, 1, '0000-00-00'),
(87, 31, 38, 0, 0, 1, '0000-00-00'),
(88, 31, 38, 0, 0, 1, '0000-00-00'),
(89, 31, 38, 0, 0, 1, '0000-00-00'),
(90, 31, 38, 0, 0, 1, '0000-00-00'),
(91, 31, 38, 0, 0, 1, '0000-00-00'),
(92, 31, 38, 0, 0, 1, '0000-00-00'),
(93, 31, 38, 0, 0, 1, '0000-00-00'),
(94, 31, 38, 0, 0, 1, '0000-00-00'),
(95, 31, 38, 0, 0, 1, '0000-00-00'),
(96, 31, 38, 0, 0, 1, '0000-00-00'),
(97, 31, 38, 0, 0, 1, '0000-00-00'),
(98, 31, 38, 0, 0, 1, '0000-00-00'),
(99, 31, 38, 0, 0, 1, '0000-00-00'),
(100, 31, 38, 0, 0, 1, '2019-12-05'),
(101, 31, 38, 0, 0, 1, '2019-12-10'),
(102, 31, 38, 0, 0, 1, '2019-12-10'),
(103, 31, 38, 0, 0, 1, '2019-12-10'),
(104, 31, 38, 0, 0, 1, '2019-12-10'),
(105, 31, 38, 0, 0, 1, '2019-12-11'),
(106, 31, 38, 0, 0, 1, '2019-12-12'),
(107, 31, 38, 0, 0, 1, '2019-12-16'),
(108, 31, 38, 0, 0, 1, '2019-12-16'),
(109, 31, 38, 0, 0, 1, '2019-12-17'),
(110, 31, 41, 0, 1, 0, '2019-12-22'),
(111, 31, 41, 0, 0, 1, '2019-12-23'),
(112, 31, 41, 0, 0, 1, '2019-12-23'),
(113, 31, 41, 0, 0, 1, '2019-12-28'),
(114, 31, 38, 0, 0, 1, '2019-12-30'),
(115, 31, 38, 0, 0, 1, '2019-12-30'),
(116, 31, 38, 0, 0, 1, '2019-12-30'),
(117, 31, 38, 0, 0, 1, '2019-12-30'),
(118, 31, 38, 0, 0, 1, '2019-12-30'),
(119, 31, 38, 0, 0, 1, '2019-12-30'),
(120, 31, 38, 0, 0, 1, '2019-12-30'),
(121, 31, 38, 0, 0, 1, '2019-12-30'),
(122, 31, 38, 0, 0, 1, '2019-12-30'),
(123, 31, 38, 0, 0, 1, '2019-12-30'),
(124, 31, 37, 0, 0, 1, '2019-12-31'),
(125, 31, 37, 0, 0, 1, '2019-12-31'),
(126, 31, 37, 0, 0, 1, '2019-12-31'),
(127, 31, 37, 0, 0, 1, '2019-12-31'),
(128, 31, 37, 0, 0, 1, '2019-12-31'),
(129, 31, 37, 0, 0, 1, '2019-12-31'),
(130, 31, 37, 0, 0, 1, '2019-12-31'),
(131, 31, 37, 0, 0, 1, '2019-12-31'),
(132, 31, 37, 0, 0, 1, '2019-12-31'),
(133, 31, 37, 0, 0, 1, '2019-12-31'),
(134, 31, 37, 0, 0, 1, '2019-12-31'),
(135, 31, 37, 0, 0, 1, '2019-12-31'),
(136, 31, 37, 0, 0, 1, '2019-12-31'),
(137, 31, 41, 0, 0, 1, '2020-01-03'),
(138, 33, 41, 0, 1, 0, '2020-01-03'),
(139, 32, 41, 0, 1, 0, '2020-01-03'),
(140, 31, 41, 0, 0, 1, '2020-01-03'),
(141, 31, 41, 0, 0, 1, '2020-01-03'),
(142, 31, 41, 0, 0, 1, '2020-01-03'),
(143, 31, 41, 0, 0, 1, '2020-01-03'),
(144, 31, 41, 0, 0, 1, '2020-01-03'),
(145, 31, 38, 0, 0, 1, '2020-01-05'),
(146, 31, 38, 0, 0, 1, '2020-01-05'),
(147, 31, 38, 0, 0, 1, '2020-01-05'),
(148, 31, 41, 0, 0, 1, '2020-01-05'),
(149, 31, 41, 0, 0, 1, '2020-01-05'),
(150, 31, 41, 0, 0, 1, '2020-01-05'),
(151, 31, 41, 0, 0, 1, '2020-01-06'),
(152, 31, 41, 0, 0, 1, '2020-01-06'),
(153, 31, 41, 0, 0, 1, '2020-01-06'),
(154, 31, 41, 0, 0, 1, '2020-01-06'),
(155, 31, 41, 0, 0, 1, '2020-01-06'),
(156, 31, 41, 0, 0, 1, '2020-01-06'),
(157, 31, 41, 0, 0, 1, '2020-01-06'),
(158, 31, 41, 0, 0, 1, '2020-01-06'),
(159, 31, 41, 0, 0, 1, '2020-01-06'),
(160, 31, 41, 0, 0, 1, '2020-01-06'),
(161, 31, 41, 0, 0, 1, '2020-01-06'),
(162, 31, 41, 0, 0, 1, '2020-01-06'),
(163, 31, 38, 0, 0, 1, '2020-01-07'),
(164, 31, 41, 0, 0, 1, '2020-01-13'),
(165, 31, 41, 0, 0, 1, '2020-01-13'),
(166, 31, 41, 0, 0, 1, '2020-01-13'),
(167, 31, 38, 0, 0, 1, '2020-01-13'),
(168, 31, 38, 0, 0, 1, '2020-01-13'),
(169, 31, 41, 0, 0, 1, '2020-01-13'),
(170, 31, 44, 0, 1, 0, '2020-01-13'),
(171, 31, 38, 0, 0, 1, '2020-01-13'),
(172, 31, 38, 0, 0, 1, '2020-01-13'),
(173, 31, 44, 0, 0, 1, '2020-01-13'),
(174, 31, 41, 0, 0, 1, '2020-01-13'),
(175, 31, 41, 0, 0, 1, '2020-01-13'),
(176, 31, 41, 0, 0, 1, '2020-01-13'),
(177, 31, 41, 0, 0, 1, '2020-01-13'),
(178, 31, 41, 0, 0, 1, '2020-01-13'),
(179, 31, 38, 0, 0, 1, '2020-01-13'),
(180, 31, 38, 0, 0, 1, '2020-01-13'),
(181, 31, 38, 0, 0, 1, '2020-01-13'),
(182, 31, 44, 0, 0, 1, '2020-01-13'),
(183, 31, 44, 0, 0, 1, '2020-01-13'),
(184, 31, 44, 0, 0, 1, '2020-01-13'),
(185, 31, 44, 0, 0, 1, '2020-01-13'),
(186, 31, 44, 0, 0, 1, '2020-01-13'),
(187, 31, 44, 0, 0, 1, '2020-01-13'),
(188, 31, 44, 0, 0, 1, '2020-01-13'),
(189, 31, 44, 0, 0, 1, '2020-01-13'),
(190, 31, 44, 0, 0, 1, '2020-01-14'),
(191, 31, 44, 0, 0, 1, '2020-01-14'),
(192, 31, 44, 0, 0, 1, '2020-01-14'),
(193, 31, 44, 0, 0, 1, '2020-01-14'),
(194, 31, 44, 0, 0, 1, '2020-01-14'),
(195, 31, 44, 0, 0, 1, '2020-01-14'),
(196, 31, 38, 0, 0, 1, '2020-01-14'),
(197, 31, 44, 0, 0, 1, '2020-01-14'),
(198, 31, 44, 0, 0, 1, '2020-01-14'),
(199, 31, 44, 0, 0, 1, '2020-01-18'),
(200, 31, 38, 0, 0, 1, '2020-01-18'),
(201, 31, 44, 0, 0, 1, '2020-01-18'),
(202, 31, 44, 0, 0, 1, '2020-01-18'),
(203, 31, 44, 0, 0, 1, '2020-01-18'),
(204, 31, 44, 0, 0, 1, '2020-01-18'),
(205, 31, 44, 0, 0, 1, '2020-01-18'),
(206, 31, 44, 0, 0, 1, '2020-01-18'),
(207, 31, 44, 0, 0, 1, '2020-01-18'),
(208, 31, 41, 0, 0, 1, '2020-01-20'),
(209, 31, 41, 0, 0, 1, '2020-01-20'),
(210, 31, 41, 0, 0, 1, '2020-01-20'),
(211, 31, 41, 0, 0, 1, '2020-01-20'),
(212, 31, 41, 0, 0, 1, '2020-01-20'),
(213, 31, 41, 0, 0, 1, '2020-01-20'),
(214, 31, 41, 0, 0, 1, '2020-01-20'),
(215, 31, 41, 0, 0, 1, '2020-01-20'),
(216, 31, 38, 0, 0, 1, '2020-01-21'),
(217, 31, 38, 0, 0, 1, '2020-01-23'),
(218, 31, 38, 0, 0, 1, '2020-01-23'),
(219, 31, 41, 0, 0, 1, '2020-01-25'),
(220, 31, 41, 0, 0, 1, '2020-01-25'),
(221, 31, 44, 0, 0, 1, '2020-01-28'),
(222, 31, 38, 0, 0, 1, '2020-01-28'),
(223, 34, 41, 0, 1, 0, '2020-01-29'),
(224, 34, 41, 0, 0, 1, '2020-01-29'),
(225, 34, 41, 0, 0, 1, '2020-01-29'),
(226, 31, 41, 0, 0, 1, '2020-01-29'),
(227, 34, 41, 0, 0, 1, '2020-01-29'),
(228, 31, 41, 0, 0, 1, '2020-01-29'),
(229, 34, 41, 0, 0, 1, '2020-01-29'),
(230, 34, 41, 0, 0, 1, '2020-01-30'),
(231, 34, 41, 0, 0, 1, '2020-01-31'),
(232, 34, 41, 0, 0, 1, '2020-01-31'),
(233, 34, 41, 0, 0, 1, '2020-01-31'),
(234, 34, 38, 0, 1, 0, '2020-02-01'),
(235, 34, 38, 0, 0, 1, '2020-02-01'),
(236, 34, 41, 0, 0, 1, '2020-02-01'),
(237, 34, 41, 0, 0, 1, '2020-02-01'),
(238, 34, 41, 0, 0, 1, '2020-02-01'),
(239, 31, 41, 0, 0, 1, '2020-02-01'),
(240, 31, 41, 0, 0, 1, '2020-02-01'),
(241, 31, 41, 0, 0, 1, '2020-02-01'),
(242, 31, 41, 0, 0, 1, '2020-02-01'),
(243, 34, 41, 0, 0, 1, '2020-02-01'),
(244, 34, 38, 0, 0, 1, '2020-02-01'),
(245, 34, 38, 0, 0, 1, '2020-02-01'),
(246, 34, 38, 0, 0, 1, '2020-02-01'),
(247, 34, 38, 0, 0, 1, '2020-02-01'),
(248, 34, 38, 0, 0, 1, '2020-02-01'),
(249, 31, 38, 0, 0, 1, '2020-02-02'),
(250, 34, 38, 0, 0, 1, '2020-02-02'),
(251, 34, 38, 0, 0, 1, '2020-02-02'),
(252, 31, 38, 0, 0, 1, '2020-02-02'),
(253, 34, 41, 0, 0, 1, '2020-02-02'),
(254, 34, 41, 0, 0, 1, '2020-02-02'),
(255, 34, 41, 0, 0, 1, '2020-02-02'),
(256, 34, 41, 0, 0, 1, '2020-02-02'),
(257, 34, 41, 0, 0, 1, '2020-02-02'),
(258, 31, 38, 0, 0, 1, '2020-02-02'),
(259, 34, 38, 0, 0, 1, '2020-02-02'),
(260, 31, 38, 0, 0, 1, '2020-02-02'),
(261, 34, 38, 0, 0, 1, '2020-02-02'),
(262, 31, 38, 0, 0, 1, '2020-02-02'),
(263, 34, 38, 0, 0, 1, '2020-02-02'),
(264, 31, 38, 0, 0, 1, '2020-02-02'),
(265, 31, 38, 0, 0, 1, '2020-02-02'),
(266, 34, 38, 0, 0, 1, '2020-02-02'),
(267, 31, 38, 0, 0, 1, '2020-02-02'),
(268, 34, 38, 0, 0, 1, '2020-02-02'),
(269, 34, 38, 0, 0, 1, '2020-02-02'),
(270, 31, 41, 0, 0, 1, '2020-02-02'),
(271, 31, 41, 0, 0, 1, '2020-02-02'),
(272, 31, 41, 0, 0, 1, '2020-02-02'),
(273, 34, 41, 0, 0, 1, '2020-02-02'),
(274, 34, 41, 0, 0, 1, '2020-02-02'),
(275, 31, 41, 0, 0, 1, '2020-02-02'),
(276, 31, 38, 0, 0, 1, '2020-02-03'),
(277, 31, 46, 0, 1, 0, '2020-02-03'),
(278, 31, 46, 0, 0, 1, '2020-02-03'),
(279, 34, 46, 0, 1, 0, '2020-02-03'),
(280, 31, 48, 0, 1, 0, '2020-02-03'),
(281, 31, 54, 0, 1, 0, '2020-02-03'),
(282, 31, 56, 0, 1, 0, '2020-02-03'),
(283, 31, 48, 0, 0, 1, '2020-02-03'),
(284, 31, 55, 0, 1, 0, '2020-02-03'),
(285, 31, 53, 0, 1, 0, '2020-02-03'),
(286, 31, 62, 0, 1, 0, '2020-02-03'),
(287, 31, 58, 0, 1, 0, '2020-02-03'),
(288, 31, 50, 0, 1, 0, '2020-02-03'),
(289, 31, 57, 0, 1, 0, '2020-02-03'),
(290, 31, 46, 0, 0, 1, '2020-02-03'),
(291, 31, 61, 0, 1, 0, '2020-02-03'),
(292, 31, 49, 0, 1, 0, '2020-02-03'),
(293, 31, 52, 0, 1, 0, '2020-02-03'),
(294, 31, 47, 0, 1, 0, '2020-02-03'),
(295, 31, 65, 0, 1, 0, '2020-02-03'),
(296, 31, 51, 0, 1, 0, '2020-02-03'),
(297, 31, 60, 0, 1, 0, '2020-02-03'),
(298, 31, 59, 0, 1, 0, '2020-02-03'),
(299, 31, 63, 0, 1, 0, '2020-02-03'),
(300, 31, 64, 0, 1, 0, '2020-02-03'),
(301, 31, 59, 0, 0, 1, '2020-02-03'),
(302, 31, 50, 0, 0, 1, '2020-02-03'),
(303, 34, 46, 0, 0, 1, '2020-02-03'),
(304, 31, 46, 0, 0, 1, '2020-02-03'),
(305, 31, 47, 0, 0, 1, '2020-02-03'),
(306, 31, 48, 0, 0, 1, '2020-02-03'),
(307, 31, 48, 0, 0, 1, '2020-02-03'),
(308, 31, 58, 0, 0, 1, '2020-02-03'),
(309, 31, 46, 0, 0, 1, '2020-02-03'),
(310, 31, 47, 0, 0, 1, '2020-02-03'),
(311, 31, 62, 0, 0, 1, '2020-02-03'),
(312, 34, 65, 0, 1, 0, '2020-02-03'),
(313, 31, 54, 0, 0, 1, '2020-02-03'),
(314, 31, 53, 0, 0, 1, '2020-02-03'),
(315, 31, 62, 0, 0, 1, '2020-02-03'),
(316, 31, 55, 0, 0, 1, '2020-02-03'),
(317, 31, 61, 0, 0, 1, '2020-02-03'),
(318, 31, 60, 0, 0, 1, '2020-02-03'),
(319, 31, 46, 0, 0, 1, '2020-02-03'),
(320, 31, 59, 0, 0, 1, '2020-02-03'),
(321, 31, 65, 0, 0, 1, '2020-02-03'),
(322, 31, 58, 0, 0, 1, '2020-02-03'),
(323, 31, 47, 0, 0, 1, '2020-02-03'),
(324, 31, 48, 0, 0, 1, '2020-02-03'),
(325, 31, 52, 0, 0, 1, '2020-02-03'),
(326, 31, 64, 0, 0, 1, '2020-02-03'),
(327, 31, 63, 0, 0, 1, '2020-02-03'),
(328, 31, 49, 0, 0, 1, '2020-02-03'),
(329, 31, 50, 0, 0, 1, '2020-02-03'),
(330, 31, 58, 0, 0, 1, '2020-02-03'),
(331, 31, 51, 0, 0, 1, '2020-02-03'),
(332, 31, 56, 0, 0, 1, '2020-02-03'),
(333, 31, 57, 0, 0, 1, '2020-02-03'),
(334, 31, 48, 0, 0, 1, '2020-02-03'),
(335, 31, 61, 0, 0, 1, '2020-02-03'),
(336, 31, 61, 0, 0, 1, '2020-02-03'),
(337, 31, 59, 0, 0, 1, '2020-02-03'),
(338, 31, 55, 0, 0, 1, '2020-02-03'),
(339, 31, 51, 0, 0, 1, '2020-02-03'),
(340, 31, 65, 0, 0, 1, '2020-02-03'),
(341, 31, 50, 0, 0, 1, '2020-02-03'),
(342, 31, 65, 0, 0, 1, '2020-02-03'),
(343, 34, 51, 0, 1, 0, '2020-02-03'),
(344, 31, 51, 0, 0, 1, '2020-02-03'),
(345, 31, 55, 0, 0, 1, '2020-02-03'),
(346, 31, 54, 0, 0, 1, '2020-02-03'),
(347, 31, 63, 0, 0, 1, '2020-02-03'),
(348, 31, 51, 0, 0, 1, '2020-02-03'),
(349, 31, 53, 0, 0, 1, '2020-02-03'),
(350, 31, 55, 0, 0, 1, '2020-02-03'),
(351, 31, 54, 0, 0, 1, '2020-02-03'),
(352, 31, 54, 0, 0, 1, '2020-02-03'),
(353, 31, 54, 0, 0, 1, '2020-02-03'),
(354, 31, 53, 0, 0, 1, '2020-02-03'),
(355, 31, 54, 0, 0, 1, '2020-02-03'),
(356, 31, 55, 0, 0, 1, '2020-02-03'),
(357, 31, 63, 0, 0, 1, '2020-02-03'),
(358, 31, 55, 0, 0, 1, '2020-02-03'),
(359, 31, 58, 0, 0, 1, '2020-02-03'),
(360, 31, 62, 0, 0, 1, '2020-02-03'),
(361, 31, 55, 0, 0, 1, '2020-02-03'),
(362, 31, 60, 0, 0, 1, '2020-02-03'),
(363, 31, 51, 0, 0, 1, '2020-02-03'),
(364, 31, 63, 0, 0, 1, '2020-02-03'),
(365, 31, 59, 0, 0, 1, '2020-02-03'),
(366, 31, 62, 0, 0, 1, '2020-02-03'),
(367, 31, 62, 0, 0, 1, '2020-02-03'),
(368, 31, 51, 0, 0, 1, '2020-02-03'),
(369, 31, 65, 0, 0, 1, '2020-02-03'),
(370, 31, 63, 0, 0, 1, '2020-02-03'),
(371, 31, 55, 0, 0, 1, '2020-02-03'),
(372, 31, 51, 0, 0, 1, '2020-02-03'),
(373, 31, 58, 0, 0, 1, '2020-02-03'),
(374, 31, 63, 0, 0, 1, '2020-02-03'),
(375, 31, 60, 0, 0, 1, '2020-02-03'),
(376, 31, 53, 0, 0, 1, '2020-02-03'),
(377, 31, 62, 0, 0, 1, '2020-02-03'),
(378, 31, 64, 0, 0, 1, '2020-02-03'),
(379, 31, 51, 0, 0, 1, '2020-02-03'),
(380, 34, 54, 0, 1, 0, '2020-02-03'),
(381, 34, 62, 0, 1, 0, '2020-02-03'),
(382, 34, 65, 0, 0, 1, '2020-02-03'),
(383, 34, 55, 0, 1, 0, '2020-02-03'),
(384, 34, 61, 0, 1, 0, '2020-02-03'),
(385, 34, 65, 0, 0, 1, '2020-02-03'),
(386, 31, 53, 0, 0, 1, '2020-02-03'),
(387, 34, 46, 0, 0, 1, '2020-02-03'),
(388, 34, 60, 0, 1, 0, '2020-02-03'),
(389, 34, 47, 0, 1, 0, '2020-02-03'),
(390, 31, 64, 0, 0, 1, '2020-02-03'),
(391, 34, 48, 0, 1, 0, '2020-02-03'),
(392, 31, 57, 0, 0, 1, '2020-02-03'),
(393, 31, 65, 0, 0, 1, '2020-02-03'),
(394, 34, 65, 0, 0, 1, '2020-02-03'),
(395, 34, 64, 0, 1, 0, '2020-02-03'),
(396, 34, 54, 0, 0, 1, '2020-02-03'),
(397, 31, 63, 0, 0, 1, '2020-02-03'),
(398, 34, 64, 0, 0, 1, '2020-02-03'),
(399, 34, 54, 0, 0, 1, '2020-02-03'),
(400, 31, 51, 0, 0, 1, '2020-02-03'),
(401, 34, 64, 0, 0, 1, '2020-02-03'),
(402, 31, 65, 0, 0, 1, '2020-02-03'),
(403, 31, 65, 0, 0, 1, '2020-02-03'),
(404, 31, 49, 0, 0, 1, '2020-02-03'),
(405, 34, 46, 0, 0, 1, '2020-02-03'),
(406, 34, 55, 0, 0, 1, '2020-02-03'),
(407, 31, 65, 0, 0, 1, '2020-02-03'),
(408, 34, 46, 0, 0, 1, '2020-02-03'),
(409, 34, 64, 0, 0, 1, '2020-02-03'),
(410, 34, 54, 0, 0, 1, '2020-02-03'),
(411, 34, 55, 0, 0, 1, '2020-02-03'),
(412, 31, 50, 0, 0, 1, '2020-02-03'),
(413, 34, 64, 0, 0, 1, '2020-02-03'),
(414, 34, 46, 0, 0, 1, '2020-02-03'),
(415, 31, 50, 0, 0, 1, '2020-02-03'),
(416, 34, 55, 0, 0, 1, '2020-02-03'),
(417, 31, 58, 0, 0, 1, '2020-02-03'),
(418, 31, 50, 0, 0, 1, '2020-02-03'),
(419, 34, 46, 0, 0, 1, '2020-02-03'),
(420, 34, 54, 0, 0, 1, '2020-02-03'),
(421, 34, 65, 0, 0, 1, '2020-02-03'),
(422, 31, 62, 0, 0, 1, '2020-02-03'),
(423, 34, 62, 0, 0, 1, '2020-02-03'),
(424, 31, 50, 0, 0, 1, '2020-02-03'),
(425, 34, 65, 0, 0, 1, '2020-02-03'),
(426, 34, 65, 0, 0, 1, '2020-02-03'),
(427, 31, 53, 0, 0, 1, '2020-02-03'),
(428, 31, 53, 0, 0, 1, '2020-02-03'),
(429, 34, 62, 0, 0, 1, '2020-02-03'),
(430, 34, 63, 0, 1, 0, '2020-02-03'),
(431, 34, 63, 0, 0, 1, '2020-02-03'),
(432, 34, 54, 0, 0, 1, '2020-02-03'),
(433, 34, 62, 0, 0, 1, '2020-02-03'),
(434, 31, 50, 0, 0, 1, '2020-02-03'),
(435, 34, 65, 0, 0, 1, '2020-02-03'),
(436, 31, 60, 0, 0, 1, '2020-02-03'),
(437, 34, 55, 0, 0, 1, '2020-02-03'),
(438, 31, 58, 0, 0, 1, '2020-02-03'),
(439, 34, 58, 0, 1, 0, '2020-02-03'),
(440, 31, 53, 0, 0, 1, '2020-02-03'),
(441, 31, 50, 0, 0, 1, '2020-02-03'),
(442, 31, 49, 0, 0, 1, '2020-02-03'),
(443, 34, 57, 0, 1, 0, '2020-02-03'),
(444, 31, 59, 0, 0, 1, '2020-02-03'),
(445, 31, 49, 0, 0, 1, '2020-02-03'),
(446, 34, 47, 0, 0, 1, '2020-02-03'),
(447, 31, 65, 0, 0, 1, '2020-02-03'),
(448, 31, 65, 0, 0, 1, '2020-02-03'),
(449, 34, 47, 0, 0, 1, '2020-02-03'),
(450, 31, 47, 0, 0, 1, '2020-02-03'),
(451, 34, 47, 0, 0, 1, '2020-02-03'),
(452, 31, 49, 0, 0, 1, '2020-02-03'),
(453, 34, 63, 0, 0, 1, '2020-02-03'),
(454, 31, 58, 0, 0, 1, '2020-02-03'),
(455, 34, 54, 0, 0, 1, '2020-02-03'),
(456, 34, 59, 0, 1, 0, '2020-02-03'),
(457, 31, 58, 0, 0, 1, '2020-02-03'),
(458, 34, 63, 0, 0, 1, '2020-02-03'),
(459, 34, 58, 0, 0, 1, '2020-02-03'),
(460, 31, 49, 0, 0, 1, '2020-02-03'),
(461, 34, 63, 0, 0, 1, '2020-02-03'),
(462, 31, 58, 0, 0, 1, '2020-02-03'),
(463, 31, 65, 0, 0, 1, '2020-02-03'),
(464, 31, 49, 0, 0, 1, '2020-02-03'),
(465, 31, 65, 0, 0, 1, '2020-02-03'),
(466, 34, 47, 0, 0, 1, '2020-02-03'),
(467, 34, 63, 0, 0, 1, '2020-02-03'),
(468, 34, 63, 0, 0, 1, '2020-02-03'),
(469, 31, 65, 0, 0, 1, '2020-02-03'),
(470, 31, 49, 0, 0, 1, '2020-02-03'),
(471, 34, 64, 0, 0, 1, '2020-02-03'),
(472, 34, 62, 0, 0, 1, '2020-02-03'),
(473, 34, 61, 0, 0, 1, '2020-02-03'),
(474, 31, 49, 0, 0, 1, '2020-02-03'),
(475, 34, 57, 0, 0, 1, '2020-02-03'),
(476, 31, 65, 0, 0, 1, '2020-02-03'),
(477, 34, 62, 0, 0, 1, '2020-02-03'),
(478, 31, 49, 0, 0, 1, '2020-02-03'),
(479, 31, 58, 0, 0, 1, '2020-02-03'),
(480, 34, 54, 0, 0, 1, '2020-02-03'),
(481, 31, 65, 0, 0, 1, '2020-02-03'),
(482, 31, 51, 0, 0, 1, '2020-02-03'),
(483, 31, 65, 0, 0, 1, '2020-02-03'),
(484, 31, 65, 0, 0, 1, '2020-02-03'),
(485, 34, 41, 0, 0, 1, '2020-02-03'),
(486, 34, 46, 0, 0, 1, '2020-02-04'),
(487, 31, 41, 0, 0, 1, '2020-02-05'),
(488, 31, 41, 0, 0, 1, '2020-02-05'),
(489, 31, 41, 0, 0, 1, '2020-02-05'),
(490, 34, 41, 0, 0, 1, '2020-02-05'),
(491, 31, 44, 0, 0, 1, '2020-02-05'),
(492, 31, 41, 0, 0, 1, '2020-02-05'),
(493, 31, 44, 0, 0, 1, '2020-02-05'),
(494, 31, 44, 0, 0, 1, '2020-02-05'),
(495, 31, 44, 0, 0, 1, '2020-02-05'),
(496, 31, 44, 0, 0, 1, '2020-02-05'),
(497, 31, 44, 0, 0, 1, '2020-02-05'),
(498, 31, 44, 0, 0, 1, '2020-02-05'),
(499, 31, 44, 0, 0, 1, '2020-02-05'),
(500, 34, 44, 0, 1, 0, '2020-02-05'),
(501, 34, 41, 0, 0, 1, '2020-02-05'),
(502, 34, 46, 0, 0, 1, '2020-02-05'),
(503, 34, 46, 0, 0, 1, '2020-02-05'),
(504, 31, 66, 0, 1, 0, '2020-02-05'),
(505, 31, 66, 0, 0, 1, '2020-02-05'),
(506, 34, 66, 0, 1, 0, '2020-02-05'),
(507, 31, 41, 0, 0, 1, '2020-02-05'),
(508, 31, 41, 0, 0, 1, '2020-02-05'),
(509, 31, 41, 0, 0, 1, '2020-02-05'),
(510, 34, 41, 0, 0, 1, '2020-02-05'),
(511, 31, 46, 0, 0, 1, '2020-02-06'),
(512, 31, 46, 0, 0, 1, '2020-02-06'),
(513, 31, 46, 0, 0, 1, '2020-02-06'),
(514, 31, 46, 0, 0, 1, '2020-02-06'),
(515, 31, 38, 0, 0, 1, '2020-02-07'),
(516, 31, 38, 0, 0, 1, '2020-02-07'),
(517, 31, 38, 0, 0, 1, '2020-02-07'),
(518, 34, 38, 0, 0, 1, '2020-02-07'),
(519, 34, 38, 0, 0, 1, '2020-02-07'),
(520, 31, 38, 0, 0, 1, '2020-02-07'),
(521, 34, 38, 0, 0, 1, '2020-02-07'),
(522, 34, 38, 0, 0, 1, '2020-02-07'),
(523, 31, 38, 0, 0, 1, '2020-02-07'),
(524, 34, 41, 0, 0, 1, '2020-02-10'),
(525, 31, 41, 0, 0, 1, '2020-02-10'),
(526, 31, 41, 0, 0, 1, '2020-02-10'),
(527, 31, 41, 0, 0, 1, '2020-02-10'),
(528, 31, 41, 0, 0, 1, '2020-02-10'),
(529, 31, 66, 0, 0, 1, '2020-02-10'),
(530, 31, 38, 0, 0, 1, '2020-02-10'),
(531, 31, 38, 0, 0, 1, '2020-02-10'),
(532, 31, 47, 0, 0, 1, '2020-02-10'),
(533, 31, 47, 0, 0, 1, '2020-02-10'),
(534, 34, 48, 0, 0, 1, '2020-02-10'),
(535, 31, 48, 0, 0, 1, '2020-02-10'),
(536, 34, 48, 0, 0, 1, '2020-02-10'),
(537, 31, 41, 0, 0, 1, '2020-02-10'),
(538, 34, 41, 0, 0, 1, '2020-02-10'),
(539, 31, 46, 0, 0, 1, '2020-02-16'),
(540, 34, 46, 0, 0, 1, '2020-02-16'),
(541, 31, 46, 0, 0, 1, '2020-02-16'),
(542, 31, 46, 0, 0, 1, '2020-02-16'),
(543, 31, 68, 0, 1, 0, '2020-02-16'),
(544, 31, 67, 0, 1, 0, '2020-02-16'),
(545, 34, 67, 0, 1, 0, '2020-02-16'),
(546, 31, 67, 0, 0, 1, '2020-02-17'),
(547, 34, 67, 0, 0, 1, '2020-02-17'),
(548, 31, 67, 0, 0, 1, '2020-02-17'),
(549, 31, 41, 0, 0, 1, '2020-02-17'),
(550, 31, 41, 0, 0, 1, '2020-02-17'),
(551, 34, 41, 0, 0, 1, '2020-02-17'),
(552, 31, 41, 0, 0, 1, '2020-02-17'),
(553, 31, 41, 0, 0, 1, '2020-02-17'),
(554, 31, 41, 0, 0, 1, '2020-02-17'),
(555, 31, 41, 0, 0, 1, '2020-02-17'),
(556, 31, 67, 0, 0, 1, '2020-02-17'),
(557, 31, 68, 0, 0, 1, '2020-02-17'),
(558, 31, 68, 0, 0, 1, '2020-02-17'),
(559, 31, 68, 0, 0, 1, '2020-02-17'),
(560, 31, 67, 0, 0, 1, '2020-02-17'),
(561, 31, 67, 0, 0, 1, '2020-02-17'),
(562, 31, 41, 0, 0, 1, '2020-02-17'),
(563, 31, 67, 0, 0, 1, '2020-02-17'),
(564, 31, 41, 0, 0, 1, '2020-02-17'),
(565, 31, 67, 0, 0, 1, '2020-02-17'),
(566, 31, 67, 0, 0, 1, '2020-02-17'),
(567, 31, 67, 0, 0, 1, '2020-02-17'),
(568, 31, 67, 0, 0, 1, '2020-02-17'),
(569, 31, 67, 0, 0, 1, '2020-02-17'),
(570, 31, 68, 0, 0, 1, '2020-02-17'),
(571, 31, 68, 0, 0, 1, '2020-02-17'),
(572, 31, 68, 0, 0, 1, '2020-02-17'),
(573, 34, 67, 0, 0, 1, '2020-02-17'),
(574, 34, 67, 0, 0, 1, '2020-02-17'),
(575, 31, 68, 0, 0, 1, '2020-02-17'),
(576, 31, 68, 0, 0, 1, '2020-02-17'),
(577, 31, 67, 0, 0, 1, '2020-02-18'),
(578, 31, 67, 0, 0, 1, '2020-02-18'),
(579, 31, 67, 0, 0, 1, '2020-02-18'),
(580, 31, 67, 0, 0, 1, '2020-02-18'),
(581, 31, 67, 0, 0, 1, '2020-02-18'),
(582, 31, 67, 0, 0, 1, '2020-02-18'),
(583, 31, 67, 0, 0, 1, '2020-02-18'),
(584, 31, 67, 0, 0, 1, '2020-02-18'),
(585, 31, 67, 0, 0, 1, '2020-02-18'),
(586, 31, 67, 0, 0, 1, '2020-02-19'),
(587, 31, 67, 0, 0, 1, '2020-02-19'),
(588, 31, 67, 0, 0, 1, '2020-02-19'),
(589, 31, 67, 0, 0, 1, '2020-02-19'),
(590, 31, 67, 0, 0, 1, '2020-02-19'),
(591, 31, 68, 0, 0, 1, '2020-02-19'),
(592, 34, 67, 0, 0, 1, '2020-02-19'),
(593, 31, 68, 0, 0, 1, '2020-02-19'),
(594, 31, 67, 0, 0, 1, '2020-02-19'),
(595, 31, 67, 0, 0, 1, '2020-02-20'),
(596, 31, 67, 0, 0, 1, '2020-02-20'),
(597, 31, 67, 0, 0, 1, '2020-02-20'),
(598, 31, 67, 0, 0, 1, '2020-02-20'),
(599, 31, 41, 0, 0, 1, '2020-02-20'),
(600, 31, 41, 0, 0, 1, '2020-02-20'),
(601, 31, 66, 0, 0, 1, '2020-02-21'),
(602, 31, 66, 0, 0, 1, '2020-02-21'),
(603, 31, 41, 0, 0, 1, '2020-02-21'),
(604, 31, 67, 0, 0, 1, '2020-02-21'),
(605, 31, 67, 0, 0, 1, '2020-02-21'),
(606, 31, 38, 0, 0, 1, '2020-02-21'),
(607, 31, 67, 0, 0, 1, '2020-02-21'),
(608, 31, 67, 0, 0, 1, '2020-02-21'),
(609, 31, 67, 0, 0, 1, '2020-02-21'),
(610, 31, 67, 0, 0, 1, '2020-02-21'),
(611, 31, 67, 0, 0, 1, '2020-02-21'),
(612, 31, 67, 0, 0, 1, '2020-02-21'),
(613, 31, 68, 0, 0, 1, '2020-02-21'),
(614, 31, 67, 0, 0, 1, '2020-02-21'),
(615, 31, 68, 0, 0, 1, '2020-02-21'),
(616, 31, 68, 0, 0, 1, '2020-02-21'),
(617, 31, 68, 0, 0, 1, '2020-02-21'),
(618, 31, 68, 0, 0, 1, '2020-02-21'),
(619, 31, 68, 0, 0, 1, '2020-02-21'),
(620, 31, 68, 0, 0, 1, '2020-02-21'),
(621, 31, 67, 0, 0, 1, '2020-02-21'),
(622, 31, 67, 0, 0, 1, '2020-02-21'),
(623, 31, 68, 0, 0, 1, '2020-02-21'),
(624, 31, 67, 0, 0, 1, '2020-02-21'),
(625, 31, 67, 0, 0, 1, '2020-02-21'),
(626, 31, 67, 0, 0, 1, '2020-02-21'),
(627, 31, 67, 0, 0, 1, '2020-02-21'),
(628, 31, 67, 0, 0, 1, '2020-02-21'),
(629, 31, 67, 0, 0, 1, '2020-02-21'),
(630, 31, 67, 0, 0, 1, '2020-02-21'),
(631, 31, 68, 0, 0, 1, '2020-02-21'),
(632, 31, 68, 0, 0, 1, '2020-02-21'),
(633, 31, 67, 0, 0, 1, '2020-02-21'),
(634, 31, 68, 0, 0, 1, '2020-02-21'),
(635, 31, 68, 0, 0, 1, '2020-02-21'),
(636, 31, 67, 0, 0, 1, '2020-02-21'),
(637, 31, 67, 0, 0, 1, '2020-02-21'),
(638, 31, 38, 0, 0, 1, '2020-02-21'),
(639, 31, 38, 0, 0, 1, '2020-02-21'),
(640, 31, 67, 0, 0, 1, '2020-02-21'),
(641, 31, 68, 0, 0, 1, '2020-02-21'),
(642, 31, 68, 0, 0, 1, '2020-02-21'),
(643, 31, 68, 0, 0, 1, '2020-02-21'),
(644, 31, 67, 0, 0, 1, '2020-02-21'),
(645, 31, 68, 0, 0, 1, '2020-02-21'),
(646, 31, 68, 0, 0, 1, '2020-02-21'),
(647, 31, 68, 0, 0, 1, '2020-02-22'),
(648, 31, 38, 0, 0, 1, '2020-02-22'),
(649, 31, 38, 0, 0, 1, '2020-02-22'),
(650, 31, 67, 0, 0, 1, '2020-02-22'),
(651, 31, 68, 0, 0, 1, '2020-02-22'),
(652, 31, 68, 0, 0, 1, '2020-02-22'),
(653, 31, 68, 0, 0, 1, '2020-02-22'),
(654, 31, 68, 0, 0, 1, '2020-02-22'),
(655, 31, 68, 0, 0, 1, '2020-02-22'),
(656, 31, 68, 0, 0, 1, '2020-02-22'),
(657, 31, 68, 0, 0, 1, '2020-02-22'),
(658, 31, 68, 0, 0, 1, '2020-02-22'),
(659, 31, 68, 0, 0, 1, '2020-02-22'),
(660, 31, 68, 0, 0, 1, '2020-02-22'),
(661, 31, 46, 0, 0, 1, '2020-02-22'),
(662, 31, 68, 0, 0, 1, '2020-02-22'),
(663, 31, 67, 0, 0, 1, '2020-02-22'),
(664, 31, 67, 0, 0, 1, '2020-02-22'),
(665, 31, 68, 0, 0, 1, '2020-02-22'),
(666, 31, 67, 0, 0, 1, '2020-02-22'),
(667, 31, 46, 0, 0, 1, '2020-02-22'),
(668, 34, 46, 0, 0, 1, '2020-02-22'),
(669, 31, 46, 0, 0, 1, '2020-02-22'),
(670, 31, 68, 0, 0, 1, '2020-02-22'),
(671, 31, 68, 0, 0, 1, '2020-02-22'),
(672, 31, 68, 0, 0, 1, '2020-02-22'),
(673, 31, 67, 0, 0, 1, '2020-02-22'),
(674, 31, 68, 0, 0, 1, '2020-02-22'),
(675, 31, 68, 0, 0, 1, '2020-02-22'),
(676, 31, 67, 0, 0, 1, '2020-02-22'),
(677, 31, 66, 0, 0, 1, '2020-02-22'),
(678, 31, 66, 0, 0, 1, '2020-02-22'),
(679, 31, 41, 0, 0, 1, '2020-02-22'),
(680, 31, 41, 0, 0, 1, '2020-02-22'),
(681, 31, 41, 0, 0, 1, '2020-02-22'),
(682, 31, 41, 0, 0, 1, '2020-02-22'),
(683, 31, 41, 0, 0, 1, '2020-02-22'),
(684, 31, 41, 0, 0, 1, '2020-02-22'),
(685, 31, 41, 0, 0, 1, '2020-02-22'),
(686, 31, 41, 0, 0, 1, '2020-02-22'),
(687, 31, 41, 0, 0, 1, '2020-02-22'),
(688, 31, 41, 0, 0, 1, '2020-02-22'),
(689, 31, 41, 0, 0, 1, '2020-02-22'),
(690, 31, 41, 0, 0, 1, '2020-02-22'),
(691, 31, 46, 0, 0, 1, '2020-02-23'),
(692, 31, 41, 0, 0, 1, '2020-02-23'),
(693, 31, 41, 0, 0, 1, '2020-02-23'),
(694, 31, 69, 0, 1, 0, '2020-02-24'),
(695, 31, 69, 0, 0, 1, '2020-02-24'),
(696, 34, 69, 0, 1, 0, '2020-02-24'),
(697, 31, 69, 0, 0, 1, '2020-02-24'),
(698, 31, 41, 0, 0, 1, '2020-02-24'),
(699, 31, 41, 0, 0, 1, '2020-02-24'),
(700, 31, 41, 0, 0, 1, '2020-02-24'),
(701, 31, 41, 0, 0, 1, '2020-02-24'),
(702, 31, 41, 0, 0, 1, '2020-02-24'),
(703, 31, 41, 0, 0, 1, '2020-02-24'),
(704, 31, 41, 0, 0, 1, '2020-02-24'),
(705, 31, 41, 0, 0, 1, '2020-02-24'),
(706, 31, 66, 0, 0, 1, '2020-02-24'),
(707, 31, 66, 0, 0, 1, '2020-02-25'),
(708, 31, 66, 0, 0, 1, '2020-02-25'),
(709, 31, 66, 0, 0, 1, '2020-02-25'),
(710, 31, 66, 0, 0, 1, '2020-02-25'),
(711, 31, 66, 0, 0, 1, '2020-02-25'),
(712, 31, 66, 0, 0, 1, '2020-02-25'),
(713, 31, 66, 0, 0, 1, '2020-02-25'),
(714, 31, 66, 0, 0, 1, '2020-02-25'),
(715, 31, 69, 0, 0, 1, '2020-02-25'),
(716, 31, 46, 0, 0, 1, '2020-02-27'),
(717, 31, 46, 0, 0, 1, '2020-02-27'),
(718, 34, 71, 0, 1, 0, '2020-03-03'),
(719, 31, 71, 0, 1, 0, '2020-03-03'),
(720, 31, 41, 0, 0, 1, '2020-03-03'),
(721, 31, 41, 0, 0, 1, '2020-03-03'),
(722, 31, 41, 0, 0, 1, '2020-03-03'),
(723, 31, 41, 0, 0, 1, '2020-03-03'),
(724, 31, 41, 0, 0, 1, '2020-03-03'),
(725, 31, 71, 0, 0, 1, '2020-03-03'),
(726, 31, 71, 0, 0, 1, '2020-03-03'),
(727, 31, 71, 0, 0, 1, '2020-03-03'),
(728, 31, 71, 0, 0, 1, '2020-03-03'),
(729, 31, 71, 0, 0, 1, '2020-03-03'),
(730, 31, 71, 0, 0, 1, '2020-03-03'),
(731, 35, 71, 0, 1, 0, '2020-03-03'),
(732, 31, 71, 0, 0, 1, '2020-03-03'),
(733, 34, 46, 0, 0, 1, '2020-03-03'),
(734, 31, 71, 0, 0, 1, '2020-03-03'),
(735, 35, 71, 0, 0, 1, '2020-03-03'),
(736, 35, 71, 0, 0, 1, '2020-03-03'),
(737, 31, 71, 0, 0, 1, '2020-03-03'),
(738, 31, 71, 0, 0, 1, '2020-03-03'),
(739, 35, 46, 0, 1, 0, '2020-03-04'),
(740, 31, 71, 0, 0, 1, '2020-03-04'),
(741, 34, 71, 0, 0, 1, '2020-03-05'),
(742, 35, 41, 0, 1, 0, '2020-03-06'),
(743, 31, 41, 0, 0, 1, '2020-03-06'),
(744, 31, 41, 0, 0, 1, '2020-03-06'),
(745, 31, 41, 0, 0, 1, '2020-03-06'),
(746, 31, 72, 0, 1, 0, '2020-03-10'),
(747, 31, 72, 0, 0, 1, '2020-03-10'),
(748, 31, 72, 0, 0, 1, '2020-03-10'),
(749, 31, 72, 0, 0, 1, '2020-03-10'),
(750, 31, 72, 0, 0, 1, '2020-03-10'),
(751, 31, 72, 0, 0, 1, '2020-03-10'),
(752, 31, 72, 0, 0, 1, '2020-03-10'),
(753, 31, 72, 0, 0, 1, '2020-03-12'),
(754, 34, 71, 0, 0, 1, '2020-03-16'),
(755, 34, 71, 0, 0, 1, '2020-03-16'),
(756, 34, 71, 0, 0, 1, '2020-03-16'),
(757, 34, 71, 0, 0, 1, '2020-03-16'),
(758, 34, 71, 0, 0, 1, '2020-03-16'),
(759, 36, 71, 0, 1, 0, '2020-03-16'),
(760, 36, 71, 0, 0, 1, '2020-03-16'),
(761, 36, 71, 0, 0, 1, '2020-03-16'),
(762, 36, 71, 0, 0, 1, '2020-03-18'),
(763, 36, 71, 0, 0, 1, '2020-03-18'),
(764, 36, 71, 0, 0, 1, '2020-03-18'),
(765, 36, 71, 0, 0, 1, '2020-03-18'),
(766, 36, 73, 0, 1, 0, '2020-03-18'),
(767, 36, 73, 0, 0, 1, '2020-03-18'),
(768, 36, 73, 0, 0, 1, '2020-03-18'),
(769, 36, 73, 0, 0, 1, '2020-03-18'),
(770, 36, 73, 0, 0, 1, '2020-03-18'),
(771, 36, 73, 0, 0, 1, '2020-03-18'),
(772, 36, 73, 0, 0, 1, '2020-03-18'),
(773, 36, 71, 0, 0, 1, '2020-03-20'),
(774, 36, 71, 0, 0, 1, '2020-03-20'),
(775, 36, 71, 0, 0, 1, '2020-03-20'),
(776, 36, 71, 0, 0, 1, '2020-03-20'),
(777, 36, 71, 0, 0, 1, '2020-03-20'),
(778, 36, 71, 0, 0, 1, '2020-03-20'),
(779, 36, 71, 0, 0, 1, '2020-03-20'),
(780, 36, 71, 0, 0, 1, '2020-03-20'),
(781, 36, 71, 0, 0, 1, '2020-03-20'),
(782, 36, 71, 0, 0, 1, '2020-03-20'),
(783, 36, 71, 0, 0, 1, '2020-03-20'),
(784, 36, 71, 0, 0, 1, '2020-03-20'),
(785, 36, 71, 0, 0, 1, '2020-03-20'),
(786, 36, 71, 0, 0, 1, '2020-03-20'),
(787, 36, 71, 0, 0, 1, '2020-03-20'),
(788, 36, 946, 0, 1, 0, '2020-03-20'),
(789, 36, 946, 0, 0, 1, '2020-03-20'),
(790, 36, 946, 0, 0, 1, '2020-03-21'),
(791, 36, 946, 0, 0, 1, '2020-03-21'),
(792, 36, 946, 0, 0, 1, '2020-03-21'),
(793, 36, 946, 0, 0, 1, '2020-03-21'),
(794, 37, 946, 0, 1, 0, '2020-03-21'),
(795, 37, 946, 0, 0, 1, '2020-03-21'),
(796, 37, 946, 0, 0, 1, '2020-03-21'),
(797, 37, 945, 0, 1, 0, '2020-03-21'),
(798, 31, 946, 0, 1, 0, '2020-03-21'),
(799, 37, 946, 0, 0, 1, '2020-03-21'),
(800, 37, 944, 0, 1, 0, '2020-03-21'),
(801, 37, 944, 0, 0, 1, '2020-03-21'),
(802, 37, 946, 0, 0, 1, '2020-03-21'),
(803, 37, 944, 0, 0, 1, '2020-03-21'),
(804, 37, 944, 0, 0, 1, '2020-03-21'),
(805, 37, 946, 0, 0, 1, '2020-03-21'),
(806, 37, 944, 0, 0, 1, '2020-03-21'),
(807, 38, 352, 0, 1, 0, '2020-03-21'),
(808, 38, 352, 0, 0, 1, '2020-03-21'),
(809, 31, 352, 0, 1, 0, '2020-03-21'),
(810, 31, 352, 0, 0, 1, '2020-03-21'),
(811, 31, 352, 0, 0, 1, '2020-03-21'),
(812, 31, 352, 0, 0, 1, '2020-03-21'),
(813, 31, 352, 0, 0, 1, '2020-03-21'),
(814, 39, 353, 0, 1, 0, '2020-03-21'),
(815, 39, 353, 0, 0, 1, '2020-03-21'),
(816, 39, 353, 0, 0, 1, '2020-03-21'),
(817, 39, 353, 0, 0, 1, '2020-03-21'),
(818, 39, 353, 0, 0, 1, '2020-03-21'),
(819, 39, 353, 0, 0, 1, '2020-03-21'),
(820, 39, 353, 0, 0, 1, '2020-03-21'),
(821, 39, 353, 0, 0, 1, '2020-03-21'),
(822, 39, 353, 0, 0, 1, '2020-03-21'),
(823, 39, 353, 0, 0, 1, '2020-03-21'),
(824, 39, 353, 0, 0, 1, '2020-03-21'),
(825, 31, 352, 0, 0, 1, '2020-03-21'),
(826, 39, 353, 0, 0, 1, '2020-03-21'),
(827, 39, 353, 0, 0, 1, '2020-03-21'),
(828, 39, 353, 0, 0, 1, '2020-03-21'),
(829, 39, 353, 0, 0, 1, '2020-03-21'),
(830, 39, 353, 0, 0, 1, '2020-03-21'),
(831, 39, 353, 0, 0, 1, '2020-03-21'),
(832, 31, 352, 0, 0, 1, '2020-03-22'),
(833, 38, 186, 0, 1, 0, '2020-03-22'),
(834, 38, 185, 0, 1, 0, '2020-03-22'),
(835, 39, 187, 0, 1, 0, '2020-03-22'),
(836, 47, 362, 0, 1, 0, '2020-03-22'),
(837, 47, 362, 0, 0, 1, '2020-03-22'),
(838, 47, 362, 0, 0, 1, '2020-03-22'),
(839, 47, 362, 0, 0, 1, '2020-03-22'),
(840, 47, 362, 0, 0, 1, '2020-03-22'),
(841, 47, 361, 0, 1, 0, '2020-03-22'),
(842, 47, 361, 0, 0, 1, '2020-03-22'),
(843, 47, 361, 0, 0, 1, '2020-03-22'),
(844, 47, 361, 0, 0, 1, '2020-03-22'),
(845, 47, 362, 0, 0, 1, '2020-03-22'),
(846, 47, 362, 0, 0, 1, '2020-03-22'),
(847, 53, 526, 0, 1, 0, '2020-03-23'),
(848, 53, 526, 0, 0, 1, '2020-03-23'),
(849, 53, 526, 0, 0, 1, '2020-04-01'),
(850, 53, 526, 0, 0, 1, '2020-04-01'),
(851, 53, 526, 0, 0, 1, '2020-04-01'),
(852, 53, 526, 0, 0, 1, '2020-04-01'),
(853, 53, 526, 0, 0, 1, '2020-04-01'),
(854, 53, 526, 0, 0, 1, '2020-04-01'),
(855, 53, 526, 0, 0, 1, '2020-04-01'),
(856, 53, 526, 0, 0, 1, '2020-04-01'),
(857, 53, 526, 0, 0, 1, '2020-04-01'),
(858, 53, 526, 0, 0, 1, '2020-04-01'),
(859, 53, 526, 0, 0, 1, '2020-04-01'),
(860, 53, 526, 0, 0, 1, '2020-04-01'),
(861, 53, 526, 0, 0, 1, '2020-04-01'),
(862, 53, 526, 0, 0, 1, '2020-04-01'),
(863, 53, 526, 0, 0, 1, '2020-04-01'),
(864, 53, 526, 0, 0, 1, '2020-04-01'),
(865, 53, 526, 0, 0, 1, '2020-04-01'),
(866, 53, 526, 0, 0, 1, '2020-04-01'),
(867, 53, 526, 0, 0, 1, '2020-04-01'),
(868, 53, 526, 0, 0, 1, '2020-04-01'),
(869, 53, 526, 0, 0, 1, '2020-04-01'),
(870, 53, 526, 0, 0, 1, '2020-04-01'),
(871, 53, 526, 0, 0, 1, '2020-04-01'),
(872, 53, 526, 0, 0, 1, '2020-04-01'),
(873, 53, 526, 0, 0, 1, '2020-04-01'),
(874, 53, 526, 0, 0, 1, '2020-04-01'),
(875, 53, 526, 0, 0, 1, '2020-04-01'),
(876, 53, 526, 0, 0, 1, '2020-04-02'),
(877, 53, 526, 0, 0, 1, '2020-04-02'),
(878, 53, 526, 0, 0, 1, '2020-04-02'),
(879, 53, 526, 0, 0, 1, '2020-04-02'),
(880, 53, 526, 0, 0, 1, '2020-04-02'),
(881, 53, 526, 0, 0, 1, '2020-04-02'),
(882, 53, 526, 0, 0, 1, '2020-04-04'),
(883, 53, 526, 0, 0, 1, '2020-04-04'),
(884, 53, 526, 0, 0, 1, '2020-04-04'),
(885, 53, 526, 0, 0, 1, '2020-04-04'),
(886, 53, 526, 0, 0, 1, '2020-04-04'),
(887, 53, 526, 0, 0, 1, '2020-04-05'),
(888, 53, 526, 0, 0, 1, '2020-04-05'),
(889, 53, 526, 0, 0, 1, '2020-04-05'),
(890, 53, 526, 0, 0, 1, '2020-04-05'),
(891, 53, 526, 0, 0, 1, '2020-04-05'),
(892, 53, 526, 0, 0, 1, '2020-04-05'),
(893, 53, 526, 0, 0, 1, '2020-04-05'),
(894, 53, 526, 0, 0, 1, '2020-04-05'),
(895, 53, 526, 0, 0, 1, '2020-04-05'),
(896, 53, 526, 0, 0, 1, '2020-04-05'),
(897, 53, 526, 0, 0, 1, '2020-04-05'),
(898, 55, 528, 0, 1, 0, '2020-04-05'),
(899, 55, 528, 0, 0, 1, '2020-04-05'),
(900, 55, 528, 0, 0, 1, '2020-04-05'),
(901, 55, 528, 0, 0, 1, '2020-04-05'),
(902, 55, 528, 0, 0, 1, '2020-04-05'),
(903, 53, 526, 0, 0, 1, '2020-04-05'),
(904, 53, 526, 0, 0, 1, '2020-04-05'),
(905, 53, 526, 0, 0, 1, '2020-04-05'),
(906, 53, 526, 0, 0, 1, '2020-04-05'),
(907, 55, 526, 0, 1, 0, '2020-04-05'),
(908, 53, 530, 0, 1, 0, '2020-04-05'),
(909, 55, 530, 0, 1, 0, '2020-04-05'),
(910, 53, 526, 0, 0, 1, '2020-04-06'),
(911, 55, 528, 0, 0, 1, '2020-04-06'),
(912, 55, 528, 0, 0, 1, '2020-04-06'),
(913, 53, 528, 0, 1, 0, '2020-04-06'),
(914, 55, 528, 0, 0, 1, '2020-04-06'),
(915, 55, 528, 0, 0, 1, '2020-04-06'),
(916, 55, 530, 0, 0, 1, '2020-04-06'),
(917, 55, 526, 0, 0, 1, '2020-04-06'),
(918, 55, 530, 0, 0, 1, '2020-04-06'),
(919, 55, 530, 0, 0, 1, '2020-04-06'),
(920, 53, 526, 0, 0, 1, '2020-04-06'),
(921, 55, 526, 0, 0, 1, '2020-04-06'),
(922, 53, 526, 0, 0, 1, '2020-04-12'),
(923, 53, 526, 0, 0, 1, '2020-04-12'),
(924, 53, 526, 0, 0, 1, '2020-04-13'),
(925, 53, 526, 0, 0, 1, '2020-04-13'),
(926, 53, 526, 0, 0, 1, '2020-04-14'),
(927, 53, 526, 0, 0, 1, '2020-04-14'),
(928, 0, 526, 0, 0, 1, '2020-04-18'),
(929, 0, 526, 0, 0, 1, '2020-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `m_mapel`
--

CREATE TABLE `m_mapel` (
  `id` int(6) NOT NULL,
  `kd_mp` varchar(100) DEFAULT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `silabus` tinyint(10) NOT NULL,
  `path_silabus` text DEFAULT NULL,
  `sks` int(3) DEFAULT NULL,
  `semester` int(4) DEFAULT NULL,
  `angkatan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_mapel`
--

INSERT INTO `m_mapel` (`id`, `kd_mp`, `id_instansi`, `nama`, `silabus`, `path_silabus`, `sks`, `semester`, `angkatan`) VALUES
(55, 'abb1', 1, 'Bahasa Inggris', 0, NULL, 2, 2, '2020'),
(59, NULL, 1, 'Psikologi', 0, NULL, NULL, NULL, NULL),
(60, NULL, 1, 'Matematika Diskrit', 0, NULL, NULL, NULL, NULL),
(62, NULL, 1, 'Kewarganegaraan', 0, NULL, NULL, NULL, NULL),
(63, NULL, 1, 'Strategi Maritim', 0, NULL, NULL, NULL, NULL),
(65, 'A2a1', 1, 'Matematika', 0, NULL, 4, 2, '2020'),
(66, '110', 10, 'Fisika', 0, NULL, 1, 1, '2020'),
(67, '111', 10, 'Kimia', 0, NULL, 1, 1, '2020'),
(68, '112', 10, 'Bahasa Indonesia', 0, NULL, 1, 1, '2020'),
(69, '113', 10, 'Bahasa Inggris', 0, NULL, 1, 1, '2020'),
(70, '114', 10, 'Biologi', 0, NULL, 1, 1, '2020'),
(71, '115', 10, 'Geografi', 0, NULL, 1, 1, '2020'),
(72, '116', 10, 'Sejarah', 0, NULL, 1, 1, '2020'),
(73, '117', 10, 'Ekonomi', 0, NULL, 1, 1, '2020'),
(74, '118', 10, 'Sosiologi', 0, NULL, 1, 1, '2020'),
(75, '119', 10, 'Matematika', 0, NULL, 1, 1, '2020'),
(77, 'IPA001', 11, 'Matematika (IPA) Kelas 10', 0, NULL, 3, 1, '2020'),
(78, 'IPS002', 11, 'EKONOMI KELAS 10', 0, NULL, 2, 1, '2020'),
(79, 'Q1', 11, 'Prakarya', 0, NULL, 2, 1, '2020'),
(80, 'M1', 11, 'Matematika', 0, NULL, 3, 1, '2020'),
(81, 'E1', 11, 'Ekonomi', 0, NULL, 3, 1, '2020'),
(82, 'K1', 11, 'Kimia', 0, NULL, 3, 1, '2020'),
(83, 'S1', 11, 'Sejarah Indonesia', 0, NULL, 2, 1, '2020'),
(84, 'IPA001', 12, 'Matematika (IPA) Kelas 10', 0, NULL, 3, 1, '2020'),
(85, 'IPS001', 12, 'Matematika (IPS) Kelas 10', 0, NULL, 3, 1, '2020');

--
-- Triggers `m_mapel`
--
DELIMITER $$
CREATE TRIGGER `hapus_mapel` AFTER DELETE ON `m_mapel` FOR EACH ROW BEGIN
DELETE FROM m_soal WHERE m_soal.id_mapel = OLD.id;
DELETE FROM tr_guru_mapel WHERE tr_guru_mapel.id_mapel = OLD.id;
DELETE FROM tr_guru_tes WHERE tr_guru_tes.id_mapel = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_materi`
--

CREATE TABLE `m_materi` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_trainer` int(6) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `content` longtext NOT NULL,
  `is_verify` tinyint(4) NOT NULL,
  `pdf` tinyint(4) NOT NULL,
  `video` longtext NOT NULL,
  `path_video` text NOT NULL,
  `upload_manual` tinyint(9) NOT NULL DEFAULT 0,
  `file_pdf` text DEFAULT NULL,
  `file_ppt` text DEFAULT NULL,
  `req_add` tinyint(4) NOT NULL,
  `req_edit` tinyint(4) NOT NULL,
  `req_delete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_materi`
--

INSERT INTO `m_materi` (`id`, `id_mapel`, `id_trainer`, `title`, `content`, `is_verify`, `pdf`, `video`, `path_video`, `upload_manual`, `file_pdf`, `file_ppt`, `req_add`, `req_edit`, `req_delete`) VALUES
(4, 59, 36, 'Membaca Karakter', '<p>Membaca Karakter</p>\r\n', 1, 0, 'https://tnial.dianglobal-tech.net/assets/materi/video/03-06-2020-1591119477-video.mp4', 'assets/materi/video/03-06-2020-1591119477-video.mp4', 1, '03-06-2020-1591122958-fsf.pdf', '03-06-2020-1591122012-Pertemuan_4_-_Array.pptx', 0, 1, 0),
(9, 55, 1, 'BAB 1', '<p>dwafwafwa dwdww</p>\r\n', 1, 0, '1YOuDS78fD5jo2T9cbWBH4PAWWpX46ZVW', '1YOuDS78fD5jo2T9cbWBH4PAWWpX46ZVW', 0, NULL, NULL, 1, 1, 0),
(11, 55, 1, 'BAB 2', '<p>INI KONTEN UJIAN</p>\r\n', 1, 0, 'dwadwajhdkjawkd', 'dwadwajhdkjawkd', 0, NULL, NULL, 1, 1, 0),
(12, 55, 1, 'BAB 3', '<p>bab 3</p>\r\n', 1, 0, '', '', 0, NULL, NULL, 1, 0, 0),
(13, 71, 49, 'BAB 1 Teori Geosfer', '<p>Menjelaskan tentang teori geosfer</p>\r\n', 1, 0, 'http://192.168.1.5/tnial/assets/materi/video/15-06-2020-1592187500-geosfer.mp4', 'assets/materi/video/15-06-2020-1592187500-geosfer.mp4', 1, '15-06-2020-1592187672-teorigeosfer.pdf', NULL, 1, 1, 0),
(14, 70, 46, 'BAB 1 Materi Dasar Biologi', '<p>Menjelaskan tentang konsep dasar biologi agar mudah dipahami</p>\r\n', 1, 0, 'http://192.168.1.5/tnial/assets/materi/video/15-06-2020-1592188784-KONSEP_DASAR_BIOLOGI_(Multiseluler,_Uniseluler,_Prokariotik,_Eukariotik,_Autotrof,_Heterotrof).mp4', 'assets/materi/video/15-06-2020-1592188784-KONSEP_DASAR_BIOLOGI_(Multiseluler,_Uniseluler,_Prokariotik,_Eukariotik,_Autotrof,_Heterotrof).mp4', 1, '15-06-2020-1592188812-RINGKASAN_MATERI_BIOLOGI_DASAR.pdf', NULL, 1, 1, 0),
(16, 77, 53, 'Integral', '<p>-</p>\r\n', 1, 0, '', '', 0, '26-06-2020-1593164571-DAFTAR-ANALISA-SOAL_Bahasa_Indonesia_SMAn_21.pdf', NULL, 0, 1, 0),
(17, 59, 1, 'Belajar Piskologi 1', '<p>Psikologi 1</p>\n', 1, 0, 'https://elearning.dianglobal-tech.net/assets/materi/video/27-06-2020-1593214409-demo-covid19app.mp4', 'assets/materi/video/27-06-2020-1593214409-demo-covid19app.mp4', 1, NULL, NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_siswa`
--

CREATE TABLE `m_siswa` (
  `id` int(6) NOT NULL,
  `photo` text DEFAULT NULL,
  `kelompok` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `nrp` varchar(50) NOT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` varchar(100) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `tahun_angkatan_masuk` varchar(10) DEFAULT NULL,
  `angkatan` varchar(10) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_jurusan` bigint(20) DEFAULT NULL,
  `instansi` int(20) NOT NULL,
  `pembuatan_akun` varchar(100) NOT NULL,
  `verifikasi` varchar(150) NOT NULL,
  `active_num` int(10) NOT NULL DEFAULT 0,
  `active_video` int(10) NOT NULL DEFAULT 0,
  `active_read` int(10) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_graduated` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_siswa`
--

INSERT INTO `m_siswa` (`id`, `photo`, `kelompok`, `nama`, `username`, `pangkat`, `nrp`, `no_telpon`, `tempat_lahir`, `tanggal_lahir`, `nim`, `tahun_angkatan_masuk`, `angkatan`, `nik`, `email`, `alamat`, `id_jurusan`, `instansi`, `pembuatan_akun`, `verifikasi`, `active_num`, `active_video`, `active_read`, `deleted`, `is_graduated`) VALUES
(526, NULL, 'AL', 'Aji Rohimat', 'rohimat', '-', '23452345', '087634285', 'Bandung', '1997-10-01', '78678578', '2020', '2020', '456456', 'rezharanmark@gmail.com', 'Bandung', 4, 1, '1591803694', '7fcc56e19c066f37edb5e04d6a9a4bf7', 171, 5, 2, 0, 1),
(529, NULL, 'AL', 'JANG KI YONG', 'JKYCAKEP', 'INTEL', '3570256987', '08571287456', 'KOREA', '1987-02-11', '6729462819936', NULL, '', '2748273894727485', 'kiyongkiyut@yahoo.com', 'endon', NULL, 2, '1586108703', '231586b344c2084b63466980d909b528', 3, 0, 0, 0, 1),
(531, NULL, 'XII TKJ 3', 'Ridwan', 'ridwan', 'Siswa', '1600123', '099', 'Bandung', '2002-01-01', '08', NULL, '', '01', 'ridwan@gmail.com', 'Bandung', NULL, 3, '1587385185', '6b1ae604c8fc82684ee2339f19b3482e', 0, 0, 0, 0, 0),
(532, NULL, 'MIPA', 'Kamil', 'kamil', 'Mahasiswa', '081', '081', 'Bandung', '2000-01-01', '08', NULL, '', '0812', 'kamil@gmal.com', 'Bandung', NULL, 4, '1587385241', '31e9282d73542f85716ac3e52da9ee28', 1, 0, 0, 0, 0),
(536, '01-06-2020-1591013958-visa.png', 'Dikreegg22', 'Saepudin', 'saepudin', 'gak tau', '87126318276', '08276482763', 'Bandung', '2020-05-31', '35467890', '2020', '', '5467890-', 'sapeudinnn@gmail.com', 'Bandunggg', 6, 1, '1591013958', '8cf562e20b50599cc0bffb6434c7ec1d', 1, 0, 0, 0, 0),
(537, NULL, 'Dikregss', 'Asep', 'asep', '-', '45321', '5345', 'Bdg', '1992-06-22', '6453245', '2020', '', '34564356', 'asep@yahoo.com', 'Banudng', 6, 1, '1591014386', 'a4ccdc2bb450febf7c22c2b1dd293581', 0, 0, 0, 0, 0),
(538, NULL, 'Dikregss', 'Asup', 'asup', '-', '45623', '8736458', 'Bgd', '1993-06-22', '345345', '2020', '', '435643', 'asup@iconn.com', 'bandu', 6, 1, '1591014386', 'a4ccdc2bb450febf7c22c2b1dd293581', 0, 0, 0, 1, 0),
(539, NULL, 'Dikregss', 'Asap', 'asap', '-', '645', '3453', 'Bdg', '1994-06-22', '345345', '2020', '', '465435', 'asap@gmail.com', 'Bali', 6, 1, '1591014386', 'a4ccdc2bb450febf7c22c2b1dd293581', 0, 0, 0, 1, 0),
(541, NULL, 'bunga', 'melati putih', 'melmela', 'smartgals', '0875490', '08127893457', 'denpasar', '1993-05-30', '83651869', '2018', '', '0876123409872367', 'melmela3093@gmail.com', 'bdg ajah', 4, 1, '1591117390', 'd56faef47f7fee21dbbc1b41d37d0c97', 14, 3, 1, 0, 0),
(543, NULL, '-', 'Deni Febriyanto', 'febri', '-', '19452/P', '0828182918291', 'Bandung', '2020-06-04', '78678578', '2020', '', '456456', 'aldilla@tnial.mil.id', '-', 9, 1, '1591156731', 'd604a942d47c44a9f7a1532e2895bdaf', 1, 0, 0, 0, 0),
(544, NULL, 'Jambu', 'Jazai', 'jazai', 'King Of Energen', '123456', '089627352261', 'Mars', '2009-02-22', '1293891', '1879', '', '182932983', 'jazai@mars.ilegal', 'Venus', 6, 1, '1591164300', 'f75d4a036ded86f95702d7e8ae4a0dcc', 8, 0, 0, 0, 0),
(545, NULL, 'Testing', 'Testing 123', 'siswatesting123', 'Siswa', '123', '821', 'Bandung', '2000-05-05', '123', '2020', '', '123', 'siswatesting123@gmail.com', 'Bandung', 4, 1, '1591197103', '0f3a664cfa8f682853e4b1bb202fcfa2', 0, 0, 0, 0, 0),
(546, NULL, 'Testing', 'Testing 456', 'siswatesting456', 'Siswa', '456', '812', 'Jakarta', '2000-05-05', '456', '2020', '', '456', 'siswatesting456@gmail.com', 'Jakarta', 4, 1, '1591197103', '0f3a664cfa8f682853e4b1bb202fcfa2', 0, 0, 0, 0, 0),
(547, NULL, 'Testing', 'Testing 789', 'siswatesting789', 'Siswa', '789', '20801', 'Semarang', '2000-05-05', '789', '2020', '', '789', 'siswatesting789@gmail.com', 'Semarang', 4, 1, '1591197103', '0f3a664cfa8f682853e4b1bb202fcfa2', 0, 0, 0, 0, 0),
(549, NULL, 'Jambu', 'The Roast', 'theroast', 'Mayjen', '2183', '08129381', 'Make make', '2020-06-06', '23142134', '1970', '1970', '3242543242', 'theroast@makemake.planet', 'Orbit', 9, 1, '1591517320', '41b76365ce10bb6ce9bcaa8590de7fd6', 0, 0, 0, 0, 0),
(550, NULL, 'XI IPS 1', 'Siswa 41', 'siswa41', '123434', '2020041', '09876543', 'Bandung', '2020-06-04', '1233413', '2020', '-', '123123123', 'siswa41@gmail.com', 'Bandung', 11, 10, '1592187219', '5671b4aab9a576afec32e615631e9674', 7, 0, 0, 0, 1),
(551, NULL, 'XI IPA 1', 'Siswa 42', 'siswa42', '2341234', '1231231', '0884234', 'Bandung', '2020-06-14', '12324123', '2020', '2020', '234234234', 'siswa42@gmail.com', 'Bandung', 10, 10, '1592187580', '6a00676913d908ea1e31aad26e4989a1', 5, 0, 1, 0, 0),
(553, NULL, 'XI IPA 1', 'Siswa 43', 'siswa43', '98798', '987987', '0863816', 'Bandung', '2020-06-09', '342342', '2020', '2020', '345345', 'siswa43@gmail.com', 'Bandung', 10, 10, '1592188204', 'cc72369b6d52d5f9ed057f515ca562c6', 0, 0, 0, 0, 0),
(554, NULL, 'XI IPS 1', 'Siswa 44', 'siswa44', '876876', '876865987', '0276382', 'Bandung', '2020-06-10', '13124234', '2020', '2020', '23423423', 'siswa44@gmail.com', 'Bandung', 11, 10, '1592188251', '6412cba474f7513591c0a69a28d14e16', 0, 0, 0, 0, 0),
(555, NULL, 'X IPA', 'ADITYA', 'adityasman21bdg', 'ISLAM', '1231231001', '8213130001', 'BANDUNG', '2006-01-01', '8213130001', '2020', '', 'L', 'adityasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 1, 1),
(556, NULL, 'X IPA', 'AJI', 'ajisman21bdg', 'ISLAM', '1231231002', '8213130002', 'BANDUNG', '2006-01-01', '8213130002', '2020', '', 'L', 'ajisman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 6, 0, 0, 0, 1),
(557, NULL, 'X IPA', 'ANINDA', 'anindasman21bdg', 'ISLAM', '1231231003', '8213130003', 'BANDUNG', '2006-01-01', '8213130003', '2020', '', 'P', 'anindasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(558, NULL, 'X IPA', 'ANNISA', 'annisasman21bdg', 'ISLAM', '1231231004', '8213130004', 'BANDUNG', '2006-01-01', '8213130004', '2020', '', 'P', 'annisasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(559, NULL, 'XI IPA', 'BAYU', 'bayusman21bdg', 'ISLAM', '1231231005', '8213130005', 'BANDUNG', '2005-01-01', '8213130005', '2020', '', 'L', 'bayusman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(560, NULL, 'XI IPA', 'BADRUN', 'badrunsman21bdg', 'ISLAM', '1231231006', '8213130006', 'BANDUNG', '2005-01-01', '8213130006', '2020', '', 'L', 'badrunsman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(561, NULL, 'XI IPA', 'BILQIS', 'bilqissman21bdg', 'ISLAM', '1231231007', '8213130007', 'BANDUNG', '2005-01-01', '8213130007', '2020', '', 'P', 'bilqissman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(562, NULL, 'XI IPA', 'BUNGA', 'bungasman21bdg', 'ISLAM', '1231231008', '8213130008', 'BANDUNG', '2005-01-01', '8213130008', '2020', '', 'P', 'bungasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(563, NULL, 'XII IPA', 'CACA', 'cacasman21bdg', 'ISLAM', '1231231009', '8213130009', 'BANDUNG', '2004-01-01', '8213130009', '2020', '', 'P', 'cacasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(564, NULL, 'XII IPA', 'CHIKA', 'chikasman21bdg', 'ISLAM', '1231231010', '8213130010', 'BANDUNG', '2004-01-01', '8213130010', '2020', '', 'P', 'chikasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(565, NULL, 'XII IPA', 'COKY', 'cokysman21bdg', 'ISLAM', '1231231011', '8213130011', 'BANDUNG', '2004-01-01', '8213130011', '2020', '', 'L', 'cokysman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(566, NULL, 'XII IPA', 'CAKA', 'cakasman21bdg', 'ISLAM', '1231231012', '8213130012', 'BANDUNG', '2004-01-01', '8213130012', '2020', '', 'L', 'cakasman21bdg@gmail.com', 'BANDUNG', 12, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(567, NULL, 'X IPS', 'DEDE', 'dedesman21bdg', 'ISLAM', '1231231013', '8213130013', 'BANDUNG', '2006-01-01', '8213130013', '2020', '', 'L', 'dedesman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(568, NULL, 'X IPS', 'DEDEN', 'dedensman21bdg', 'ISLAM', '1231231014', '8213130014', 'BANDUNG', '2006-01-01', '8213130014', '2020', '', 'L', 'dedensman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 4, 0, 0, 0, 0),
(569, NULL, 'X IPS', 'DELVY', 'delvysman21bdg', 'ISLAM', '1231231015', '8213130015', 'BANDUNG', '2006-01-01', '8213130015', '2020', '', 'P', 'delvysman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(570, NULL, 'X IPS', 'DESI', 'desisman21bdg', 'ISLAM', '1231231016', '8213130016', 'BANDUNG', '2006-01-01', '8213130016', '2020', '', 'P', 'desisman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(571, NULL, 'XI IPS', 'GIFAR', 'gifarsman21bdg', 'ISLAM', '1231231017', '8213130017', 'BANDUNG', '2005-01-01', '8213130017', '2020', '', 'L', 'gifarsman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(572, NULL, 'XI IPS', 'GEO', 'geosman21bdg', 'ISLAM', '1231231018', '8213130018', 'BANDUNG', '2005-01-01', '8213130018', '2020', '', 'L', 'geosman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(573, NULL, 'XI IPS', 'GHEA', 'gheasman21bdg', 'ISLAM', '1231231019', '8213130019', 'BANDUNG', '2005-01-01', '8213130019', '2020', '', 'P', 'gheasman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(574, NULL, 'XI IPS', 'GIOVANNI', 'giovannisman21bdg', 'ISLAM', '1231231020', '8213130020', 'BANDUNG', '2005-01-01', '8213130020', '2020', '', 'P', 'giovannisman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(575, NULL, 'XII IPS', 'HAIKAL', 'haikalsman21bdg', 'ISLAM', '1231231021', '8213130021', 'BANDUNG', '2004-01-01', '8213130021', '2020', '', 'L', 'haikalsman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(576, NULL, 'XII IPS', 'HUSNI', 'husnisman21bdg', 'ISLAM', '1231231022', '8213130022', 'BANDUNG', '2004-01-01', '8213130022', '2020', '', 'L', 'husnisman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(577, NULL, 'XII IPS', 'IIS', 'iissman21bdg', 'ISLAM', '1231231023', '8213130023', 'BANDUNG', '2004-01-01', '8213130023', '2020', '', 'P', 'iissman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(578, NULL, 'XII IPS', 'IMAS', 'imassman21bdg', 'ISLAM', '1231231024', '8213130024', 'BANDUNG', '2004-01-01', '8213130024', '2020', '', 'P', 'imassman21bdg@gmail.com', 'BANDUNG', 13, 11, '1593143026', '459913c854639fe67e5cb74b8cace402', 0, 0, 0, 0, 0),
(579, NULL, 'X IPA', 'ADITYA', 'adityasman25bdg', 'ISLAM', '1231231001', '8213130001', 'BANDUNG', '2006-01-01', '8213130001', '2020', '', 'L', 'adityasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(580, NULL, 'X IPA', 'AJI', 'ajisman25bdg', 'ISLAM', '1231231002', '8213130002', 'BANDUNG', '2006-01-01', '8213130002', '2020', '', 'L', 'ajisman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(581, NULL, 'X IPA', 'ANINDA', 'anindasman25bdg', 'ISLAM', '1231231003', '8213130003', 'BANDUNG', '2006-01-01', '8213130003', '2020', '', 'P', 'anindasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(582, NULL, 'X IPA', 'ANNISA', 'annisasman25bdg', 'ISLAM', '1231231004', '8213130004', 'BANDUNG', '2006-01-01', '8213130004', '2020', '', 'P', 'annisasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(583, NULL, 'XI IPA', 'BAYU', 'bayusman25bdg', 'ISLAM', '1231231005', '8213130005', 'BANDUNG', '2005-01-01', '8213130005', '2020', '', 'L', 'bayusman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(584, NULL, 'XI IPA', 'BADRUN', 'badrunsman25bdg', 'ISLAM', '1231231006', '8213130006', 'BANDUNG', '2005-01-01', '8213130006', '2020', '', 'L', 'badrunsman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(585, NULL, 'XI IPA', 'BILQIS', 'bilqissman25bdg', 'ISLAM', '1231231007', '8213130007', 'BANDUNG', '2005-01-01', '8213130007', '2020', '', 'P', 'bilqissman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(586, NULL, 'XI IPA', 'BUNGA', 'bungasman25bdg', 'ISLAM', '1231231008', '8213130008', 'BANDUNG', '2005-01-01', '8213130008', '2020', '', 'P', 'bungasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(587, NULL, 'XII IPA', 'CACA', 'cacasman25bdg', 'ISLAM', '1231231009', '8213130009', 'BANDUNG', '2004-01-01', '8213130009', '2020', '', 'P', 'cacasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(588, NULL, 'XII IPA', 'CHIKA', 'chikasman25bdg', 'ISLAM', '1231231010', '8213130010', 'BANDUNG', '2004-01-01', '8213130010', '2020', '', 'P', 'chikasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(589, NULL, 'XII IPA', 'COKY', 'cokysman25bdg', 'ISLAM', '1231231011', '8213130011', 'BANDUNG', '2004-01-01', '8213130011', '2020', '', 'L', 'cokysman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(590, NULL, 'XII IPA', 'CAKA', 'cakasman25bdg', 'ISLAM', '1231231012', '8213130012', 'BANDUNG', '2004-01-01', '8213130012', '2020', '', 'L', 'cakasman25bdg@gmail.com', 'BANDUNG', 17, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(591, NULL, 'X IPS', 'DEDE', 'dedesman25bdg', 'ISLAM', '1231231013', '8213130013', 'BANDUNG', '2006-01-01', '8213130013', '2020', '', 'L', 'dedesman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(592, NULL, 'X IPS', 'DEDEN', 'dedensman25bdg', 'ISLAM', '1231231014', '8213130014', 'BANDUNG', '2006-01-01', '8213130014', '2020', '', 'L', 'dedensman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(593, NULL, 'X IPS', 'DELVY', 'delvysman25bdg', 'ISLAM', '1231231015', '8213130015', 'BANDUNG', '2006-01-01', '8213130015', '2020', '', 'P', 'delvysman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(594, NULL, 'X IPS', 'DESI', 'desisman25bdg', 'ISLAM', '1231231016', '8213130016', 'BANDUNG', '2006-01-01', '8213130016', '2020', '', 'P', 'desisman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(595, NULL, 'XI IPS', 'GIFAR', 'gifarsman25bdg', 'ISLAM', '1231231017', '8213130017', 'BANDUNG', '2005-01-01', '8213130017', '2020', '', 'L', 'gifarsman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(596, NULL, 'XI IPS', 'GEO', 'geosman25bdg', 'ISLAM', '1231231018', '8213130018', 'BANDUNG', '2005-01-01', '8213130018', '2020', '', 'L', 'geosman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(597, NULL, 'XI IPS', 'GHEA', 'gheasman25bdg', 'ISLAM', '1231231019', '8213130019', 'BANDUNG', '2005-01-01', '8213130019', '2020', '', 'P', 'gheasman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(598, NULL, 'XI IPS', 'GIOVANNI', 'giovannisman25bdg', 'ISLAM', '1231231020', '8213130020', 'BANDUNG', '2005-01-01', '8213130020', '2020', '', 'P', 'giovannisman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(599, NULL, 'XII IPS', 'HAIKAL', 'haikalsman25bdg', 'ISLAM', '1231231021', '8213130021', 'BANDUNG', '2004-01-01', '8213130021', '2020', '', 'L', 'haikalsman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(600, NULL, 'XII IPS', 'HUSNI', 'husnisman25bdg', 'ISLAM', '1231231022', '8213130022', 'BANDUNG', '2004-01-01', '8213130022', '2020', '', 'L', 'husnisman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(601, NULL, 'XII IPS', 'IIS', 'iissman25bdg', 'ISLAM', '1231231023', '8213130023', 'BANDUNG', '2004-01-01', '8213130023', '2020', '', 'P', 'iissman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(602, NULL, 'XII IPS', 'IMAS', 'imassman25bdg', 'ISLAM', '1231231024', '8213130024', 'BANDUNG', '2004-01-01', '8213130024', '2020', '', 'P', 'imassman25bdg@gmail.com', 'BANDUNG', 18, 12, '1593152580', 'd39520319d8124cebfd74680723b548b', 0, 0, 0, 0, 0),
(603, NULL, 'Jambu', 'Bara Bursa', 'barabursa', 'Islam', '213198', '08531231234214', 'Sumedang', '2000-02-22', '12839139281', '2020', '2020', 'Laki', 'barabursa@gmial.com', 'Bandung', 7, 1, '1593213833', '54ad8eb1e0fc56dfe11119b1b2a3a793', 4, 0, 0, 0, 1);

--
-- Triggers `m_siswa`
--
DELIMITER $$
CREATE TRIGGER `hapus_siswa` AFTER DELETE ON `m_siswa` FOR EACH ROW BEGIN
DELETE FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_user = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_soal`
--

CREATE TABLE `m_soal` (
  `id` int(6) NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL,
  `bobot` int(2) NOT NULL,
  `file` varchar(150) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `opsi_e` longtext NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp(),
  `jml_benar` int(6) NOT NULL,
  `jml_salah` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `m_soal_penilaian`
--

CREATE TABLE `m_soal_penilaian` (
  `id` int(6) NOT NULL,
  `id_paket` bigint(20) DEFAULT NULL,
  `id_dimensi` int(11) NOT NULL,
  `bobot` decimal(10,8) NOT NULL,
  `file` varchar(150) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `opsi_e` longtext NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp(),
  `jml_benar` int(6) NOT NULL,
  `jml_salah` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_soal_penilaian`
--

INSERT INTO `m_soal_penilaian` (`id`, `id_paket`, `id_dimensi`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `jawaban`, `tgl_input`, `jml_benar`, `jml_salah`) VALUES
(11, 2, 8, 0.50000000, '', '', '<p>Soal 1</p>\r\n', '#####<p>100</p>\r\n', '#####<p>80</p>\r\n', '#####<p>60</p>\r\n', '#####<p>40</p>\r\n', '#####<p>20</p>\r\n', 'A', '2020-06-02 21:08:54', 0, 0),
(12, 2, 8, 0.50000000, '', '', '<p>Soal 2</p>\r\n', '#####<p>fghjk</p>\r\n', '#####<p>ghjk</p>\r\n', '#####<p>hjk</p>\r\n', '#####<p>gjhk</p>\r\n', '#####<p>ghjk</p>\r\n', 'A', '2020-06-03 00:54:50', 0, 0),
(13, 2, 9, 0.50000000, '', '', '<p>Soal 3</p>\r\n', '#####<p>a</p>\r\n', '#####<p>b</p>\r\n', '#####<p>c</p>\r\n', '#####<p>d</p>\r\n', '#####<p>e</p>\r\n', 'A', '2020-06-03 01:32:02', 0, 0),
(14, 2, 9, 0.50000000, '', '', '<p>Soal 4</p>\r\n', '#####<p>baik</p>\r\n', '#####<p>cukup</p>\r\n', '#####<p>baik sekali</p>\r\n', '#####<p>kurang</p>\r\n', '#####<p>kurang sekali</p>\r\n', 'A', '2020-06-03 07:50:46', 0, 0),
(15, 2, 10, 0.50000000, '', '', '<p>Soal 5</p>\r\n', '#####<p>a</p>\r\n', '#####<p>c</p>\r\n', '#####<p>a</p>\r\n', '#####<p>w</p>\r\n', '#####<p>escs</p>\r\n', 'A', '2020-06-03 07:51:11', 0, 0),
(16, 2, 10, 0.50000000, '', '', '<p>Soal 6</p>\r\n', '#####', '#####', '#####', '#####', '#####', 'A', '2020-06-03 11:05:19', 0, 0),
(17, 2, 11, 0.50000000, '', '', '<p>Soal 7</p>\r\n', '#####<p>70 Tahun</p>\r\n', '#####<p>50 Tahun</p>\r\n', '#####<p>40 Tahun</p>\r\n', '#####<p>1 tahun</p>\r\n', '#####<p>Belum lahir</p>\r\n', 'A', '2020-06-03 22:52:29', 0, 0),
(18, 2, 11, 0.50000000, '', '', '<p>Soal 8</p>\r\n', '#####<p>1</p>\r\n', '#####<p>2</p>\r\n', '#####<p>3</p>\r\n', '#####<p>4</p>\r\n', '#####<p>5</p>\r\n', 'A', '2020-06-04 05:12:46', 0, 0),
(19, 2, 12, 1.00000000, '', '', '<p>Soal 9</p>\r\n', '#####<p>Jakarata</p>\r\n', '#####<p>Batavia</p>\r\n', '#####<p>Djakarta</p>\r\n', '#####<p>Jakarta</p>\r\n', '#####<p>Semua Salah</p>\r\n', 'A', '2020-06-04 22:48:38', 0, 0),
(21, 3, 0, 1.00000000, '', '', '<p>Apakah dosen menyampaikan materi perkuliahan sudah menggunakan rujukan akademik yang jelas ?</p>\r\n', '#####<p>Sesuai daftar referensi di dalam RPS/Modul/Paket Instruksi dan ada tambahan buku lain.</p>\r\n', '#####<p>Sesuai daftar referensi di dalam RPS/Modul/Paket Instruksi.</p>\r\n', '#####<p>Ada dan relevan meskipun tidak sesuai daftar referensi di dalam RPS/Modul/Paket Instruksi.</p>\r\n', '#####<p>Ada sebagian tapi kurang relevan</p>\r\n', '#####<p>Tidak ada dan tidak merujuk.</p>\r\n', 'A', '2020-06-11 04:35:31', 0, 0),
(22, 3, 0, 1.00000000, '', '', '<p>Bagaimana dosen menyampaikan materi perkuliahan menggunakan slide paparan ?</p>\r\n', '#####<p>Menarik, jelas dan ditambah cuplikan film.</p>\r\n', '#####<p>Menarik dan jelas.</p>\r\n', '#####<p>Menarik tapi kurang jelas.</p>\r\n', '#####<p>Tidak menarik dan tidak jelas.</p>\r\n', '#####<p>Tanpa slide.</p>\r\n', 'A', '2020-06-11 04:37:39', 0, 0),
(23, 3, 0, 1.00000000, '', '', '<p>Bagaimana kemampuan dosen menyampaikan materi perkuliahan ?</p>\r\n', '#####<p>Menarik, sistematis dan menguasai materi.</p>\r\n', '#####<p>Menarik dan jelas.</p>\r\n', '#####<p>Menarik tapi tidak jelas.</p>\r\n', '#####<p>Tidak menarik dan tidak jelas.</p>\r\n', '#####<p>Seadanya.</p>\r\n', 'A', '2020-06-11 04:39:17', 0, 0),
(24, 3, 0, 1.00000000, '', '', '<p>Apakah dosen memberikan aplikasi ilmu dengan kehidupan nyata atau medan penugasan sepanjang perkuliahan berlangsung ?</p>\r\n', '#####<p>Mengkaitkan dengan situasi dan kondisi nyata kedinasan yang dihadapi secara tepat.</p>\r\n', '#####<p>Membahas sesuai permasalahan yang kontekstual.</p>\r\n', '#####<p>Memberi contoh aplikasi tapi kurang relevan.</p>\r\n', '#####<p>Sesekali memberi contoh aplikasi.</p>\r\n', '#####<p>Tidak memberi contoh sama sekali.</p>\r\n', 'A', '2020-06-11 04:41:01', 0, 0),
(25, 3, 0, 1.00000000, '', '', '<p>Apakah dosen memberikan inspirasi baru atau ide-ide penelitian untuk menyusun tesis atau Taskap ?</p>\r\n', '#####<p>Membuka wawasan pengetahuan baru.</p>\r\n', '#####<p>Memberi perspektif dan cara pandang baru.</p>\r\n', '#####<p>Memberi paradigma atau topik penelitian.</p>\r\n', '#####<p>Kurang inspiratif.</p>\r\n', '#####<p>Tidak memberi inspirasi.</p>\r\n', 'A', '2020-06-11 04:44:09', 0, 0),
(26, 3, 0, 1.00000000, '', '', '<p>Bagaimana kemampuan dosen meningkatkan gairah belajar Perwira Mahasiswa/Perwira Siswa dan suasana akademis ?</p>\r\n', '#####<p>Menjadi lebih rajin pinjam buku perpustakaan.</p>\r\n', '#####<p>Lebih sering berdiskusi dengan temannya.</p>\r\n', '#####<p>Lebih rajin mencari materi tambahan.</p>\r\n', '#####<p>Tidak terjadi perubahan.</p>\r\n', '#####<p>Gairah belajar malah menurun.</p>\r\n', 'A', '2020-06-11 05:04:02', 0, 0),
(27, 3, 0, 1.00000000, '', '', '<p>Bagaimana kemampuan dosen meningkatkan rasa keingintahuan akademis Perwira Mahasiswa/Perwira Siswa ?</p>\r\n', '#####<p>Menjadi sering menghadiri ujian proposal atau ujian tesis rekannya.</p>\r\n', '#####<p>Mencari teori-teori dan konsep-konsep baru dari buku atau jurnal.</p>\r\n', '#####<p>Membaca tesis-tesis angkatan sebelumnya.</p>\r\n', '#####<p>Tidak terjadi perubahan.</p>\r\n', '#####<p>Keingintahuan malah berkurang.</p>\r\n', 'A', '2020-06-11 05:04:58', 0, 0),
(28, 3, 0, 1.00000000, '', '', '<p>Bagaimana kemampuan dosen meningkatkan kebanggaan sebagai Peserta Didik Seskoal ?</p>\r\n', '#####<p>Meningkatkan rasa nasionalisme dan patriotisme.</p>\r\n', '#####<p>Tumbuh semangat bela negara.</p>\r\n', '#####<p>Aktif di kelas dan senat.</p>\r\n', '#####<p>Tidak terjadi perubahan perilaku.</p>\r\n', '#####<p>Kebanggaan malah menurun.</p>\r\n', 'A', '2020-06-11 05:05:52', 0, 0),
(29, 3, 0, 1.00000000, '', '', '<p>Bagaimana kemampuan dosen meningkatkan prestasi akademik ?</p>\r\n', '#####<p>Lebih aktif menulis artikel ilmiah untuk jurnal nasional terakreditasi atau jurnal internasional bereputasi.</p>\r\n', '#####<p>Aktif mengikuti lomba-lomba penulisan artikel ilmiah atau call of paper.</p>\r\n', '#####<p>Aktif menghadiri seminar.</p>\r\n', '#####<p>Tidak terjadi perubahan prestasi.</p>\r\n', '#####<p>Prestasi malah menurun.</p>\r\n', 'A', '2020-06-11 05:07:07', 0, 0),
(30, 3, 0, 1.00000000, '', '', '<p>Bagaimana dosen menggunakan alokasi waktu sesuai jadwal perkuliahan ?</p>\r\n', '#####<p>Tepat sesuai jadwal dan memberikan diskusi/tanya-jawab.</p>\r\n', '#####<p>Relatif masih sesuai jadwal.</p>\r\n', '#####<p>Terlambat dari jadwal.</p>\r\n', '#####<p>Tidak sesuai jadwal.</p>\r\n', '#####<p>Ada perubahan waktu tanpa ada pemberitahuan.</p>\r\n', 'A', '2020-06-11 05:08:02', 0, 0),
(31, 3, 0, 1.00000000, '', '', '<p>Bagaimana dosen menggunakan bahasa pengantar selama perkuliahan ?</p>\r\n', '#####<p>Kombinasi bahasa Indonesia dan bahasa Inggris.</p>\r\n', '#####<p>Kombinasi bahasa Indonesia dengan sedikit terminologi bahasa Inggris.</p>\r\n', '#####<p>Hanya bahasa Indonesia baku.</p>\r\n', '#####<p>Bahasa Indonesia tidak baku.</p>\r\n', '#####<p>Artikulasi tidak jelas.</p>\r\n', 'A', '2020-06-11 05:09:06', 0, 0),
(32, 3, 0, 1.00000000, '', '', '<p>Bagaimana interaksi sosial dosen selama perkuliahan dan/atau di luar perkuliahan ?</p>\r\n', '#####<p>Ramah dan bersemangat.</p>\r\n', '#####<p>Ramah dan humoris.</p>\r\n', '#####<p>Ramah tapi kurang bersemangat.</p>\r\n', '#####<p>Kurang ramah.</p>\r\n', '#####<p>Tidak bersemangat.</p>\r\n', 'A', '2020-06-11 05:09:59', 0, 0),
(33, 3, 0, 1.00000000, '', '', '<p>Bagaimana mutu tugas dan kuis yang diberikan dosen ?</p>\r\n', '#####<p>Relevan dengan materi kuliah menjawab pertanyaan.</p>\r\n', '#####<p>Memacu pemahaman atas materi kuliah.</p>\r\n', '#####<p>Kontekstual materi kuliah.</p>\r\n', '#####<p>Kurang relevan dengan materi kuliah.</p>\r\n', '#####<p>Tidak memberi tugas atau kuis.</p>\r\n', 'A', '2020-06-11 05:12:16', 0, 0),
(34, 3, 0, 1.00000000, '', '', '<p>Bagaimana mutu UAS dan UTS yang diberikan dosen ?</p>\r\n', '#####<p>Relevan dengan pemecahan masalah.</p>\r\n', '#####<p>Relevan dengan materi kuliah.</p>\r\n', '#####<p>Relevan dengan tugas dan kuis.</p>\r\n', '#####<p>Kurang relevan dengan materi kuliah.</p>\r\n', '#####<p>Tidak relevan dengan materi kuliah.</p>\r\n', 'A', '2020-06-11 05:13:43', 0, 0),
(35, 3, 0, 1.00000000, '', '', '<p>Bagaimana personifikasi dosen ?</p>\r\n', '#####<p>Rapi berpakaian sesuai ketentuan seragam yang berlaku.</p>\r\n', '#####<p>Rapi berpakaian tidak sesuai ketentuan.</p>\r\n', '#####<p>Rapi berpakaian tapi tidak gunakan atribut.</p>\r\n', '#####<p>Busana kurang sesuai dengan kombinasi warna.</p>\r\n', '#####<p>Melanggar ketentuan seragam.</p>\r\n', 'A', '2020-06-11 05:16:15', 0, 0),
(36, 3, 0, 1.00000000, '', '', '<p>Sejauh mana peran dosen mendampingi praktek kuliah di luar Seskoal, KKDN dan KKLN ?</p>\r\n', '#####<p>Aktif dan menguasai materi objek yang dikunjungi.</p>\r\n', '#####<p>Aktif tapi kurang menguasai materi.</p>\r\n', '#####<p>Memang tidak ikut KKDN dan KKLN.</p>\r\n', '#####<p>Kurang aktif membimbing.</p>\r\n', '#####<p>Tidak menguasai materi.</p>\r\n', 'A', '2020-06-11 05:17:13', 0, 0),
(37, 3, 0, 1.00000000, '', '', '<p>Bagaimana peran dosen dalam latihan Opsgab/Opsma dan latihan lainnya ?</p>\r\n', '#####<p>Aktif dan menguasai konteks latihan sesuai materi perkuliahan.</p>\r\n', '#####<p>Aktif tapi kurang memahami Buku I, Buku II A dan Buku II B.</p>\r\n', '#####<p>Memang tidak ikut latihan.</p>\r\n', '#####<p>Aktif tapi kurang memahami produk yang dihasilkan.</p>\r\n', '#####<p>Kurang aktif menjalankan peran yang ada.</p>\r\n', 'A', '2020-06-11 05:18:20', 0, 0),
(38, 3, 0, 1.00000000, '', '', '<p>Bagaimana peran dosen dalam aplikasi simulasi penyusunan produk-produk latihan/produk-produk kebijakan ?</p>\r\n', '#####<p>Aktif dan menguasai konteks aplikasi sesuai materi perkuliahan.</p>\r\n', '#####<p>Aktif tapi kurang memahami Rencana Garis Besar (RGB).</p>\r\n', '#####<p>Memang tidak ikut aplikasi.</p>\r\n', '#####<p>Aktif tapi kurang memahami produk yang dihasilkan.</p>\r\n', '#####<p>Kurang aktif menjalankan peran yang ada.</p>\r\n', 'A', '2020-06-11 05:20:43', 0, 0),
(39, 3, 0, 1.00000000, '', '', '<p>Bagaimana peran dosen dalam kegiatan forum strategi dan seminar/FGD/diskusi panel ?</p>\r\n', '#####<p>Aktif dan menguasai tahapan kegiatan sesuai materi perkuliahan.</p>\r\n', '#####<p>Aktif tapi kurang memahami Term Of References (TOR).</p>\r\n', '#####<p>Memang tidak ikut forum.</p>\r\n', '#####<p>Aktif tapi kurang memahami produk yang dihasilkan.</p>\r\n', '#####<p>Kurang aktif menjalankan peran yang ada.</p>\r\n', 'A', '2020-06-11 05:22:11', 0, 0),
(40, 3, 0, 1.00000000, '', '', '<p>Bagaimana peran dosen melaksanakan pembimbingan rangkaian Program Kegiatan Bersama (PKB) ?</p>\r\n', '#####<p>Aktif dan menguasai materi PKB sesuai tema dan/atau topik.</p>\r\n', '#####<p>Aktif tapi kurang memahami tujuan dan sasaran PKB.</p>\r\n', '#####<p>Memang tidak ikut PKB.</p>\r\n', '#####<p>Aktif tapi kurang memahami produk yang dihasilkan.</p>\r\n', '#####<p>Kurang aktif menjalankan peran yang ada.</p>\r\n', 'A', '2020-06-11 05:23:18', 0, 0),
(41, 4, 11, 0.50000000, '', '', '<p>Apakah Guru Aktif Mengajar</p>\r\n', '#####<p>Aktif Sekali</p>\r\n', '#####<p>Aktif</p>\r\n', '#####<p>kurang aktif</p>\r\n', '#####<p>tidak aktif</p>\r\n', '#####<p>sangat tidak aktif</p>\r\n', 'A', '2020-06-15 09:57:06', 0, 0),
(42, 4, 8, 0.50000000, '', '', '<p>Guru Sesuai menjelaskan kematerian?</p>\r\n', '#####<p>Sangat Jelas</p>\r\n', '#####<p>jelas</p>\r\n', '#####<p>cukup jelas</p>\r\n', '#####<p>kurang jelas</p>\r\n', '#####<p>sangat tidak jelas</p>\r\n', 'A', '2020-06-15 09:57:50', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_soal_ujian`
--

CREATE TABLE `m_soal_ujian` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) DEFAULT NULL,
  `bobot` int(2) NOT NULL,
  `file` varchar(150) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `opsi_e` longtext NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp(),
  `jml_benar` int(6) NOT NULL,
  `jml_salah` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_soal_ujian`
--

INSERT INTO `m_soal_ujian` (`id`, `id_ujian`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `jawaban`, `tgl_input`, `jml_benar`, `jml_salah`) VALUES
(1, 1, 1, '', '', '<p>dwa</p>\r\n', '#####<p>21</p>\r\n', '#####<p>2</p>\r\n', '#####<p>3</p>\r\n', '#####<p>4</p>\r\n', '', 'A', '2020-05-31 00:17:23', 1, 0),
(2, 3, 2, '', '', '<p>Apakah Benar?</p>\r\n', '#####<p>a</p>\r\n', '#####<p>b</p>\r\n', '#####<p>c</p>\r\n', '#####<p>d</p>\r\n', '', 'B', '2020-06-03 01:35:31', 1, 1),
(4, 1, 1, '', '', '<p>Nama Ibukota Zimbabwe?</p>\r\n', '#####<p>Jakarta</p>\r\n', '#####<p>Bandung</p>\r\n', '#####<p>Jawa Barat</p>\r\n', '#####<p>Salah Semua</p>\r\n', '', 'D', '2020-06-03 21:01:58', 0, 0),
(5, 3, 1, '', '', '<p>Apa Ibu Kota Provinsi Jawa Barat ?</p>\r\n', '#####<p>Bandung</p>\r\n', '#####<p>DKI Jakarta</p>\r\n', '#####<p>Surabaya</p>\r\n', '#####<p>Semarang</p>\r\n', '', 'A', '2020-06-04 03:48:17', 0, 2),
(6, 3, 10, '', '', '<p>Ibu Kota Indonesia adalah??</p>', '#####<p>Jakarta</p>', '#####<p>Kalimantan</p>', '#####<p>Bandung</p>', '#####<p>Palembang</p>', '', 'A', '0000-00-00 00:00:00', 0, 2),
(7, 3, 10, '', '', '<p>Apakah Nama resmi Virus Corona</p>', '#####<p>COVED</p>', '#####<p>CORON</p>', '#####<p>COVID-19</p>', '#####<p>COVID-20</p>', '', 'C', '0000-00-00 00:00:00', 1, 1),
(8, 4, 1, '', '', '<p>Ibukota Medan</p>\r\n', '#####<p>Ibunya Medan</p>\r\n', '#####<p>Bika Ambon</p>\r\n', '#####<p>Ngantuk cuy</p>\r\n', '#####<p>Benar semua</p>\r\n', '', 'C', '2020-06-14 20:39:35', 0, 0),
(9, 5, 50, '', '', '<p>Berapa Lapisan Langit di Bumi?</p>\r\n', '#####<p>3 Lapis</p>\r\n', '#####<p>7 Lapis</p>\r\n', '#####<p>2 Lapis</p>\r\n', '#####<p>8 Lapis</p>\r\n', '', 'B', '2020-06-15 09:42:19', 17, 0),
(10, 5, 50, '', '', '<p>Apa pengertian Geosfer?</p>\r\n', '#####<p>Suatu fenomena atau pun kejadian atau peristiwa yang sudah terjadi di permukaan bumi</p>\r\n', '#####<p>fenomena meluruhnya tanah</p>\r\n', '#####<p>Fenomena bergerak lempeng bumi</p>\r\n', '#####<p>Fenomena naiknya air laut</p>\r\n', '', 'A', '2020-06-15 09:43:42', 17, 0),
(11, 3, 1, '', '', '<p>wkwkwk</p>\r\n', '#####', '#####', '#####', '#####', '', '', '2020-06-21 14:29:23', 0, 2),
(12, 6, 20, '', '', '<p>1+1=</p>\r\n', '#####<p>2</p>\r\n', '#####<p>3</p>\r\n', '#####<p>5</p>\r\n', '#####<p>7</p>\r\n', '', 'A', '2020-06-26 16:58:47', 1, 0),
(13, 7, 1, '', '', '<p>Nama Ibukota Indonesia sekarang adalah&nbsp;...</p>\r\n', '#####<p>Jakarta</p>\r\n', '#####<p>Djakarta</p>\r\n', '#####<p>Batavia</p>\r\n', '#####<p>Betawi</p>\r\n', '', 'A', '2020-06-27 09:56:41', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_soal_ujian_essay`
--

CREATE TABLE `m_soal_ujian_essay` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) DEFAULT NULL,
  `bobot` int(2) NOT NULL,
  `file` varchar(150) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_soal_ujian_essay`
--

INSERT INTO `m_soal_ujian_essay` (`id`, `id_ujian`, `bobot`, `file`, `tipe_file`, `soal`, `tgl_input`) VALUES
(29, 3, 70, 'file_ujian_soal_essay_29.jpg', 'image/jpeg', '<p>Logo apa ini ?</p>\r\n', '2020-06-21 14:52:34'),
(30, 3, 30, '', '', '<p>arti dari &quot;How Are You&quot;</p>\r\n', '2020-06-21 15:44:49'),
(31, 6, 30, '', '', '<p>Ibu Kota Jawa Barat?</p>\r\n', '2020-06-26 16:59:19'),
(32, 7, 100, '', '', '<p>jelaskan bagaimana proses fotosintesis tumbuhan</p>\r\n', '2020-06-27 10:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `rule_users`
--

CREATE TABLE `rule_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `id_level` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `rule_users`
--

INSERT INTO `rule_users` (`id`, `id_menu`, `id_level`) VALUES
(1, 1, 1),
(2, 41, 1),
(3, 2, 1),
(7, 3, 1),
(13, 1, 2),
(24, 22, 1),
(27, 4, 1),
(34, 20, 1),
(35, 23, 3),
(38, 24, 1),
(39, 1, 4),
(40, 2, 4),
(41, 19, 4),
(42, 3, 4),
(43, 25, 2),
(45, 26, 3),
(46, 27, 3),
(47, 27, 2),
(48, 4, 4),
(51, 27, 4),
(52, 28, 4),
(53, 29, 4),
(117, 1, 5),
(118, 2, 5),
(119, 19, 5),
(120, 3, 5),
(121, 4, 5),
(124, 27, 5),
(125, 28, 5),
(126, 1, 3),
(127, 33, 4),
(128, 34, 3),
(129, 42, 1),
(130, 35, 4),
(131, 35, 5),
(132, 36, 2),
(133, 37, 4),
(136, 22, 4),
(137, 40, 2),
(142, 23, 2),
(147, 37, 3),
(148, 47, 4),
(150, 49, 3),
(151, 49, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `link` varchar(50) NOT NULL,
  `urutan` int(11) DEFAULT 0,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `id_menu`, `id_level`, `nama`, `link`, `urutan`, `icon`) VALUES
(2, 37, 4, 'Luaran Penilaian', 'penilaian/luaran', 3, 'fas fa-file mr-2'),
(3, 18, 4, 'Keaktifan Diskusi', 'rank', 0, 'far fa-comments mr-2'),
(4, 37, 4, 'Soal Penilaian', 'penilaian/paket_soal', 1, 'fas fa-file mr-2'),
(8, 47, 4, 'Aktivitas Guru', 'aktivitas/guru', 2, 'fas fa-walking mr-2'),
(9, 47, 4, 'Aktivitas Siswa', 'aktivitas', 1, 'fas fa-walking mr-2'),
(10, 2, 4, 'Riwayat Kelulusan', 'pengusaha/arsip_lulus', 2, 'fas fa-graduation-cap mr-2'),
(11, 2, 4, 'Nilai Siswa', 'rekaptulasi', 3, 'fas fa-check mr-2'),
(13, 2, 4, 'Siswa', 'pengusaha/data', 1, 'fas fa-user-tie mr-2'),
(14, 37, 4, 'Penilaian Guru', 'penilaian', 2, 'fas fa-building mr-2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin_lembaga`
--

CREATE TABLE `tb_admin_lembaga` (
  `id` int(6) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `instansi` int(20) NOT NULL,
  `pembuatan_akun` varchar(100) DEFAULT NULL,
  `verifikasi` varchar(150) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_admin_lembaga`
--

INSERT INTO `tb_admin_lembaga` (`id`, `nama`, `username`, `no_telpon`, `tempat_lahir`, `tanggal_lahir`, `email`, `instansi`, `pembuatan_akun`, `verifikasi`, `deleted`) VALUES
(537, 'iwan', 'indriawan22', '', 'bandung', '2020-04-08', 'iwan@gmail.com', 1, '1591117878', 'a3989f9969e4dd46e7e0bc54962c3284', 1),
(538, 'Bapak Agus', 'admin1', '', 'Bandung', '2020-06-01', 'admin1@gmail.com', 10, '1592182911', 'cf94e018c3523c4dff8e01aeb58a2a5c', 0);

--
-- Triggers `tb_admin_lembaga`
--
DELIMITER $$
CREATE TRIGGER `hapus_siswa_copy1_copy1` AFTER DELETE ON `tb_admin_lembaga` FOR EACH ROW BEGIN
DELETE FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_user = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun_lembaga`
--

CREATE TABLE `tb_akun_lembaga` (
  `id` int(6) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `instansi` int(20) NOT NULL,
  `pembuatan_akun` varchar(100) DEFAULT NULL,
  `verifikasi` varchar(150) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_akun_lembaga`
--

INSERT INTO `tb_akun_lembaga` (`id`, `nama`, `username`, `no_telpon`, `tempat_lahir`, `tanggal_lahir`, `email`, `instansi`, `pembuatan_akun`, `verifikasi`, `deleted`) VALUES
(532, 'indriawan', 'adminseskoal', '', 'bandun', '2020-03-14', 'rezharanmarks@gmail.com', 1, '1591185633', '23bc4a561514c32309f3a429541b12af', 0),
(533, 'STASIUN BALAPAN', 'STASIUN', '', 'JAKARTA', '2020-04-05', 'STASIUNLEARN@GMAIL.COM', 2, '1586100594', '8ff1dee6cec9670029c6f4d8fd0a62bd', 0),
(535, 'WKWKWK', 'WKWKWK', '', 'WKWKWK', '2001-01-01', 'WKWKWKCOBA@GMAIL.COM', 1, '1586100909', '86808f06d32eb28c5971cb911bf046ba', 0),
(536, 'Staff TU', 'stafftu', '', 'Bandung', '1977-08-12', 'smktu@gmail.com', 3, '1587384873', 'd9f533abba5805c41609558980d5303b', 0),
(537, 'Akademik Kampus', 'akademik', '', 'Bandung', '1977-08-12', 'akademik@gmail.com', 4, '1587385046', 'c7f1947bda4dc4a7ebeec79293cd7194', 0),
(540, 'alel', 'alel', '', 'Bandung', '2001-01-01', 'alel@gmail.com', 7, '1591126481', 'e7c509251af05602114dd574e3151960', 0),
(541, 'Superadmin AAL', 'adminaal', '', '-', '2020-06-09', 'aal@tni.mil.id', 9, '1591833199', 'e1e985bdce82a5b58ae80a25f7f349ac', 0),
(542, 'adminsman5bdg', 'adminsman5bdg', '', 'Bandung', '2020-06-14', 'sman5bdg@gmail.com', 10, '1592182380', '9d2b5c7772e9950d6fbacf85fd855780', 0),
(543, 'Admin SMAN 21 BANDUNG', 'adminsman21bdg', '', 'Bandung', '2020-06-25', 'adminsman21bdg@gmail.com', 11, '1593069480', '24bef1c41c633eb27c20f2cc2fcd7e52', 0),
(544, 'Admin SMAN 25 BANDUNG', 'adminsman25bdg', '', 'Bandung', '2020-05-11', 'adminsman25bdg@gmail.com', 12, '1593069524', '019cddedf36ec77b9a5bfe4f8ff8082f', 0);

--
-- Triggers `tb_akun_lembaga`
--
DELIMITER $$
CREATE TRIGGER `hapus_siswa_copy1` AFTER DELETE ON `tb_akun_lembaga` FOR EACH ROW BEGIN
DELETE FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_user = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_block_materi`
--

CREATE TABLE `tb_block_materi` (
  `id` bigint(20) NOT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `id_peserta` int(6) DEFAULT NULL,
  `id_mapel` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_block_materi`
--

INSERT INTO `tb_block_materi` (`id`, `id_instansi`, `id_peserta`, `id_mapel`) VALUES
(6, 5, 71, 31),
(7, 5, 352, 31);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_kelas`
--

CREATE TABLE `tb_detail_kelas` (
  `id` bigint(20) NOT NULL,
  `id_peserta` int(6) DEFAULT NULL,
  `id_kelas` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_detail_kelas`
--

INSERT INTO `tb_detail_kelas` (`id`, `id_peserta`, `id_kelas`) VALUES
(65, 536, 3),
(66, 537, 3),
(67, 538, 3),
(68, 539, 3),
(80, 526, 6),
(86, 543, 34),
(89, 541, 1),
(94, 536, 37),
(95, 537, 37),
(96, 538, 37),
(97, 539, 37),
(98, 544, 37),
(99, 526, 1),
(100, 551, 39),
(101, 550, 38),
(102, 553, 39),
(103, 554, 38),
(104, 555, 40),
(105, 556, 40),
(106, 557, 40),
(107, 558, 40),
(114, 579, 43),
(115, 580, 43),
(116, 581, 43),
(117, 582, 43),
(118, 591, 44),
(119, 592, 44),
(120, 593, 44),
(121, 594, 44),
(134, 567, 41),
(135, 568, 41),
(136, 569, 41),
(137, 570, 41),
(138, 571, 41),
(139, 572, 41),
(140, 573, 41),
(141, 574, 41),
(142, 575, 41),
(143, 576, 41),
(144, 577, 41),
(145, 578, 41),
(146, 545, 1),
(147, 603, 45),
(148, 544, 46);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dimensi`
--

CREATE TABLE `tb_dimensi` (
  `id` int(10) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `bobot` decimal(65,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_dimensi`
--

INSERT INTO `tb_dimensi` (`id`, `nama`, `bobot`) VALUES
(8, 'Materi', 0.21010000),
(9, 'Aplikasi', 0.21070000),
(10, 'Motivator', 0.19720000),
(11, 'Personal', 0.18940000),
(12, 'Tugas & Ujian', 0.19260000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_penilaian`
--

CREATE TABLE `tb_ikut_penilaian` (
  `id` int(6) NOT NULL,
  `id_penilaian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_ikut_penilaian`
--

INSERT INTO `tb_ikut_penilaian` (`id`, `id_penilaian`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 1, NULL, 541, '11,12,13,14,15,16,17,18,19', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:B:N,17:B:N,18:C:N,19:B:N', 5, 55.56, 55.56, '2020-06-10 22:15:09', '2020-06-10 22:16:42', 'N', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:A:N,17:A:N,18:A:N,19:A:N', 1),
(2, 1, NULL, 526, '11,12,13,14,15,16,17,18,19', '11:C:N,12:B:N,13:D:N,14:C:N,15:A:N,16:B:N,17:E:N,18:D:N,19:B:N', 1, 11.11, 11.11, '2020-06-10 22:42:25', '2020-06-10 22:43:19', 'N', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:A:N,17:A:N,18:A:N,19:A:N', 1),
(3, 2, NULL, 550, '41,42', '41:A:N,42:C:N', 1, 50.00, 50.00, '2020-06-15 10:24:11', '2020-06-15 10:24:28', 'N', '41:A:N,42:A:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_penilaian_pertama`
--

CREATE TABLE `tb_ikut_penilaian_pertama` (
  `id` int(6) NOT NULL,
  `id_penilaian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tb_ikut_penilaian_pertama`
--

INSERT INTO `tb_ikut_penilaian_pertama` (`id`, `id_penilaian`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 1, NULL, 541, '11,12,13,14,15,16,17,18,19', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:B:N,17:B:N,18:C:N,19:B:N', 0, 0.00, 0.00, '2020-06-10 22:15:09', '2020-06-11 00:15:09', 'N', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:A:N,17:A:N,18:A:N,19:A:N', 1),
(2, 1, NULL, 526, '11,12,13,14,15,16,17,18,19', '11:C:N,12:B:N,13:D:N,14:C:N,15:A:N,16:B:N,17:E:N,18:D:N,19:B:N', 0, 0.00, 0.00, '2020-06-10 22:42:25', '2020-06-11 00:42:25', 'N', '11:A:N,12:A:N,13:A:N,14:A:N,15:A:N,16:A:N,17:A:N,18:A:N,19:A:N', 1),
(3, 2, NULL, 550, '41,42', '41:A:N,42:C:N', 0, 0.00, 0.00, '2020-06-15 10:24:11', '2020-06-15 11:14:11', 'N', '41:A:N,42:A:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_ujian`
--

CREATE TABLE `tb_ikut_ujian` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_ikut_ujian`
--

INSERT INTO `tb_ikut_ujian` (`id`, `id_ujian`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 3, NULL, 526, '2,5,6,7,11', '2:B:Y,5:B:Y,6:B:N,7:B:N,11:B:N', 1, 20.00, 8.33, '2020-06-21 20:45:15', '2020-06-21 20:47:59', 'N', '2:B:N,5:A:N,6:A:N,7:C:N,11::N', 1),
(2, 6, NULL, 556, '12', '12:A:N', 1, 100.00, 100.00, '2020-06-26 17:02:24', '2020-06-26 17:02:49', 'N', '12:A:N', 1),
(3, 7, NULL, 603, '13', '13:A:N', 1, 100.00, 100.00, '2020-06-27 10:20:46', '2020-06-27 10:21:14', 'N', '13:A:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_ujian_essay`
--

CREATE TABLE `tb_ikut_ujian_essay` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_ikut_ujian_essay`
--

INSERT INTO `tb_ikut_ujian_essay` (`id`, `id_ujian`, `id_penggunaan`, `id_user`, `list_soal`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 3, NULL, 526, '29,30', 0, 0.00, 0.00, '2020-06-21 22:49:51', '2020-06-21 23:22:03', 'N', '', 1),
(2, 6, NULL, 556, '31', 0, 0.00, 0.00, '2020-06-26 17:03:39', '2020-06-26 17:03:52', 'N', '', 1),
(3, 7, NULL, 603, '32', 0, 0.00, 0.00, '2020-06-27 10:21:29', '2020-06-27 10:22:45', 'N', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_ujian_essay_pertama`
--

CREATE TABLE `tb_ikut_ujian_essay_pertama` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tb_ikut_ujian_essay_pertama`
--

INSERT INTO `tb_ikut_ujian_essay_pertama` (`id`, `id_ujian`, `id_penggunaan`, `id_user`, `list_soal`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 3, NULL, 526, '29,30', 0, 0.00, 0.00, '2020-06-21 22:57:19', '2020-06-21 23:57:19', 'N', '', 1),
(2, 6, NULL, 556, '31', 0, 0.00, 0.00, '2020-06-26 17:03:39', '2020-06-26 18:13:39', 'N', '', 1),
(3, 7, NULL, 603, '32', 0, 0.00, 0.00, '2020-06-27 10:21:29', '2020-06-27 13:44:29', 'N', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ikut_ujian_pertama`
--

CREATE TABLE `tb_ikut_ujian_pertama` (
  `id` int(6) NOT NULL,
  `id_ujian` int(6) NOT NULL,
  `id_penggunaan` int(11) DEFAULT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tb_ikut_ujian_pertama`
--

INSERT INTO `tb_ikut_ujian_pertama` (`id`, `id_ujian`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 3, NULL, 526, '2,5,6,7,11', '2:B:Y,5:B:Y,6:B:N,7:B:N,11:B:N', 0, 0.00, 0.00, '2020-06-21 20:45:15', '2020-06-21 21:45:15', 'N', '2:B:N,5:A:N,6:A:N,7:C:N,11::N', 1),
(2, 6, NULL, 556, '12', '12:A:N', 0, 0.00, 0.00, '2020-06-26 17:02:24', '2020-06-26 18:12:24', 'N', '12:A:N', 1),
(3, 7, NULL, 603, '13', '13:A:N', 0, 0.00, 0.00, '2020-06-27 10:20:46', '2020-06-27 13:43:46', 'N', '13:A:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_instansi`
--

CREATE TABLE `tb_instansi` (
  `id` bigint(20) NOT NULL,
  `instansi` varchar(200) DEFAULT NULL,
  `nama_pimpinan` varchar(200) DEFAULT NULL,
  `no_telp` varchar(14) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_instansi`
--

INSERT INTO `tb_instansi` (`id`, `instansi`, `nama_pimpinan`, `no_telp`, `alamat`, `deleted`) VALUES
(1, 'SESKOAL', '-', '-', '-', 0),
(8, 'STT AL', '-', '-', '-', 0),
(9, 'Akademi Angkatan Laut', '-', '-', '-', 0),
(10, 'SMAN 5 Bandung', '-', '-', 'Bandung', 0),
(11, 'SMAN 21 BANDUNG', 'KEPSEK SMAN 21 BANDUNG', '022', 'BANDUNG', 0),
(12, 'SMAN 25 BANDUNG', 'KEPSEK SMAN 25 BANDUNG', '022', 'BANDUNG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id` bigint(20) NOT NULL,
  `id_calendar` varchar(200) NOT NULL,
  `id_kelas` bigint(20) DEFAULT NULL,
  `id_materi` int(6) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id`, `id_calendar`, `id_kelas`, `id_materi`, `keterangan`, `start_date`, `end_date`, `color`) VALUES
(8, 'NzM0MXZqaHF1OXY2N3VldDdkNTlzNmVyMWdfMjAyMDA2MDJUMDAwMDAwWiBpa2hzYW5oYW1pZGFuMTNAbQ', 1, 3, 'Testing rasa bbq', '2020-06-02 00:00:00', '2020-06-03 00:00:00', '#0071c5'),
(9, 'NTQ3NXNvZWI2c2t0YW4xamw3ZTltamI0bjhfMjAyMDA2MDFUMTExNTAwWiBhamlyb2hpbWF0OTdAbQ', 1, 3, 'Belajar Diskusi', '2020-06-01 11:15:00', '2020-06-24 11:15:00', '#FFD700'),
(10, 'azYzY211YmRyYXU5bWcxZzI0OHRiajhzaDRfMjAyMDA2MDJUMjEwMTAwWiBhamlyb2hpbWF0OTdAbQ', 1, 3, 'coba', '2020-06-02 21:01:00', '2020-06-06 22:02:00', ''),
(11, 'djc1dDBqY2JqdmgxNzJhMTdsMTUzbXVhdDBfMjAyMDA2MDJUMTExMTAwWiBhamlyb2hpbWF0OTdAbQ', 3, 0, '-', '2020-06-02 11:11:00', '2020-06-06 12:03:00', '#FFD700'),
(13, 'MzFxaGNybnVrdGcyaG1uYjdrczFnYm5yMjRfMjAyMDA2MDJUMTE0NzAwWiBhamlyb2hpbWF0OTdAbQ', 5, 4, 'Belajar', '2020-06-02 11:47:00', '2020-06-03 11:47:00', '#008000'),
(14, 'cXNucWVpZ2I3bnF2c2JjdDFsaWw3czVhNG9fMjAyMDA2MDhUMTEwMTAwWiBkd2lzdXJkaWFuYTg4QG0', 1, 3, 'test fix', '2020-06-08 11:01:00', '2020-06-13 11:11:00', '#FF8C00'),
(15, 'YTBjZWwzMnZtNjUwZWI0cjVyMjlwbzBrOW9fMjAyMDA2MDFUMDUyMDAwWiBhamlyb2hpbWF0OThAbQ', 36, 3, 'tes', '2020-06-01 05:20:00', '2020-06-05 09:26:31', '#0071c5'),
(17, 'dXBqZHZpdGZ0djZwa2oxN2djdHJlYWhsNW9fMjAyMDA2MjNUMTEwMTAwWiBkd2lzdXJkaWFuYTg4QG0', 39, 14, '-', '2020-06-23 11:01:00', '2020-06-27 03:21:00', ''),
(18, 'bmtza2pwMWhrcDFzcWFzOGxvdmxxODNvcmdfMjAyMDA2MDFUMDIyMjAwWiBpa2hzYW5oYW1pZGFuMTNAbQ', 45, 17, 'Jam ajar wajib', '2020-06-26 02:22:00', '2020-06-27 20:00:00', '#008000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jawaban_essay`
--

CREATE TABLE `tb_jawaban_essay` (
  `id` bigint(20) NOT NULL,
  `id_ujian` bigint(20) DEFAULT NULL,
  `id_user` int(6) DEFAULT NULL,
  `id_ikut_essay` bigint(20) DEFAULT NULL,
  `id_soal` bigint(20) DEFAULT NULL,
  `jawaban` text DEFAULT NULL,
  `ragu` varchar(1) DEFAULT NULL,
  `nilai` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_jawaban_essay`
--

INSERT INTO `tb_jawaban_essay` (`id`, `id_ujian`, `id_user`, `id_ikut_essay`, `id_soal`, `jawaban`, `ragu`, `nilai`) VALUES
(1, 3, 526, 1, 29, 'test', 'N', 70),
(2, 3, 526, 1, 30, 'apa kabar', 'N', 30),
(3, 6, 556, 2, 31, 'Kota Bandung', 'N', 1),
(4, 7, 603, 3, 32, 'Jadi gini', 'N', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id` bigint(20) NOT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `jurusan` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `id_instansi`, `jurusan`) VALUES
(4, 1, 'Kopasus'),
(6, 1, 'Dikreg999'),
(7, 1, 'Dikreg 57'),
(8, 1, 'Dikreg 2020'),
(9, 1, 'Strategi Operasi Laut'),
(10, 10, 'IPA'),
(11, 10, 'IPS'),
(15, 11, 'MIPA'),
(16, 11, 'IPS'),
(17, 12, 'IPA'),
(18, 12, 'IPS'),
(19, 1, 'MIPA');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_trainer` int(6) DEFAULT NULL,
  `id_mapel` int(6) DEFAULT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `id_jurusan` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama`, `keterangan`, `id_trainer`, `id_mapel`, `id_instansi`, `id_jurusan`) VALUES
(1, 'II Pelaut 2', 'Online', 1, 55, 1, 4),
(3, 'Dikreg7777', 'Kelas Reguler', 33, 59, 1, 6),
(6, 'Kewarganegaraan', 'Kewarganegaraan', 37, 62, 1, 8),
(34, 'Strategi Operasi Laut', '-', 38, 63, 1, 9),
(37, 'II Pelaut 1', 'Online', 1, 55, 1, 6),
(38, 'XI IPS 1', '-', 49, 71, 10, 11),
(39, 'XI IPA 1', '-', 46, 70, 10, 10),
(40, 'X IPA', 'X IPA', 53, 77, 11, 12),
(41, 'X IPa', 'X IPa', 53, 77, 11, 15),
(42, 'X MIPA 1', '', 66, 83, 11, 15),
(43, 'X IPA (Matematika 10)', '-', 68, 84, 12, 17),
(44, 'X IPS (Matematika 10)', '-', 68, 85, 12, 18),
(45, 'Belajar Psikologi', 'Sangat penting buat pengembangan diri!', 1, 59, 1, 7),
(46, 'Red Room', 'You know what Red Room mean right?', 1, 59, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tb_komen_materi`
--

CREATE TABLE `tb_komen_materi` (
  `id` bigint(20) NOT NULL,
  `id_materi` int(6) DEFAULT NULL,
  `id_head` bigint(20) DEFAULT NULL,
  `id_trainer` int(6) DEFAULT NULL,
  `id_siswa` int(6) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `create_time` time DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `update_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_komen_materi`
--

INSERT INTO `tb_komen_materi` (`id`, `id_materi`, `id_head`, `id_trainer`, `id_siswa`, `komentar`, `file`, `create_date`, `create_time`, `update_date`, `update_time`) VALUES
(1, 4, 0, 0, 541, 'Mau tanya ?', NULL, '2020-06-03', '02:06:09', NULL, NULL),
(2, 3, 0, 0, 526, 'Hai kevin', NULL, '2020-06-08', '13:10:40', NULL, NULL),
(3, 3, 2, 0, 526, 'Iya ada apa?', NULL, '2020-06-08', '13:39:24', NULL, NULL),
(4, 3, 0, 0, 526, 'Hina aja terooz', NULL, '2020-06-08', '14:12:00', NULL, NULL),
(5, 3, 0, 0, 526, 'Iri bilang boos', 'assets/materi/diskusi/c3247998a587a11845c425e75427a6f3.png', '2020-06-08', '14:17:05', NULL, NULL),
(8, 3, 0, 0, 526, 'rese', 'assets/materi/diskusi/1efae16f473f3b51151e00afe609673e.pdf', '2020-06-08', '17:14:20', NULL, NULL),
(12, 3, 5, 0, 526, 'ini apa?', 'assets/materi/diskusi/3dd95c513d4b50cf05859b6fd5766863.png', '2020-06-09', '11:29:00', NULL, NULL),
(14, 3, 2, 0, 526, 'Engga ini tugas', 'assets/materi/diskusi/7673a5aaa5df01cfd60bbb70d2615706.pdf', '2020-06-09', '11:34:45', NULL, NULL),
(15, 14, 0, 0, 551, 'Saya Mau Tanya Pak', '0', '2020-06-25', '15:01:48', NULL, NULL),
(16, 14, 15, 46, 0, 'boleh silahkan', NULL, '2020-06-25', '15:08:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_materi_instansi`
--

CREATE TABLE `tb_materi_instansi` (
  `id` bigint(20) NOT NULL,
  `id_mapel` int(6) DEFAULT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `id_trainer` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_materi_instansi`
--

INSERT INTO `tb_materi_instansi` (`id`, `id_mapel`, `id_instansi`, `id_trainer`) VALUES
(1, 53, 1, 1),
(3, 58, 4, 24),
(4, 55, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_notifikasi_forum`
--

CREATE TABLE `tb_notifikasi_forum` (
  `id` bigint(20) NOT NULL,
  `id_koment` bigint(20) DEFAULT NULL,
  `id_materi` int(6) DEFAULT NULL,
  `id_siswa` int(6) DEFAULT NULL,
  `sender_id` int(6) DEFAULT NULL,
  `sender_lvl` varchar(15) DEFAULT NULL,
  `id_trainer` int(6) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `see` tinyint(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_notifikasi_forum`
--

INSERT INTO `tb_notifikasi_forum` (`id`, `id_koment`, `id_materi`, `id_siswa`, `sender_id`, `sender_lvl`, `id_trainer`, `keterangan`, `see`, `create_date`) VALUES
(1, 1, 4, NULL, 541, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 1, '2020-06-03 02:06:09'),
(2, 2, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 13:10:40'),
(3, 3, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 1, '2020-06-08 13:39:24'),
(4, 3, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-08 13:39:24'),
(5, 4, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 14:12:00'),
(6, 5, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 14:17:05'),
(7, 6, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 17:08:30'),
(8, 7, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 17:11:14'),
(9, 8, 3, NULL, 526, 'siswa', 1, 'Menulis sesuatu di materi yang anda tulis', 0, '2020-06-08 17:14:20'),
(10, 9, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 1, '2020-06-09 11:14:01'),
(11, 9, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:14:01'),
(12, 10, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 0, '2020-06-09 11:17:27'),
(13, 10, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:17:27'),
(14, 11, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 0, '2020-06-09 11:20:23'),
(15, 11, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:20:23'),
(16, 12, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 0, '2020-06-09 11:29:00'),
(17, 12, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:29:00'),
(18, 13, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 0, '2020-06-09 11:32:11'),
(19, 13, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:32:11'),
(20, 14, 3, 526, 526, 'siswa', NULL, 'peserta lain ikut berkomentar', 0, '2020-06-09 11:34:45'),
(21, 14, 3, NULL, 526, 'siswa', 1, 'peserta membalas ikut membalas komentar', 0, '2020-06-09 11:34:45'),
(22, 15, 14, NULL, 551, 'siswa', 46, 'Menulis sesuatu di materi yang anda tulis', 1, '2020-06-25 15:01:48'),
(23, 16, 14, 551, 46, 'guru', NULL, 'Trainer ikut berkomentar', 1, '2020-06-25 15:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket_soal`
--

CREATE TABLE `tb_paket_soal` (
  `id` bigint(20) NOT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_paket_soal`
--

INSERT INTO `tb_paket_soal` (`id`, `id_instansi`, `nama`) VALUES
(2, 1, 'Soal Contoh'),
(3, 1, 'SOAL EDOPM 1'),
(4, 10, 'Paket Soal 1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penilaian`
--

CREATE TABLE `tb_penilaian` (
  `id` int(6) NOT NULL,
  `id_kelas` bigint(20) NOT NULL,
  `id_paket_soal` bigint(20) DEFAULT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(6) NOT NULL,
  `waktu` int(6) NOT NULL,
  `jenis` enum('acak','set') NOT NULL,
  `detil_jenis` varchar(500) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `status_token` int(11) DEFAULT NULL,
  `verifikasi` int(1) DEFAULT NULL,
  `token` varchar(5) DEFAULT NULL,
  `izin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_penilaian`
--

INSERT INTO `tb_penilaian` (`id`, `id_kelas`, `id_paket_soal`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `detil_jenis`, `tgl_mulai`, `terlambat`, `status_token`, `verifikasi`, `token`, `izin`) VALUES
(1, 1, 2, 'testing', 1, 120, 'set', NULL, '2020-06-10 18:00:00', '2020-06-11 12:00:00', NULL, NULL, NULL, 1),
(2, 38, 4, 'Penilaian Guru Geografi', 1, 50, 'set', NULL, '2020-06-03 19:54:00', '2020-06-17 21:57:00', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rank`
--

CREATE TABLE `tb_rank` (
  `id` bigint(20) NOT NULL,
  `id_trainer` int(6) DEFAULT NULL,
  `id_mapel` int(6) DEFAULT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `tgl_input` date DEFAULT NULL,
  `responden` bigint(20) DEFAULT NULL,
  `total_a` int(10) DEFAULT NULL,
  `total_b` int(10) DEFAULT NULL,
  `total_c` int(10) DEFAULT NULL,
  `total_d` int(10) DEFAULT NULL,
  `total_e` int(10) DEFAULT NULL,
  `skor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_rank`
--

INSERT INTO `tb_rank` (`id`, `id_trainer`, `id_mapel`, `id_instansi`, `tgl_input`, `responden`, `total_a`, `total_b`, `total_c`, `total_d`, `total_e`, `skor`) VALUES
(1, 1, 53, 1, '2020-06-01', 2, 5, 2, 1, 0, 0, '36'),
(3, 1, 53, 1, '2020-06-02', 1, 0, 0, 0, 0, 0, '0'),
(4, 1, 53, 1, '2020-06-03', 3, 1, 3, 1, 0, 0, '20'),
(6, 38, 63, 1, '2020-06-03', 1, 0, 0, 1, 0, 0, '3'),
(7, 1, 53, 1, '2020-06-10', 2, 6, 6, 3, 2, 1, '68'),
(8, 49, 71, 10, '2020-06-15', 1, 1, 0, 1, 0, 0, '8');

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting`
--

CREATE TABLE `tb_setting` (
  `id` int(2) NOT NULL,
  `jumlah_testing` tinyint(3) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `footer` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `logo_login` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_setting`
--

INSERT INTO `tb_setting` (`id`, `jumlah_testing`, `judul`, `footer`, `logo`, `logo_login`) VALUES
(1, 3, 'E-LEARNING DIAN GLOBAL TECH', 'E-LEARNING DIAN GLOBAL TECH', '1593064586_logo_20200625125626.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting_instansi`
--

CREATE TABLE `tb_setting_instansi` (
  `id` int(2) NOT NULL,
  `jumlah_testing` tinyint(3) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `footer` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_setting_instansi`
--

INSERT INTO `tb_setting_instansi` (`id`, `jumlah_testing`, `judul`, `footer`, `logo`, `id_instansi`, `video`) VALUES
(8, 2, 'E-LEARNING TNI AL - SESKOAL', 'E-LEARNING TNI AL - SESKOAL', '1591837596_logo_SESKOAL20200611080636.png', 1, '1591031827_video_TNI_AL20200602001707.mp4'),
(9, 2, 'E-Learning Sekolah', 'E-Learning Sekolah', '1587386003_logo_Sekolah20200420193323.png', 3, ''),
(10, 2, 'E-Learning Perguruan Tinggi', 'E-Learning Perguruan Tinggi', '1587386142_logo_Kampus20200420193542.png', 4, ''),
(11, 0, 'AKADEMI ANGKATAN LAUT', 'E-LEARNING TNI AL - AKADEMI ANGKATAN LAUT', NULL, 9, ''),
(12, 0, 'E-LEARNING SMAN 5 BANDUNG', 'E-LEARNING SMAN 5 BANDUNG', '1592190413_logo_SMAN_5_Bandung20200615100653.png', 10, ''),
(13, 0, 'E-LEARNING SMAN 21 BANDUNG', 'E-LEARNING SMAN 21 BANDUNG', '1593069655_logo_SMAN_21_BANDUNG20200625142055.jpg', 11, ''),
(14, 0, 'E-LEARNING SMAN 25 BANDUNG', 'E-LEARNING SMAN 25 BANDUNG', '1593069722_logo_SMAN_25_BANDUNG20200625142202.JPG', 12, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_slider`
--

CREATE TABLE `tb_slider` (
  `id` bigint(20) NOT NULL,
  `id_instansi` bigint(20) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `format` varchar(40) DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_slider`
--

INSERT INTO `tb_slider` (`id`, `id_instansi`, `file`, `format`, `create_at`) VALUES
(2, 1, 'slide-16-06-2020-1592277807-0.jpg', '.jpg', '2020-06-16 10:23:27'),
(4, 1, 'slide-16-06-2020-1592277807-2.png', '.png', '2020-06-16 10:23:27'),
(5, 1, 'slide-23-06-2020-1592886023-0.jpg', '.jpg', '2020-06-23 11:20:24'),
(6, 10, 'slide-25-06-2020-1593070464-0.jpg', '.jpg', '2020-06-25 14:34:24'),
(7, 10, 'slide-25-06-2020-1593070659-0.png', '.png', '2020-06-25 14:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sub_menu`
--

CREATE TABLE `tb_sub_menu` (
  `id` int(10) NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `sub_menu` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_sub_menu`
--

INSERT INTO `tb_sub_menu` (`id`, `id_menu`, `sub_menu`) VALUES
(1, 49, 'rekaptulasi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas`
--

CREATE TABLE `tb_tugas` (
  `id` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_kelas` int(6) DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_tugas`
--

INSERT INTO `tb_tugas` (`id`, `keterangan`, `id_kelas`, `end_date`) VALUES
(1, 'Tugas ketika liur', 3, '2020-04-20 23:59:00'),
(23, 'test', 37, '2020-06-02 00:00:00'),
(24, 'test 2324', 37, '2020-06-02 00:00:00'),
(25, 'Adwada', 37, '2020-06-06 00:00:00'),
(26, 'test', 1, '2020-06-16 20:00:00'),
(27, 'Tugas Harian', 38, '2020-06-17 08:12:00'),
(28, 'Kerjakan tugas Integral', 40, '2020-06-27 03:44:00'),
(29, 'Kerjakan hanya 1 jam', 45, '2020-06-28 02:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas_attachment`
--

CREATE TABLE `tb_tugas_attachment` (
  `id` bigint(20) NOT NULL,
  `id_tugas` bigint(20) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `format` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_tugas_attachment`
--

INSERT INTO `tb_tugas_attachment` (`id`, `id_tugas`, `file`, `format`) VALUES
(1, 1, 'tugas-18-04-2020-1587220255-0.docx', '.docx'),
(2, 1, 'tugas-18-04-2020-1587220255-1.pdf', '.pdf'),
(4, 23, 'tugas-09-06-2020-1591709953-0.pdf', '.pdf'),
(5, 24, 'tugas-09-06-2020-1591710301-0.pdf', '.pdf'),
(6, 24, 'tugas-09-06-2020-1591711622-0.jpg', '.jpg'),
(7, 25, 'tugas-14-06-2020-1592130674-0.jpg', '.jpg'),
(8, 26, 'tugas-14-06-2020-1592133674-0.pdf', '.pdf'),
(9, 27, 'tugas-15-06-2020-1592190930-0.png', '.png'),
(10, 28, 'tugas-26-06-2020-1593164756-0.xlsx', '.xlsx'),
(11, 29, 'tugas-27-06-2020-1593228308-0.pdf', '.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas_attachment_siswa`
--

CREATE TABLE `tb_tugas_attachment_siswa` (
  `id` bigint(20) NOT NULL,
  `id_tugas` bigint(20) DEFAULT NULL,
  `id_siswa` int(6) DEFAULT NULL,
  `file` text DEFAULT NULL,
  `format` varchar(40) DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_tugas_attachment_siswa`
--

INSERT INTO `tb_tugas_attachment_siswa` (`id`, `id_tugas`, `id_siswa`, `file`, `format`, `create_at`) VALUES
(1, 1, 526, 'tugas-Aji_Rohimat-18-04-2020-1587222536-0.docx', '.docx', NULL),
(2, 1, 526, 'tugas-Aji_Rohimat-18-04-2020-1587222536-1.pdf', '.pdf', NULL),
(3, 24, 544, 'tugas-Jazai-09-06-2020-1591712335-0.jpg', '.jpg', NULL),
(18, 25, 544, 'tugas-Jazai-14-06-2020-1592132005-0.xlsx', '.xlsx', NULL),
(26, 26, 526, 'tugas-Aji_Rohimat-14-06-2020-1592141538-0.pdf', '.pdf', '2020-06-14 20:32:18'),
(27, 26, 526, 'tugas-Aji_Rohimat-14-06-2020-1592141538-1.pptx', '.pptx', '2020-06-17 20:32:18'),
(28, 26, 526, 'tugas-Aji_Rohimat-15-06-2020-1592155615-0.png', '.png', '2020-06-15 00:26:55'),
(29, 27, 550, 'tugas-Siswa_41-15-06-2020-1592192551-0.png', '.png', '2020-06-15 10:42:31'),
(30, 28, 556, 'tugas-AJI-26-06-2020-1593164868-0.xlsx', '.xlsx', '2020-06-26 16:47:48'),
(31, 29, 603, 'tugas-Bara_Bursa-27-06-2020-1593228882-0.png', '.png', '2020-06-27 10:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas_nilai`
--

CREATE TABLE `tb_tugas_nilai` (
  `id` bigint(20) NOT NULL,
  `id_tugas` bigint(20) DEFAULT NULL,
  `id_siswa` int(6) DEFAULT NULL,
  `nilai` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_tugas_nilai`
--

INSERT INTO `tb_tugas_nilai` (`id`, `id_tugas`, `id_siswa`, `nilai`) VALUES
(2, 26, 526, 100),
(3, 27, 550, 0),
(4, 28, 556, 80);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ujian`
--

CREATE TABLE `tb_ujian` (
  `id` int(6) NOT NULL,
  `id_kelas` bigint(20) NOT NULL,
  `type_ujian` enum('uas','uts') DEFAULT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(6) NOT NULL,
  `waktu` int(6) NOT NULL,
  `jenis` enum('acak','set') NOT NULL,
  `detil_jenis` varchar(500) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `status_token` int(11) DEFAULT NULL,
  `verifikasi` int(1) DEFAULT NULL,
  `token` varchar(5) DEFAULT NULL,
  `izin` tinyint(1) DEFAULT 0,
  `min_nilai` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_ujian`
--

INSERT INTO `tb_ujian` (`id`, `id_kelas`, `type_ujian`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `detil_jenis`, `tgl_mulai`, `terlambat`, `status_token`, `verifikasi`, `token`, `izin`, `min_nilai`) VALUES
(1, 1, 'uts', 'dwad', 1, 60, 'set', NULL, '2020-05-31 00:00:00', '2020-05-31 20:00:00', NULL, NULL, NULL, 1, 70),
(3, 1, 'uts', 'UTS Ganjil', 5, 60, 'set', NULL, '2020-06-01 00:32:00', '2020-06-22 00:32:00', NULL, NULL, NULL, 1, 75),
(4, 1, 'uts', 'UTS tapi boong', 1, 60, 'set', NULL, '2020-06-03 00:00:00', '2020-06-07 00:00:00', NULL, NULL, NULL, 1, 75),
(5, 38, 'uts', 'UTS Geografi XI IPS 1 - Semester 1', 2, 60, 'set', NULL, '2020-06-13 18:55:00', '2020-06-17 19:54:00', NULL, NULL, NULL, 1, 70),
(6, 40, 'uts', 'UTS Matematika', 1, 70, 'set', NULL, '2020-06-25 01:48:00', '2020-06-27 02:49:00', NULL, NULL, NULL, 1, 70),
(7, 45, 'uts', 'Test Psikologi', 1, 203, 'set', NULL, '2020-06-27 02:00:00', '2020-06-27 14:00:00', NULL, NULL, NULL, 1, 75);

-- --------------------------------------------------------

--
-- Table structure for table `tr_guru_mapel`
--

CREATE TABLE `tr_guru_mapel` (
  `id` int(6) NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tr_guru_mapel`
--

INSERT INTO `tr_guru_mapel` (`id`, `id_guru`, `id_mapel`) VALUES
(35, 1, 55),
(41, 1, 59),
(54, 38, 63),
(55, 49, 71),
(56, 46, 70),
(58, 53, 77),
(59, 57, 78),
(60, 67, 82),
(61, 66, 83),
(62, 64, 79),
(63, 68, 84),
(64, 68, 85);

-- --------------------------------------------------------

--
-- Table structure for table `tr_guru_tes`
--

CREATE TABLE `tr_guru_tes` (
  `id` int(6) NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(6) NOT NULL,
  `waktu` int(6) NOT NULL,
  `jenis` enum('acak','set') NOT NULL,
  `detil_jenis` varchar(500) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `status_token` int(11) NOT NULL,
  `verifikasi` int(1) NOT NULL,
  `penggunaan` int(11) NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tr_ikut_ujian`
--

CREATE TABLE `tr_ikut_ujian` (
  `id` int(6) NOT NULL,
  `id_tes` int(6) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tr_ikut_ujian`
--

INSERT INTO `tr_ikut_ujian` (`id`, `id_tes`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 1, 6, 526, '1', '1:A:N', 0, 0.00, 0.00, '2020-04-18 21:04:16', '2020-04-18 21:04:31', 'N', '1:B:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tr_ikut_ujian_pertama`
--

CREATE TABLE `tr_ikut_ujian_pertama` (
  `id` int(6) NOT NULL,
  `id_tes` int(6) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `jawaban_benar` longtext NOT NULL,
  `banyak` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tr_ikut_ujian_pertama`
--

INSERT INTO `tr_ikut_ujian_pertama` (`id`, `id_tes`, `id_penggunaan`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`, `jawaban_benar`, `banyak`) VALUES
(1, 1, 6, 526, '1', '1:A:N', 0, 0.00, 0.00, '2020-04-18 21:04:16', '2020-04-18 23:04:16', 'N', '1:B:N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tr_mapel_chat`
--

CREATE TABLE `tr_mapel_chat` (
  `id` int(11) NOT NULL,
  `pengirim` varchar(100) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `id_mapel` int(11) NOT NULL,
  `chat` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tr_mapel_chat`
--

INSERT INTO `tr_mapel_chat` (`id`, `pengirim`, `level`, `id_mapel`, `chat`, `waktu`) VALUES
(112, 'Rezha Ranmark', 'peserta', 31, 'hay', '2019-11-27 14:04:06'),
(110, 'Rezha Ranmark', 'peserta', 31, 'hay', '2019-11-27 13:58:35'),
(109, 'Rezha Ranmark', 'peserta', 31, NULL, '2019-11-27 13:56:37'),
(108, 'Rezha Ranmark', 'peserta', 31, NULL, '2019-11-27 13:48:26'),
(107, 'Rezha Ranmark', 'peserta', 31, NULL, '2019-11-27 13:48:16'),
(106, 'Rezha Ranmark', 'peserta', 31, NULL, '2019-11-27 12:46:27'),
(105, 'Rezha Ranmark', 'peserta', 31, 'hello', '2019-11-27 12:44:17'),
(104, 'Rezha Ranmark', 'pengusaha', 31, '', '2019-11-27 10:35:11'),
(103, 'Rezha Ranmark', 'pengusaha', 31, '', '2019-11-27 10:35:11'),
(102, 'Dwi Surdiana', 'trainer', 31, 'oke', '2019-11-27 09:38:56'),
(101, 'Dwi Surdiana', 'trainer', 31, 'hai', '2019-11-27 09:38:41'),
(100, 'Rezha Ranmark', 'pengusaha', 31, 'hello', '2019-11-27 09:38:19'),
(111, 'Rezha Ranmark', 'peserta', 31, 'hello', '2019-11-27 13:59:41'),
(99, 'Dwi Surdiana', 'trainer', 31, 'iya', '2019-11-27 07:18:38'),
(98, 'Rezha Ranmark', 'pengusaha', 31, 'hai', '2019-11-27 07:18:26'),
(97, 'Dwi Surdiana', 'trainer', 31, 'hello', '2019-11-27 07:16:23'),
(96, 'Rezha Ranmark', 'pengusaha', 31, 'sudah', '2019-11-27 04:30:10'),
(95, 'Dwi Surdiana', 'trainer', 31, 'sudah mengerti?', '2019-11-27 04:29:18'),
(93, 'Rezha Ranmark', 'pengusaha', 31, 'menanyakan mengenai', '2019-11-27 04:22:28'),
(94, 'Rezha Ranmark', 'pengusaha', 31, 'materi', '2019-11-27 04:24:31'),
(92, 'Rezha Ranmark', 'pengusaha', 31, 'tes', '2019-11-27 04:22:04'),
(91, 'Anto', 'pengusaha', 31, 'oke', '2019-11-27 01:46:42'),
(90, 'Dwi Surdiana', 'trainer', 31, 'chat', '2019-11-27 01:46:19'),
(89, 'Anto', 'pengusaha', 31, 'hai', '2019-11-27 01:45:29'),
(88, 'Anto', 'pengusaha', 31, 'hello', '2019-11-27 01:45:16'),
(87, 'Dwi Surdiana', 'trainer', 31, 'oke terima kasih..', '2019-11-27 01:41:46'),
(86, 'Anto', 'pengusaha', 31, 'tidak..', '2019-11-27 01:41:24'),
(85, 'Dwi Surdiana', 'trainer', 31, 'apa ada yang ditanyakan??', '2019-11-27 01:41:12'),
(84, 'Anto', 'pengusaha', 31, 'apa', '2019-11-27 01:34:12'),
(83, 'Dwi Surdiana', 'trainer', 31, 'hello', '2019-11-27 01:34:01'),
(81, 'Anto', 'pengusaha', 31, 'saya mau berrtannya??', '2019-11-27 01:03:36'),
(82, 'Dwi Surdiana', 'trainer', 31, 'bertannya apa??', '2019-11-27 01:03:51'),
(113, 'Dwi Surdiana', 'trainer', 31, 'hello', '2019-11-27 14:30:35'),
(114, 'Dwi Surdiana', 'trainer', 31, 'p', '2019-11-27 14:30:55'),
(115, 'Rezha Ranmark', 'peserta', 31, 'a', '2019-11-27 15:14:42'),
(116, 'Rezha Ranmark', 'peserta', 31, 'das', '2019-11-27 15:24:28'),
(117, 'Rezha Ranmark', 'peserta', 31, 'oke', '2019-11-27 15:24:39'),
(118, 'Rezha Ranmark', 'peserta', 31, 'coba', '2019-11-27 15:38:45'),
(119, 'Rezha Ranmark', 'peserta', 31, 'ad', '2019-11-27 15:40:47'),
(120, 'Rezha Ranmark', 'peserta', 31, 'hello', '2019-11-27 15:41:13'),
(121, 'Rezha Ranmark', 'peserta', 31, 'apa kabar?', '2019-11-27 21:13:24'),
(122, 'Rezha Ranmark', 'peserta', 31, 'sudah berfungsi?', '2019-11-27 21:13:55'),
(123, 'Dwi Surdiana', 'trainer', 31, 'sippp', '2019-11-28 00:29:04'),
(124, 'Dwi Surdiana', 'trainer', 31, 'chat', '2019-11-28 04:41:53'),
(125, 'Dwi Surdiana', 'trainer', 31, 'hello', '2019-11-28 04:42:49'),
(126, 'Rezha Ranmark', 'peserta', 31, 'saya mau konsultasi materi', '2019-12-09 22:42:40'),
(127, 'Rezha Ranmark', 'peserta', 31, 'siang kang ahmadi!!!', '2019-12-16 22:30:01'),
(128, 'Soeyamto, SE', 'trainer', 31, 'tes ', '2019-12-16 22:30:58'),
(129, 'Soeyamto, SE', 'trainer', 31, 'iya', '2019-12-16 22:31:07'),
(130, 'Rezha Ranmark', 'peserta', 31, 'halo kang ahmi', '2019-12-16 22:31:11'),
(176, 'Soeyamto, SE', 'trainer', 31, 'w', '2020-01-01 05:26:37'),
(175, 'Anto', 'peserta', 31, 'a', '2020-01-01 05:08:24'),
(174, 'Anto', 'peserta', 31, 'da', '2020-01-01 05:05:46'),
(173, 'Anto', 'peserta', 31, 'cata', '2020-01-01 04:57:26'),
(172, 'Anto', 'peserta', 31, 'da', '2020-01-01 04:56:54'),
(171, 'Anto', 'peserta', 31, 'ad', '2020-01-01 04:54:10'),
(170, 'Anto', 'peserta', 31, 'h', '2020-01-01 04:11:46'),
(169, 'Soeyamto, SE', 'trainer', 31, 's', '2020-01-01 04:11:25'),
(168, 'Soeyamto, SE', 'trainer', 31, 'h', '2020-01-01 04:11:09'),
(167, 'Soeyamto, SE', 'trainer', 31, 'hay', '2020-01-01 04:09:41'),
(166, 'Anto', 'peserta', 31, 'hello', '2020-01-01 04:09:29'),
(165, 'Soeyamto, SE', 'trainer', 31, 'coba', '2020-01-01 03:23:07'),
(164, 'Anto', 'peserta', 31, '', '2020-01-01 03:19:49'),
(163, 'Anto', 'peserta', 31, 'hay', '2020-01-01 03:19:49'),
(162, 'Anto', 'peserta', 31, 'hello', '2020-01-01 03:19:10'),
(161, 'Anto', 'peserta', 31, 'y', '2020-01-01 02:46:38'),
(160, 'Soeyamto, SE', 'trainer', 31, 'hay', '2020-01-01 02:23:03'),
(159, 'Anto', 'peserta', 31, 'coba', '2020-01-01 02:20:55'),
(158, 'Anto', 'peserta', 31, 'hay', '2020-01-01 01:56:43'),
(157, 'Anto', 'peserta', 31, 'l', '2020-01-01 01:52:45'),
(156, 'Anto', 'peserta', 31, '', '2020-01-01 01:50:05'),
(177, 'Anto', 'peserta', 31, 'h', '2020-01-01 05:28:01'),
(178, 'Anto', 'peserta', 31, '', '2020-01-01 05:28:01'),
(179, 'Soeyamto, SE', 'trainer', 31, '', '2020-01-01 05:28:59'),
(180, 'Soeyamto, SE', 'trainer', 31, 'a', '2020-01-01 05:28:59'),
(181, 'Soeyamto, SE', 'trainer', 31, 'af', '2020-01-01 05:29:30'),
(182, 'Soeyamto, SE', 'trainer', 31, '', '2020-01-01 05:29:30'),
(183, 'Anto', 'peserta', 31, 'A', '2020-01-01 05:31:56'),
(184, 'Anto', 'peserta', 31, 'AD', '2020-01-01 05:33:20'),
(185, 'Anto', 'peserta', 31, '', '2020-01-01 05:33:20'),
(186, 'Anto', 'peserta', 31, 'JH', '2020-01-01 05:33:32'),
(187, 'Anto', 'peserta', 31, 'K', '2020-01-01 05:35:55'),
(188, 'Anto', 'peserta', 31, 'L', '2020-01-01 05:37:03'),
(189, 'Anto', 'peserta', 31, 'DA', '2020-01-01 05:38:44'),
(190, 'Anto', 'peserta', 31, 'I', '2020-01-01 05:39:38'),
(191, 'Anto', 'peserta', 31, 'A', '2020-01-01 05:40:32'),
(192, 'Soeyamto, SE', 'trainer', 31, 'DA', '2020-01-01 05:41:28'),
(193, 'Anto', 'peserta', 31, 'L', '2020-01-01 05:41:58'),
(194, 'Anto', 'peserta', 31, '', '2020-01-01 05:41:59'),
(195, 'Anto', 'peserta', 31, 'a', '2020-01-01 05:46:34'),
(196, 'Anto', 'peserta', 31, 'dna', '2020-01-01 05:47:35'),
(197, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 05:48:47'),
(198, 'Anto', 'peserta', 31, 'fs', '2020-01-01 05:49:28'),
(199, 'Soeyamto, SE', 'trainer', 31, 'ada', '2020-01-01 05:49:58'),
(200, 'Anto', 'peserta', 31, 'a', '2020-01-01 06:00:22'),
(201, 'Soeyamto, SE', 'trainer', 31, 'ad', '2020-01-01 06:00:49'),
(202, 'Anto', 'peserta', 31, 'daa', '2020-01-01 06:11:40'),
(203, 'Anto', 'peserta', 31, 'a', '2020-01-01 06:12:09'),
(204, 'Anto', 'peserta', 31, 'a', '2020-01-01 06:12:46'),
(205, 'Soeyamto, SE', 'trainer', 31, 'ad', '2020-01-01 06:13:24'),
(206, 'Anto', 'peserta', 31, 'a', '2020-01-01 06:16:33'),
(207, 'Anto', 'peserta', 31, 'da', '2020-01-01 06:20:48'),
(208, 'Soeyamto, SE', 'trainer', 31, 'a', '2020-01-01 06:21:04'),
(209, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 06:21:54'),
(210, 'Anto', 'peserta', 31, 'AA', '2020-01-01 06:22:22'),
(211, 'Soeyamto, SE', 'trainer', 31, 'ad', '2020-01-01 06:22:44'),
(212, 'Anto', 'peserta', 31, 'ad', '2020-01-01 06:23:26'),
(213, 'Anto', 'peserta', 31, 'ada', '2020-01-01 06:23:27'),
(214, 'Anto', 'peserta', 31, 'dadfe', '2020-01-01 06:23:29'),
(215, 'Anto', 'peserta', 31, 'cac', '2020-01-01 06:23:31'),
(216, 'Anto', 'peserta', 31, 'da', '2020-01-01 06:23:33'),
(217, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 06:24:56'),
(218, 'Anto', 'peserta', 31, 'da', '2020-01-01 06:25:58'),
(219, 'Anto', 'peserta', 31, 'adf', '2020-01-01 06:25:59'),
(220, 'Anto', 'peserta', 31, 'grt', '2020-01-01 06:26:00'),
(221, 'Anto', 'peserta', 31, 'eadf', '2020-01-01 06:26:01'),
(222, 'Anto', 'peserta', 31, 'fafa', '2020-01-01 06:26:02'),
(223, 'Soeyamto, SE', 'trainer', 31, 'a', '2020-01-01 06:26:29'),
(224, 'Soeyamto, SE', 'trainer', 31, 'ehhh si kamu', '2020-01-01 07:22:59'),
(225, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 08:28:57'),
(226, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 08:29:44'),
(227, 'Soeyamto, SE', 'trainer', 31, '', '2020-01-01 08:29:44'),
(228, 'Soeyamto, SE', 'trainer', 31, 'aa', '2020-01-01 08:29:56'),
(229, 'Soeyamto, SE', 'trainer', 31, 'coba', '2020-01-01 08:32:11'),
(230, 'Anto', 'peserta', 31, 'na', '2020-01-01 08:35:01'),
(231, 'Soeyamto, SE', 'trainer', 31, 'a', '2020-01-01 08:37:59'),
(232, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 08:46:45'),
(233, 'Soeyamto, SE', 'trainer', 31, '', '2020-01-01 08:46:45'),
(234, 'Soeyamto, SE', 'trainer', 31, 'dan', '2020-01-01 08:46:50'),
(235, 'Anto', 'peserta', 31, 'nama', '2020-01-01 08:57:16'),
(236, 'Anto', 'peserta', 31, '', '2020-01-01 08:58:03'),
(237, 'Anto', 'peserta', 31, 'kj', '2020-01-01 08:58:03'),
(238, 'Anto', 'peserta', 31, 'ul', '2020-01-01 08:58:44'),
(239, 'Soeyamto, SE', 'trainer', 31, 'a', '2020-01-01 08:59:55'),
(240, 'Soeyamto, SE', 'trainer', 31, '', '2020-01-01 08:59:55'),
(241, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 09:00:00'),
(242, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 09:01:57'),
(243, 'Anto', 'peserta', 31, 'gjhj', '2020-01-01 09:02:51'),
(244, 'Soeyamto, SE', 'trainer', 31, 'uo', '2020-01-01 09:05:53'),
(245, 'Soeyamto, SE', 'trainer', 31, 'hk', '2020-01-01 09:07:22'),
(246, 'Soeyamto, SE', 'trainer', 31, 'hj', '2020-01-01 09:08:09'),
(247, 'Soeyamto, SE', 'trainer', 31, 'kj]', '2020-01-01 09:08:34'),
(248, 'Soeyamto, SE', 'trainer', 31, 'da', '2020-01-01 20:38:50'),
(249, 'Soeyamto, SE', 'trainer', 31, 'masuk pesan?', '2020-01-04 20:58:46'),
(250, 'Soeyamto, SE', 'trainer', 31, 'iya', '2020-01-04 20:58:49'),
(251, 'Soeyamto, SE', 'trainer', 31, 'saya ingin tanya soal manajemen risiko', '2020-01-04 20:59:18'),
(252, 'Soeyamto, SE', 'trainer', 31, 'hai', '2020-01-06 01:19:54'),
(253, 'Soeyamto, SE', 'trainer', 31, 'hai ', '2020-01-06 01:23:30'),
(254, 'Soeyamto, SE', 'trainer', 31, 'saya coba chatnya', '2020-01-06 02:55:22'),
(255, 'Rezha Ranmark', 'peserta', 31, '0', '2020-01-07 01:01:28'),
(256, 'Anto', 'peserta', 31, 'da', '2020-01-07 01:02:39'),
(261, 'Ahmadi', 'peserta', 31, 'Pak Saya mau nanya ', '2020-01-07 03:01:13'),
(260, 'Ahmadi', 'peserta', 31, 'hai', '2020-01-07 02:58:37'),
(262, 'Rezha Ranmark', 'peserta', 31, 'tes', '2020-01-07 08:05:15'),
(263, 'Rezha Ranmark', 'peserta', 31, 'coba', '2020-01-07 08:14:46'),
(264, 'Anto', 'peserta', 31, 'tes', '2020-01-07 08:18:17'),
(265, 'Rezha Ranmark', 'peserta', 31, 'yuk', '2020-01-07 08:19:12'),
(266, 'Anto', 'peserta', 31, 'ok', '2020-01-07 08:19:47'),
(267, 'Ahmadi', 'peserta', 31, 'pagi', '2020-01-07 18:20:32'),
(268, 'Soeyamto, SE', 'trainer', 31, 'hhhkll', '2020-01-07 18:24:52'),
(269, 'Soeyamto, SE', 'trainer', 31, 'hsalo kawan', '2020-01-07 18:25:05'),
(270, 'Soeyamto, SE', 'trainer', 31, 'google.com ', '2020-01-07 18:25:43'),
(271, 'Ahmadi', 'peserta', 31, 'okkokokok', '2020-01-07 18:25:59'),
(272, 'Rezha Ranmark S,Kom', 'peserta', 31, 'haloo gaes', '2020-01-18 05:25:01'),
(273, 'Rezha Ranmark S,Kom', 'peserta', 31, 'pak , mau nanya soal nomor 1 maksudnya gimana pak', '2020-01-18 05:37:33'),
(274, 'Rezha Ranmark', 'peserta', 34, 'tes', '2020-01-31 22:10:07'),
(275, 'Peserta 018', 'peserta', 31, 'kenalin sama om donk ', '2020-02-03 06:38:30'),
(276, 'Peserta 011', 'peserta', 31, 'saya nomor 11', '2020-02-03 06:38:48'),
(277, 'Soeyamto, SE', 'trainer', 31, 'saya trainer', '2020-02-03 06:38:55'),
(278, 'Peserta 008', 'peserta', 31, 'hai ', '2020-02-03 06:38:57'),
(279, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(280, 'Peserta 020', 'peserta', 31, 'hayyyyy', '2020-02-03 06:38:59'),
(281, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(282, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(283, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(284, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(285, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(286, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:38:59'),
(287, 'Peserta 007', 'peserta', 31, 'Hai', '2020-02-03 06:39:04'),
(288, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:39:04'),
(289, 'Peserta 001', 'peserta', 31, 'Hai Peserta', '2020-02-03 06:39:04'),
(290, 'Peserta 017', 'peserta', 31, 'Hii', '2020-02-03 06:39:07'),
(291, 'Peserta 005', 'peserta', 31, 'Hay', '2020-02-03 06:39:09'),
(292, 'Peserta 020', 'peserta', 31, 'brooooo', '2020-02-03 06:39:10'),
(293, 'Peserta 019', 'peserta', 31, 'Hay ', '2020-02-03 06:39:14'),
(294, 'Peserta 019', 'peserta', 31, '', '2020-02-03 06:39:15'),
(295, 'Peserta 008', 'peserta', 31, 'hai', '2020-02-03 06:39:15'),
(296, 'Peserta 012', 'peserta', 31, 'saya nomor 12', '2020-02-03 06:39:16'),
(297, 'Peserta 018', 'peserta', 31, 'hay', '2020-02-03 06:39:18'),
(298, 'Peserta 018', 'peserta', 31, '', '2020-02-03 06:39:18'),
(299, 'Peserta 014', 'peserta', 31, 'Hai', '2020-02-03 06:39:19'),
(300, 'Peserta 002', 'peserta', 31, 'Hai ', '2020-02-03 06:39:19'),
(301, 'Peserta 010', 'peserta', 31, 'hai', '2020-02-03 06:39:24'),
(302, 'Peserta 003', 'peserta', 31, 'Hai', '2020-02-03 06:39:28'),
(303, 'Peserta 006', 'peserta', 31, 'hay', '2020-02-03 06:39:28'),
(304, 'Peserta 003', 'peserta', 31, '', '2020-02-03 06:39:28'),
(305, 'Peserta 016', 'peserta', 31, 'Assalamualaikum', '2020-02-03 06:39:31'),
(306, 'Peserta 016', 'peserta', 31, '', '2020-02-03 06:39:31'),
(307, 'Peserta 007', 'peserta', 31, 'Coba', '2020-02-03 06:39:31'),
(308, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:39:31'),
(309, 'Soeyamto, SE', 'trainer', 31, 'trainer', '2020-02-03 06:39:34'),
(310, 'Peserta 004', 'peserta', 31, 'hay', '2020-02-03 06:39:34'),
(311, 'Peserta 009', 'peserta', 31, 'hello word', '2020-02-03 06:39:36'),
(312, 'Peserta 008', 'peserta', 31, 'hai', '2020-02-03 06:39:38'),
(313, 'Peserta 017', 'peserta', 31, 'haii', '2020-02-03 06:39:42'),
(314, 'Peserta 017', 'peserta', 31, '', '2020-02-03 06:39:42'),
(315, 'Peserta 009', 'peserta', 31, 'typo', '2020-02-03 06:39:43'),
(316, 'Peserta 008', 'peserta', 31, 'panitia', '2020-02-03 06:39:46'),
(317, 'Peserta 013', 'peserta', 31, 'Hallo', '2020-02-03 06:39:49'),
(318, 'Peserta 013', 'peserta', 31, '', '2020-02-03 06:39:49'),
(319, 'Peserta 020', 'peserta', 31, 'hayyyii', '2020-02-03 06:39:51'),
(320, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:39:51'),
(321, 'Peserta 007', 'peserta', 31, 'Saya 20', '2020-02-03 06:39:53'),
(322, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:39:53'),
(323, 'Peserta 015', 'peserta', 31, '', '2020-02-03 06:39:57'),
(324, 'Peserta 015', 'peserta', 31, 'Saya 15', '2020-02-03 06:39:57'),
(325, 'Peserta 020', 'peserta', 31, 'saya 20', '2020-02-03 06:40:04'),
(326, 'Peserta 008', 'peserta', 31, 'saya ', '2020-02-03 06:40:11'),
(327, 'Peserta 007', 'peserta', 31, 'Haiii', '2020-02-03 06:40:17'),
(328, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:40:17'),
(329, 'Peserta 020', 'peserta', 31, 'saya 21', '2020-02-03 06:40:17'),
(330, 'Peserta 009', 'peserta', 31, 'abdi maung', '2020-02-03 06:40:20'),
(331, 'Peserta 020', 'peserta', 31, 'saya22', '2020-02-03 06:40:25'),
(332, 'Peserta 008', 'peserta', 31, 'saya 20', '2020-02-03 06:40:39'),
(333, 'Peserta 011', 'peserta', 31, 'saya nomor 11', '2020-02-03 06:40:40'),
(334, 'Soeyamto, SE', 'trainer', 31, 'bos ku', '2020-02-03 06:40:42'),
(335, 'Peserta 007', 'peserta', 31, 'Saya 77', '2020-02-03 06:40:46'),
(336, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:40:46'),
(337, 'Peserta 007', 'peserta', 31, 'Saya 7', '2020-02-03 06:40:54'),
(338, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:40:54'),
(339, 'Peserta 020', 'peserta', 31, 'okok', '2020-02-03 06:40:55'),
(340, 'Peserta 020', 'peserta', 31, 'okaok', '2020-02-03 06:41:00'),
(341, 'Peserta 020', 'peserta', 31, 'okok', '2020-02-03 06:41:02'),
(342, 'Peserta 020', 'peserta', 31, '21', '2020-02-03 06:41:07'),
(343, 'Peserta 008', 'peserta', 31, 'saya siapa ', '2020-02-03 06:41:08'),
(344, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:14'),
(345, 'Peserta 007', 'peserta', 31, 'Normal teu', '2020-02-03 06:41:14'),
(346, 'Peserta 014', 'peserta', 31, 'Assalamualaikum ', '2020-02-03 06:41:15'),
(347, 'Peserta 012', 'peserta', 31, 'saya 12', '2020-02-03 06:41:18'),
(348, 'Peserta 019', 'peserta', 31, 'Hay', '2020-02-03 06:41:25'),
(349, 'Peserta 019', 'peserta', 31, '', '2020-02-03 06:41:25'),
(350, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:34'),
(351, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:34'),
(352, 'Peserta 020', 'peserta', 31, 'saya', '2020-02-03 06:41:35'),
(353, 'Peserta 005', 'peserta', 31, '', '2020-02-03 06:41:37'),
(354, 'Peserta 005', 'peserta', 31, '', '2020-02-03 06:41:37'),
(355, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:38'),
(356, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:38'),
(357, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:41:38'),
(358, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:41:38'),
(359, 'Peserta 018', 'peserta', 31, 'hay', '2020-02-03 06:41:39'),
(360, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:40'),
(361, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:40'),
(362, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:41'),
(363, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:41'),
(364, 'Peserta 009', 'peserta', 31, '', '2020-02-03 06:41:42'),
(365, 'Peserta 009', 'peserta', 31, '', '2020-02-03 06:41:42'),
(366, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:42'),
(367, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:42'),
(368, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:42'),
(369, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:42'),
(370, 'Soeyamto, SE', 'trainer', 31, '', '2020-02-03 06:41:42'),
(371, 'Soeyamto, SE', 'trainer', 31, '', '2020-02-03 06:41:42'),
(372, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(373, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(374, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(375, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(376, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(377, 'Peserta 007', 'peserta', 31, '', '2020-02-03 06:41:43'),
(378, 'Peserta 009', 'peserta', 31, '', '2020-02-03 06:41:43'),
(379, 'Peserta 009', 'peserta', 31, '', '2020-02-03 06:41:43'),
(380, 'Peserta 019', 'peserta', 31, 'Hay', '2020-02-03 06:41:47'),
(381, 'Soeyamto, SE', 'trainer', 31, '', '2020-02-03 06:41:50'),
(382, 'Soeyamto, SE', 'trainer', 31, '', '2020-02-03 06:41:50'),
(383, 'Peserta 006', 'peserta', 31, '', '2020-02-03 06:41:52'),
(384, 'Peserta 006', 'peserta', 31, '', '2020-02-03 06:41:52'),
(385, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:41:58'),
(386, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:41:58'),
(387, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:08'),
(388, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:08'),
(389, 'Soeyamto, SE', 'trainer', 31, 'test butt', '2020-02-03 06:42:10'),
(390, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:12'),
(391, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:12'),
(392, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:42:12'),
(393, 'Peserta 020', 'peserta', 31, '', '2020-02-03 06:42:12'),
(394, 'Peserta 011', 'peserta', 31, '', '2020-02-03 06:42:13'),
(395, 'Peserta 011', 'peserta', 31, 'saya 11', '2020-02-03 06:42:13'),
(396, 'Peserta 007', 'peserta', 31, 'Hai', '2020-02-03 06:42:13'),
(397, 'Peserta 010', 'peserta', 31, 'hai', '2020-02-03 06:42:14'),
(398, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:18'),
(399, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:18'),
(400, 'Peserta 009', 'peserta', 31, 'abdi maung', '2020-02-03 06:42:21'),
(401, 'Peserta 009', 'peserta', 31, '', '2020-02-03 06:42:21'),
(402, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:21'),
(403, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:21'),
(404, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:23'),
(405, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:23'),
(406, 'Peserta 010', 'peserta', 31, '', '2020-02-03 06:42:24'),
(407, 'Peserta 010', 'peserta', 31, 'tes', '2020-02-03 06:42:24'),
(408, 'Peserta 018', 'peserta', 31, 'ikut sama om yuk', '2020-02-03 06:42:41'),
(409, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:58'),
(410, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:42:58'),
(411, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:43:00'),
(412, 'Peserta 008', 'peserta', 31, '', '2020-02-03 06:43:00'),
(413, 'Peserta 014', 'peserta', 31, 'Kemana', '2020-02-03 06:43:10'),
(414, 'Peserta 01A', 'peserta', 31, 'hai.. salam kenal', '2020-02-16 21:19:05'),
(415, 'Peserta 01A', 'peserta', 31, 'Selamat malam, ijin bertanya, untuk slide pada bab 4 dan 4a memang sama ya bpk/ibu? Trimakasih  ', '2020-02-20 08:10:11'),
(416, 'Peserta 01A', 'peserta', 31, '', '2020-02-20 08:10:11'),
(417, 'Peserta 01A', 'peserta', 31, '', '2020-02-20 20:07:50'),
(418, 'Peserta 01A', 'peserta', 31, 'Selamat Pagi Bpk/Ibu, untuk tes pada bab 3, nomor 1, apakah jawabannya memang a? tirmakasih', '2020-02-20 20:07:50'),
(419, 'Soeyamto, SE', 'trainer', 31, 'Menjawab pertanyaan Peserta 01A 20 February 2020 - 22:10 ', '2020-02-21 06:59:23'),
(420, 'Soeyamto, SE', 'trainer', 31, 'Iya soal no.4 dan 4a itu sama , slidenya sama , cuma Video nya saja yang dibagi menjadi 2 ', '2020-02-21 07:00:21'),
(421, 'Soeyamto, SE', 'trainer', 31, 'Menjawab pertanyaan Peserta 01A 21 February 2020 -10:07 ', '2020-02-21 07:01:29'),
(422, 'Soeyamto, SE', 'trainer', 31, 'JAwabannya bener A', '2020-02-21 07:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `tr_mapel_notif`
--

CREATE TABLE `tr_mapel_notif` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `notif` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table `tr_mapel_notif`
--

INSERT INTO `tr_mapel_notif` (`id`, `id_mapel`, `id_user`, `notif`) VALUES
(1, 31, 22, 0),
(39, 31, 56, 4),
(38, 31, 53, 4),
(37, 34, 38, 4),
(36, 31, 44, 4),
(35, 31, 38, 4),
(34, 31, 41, 0),
(32, 31, 37, 4),
(33, 31, 35, 4),
(40, 31, 55, 4),
(41, 31, 57, 4),
(42, 31, 54, 4),
(43, 31, 61, 4),
(44, 31, 63, 4),
(45, 31, 46, 4),
(46, 31, 47, 4),
(47, 31, 52, 4),
(48, 31, 65, 4),
(49, 31, 50, 4),
(50, 31, 62, 4),
(51, 31, 51, 4),
(52, 31, 58, 4),
(53, 31, 48, 4),
(54, 31, 60, 4),
(55, 31, 59, 4),
(56, 31, 64, 4),
(57, 31, 49, 4),
(58, 34, 48, 4),
(59, 34, 53, 4),
(60, 34, 55, 4),
(61, 34, 49, 4),
(62, 34, 63, 4),
(63, 34, 58, 4),
(64, 34, 66, 4),
(65, 34, 46, 4),
(66, 31, 66, 4),
(67, 31, 66, 4),
(68, 31, 67, 4),
(69, 34, 22, 4),
(70, 34, 71, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_token`
--
ALTER TABLE `akses_token`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_admin`
--
ALTER TABLE `m_admin`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kon_id` (`kon_id`) USING BTREE;

--
-- Indexes for table `m_guru`
--
ALTER TABLE `m_guru`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_laporan`
--
ALTER TABLE `m_laporan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_mapel`
--
ALTER TABLE `m_mapel`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_materi`
--
ALTER TABLE `m_materi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_soal`
--
ALTER TABLE `m_soal`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_guru` (`id_guru`) USING BTREE,
  ADD KEY `id_mapel` (`id_mapel`) USING BTREE;

--
-- Indexes for table `m_soal_penilaian`
--
ALTER TABLE `m_soal_penilaian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_paket` (`id_paket`) USING BTREE;

--
-- Indexes for table `m_soal_ujian`
--
ALTER TABLE `m_soal_ujian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_ujian` (`id_ujian`) USING BTREE;

--
-- Indexes for table `m_soal_ujian_essay`
--
ALTER TABLE `m_soal_ujian_essay`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_ujian` (`id_ujian`) USING BTREE;

--
-- Indexes for table `rule_users`
--
ALTER TABLE `rule_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK__menu` (`id_menu`) USING BTREE,
  ADD KEY `FK__level` (`id_level`) USING BTREE;

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE;

--
-- Indexes for table `tb_admin_lembaga`
--
ALTER TABLE `tb_admin_lembaga`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_akun_lembaga`
--
ALTER TABLE `tb_akun_lembaga`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_block_materi`
--
ALTER TABLE `tb_block_materi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_detail_kelas`
--
ALTER TABLE `tb_detail_kelas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_kelas` (`id_kelas`) USING BTREE,
  ADD KEY `id_peserta` (`id_peserta`) USING BTREE;

--
-- Indexes for table `tb_dimensi`
--
ALTER TABLE `tb_dimensi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_ikut_penilaian`
--
ALTER TABLE `tb_ikut_penilaian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tes` (`id_penilaian`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tb_ikut_penilaian_pertama`
--
ALTER TABLE `tb_ikut_penilaian_pertama`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_ikut_ujian`
--
ALTER TABLE `tb_ikut_ujian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tes` (`id_ujian`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tb_ikut_ujian_essay`
--
ALTER TABLE `tb_ikut_ujian_essay`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tes` (`id_ujian`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tb_ikut_ujian_essay_pertama`
--
ALTER TABLE `tb_ikut_ujian_essay_pertama`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_ikut_ujian_pertama`
--
ALTER TABLE `tb_ikut_ujian_pertama`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_instansi`
--
ALTER TABLE `tb_instansi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_jawaban_essay`
--
ALTER TABLE `tb_jawaban_essay`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_instansi` (`id_instansi`) USING BTREE;

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_komen_materi`
--
ALTER TABLE `tb_komen_materi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_materi_instansi`
--
ALTER TABLE `tb_materi_instansi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_notifikasi_forum`
--
ALTER TABLE `tb_notifikasi_forum`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_paket_soal`
--
ALTER TABLE `tb_paket_soal`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_penilaian`
--
ALTER TABLE `tb_penilaian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_kelas` (`id_kelas`) USING BTREE;

--
-- Indexes for table `tb_rank`
--
ALTER TABLE `tb_rank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_setting`
--
ALTER TABLE `tb_setting`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_setting_instansi`
--
ALTER TABLE `tb_setting_instansi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_slider`
--
ALTER TABLE `tb_slider`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tugas` (`id_instansi`) USING BTREE;

--
-- Indexes for table `tb_sub_menu`
--
ALTER TABLE `tb_sub_menu`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE;

--
-- Indexes for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tb_tugas_attachment`
--
ALTER TABLE `tb_tugas_attachment`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tugas` (`id_tugas`) USING BTREE;

--
-- Indexes for table `tb_tugas_attachment_siswa`
--
ALTER TABLE `tb_tugas_attachment_siswa`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tugas` (`id_tugas`) USING BTREE;

--
-- Indexes for table `tb_tugas_nilai`
--
ALTER TABLE `tb_tugas_nilai`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tugas` (`id_tugas`) USING BTREE;

--
-- Indexes for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_kelas` (`id_kelas`) USING BTREE;

--
-- Indexes for table `tr_guru_mapel`
--
ALTER TABLE `tr_guru_mapel`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_guru` (`id_guru`) USING BTREE,
  ADD KEY `id_mapel` (`id_mapel`) USING BTREE;

--
-- Indexes for table `tr_guru_tes`
--
ALTER TABLE `tr_guru_tes`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_guru` (`id_guru`) USING BTREE,
  ADD KEY `id_mapel` (`id_mapel`) USING BTREE;

--
-- Indexes for table `tr_ikut_ujian`
--
ALTER TABLE `tr_ikut_ujian`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_tes` (`id_tes`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tr_ikut_ujian_pertama`
--
ALTER TABLE `tr_ikut_ujian_pertama`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tr_mapel_chat`
--
ALTER TABLE `tr_mapel_chat`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tr_mapel_notif`
--
ALTER TABLE `tr_mapel_notif`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_token`
--
ALTER TABLE `akses_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `m_admin`
--
ALTER TABLE `m_admin`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=706;

--
-- AUTO_INCREMENT for table `m_guru`
--
ALTER TABLE `m_guru`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `m_laporan`
--
ALTER TABLE `m_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=930;

--
-- AUTO_INCREMENT for table `m_mapel`
--
ALTER TABLE `m_mapel`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `m_materi`
--
ALTER TABLE `m_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `m_siswa`
--
ALTER TABLE `m_siswa`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=604;

--
-- AUTO_INCREMENT for table `m_soal`
--
ALTER TABLE `m_soal`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_soal_penilaian`
--
ALTER TABLE `m_soal_penilaian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `m_soal_ujian`
--
ALTER TABLE `m_soal_ujian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `m_soal_ujian_essay`
--
ALTER TABLE `m_soal_ujian_essay`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rule_users`
--
ALTER TABLE `rule_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_admin_lembaga`
--
ALTER TABLE `tb_admin_lembaga`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `tb_akun_lembaga`
--
ALTER TABLE `tb_akun_lembaga`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=545;

--
-- AUTO_INCREMENT for table `tb_block_materi`
--
ALTER TABLE `tb_block_materi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_detail_kelas`
--
ALTER TABLE `tb_detail_kelas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `tb_dimensi`
--
ALTER TABLE `tb_dimensi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_ikut_penilaian`
--
ALTER TABLE `tb_ikut_penilaian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_ikut_penilaian_pertama`
--
ALTER TABLE `tb_ikut_penilaian_pertama`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_ikut_ujian`
--
ALTER TABLE `tb_ikut_ujian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_ikut_ujian_essay`
--
ALTER TABLE `tb_ikut_ujian_essay`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_ikut_ujian_essay_pertama`
--
ALTER TABLE `tb_ikut_ujian_essay_pertama`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_ikut_ujian_pertama`
--
ALTER TABLE `tb_ikut_ujian_pertama`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_instansi`
--
ALTER TABLE `tb_instansi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_jawaban_essay`
--
ALTER TABLE `tb_jawaban_essay`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tb_komen_materi`
--
ALTER TABLE `tb_komen_materi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_materi_instansi`
--
ALTER TABLE `tb_materi_instansi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_notifikasi_forum`
--
ALTER TABLE `tb_notifikasi_forum`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_paket_soal`
--
ALTER TABLE `tb_paket_soal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_penilaian`
--
ALTER TABLE `tb_penilaian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_rank`
--
ALTER TABLE `tb_rank`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_setting`
--
ALTER TABLE `tb_setting`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_setting_instansi`
--
ALTER TABLE `tb_setting_instansi`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_slider`
--
ALTER TABLE `tb_slider`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_sub_menu`
--
ALTER TABLE `tb_sub_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_tugas_attachment`
--
ALTER TABLE `tb_tugas_attachment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_tugas_attachment_siswa`
--
ALTER TABLE `tb_tugas_attachment_siswa`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tb_tugas_nilai`
--
ALTER TABLE `tb_tugas_nilai`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tr_guru_mapel`
--
ALTER TABLE `tr_guru_mapel`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tr_guru_tes`
--
ALTER TABLE `tr_guru_tes`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_ikut_ujian`
--
ALTER TABLE `tr_ikut_ujian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tr_ikut_ujian_pertama`
--
ALTER TABLE `tr_ikut_ujian_pertama`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tr_mapel_chat`
--
ALTER TABLE `tr_mapel_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT for table `tr_mapel_notif`
--
ALTER TABLE `tr_mapel_notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_soal_ujian`
--
ALTER TABLE `m_soal_ujian`
  ADD CONSTRAINT `m_soal_ujian_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `tb_ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_soal_ujian_essay`
--
ALTER TABLE `m_soal_ujian_essay`
  ADD CONSTRAINT `m_soal_ujian_essay_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `tb_ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rule_users`
--
ALTER TABLE `rule_users`
  ADD CONSTRAINT `FK__level` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK__menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_detail_kelas`
--
ALTER TABLE `tb_detail_kelas`
  ADD CONSTRAINT `id_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_peserta` FOREIGN KEY (`id_peserta`) REFERENCES `m_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD CONSTRAINT `tb_jurusan_ibfk_1` FOREIGN KEY (`id_instansi`) REFERENCES `tb_instansi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_penilaian`
--
ALTER TABLE `tb_penilaian`
  ADD CONSTRAINT `tb_penilaian_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_slider`
--
ALTER TABLE `tb_slider`
  ADD CONSTRAINT `tb_slider_ibfk_1` FOREIGN KEY (`id_instansi`) REFERENCES `tb_instansi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_sub_menu`
--
ALTER TABLE `tb_sub_menu`
  ADD CONSTRAINT `tb_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tugas_attachment`
--
ALTER TABLE `tb_tugas_attachment`
  ADD CONSTRAINT `id_tugas` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tugas_attachment_siswa`
--
ALTER TABLE `tb_tugas_attachment_siswa`
  ADD CONSTRAINT `tb_tugas_attachment_siswa_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tugas_nilai`
--
ALTER TABLE `tb_tugas_nilai`
  ADD CONSTRAINT `tb_tugas_nilai_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  ADD CONSTRAINT `tb_ujian_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
