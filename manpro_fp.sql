-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2014 at 01:54 PM
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
-- Table structure for table `ampu`
--

CREATE TABLE IF NOT EXISTS `ampu` (
  `dosen_id` varchar(10) NOT NULL,
  `mk_id` varchar(8) NOT NULL,
  KEY `mk_id` (`mk_id`),
  KEY `dosen_id` (`dosen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ampu`
--

INSERT INTO `ampu` (`dosen_id`, `mk_id`) VALUES
('TI090001', 'TIW015');

-- --------------------------------------------------------

--
-- Table structure for table `asistensi`
--

CREATE TABLE IF NOT EXISTS `asistensi` (
  `nim` varchar(11) NOT NULL,
  `jadwal_id` varchar(10) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'diproses',
  KEY `nim` (`nim`),
  KEY `jadwal_id` (`jadwal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asistensi`
--

INSERT INTO `asistensi` (`nim`, `jadwal_id`, `status`) VALUES
('71110061', '12LabA', 'diproses'),
('71110150', '12LabA', 'diproses'),
('71110150', '51LabA', 'diproses');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE IF NOT EXISTS `dosen` (
  `dosen_id` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_hp` varchar(15) NOT NULL DEFAULT '-',
  `user_id` varchar(30) NOT NULL,
  `pp` varchar(100) NOT NULL DEFAULT 'images/users/no-image.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`dosen_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`dosen_id`, `nama`, `email`, `no_hp`, `user_id`, `pp`, `status`) VALUES
('TI090001', 'Mr. Dosen Serba Bisa, S.Pk, M.Pr 	', 'nama_dosen@ti.ukdw.ac.id', '-', 'TI090001', 'images/users/no-image.jpg', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `historycal_note`
--

CREATE TABLE IF NOT EXISTS `historycal_note` (
  `hn_id` int(11) NOT NULL DEFAULT '0',
  `semester` varchar(10) NOT NULL,
  `tahun_ajar` varchar(10) NOT NULL,
  `note` varchar(100) NOT NULL,
  `nim` varchar(11) NOT NULL,
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
  `jadwal_id` varchar(10) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `waktu` time NOT NULL,
  `jenis` varchar(10) NOT NULL DEFAULT 'Praktikum',
  `ruang` varchar(8) NOT NULL,
  `grup` varchar(2) NOT NULL,
  `mk_id` varchar(10) NOT NULL,
  PRIMARY KEY (`jadwal_id`),
  KEY `mk_id` (`mk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `hari`, `waktu`, `jenis`, `ruang`, `grup`, `mk_id`) VALUES
('12LabA', 'Senin', '11:30:00', 'Praktikum', 'Lab. A', 'A', 'TIW015'),
('51LabA', 'Jumat', '07:30:00', 'Praktikum', 'Lab. A', 'A', 'TIW015');

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
  UNIQUE KEY `user_id` (`user_id`)
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
  `nim` varchar(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `pp` varchar(100) NOT NULL DEFAULT 'images/users/no-image.jpg',
  `transkrip` varchar(100) NOT NULL DEFAULT 'images/users/no-image.jpg',
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `gender`, `no_hp`, `email`, `user_id`, `pp`, `transkrip`) VALUES
('71110061', 'Andy Kurniawan', 'Laki-laki', '+6285729867666', 'andy_kurniawan@live.com', '71110061', 'images/users/no-image.jpg', 'images/users/no-image.jpg'),
('71110101', 'Dummy Char', '', '+6289693431443', 'dummy@char.com', '71110101', 'images/users/no-image.jpg', 'images/users/no-image.jpg'),
('71110102', 'Dummy Char2', '', '', 'dummy@char2.com', '71110102', 'images/users/no-image.jpg', 'images/users/no-image.jpg'),
('71110150', 'Yesaya Kristian Niko', 'Laki-laki', '+6289693431443', 'rhaynick@live.com', '71110150', 'images/users/no-image.jpg', 'images/users/no-image.jpg');

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

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`mk_id`, `nama`, `sks`) VALUES
('TIW015', 'Teknologi Komputer', 5),
('TIW099', 'Dummy MK', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE IF NOT EXISTS `pengumuman` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `isi` varchar(1000) NOT NULL,
  `koor_id` varchar(10) NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `koor_id` (`koor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`note_id`, `tanggal`, `isi`, `koor_id`) VALUES
(1, '2014-05-14', 'Asistensi UKDW versi Closed Beta', 'Admin01'),
(4, '2014-05-15', 'Final release untuk situs ini akan dilaksanakan pada akhir Juni 2014 yaaa.', 'Admin02'),
(7, '2014-05-18', 'Dibutuhkan beta tester berpengalaman.', 'Admin01');

-- --------------------------------------------------------

--
-- Table structure for table `recent_activity`
--

CREATE TABLE IF NOT EXISTS `recent_activity` (
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aktivis` varchar(30) NOT NULL,
  `aktivitas` varchar(100) NOT NULL,
  PRIMARY KEY (`waktu`),
  KEY `aktivis` (`aktivis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recent_activity`
--

INSERT INTO `recent_activity` (`waktu`, `aktivis`, `aktivitas`) VALUES
('2014-05-14 16:48:32', 'Admin01', 'menambahkan pengumuman baru.'),
('2014-05-14 17:25:58', 'Admin02', 'menambahkan pengumuman baru.'),
('2014-05-18 02:20:28', 'Admin01', 'menambahkan pengumuman baru.'),
('2014-05-19 08:16:37', '71110150', 'membatalkan asistensi.'),
('2014-05-19 08:27:19', '71110150', 'mendaftar asistensi.'),
('2014-05-19 08:27:56', '71110150', 'mendaftar asistensi.'),
('2014-05-19 08:29:12', '71110150', 'mendaftar asistensi.'),
('2014-05-19 08:29:18', '71110150', 'membatalkan asistensi.'),
('2014-05-19 08:33:22', '71110150', 'mendaftar asistensi.'),
('2014-05-19 08:33:47', '71110150', 'membatalkan asistensi.'),
('2014-05-19 08:33:50', '71110150', 'mendaftar asistensi.'),
('2014-05-24 09:40:20', 'TI090001', 'menolak asisteni mahasiswa.'),
('2014-05-24 10:56:06', '71110150', 'membatalkan asistensi.'),
('2014-05-24 10:56:10', '71110150', 'mendaftar asistensi.'),
('2014-05-24 10:56:11', '71110150', 'membatalkan asistensi.'),
('2014-05-24 10:56:13', '71110150', 'mendaftar asistensi.');

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
('71110101', 'd41d8cd98f00b204e9800998ecf8427e', 2),
('71110102', '5830a6005e09cd3bff964a5878116f3f', 2),
('71110150', '7213a5d7d54d0845a2cd3b71d0f64b00', 2),
('Admin01', '798ebdec9075ffce12517800b7eb6179', 0),
('Admin02', '6fdc43db03afcd1b13158b605a68f83b', 0),
('TI090001', '92c766f35c324142e1ccf15667bf6475', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ampu`
--
ALTER TABLE `ampu`
  ADD CONSTRAINT `mengampu` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`dosen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diampu` FOREIGN KEY (`mk_id`) REFERENCES `matakuliah` (`mk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asistensi`
--
ALTER TABLE `asistensi`
  ADD CONSTRAINT `jadwal_assist` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`jadwal_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mhs_asist` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `user_as_dosen` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `historycal_note`
--
ALTER TABLE `historycal_note`
  ADD CONSTRAINT `note_for` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_from` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`dosen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_of` FOREIGN KEY (`mk_id`) REFERENCES `matakuliah` (`mk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `recent_activity`
--
ALTER TABLE `recent_activity`
  ADD CONSTRAINT `user_as_aktivis` FOREIGN KEY (`aktivis`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
