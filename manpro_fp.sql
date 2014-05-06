-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2014 at 09:13 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `manpro_fp`
--
CREATE DATABASE IF NOT EXISTS `manpro_fp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `manpro_fp`;

-- --------------------------------------------------------

--
-- Table structure for table `asistensi`
--

CREATE TABLE IF NOT EXISTS `asistensi` (
  `nim` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  UNIQUE KEY `jadwal_id` (`jadwal_id`),
  KEY `nim` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE IF NOT EXISTS `dosen` (
  `dosen_id` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  PRIMARY KEY (`dosen_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `historycal_note`
--

CREATE TABLE IF NOT EXISTS `historycal_note` (
  `hn_id` int(11) NOT NULL DEFAULT '0',
  `semester` varchar(10) NOT NULL,
  `tahun_ajar` varchar(10) NOT NULL,
  `note` varchar(100) NOT NULL,
  `nim` int(11) NOT NULL,
  `dosen_id` varchar(10) NOT NULL,
  `mk_id` varchar(8) NOT NULL,
  PRIMARY KEY (`hn_id`),
  KEY `nim` (`nim`,`dosen_id`,`mk_id`),
  KEY `dosen_id` (`dosen_id`),
  KEY `mk_id` (`mk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE IF NOT EXISTS `jadwal` (
  `jadwal_id` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `waktu` varchar(10) NOT NULL,
  `jenis` varchar(10) NOT NULL DEFAULT 'Pratikum',
  `ruang` varchar(8) NOT NULL,
  `grup` varchar(2) NOT NULL,
  `mk_id` varchar(10) NOT NULL,
  PRIMARY KEY (`jadwal_id`),
  KEY `mk_id` (`mk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `koordinator`
--

CREATE TABLE IF NOT EXISTS `koordinator` (
  `koor_id` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  PRIMARY KEY (`koor_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `koordinator`
--

INSERT INTO `koordinator` (`koor_id`, `nama`, `email`, `user_id`) VALUES
('Admin01', 'Mimin 01', 'admin01@dummy.com', 'Admin01'),
('Admin02', 'Mimin 02', 'admin02@dummy.com', 'Admin02');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `nim` int(8) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  PRIMARY KEY (`nim`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE IF NOT EXISTS `matakuliah` (
  `mk_id` varchar(8) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `sks` int(2) NOT NULL,
  PRIMARY KEY (`mk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE IF NOT EXISTS `pengumuman` (
  `note_id` int(11) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  `isi` varchar(100) NOT NULL,
  `koor_id` varchar(10) NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `koor_id` (`koor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `password`, `user_type`) VALUES
('71110061', '746fef5972309cb2cd432f4feb2e1cf7', 2),
('71110150', '7213a5d7d54d0845a2cd3b71d0f64b00', 2),
('Admin01', '798ebdec9075ffce12517800b7eb6179', 0),
('Admin02', '6fdc43db03afcd1b13158b605a68f83b', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asistensi`
--
ALTER TABLE `asistensi`
  ADD CONSTRAINT `jadwal_assist` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`jadwal_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `user_as_dosen` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `historycal_note`
--
ALTER TABLE `historycal_note`
  ADD CONSTRAINT `note_of` FOREIGN KEY (`mk_id`) REFERENCES `matakuliah` (`mk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_for` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_from` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`dosen_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_for` FOREIGN KEY (`mk_id`) REFERENCES `matakuliah` (`mk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `koordinator`
--
ALTER TABLE `koordinator`
  ADD CONSTRAINT `user_as_koor` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `user_as_mhs` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `koor_note` FOREIGN KEY (`koor_id`) REFERENCES `koordinator` (`koor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
