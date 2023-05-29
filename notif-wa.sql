-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2023 at 06:28 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notif-wa`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` varchar(25) NOT NULL,
  `dari` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `waktu` datetime NOT NULL,
  `menit_sebelum_notif` double NOT NULL,
  `notif_ke` int(5) NOT NULL,
  `jenis_agenda` enum('public','private') NOT NULL,
  `id_biodata` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `dari`, `deskripsi`, `waktu`, `menit_sebelum_notif`, `notif_ke`, `jenis_agenda`, `id_biodata`) VALUES
('AGE1665747969458', 'yayasan', 'keterangan yayasan', '2022-11-03 21:00:00', 4, 3, 'public', 'BIO6555'),
('AGE1665749969459', 'diknas', 'tentang panitia ukk', '2022-11-03 21:00:00', 5, 1, 'public', 'BIO6551'),
('AGE1665837618417', 'yayasan', 'percobaan undangan yayasan', '2022-11-03 21:00:00', 3, 1, 'public', 'BIO6545'),
('AGE1665841577141', 'cabdin', 'ket cabdin', '2022-11-03 21:00:00', 25, 1, 'public', 'BIO6545'),
('AGE1665841613006', 'cabdin', 'ket cabdin kepala sekolah', '2022-11-03 21:00:00', 20, 1, 'public', 'BIO6551');

-- --------------------------------------------------------

--
-- Stand-in structure for view `akses`
-- (See below for the actual view)
--
CREATE TABLE `akses` (
`id` char(25)
,`nama` mediumtext
,`password` mediumtext
,`level` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `biodata`
--

CREATE TABLE `biodata` (
  `id` char(25) NOT NULL,
  `nama` text NOT NULL,
  `kelahiran` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `no_telp` varchar(25) NOT NULL,
  `id_lembaga` char(5) NOT NULL,
  `id_jabatan` char(5) NOT NULL,
  `aktif` char(5) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biodata`
--

INSERT INTO `biodata` (`id`, `nama`, `kelahiran`, `tgl_lahir`, `jenis_kelamin`, `no_telp`, `id_lembaga`, `id_jabatan`, `aktif`, `password`) VALUES
('BIO1665580449263', 'mohammad farih smp01jombang', 'jombang', '2022-10-14', 'Laki-Laki', '6289676041493', '57027', '57069', 'aktif', '$2y$10$9ozBQau7nuvkMWXGZmuIIuRkqHTy/6Z1bcNPFYMKDFPwSq2yXG1Xi'),
('BIO5167', 'telkom operator', 'jombang', '2022-10-23', 'Laki-Laki', '6289676041493', '10003', '57069', 'aktif', '$2y$10$cq1lEbg1f/RPTROneidaIe/hM9IYtdtKNvJmrXvh18nMI8TGtBM4O'),
('BIO6545', 'Operator SMK TI Ann', 'jombang', '2000-10-13', 'Laki-Laki', '6289676041493', '10002', '57069', 'aktif', '$2y$10$49Tu.xowsBzr3yzUWBpK0OOnC/3qCXjfUs53/c.eydfv3y1T6ohYG'),
('BIO6551', 'faqih smp01jombang', 'jombang', '2000-10-13', 'Laki-Laki', '6289676041493', '57027', '57065', 'aktif', ''),
('BIO6555', 'ali smp01jombang', 'jombang', '2022-10-13', 'Laki-Laki', '6289676041493', '57027', '57066', 'aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` char(5) NOT NULL,
  `nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`) VALUES
('57065', 'Kepala Sekolah'),
('57066', 'Wa.Ka. Kurikulum'),
('57067', 'Wa.Ka. Kesiswaan'),
('57069', 'Operator'),
('57070', 'Wa.Ka. Humas');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga`
--

CREATE TABLE `lembaga` (
  `id` char(5) NOT NULL,
  `nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lembaga`
--

INSERT INTO `lembaga` (`id`, `nama`) VALUES
('10002', 'SMK TI Annajiyah BU Jombang'),
('10003', 'SMK Telkom Jombang update'),
('57027', 'SMP 01 Jombang');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` char(25) NOT NULL,
  `nama` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `nama`, `password`) VALUES
('872054', 'admin mohammad zuz ubaidillah', '$2y$10$9ozBQau7nuvkMWXGZmuIIuRkqHTy/6Z1bcNPFYMKDFPwSq2yXG1Xi');

-- --------------------------------------------------------

--
-- Structure for view `akses`
--
DROP TABLE IF EXISTS `akses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `akses`  AS SELECT `super_admin`.`id` AS `id`, `super_admin`.`nama` AS `nama`, `super_admin`.`password` AS `password`, 'superadmin' AS `level` FROM `super_admin` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
