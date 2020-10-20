-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2017 at 07:32 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sid_statistika`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `tgl_akses` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`, `email`, `no_telp`, `tgl_akses`) VALUES
(1, 'aku', 'aku', 'aku', 'aku@gmail.com', '0812345', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nip` varchar(18) NOT NULL,
  `nidn` varchar(10) NOT NULL,
  `gelar_depan` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gelar_belakang` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat_rumah` varchar(1000) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `scopus_id` varchar(20) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `tgl_login` date NOT NULL,
  `hak_akses` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nip`, `nidn`, `gelar_depan`, `nama`, `gelar_belakang`, `password`, `email`, `tempat_lahir`, `tanggal_lahir`, `alamat_rumah`, `no_hp`, `scopus_id`, `foto`, `tgl_login`, `hak_akses`) VALUES
('195505281980031002', '', 'Prof. Drs.', 'Mustafid', ', MEng., Ph', 'mustafid', 'mustafid@gmail.com', 'Semarang', '1955-05-28', 'Semarang', '123', '', '195505281980031002.jpg', '2017-05-24', 2),
('195709141986032001', '', 'Dra.', 'Dwi Ispriyanti', ', MSi', '000000', '', '', '1957-09-14', '', '', '', '', '2017-05-25', 2),
('196109281986032000', '', 'Dr.', 'Tatik Widiharih', ', M.Si', '000000', '', '', '0000-00-00', '', '', '', '', '0000-00-00', 2),
('196307061991021001', '0018106106', 'Dr.', 'Tarno', ', Msi', 'tarno', 'tarno@gmail.com', 'Semarang', '1963-07-06', 'Semarang', '081325709047', '', '196307061991021001.jpg', '2017-05-30', 2),
('196407091992011001', '', 'Drs.', 'Sudarno', ', M.Si', 'sudarno', 'sudarno@gmail.com', 'Semarang', '1964-06-09', 'Semarang', '08567219876', '', '196407091992011001.jpg', '2017-05-23', 2),
('196408131990011001', '', 'Drs.', 'Agus Rusgiyono', ', M.Si', '000000', '', '', '0000-00-00', '', '', '', '', '0000-00-00', 2),
('24010314130075', '2401031413', '', 'rizka', '', 'rizka', '', 'semarang', '1996-10-03', 'jalan menuju hatimu cuitcuit', '08567219876', '', '', '2017-05-28', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_acara` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `tempat` varchar(30) NOT NULL,
  `jenis_kegiatan` varchar(10) NOT NULL,
  `id_pendidikan` varchar(5) DEFAULT NULL,
  `id_penelitian` varchar(5) DEFAULT NULL,
  `id_pengabdian` varchar(5) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `nip`, `nama_acara`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `tempat`, `jenis_kegiatan`, `id_pendidikan`, `id_penelitian`, `id_pengabdian`, `keterangan`) VALUES
(3, '195709141986032001', 'rapat', '2017-05-12', '10:00:00', '11:00:00', 'fsm', 'B', NULL, 'B0002', NULL, 'coba'),
(10, '195709141986032001', 'rapat2', '2017-05-14', '09:30:00', '11:45:00', 'lapangan', 'B', NULL, 'B0002', NULL, 'plis'),
(11, '195709141986032001', 'rapat3', '2017-05-10', '10:20:00', '12:30:00', 'lab 2', 'B', NULL, 'B0002', NULL, 'sampe siang'),
(13, '195709141986032001', 'rapat1', '2017-05-11', '20:00:00', '21:00:00', 'fsm', 'C', NULL, NULL, 'C0002', 'hehe'),
(15, '195709141986032001', 'bimbingan pkl', '2017-05-13', '08:00:00', '09:00:00', 'ruang dosen', 'A', 'A0001', NULL, NULL, ''),
(18, '195709141986032001', 'perwalian', '2017-05-20', '10:00:00', '11:00:00', 'fsm', 'A', 'A0002', NULL, NULL, ''),
(20, '195709141986032001', 'kuliah umum', '2017-05-21', '08:00:00', '12:00:00', 'fsm', 'A', 'A0002', NULL, NULL, 'mohon untuk tidak terlambat'),
(22, '196307061991021001', 'statistika dasar', '2017-05-25', '10:00:00', '11:00:00', 'A101', 'A', 'A0002', NULL, NULL, 'mengajar'),
(23, '196307061991021001', 'Survey', '2017-04-15', '10:00:00', '14:00:00', 'Semarang', 'B', NULL, 'B0005', NULL, ''),
(24, '196307061991021001', 'Rapat Tim', '2017-05-18', '12:00:00', '16:00:00', 'Universitas Diponegoro', 'C', NULL, NULL, 'C0008', ''),
(25, '195709141986032001', 'Rapat Tim', '2017-05-04', '02:00:00', '11:00:00', 'dafa', 'B', NULL, 'B0001', NULL, 'csgs');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kegiatan`
--

CREATE TABLE `jenis_kegiatan` (
  `id_kegiatan` varchar(5) NOT NULL,
  `nama_kegiatan` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_kegiatan`
--

INSERT INTO `jenis_kegiatan` (`id_kegiatan`, `nama_kegiatan`) VALUES
('A', 'pendidikan'),
('B', 'penelitian'),
('C', 'pengabdian');

-- --------------------------------------------------------

--
-- Table structure for table `kadep`
--

CREATE TABLE `kadep` (
  `username` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tgl_login` date NOT NULL,
  `hak_akses` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kadep`
--

INSERT INTO `kadep` (`username`, `password`, `tgl_login`, `hak_akses`) VALUES
('kadep', 'kadep', '2017-05-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(14) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `hak_akses` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `password`, `hak_akses`) VALUES
('24010314130075', 'Rizka Putri', '24010314130075', 3),
('24010314130087', 'Aditiya Dwi Putra', '24010314130087', 3),
('24010314130097', 'Anneta Shifa', '24010314130097', 3),
('24010314130110', 'Nadhila Tantri', '24010314130110', 3),
('24010314130126', 'Arniz Awinda Hutami', '24010314130126', 3),
('24010314140076', 'Latiffa Sarah Fajrinah', '24010314140076', 3),
('24010314140084', 'Oliver Hiskia', '24010314140084', 3),
('24010314140129', 'Ratih Permatasari', '24010314140129', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` varchar(5) NOT NULL,
  `kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `kategori`) VALUES
('A0001', 'Bimbingan'),
('A0002', 'Mengajar'),
('A0003', 'Perwalian'),
('A0004', 'Seminar'),
('A0005', 'Kuliah Umum');

-- --------------------------------------------------------

--
-- Table structure for table `penelitian`
--

CREATE TABLE `penelitian` (
  `id_penelitian` varchar(5) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `skim` varchar(30) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `sumber_dana` varchar(20) NOT NULL,
  `output` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `folder` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penelitian`
--

INSERT INTO `penelitian` (`id_penelitian`, `nip`, `judul`, `skim`, `tgl_mulai`, `tgl_selesai`, `sumber_dana`, `output`, `folder`) VALUES
('B0001', '195709141986032001', 'Penelitian 1', 'penelitian hibah bersaing', '2017-05-11', '2017-05-20', 'Dikti', '213-418-1-PB.pdf', './file_upload/'),
('B0002', '195709141986032001', 'Penelitian 2', 'penelitian hibah bersaing', '2017-05-18', '2017-05-28', 'dikti', '2 hpqfhpL41 Jurnal Hafizah (1).pdf', './file_upload/'),
('B0003', '24010314130075', 'wah', 'bisa', '2017-05-11', '2017-05-19', 'dari kantong papa', '10513_Jadwal-UAS-20152-Jurusan-Teknik-Informatika.', './file_upload/'),
('B0004', '24010314130075', 'jumlah micin', 'dana', '2017-05-22', '2017-05-24', 'dana dikti', NULL, NULL),
('B0005', '196307061991021001', 'Analisis Swing Consumer pada Permintaan Pertamax Penurunan harga BBM Nonsubsidi dengan Modal Intervensi', 'Fundamental', '2017-04-14', '2017-05-14', 'Dikti', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengabdian`
--

CREATE TABLE `pengabdian` (
  `id_pengabdian` varchar(5) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `skim` varchar(30) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `sumber_dana` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengabdian`
--

INSERT INTO `pengabdian` (`id_pengabdian`, `nip`, `judul`, `skim`, `tgl_mulai`, `tgl_selesai`, `sumber_dana`) VALUES
('C0001', '195709141986032001', 'Pengabdian 1', 'pengabdian kepada masyarakat', '2017-05-06', '2017-05-20', 'BOPTN Undip'),
('C0002', '195709141986032001', 'Pengabdian 2', 'pengabdian kepada masyarakat', '2017-05-11', '2017-05-21', 'BOPTN Undip'),
('C0003', '24010314130075', 'coba1', 'ini', '2017-05-17', '2017-05-24', 'pliiis'),
('C0004', '24010314130075', 'coba terus', 'bisa dong', '2017-05-10', '2017-05-19', 'udah subuh nih'),
('C0005', '24010314130075', 'bismillah', 'udah subuh', '2017-05-17', '2017-05-19', 'ya tuhan'),
('C0006', '24010314130075', 'cuman ngarang', 'ngarang', '2017-06-03', '2017-06-17', 'udah subuh :('),
('C0007', '24010314130075', 'coba yang keberapa ga tau', 'anehaneh', '2017-05-19', '2017-06-16', 'diktinih'),
('C0008', '196307061991021001', 'Pemodelan Volatilitas Untuk Penghitungan Value at Risk  (VaR) Saham LQ-45 Menggunakan Adaptive Neuro Fuzzy  Inference System (ANFIS)', 'Hibah Bersaing', '2017-05-17', '2017-05-27', 'Dikti');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `nip` (`nip`,`jenis_kegiatan`),
  ADD KEY `jadwal_fk_02` (`jenis_kegiatan`),
  ADD KEY `id_pendidikan` (`id_pendidikan`,`id_penelitian`,`id_pengabdian`),
  ADD KEY `jadwal_fk_03` (`id_penelitian`),
  ADD KEY `jadwal_fk_04` (`id_pengabdian`);

--
-- Indexes for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `kadep`
--
ALTER TABLE `kadep`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indexes for table `penelitian`
--
ALTER TABLE `penelitian`
  ADD PRIMARY KEY (`id_penelitian`),
  ADD KEY `nip` (`nip`),
  ADD KEY `id_output` (`output`);

--
-- Indexes for table `pengabdian`
--
ALTER TABLE `pengabdian`
  ADD PRIMARY KEY (`id_pengabdian`),
  ADD KEY `nip` (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_fk_01` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`),
  ADD CONSTRAINT `jadwal_fk_02` FOREIGN KEY (`id_pendidikan`) REFERENCES `pendidikan` (`id_pendidikan`),
  ADD CONSTRAINT `jadwal_fk_03` FOREIGN KEY (`id_penelitian`) REFERENCES `penelitian` (`id_penelitian`),
  ADD CONSTRAINT `jadwal_fk_04` FOREIGN KEY (`id_pengabdian`) REFERENCES `pengabdian` (`id_pengabdian`),
  ADD CONSTRAINT `jadwal_fk_05` FOREIGN KEY (`jenis_kegiatan`) REFERENCES `jenis_kegiatan` (`id_kegiatan`);

--
-- Constraints for table `penelitian`
--
ALTER TABLE `penelitian`
  ADD CONSTRAINT `penelitian_fk_01` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`);

--
-- Constraints for table `pengabdian`
--
ALTER TABLE `pengabdian`
  ADD CONSTRAINT `pengabdian_fk_01` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
