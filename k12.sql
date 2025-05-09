-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 09:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k12`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_user` int(60) NOT NULL,
  `nama_lengkap` varchar(90) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `level` enum('admin','dosen') DEFAULT NULL,
  `nip` int(20) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_hp` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_user`, `nama_lengkap`, `username`, `password`, `level`, `nip`, `alamat`, `no_hp`) VALUES
(1, NULL, 'ahmad', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 234, 'pppp', 0),
(7, NULL, 'Iksan', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 2147483647, 'Martadinata', 2147483647),
(22, NULL, 'bambang', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 846512, 'rtyui', 21235448),
(23, NULL, 'dosen', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 79864, 'dsifua', 8465),
(24, NULL, 'k12', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 7541156, 'sfh', 853213468),
(25, NULL, 'rps', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 653255, 'safkhjbf', 8465322),
(26, 'Kelompok 12', 'new', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 84512, 'oidsfjc', 754212),
(27, 'tulung', 'tes', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 8745231, 'asdfhunj', 12345678),
(28, 'iflhskan', 'tehasd', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 851385, 'fdskh', 686451),
(29, 'dosen TI', 'dosen', '81dc9bdb52d04dc20036dbd8313ed055', 'dosen', 78645, 'unmus', 1546485);

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id_matakuliah` int(60) NOT NULL,
  `nama_matakuliah` varchar(35) DEFAULT NULL,
  `kode_matakuliah` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rps`
--

CREATE TABLE `rps` (
  `id_rps` int(60) NOT NULL,
  `id_matakuliah` int(60) DEFAULT NULL,
  `file_rps` text DEFAULT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rps_1`
--

CREATE TABLE `tb_rps_1` (
  `id` int(11) NOT NULL,
  `Matakuliah` varchar(255) NOT NULL,
  `Dosen` text NOT NULL,
  `Kode` varchar(10) NOT NULL,
  `Rumpun_MK` varchar(255) NOT NULL,
  `Bobot_(SKS)` int(20) NOT NULL,
  `Semester` int(20) NOT NULL,
  `Tanggal_penyusunan` date NOT NULL,
  `OTORISASI` varchar(255) NOT NULL,
  `Capaian_Pembelajaran` varchar(255) NOT NULL,
  `Deskrisi_Singkat_MK` varchar(255) NOT NULL,
  `Pustaka` varchar(255) NOT NULL,
  `Media_Pembelajaran` varchar(255) NOT NULL,
  `Team_Teaching` varchar(255) NOT NULL,
  `Matakuliah_Syarat` varchar(255) NOT NULL,
  `Pengembangan_RPS` text NOT NULL,
  `Koordinator_MK` text NOT NULL,
  `Ketua_Prodi` text NOT NULL,
  `CPLP` text NOT NULL,
  `CPMK` text NOT NULL,
  `Sofwer` text NOT NULL,
  `hardwer` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `alasan_penolakan` text DEFAULT NULL,
  `1Mg_Ke` text DEFAULT NULL,
  `1Sub_CPMK` text DEFAULT NULL,
  `1Materi_Pembelajaran` text DEFAULT NULL,
  `1Metode` text DEFAULT NULL,
  `1Indikator` text DEFAULT NULL,
  `1Bentuk` text DEFAULT NULL,
  `1Bobot` text DEFAULT NULL,
  `2Mg_Ke` text DEFAULT NULL,
  `2Sub_CPMK` text DEFAULT NULL,
  `2Materi_Pembelajaran` text DEFAULT NULL,
  `2Metode` text DEFAULT NULL,
  `2Indikator` text DEFAULT NULL,
  `2Bentuk` text DEFAULT NULL,
  `2Bobot` text DEFAULT NULL,
  `3Mg_Ke` text DEFAULT NULL,
  `3Sub_CPMK` text DEFAULT NULL,
  `3Materi_Pembelajaran` text DEFAULT NULL,
  `3Metode` text DEFAULT NULL,
  `3Indikator` text DEFAULT NULL,
  `3Bentuk` text DEFAULT NULL,
  `3Bobot` text DEFAULT NULL,
  `4Mg_Ke` text DEFAULT NULL,
  `4Sub_CPMK` text DEFAULT NULL,
  `4Materi_Pembelajaran` text DEFAULT NULL,
  `4Metode` text DEFAULT NULL,
  `4Indikator` text DEFAULT NULL,
  `4Bentuk` text DEFAULT NULL,
  `4Bobot` text DEFAULT NULL,
  `5Mg_Ke` text DEFAULT NULL,
  `5Sub_CPMK` text DEFAULT NULL,
  `5Materi_Pembelajaran` text DEFAULT NULL,
  `5Metode` text DEFAULT NULL,
  `5Indikator` text DEFAULT NULL,
  `5Bentuk` text DEFAULT NULL,
  `5Bobot` text DEFAULT NULL,
  `6Mg_Ke` text DEFAULT NULL,
  `6Sub_CPMK` text DEFAULT NULL,
  `6Materi_Pembelajaran` text DEFAULT NULL,
  `6Metode` text DEFAULT NULL,
  `6Indikator` text DEFAULT NULL,
  `6Bentuk` text DEFAULT NULL,
  `6Bobot` text DEFAULT NULL,
  `7Mg_Ke` text DEFAULT NULL,
  `7Sub_CPMK` text DEFAULT NULL,
  `7Materi_Pembelajaran` text DEFAULT NULL,
  `7Metode` text DEFAULT NULL,
  `7Indikator` text DEFAULT NULL,
  `7Bentuk` text DEFAULT NULL,
  `7Bobot` text DEFAULT NULL,
  `8Mg_Ke` text DEFAULT NULL,
  `8Sub_CPMK` text DEFAULT NULL,
  `8Materi_Pembelajaran` text DEFAULT NULL,
  `8Metode` text DEFAULT NULL,
  `8Indikator` text DEFAULT NULL,
  `8Bentuk` text DEFAULT NULL,
  `8Bobot` text DEFAULT NULL,
  `9Mg_Ke` text DEFAULT NULL,
  `9Sub_CPMK` text DEFAULT NULL,
  `9Materi_Pembelajaran` text DEFAULT NULL,
  `9Metode` text DEFAULT NULL,
  `9Indikator` text DEFAULT NULL,
  `9Bentuk` text DEFAULT NULL,
  `9Bobot` text DEFAULT NULL,
  `10Mg_Ke` text DEFAULT NULL,
  `10Sub_CPMK` text DEFAULT NULL,
  `10Materi_Pembelajaran` text DEFAULT NULL,
  `10Metode` text DEFAULT NULL,
  `10Indikator` text DEFAULT NULL,
  `10Bentuk` text DEFAULT NULL,
  `10Bobot` text DEFAULT NULL,
  `11Mg_Ke` text DEFAULT NULL,
  `11Sub_CPMK` text DEFAULT NULL,
  `11Materi_Pembelajaran` text DEFAULT NULL,
  `11Metode` text DEFAULT NULL,
  `11Indikator` text DEFAULT NULL,
  `11Bentuk` text DEFAULT NULL,
  `11Bobot` text DEFAULT NULL,
  `12Mg_Ke` text DEFAULT NULL,
  `12Sub_CPMK` text DEFAULT NULL,
  `12Materi_Pembelajaran` text DEFAULT NULL,
  `12Metode` text DEFAULT NULL,
  `12Indikator` text DEFAULT NULL,
  `12Bentuk` text DEFAULT NULL,
  `12Bobot` text DEFAULT NULL,
  `13Mg_Ke` text DEFAULT NULL,
  `13Sub_CPMK` text DEFAULT NULL,
  `13Materi_Pembelajaran` text DEFAULT NULL,
  `13Metode` text DEFAULT NULL,
  `13Indikator` text DEFAULT NULL,
  `13Bentuk` text DEFAULT NULL,
  `13Bobot` text DEFAULT NULL,
  `14Mg_Ke` text DEFAULT NULL,
  `14Sub_CPMK` text DEFAULT NULL,
  `14Materi_Pembelajaran` text DEFAULT NULL,
  `14Metode` text DEFAULT NULL,
  `14Indikator` text DEFAULT NULL,
  `14Bentuk` text DEFAULT NULL,
  `14Bobot` text DEFAULT NULL,
  `15Mg_Ke` text DEFAULT NULL,
  `15Sub_CPMK` text DEFAULT NULL,
  `15Materi_Pembelajaran` text DEFAULT NULL,
  `15Metode` text DEFAULT NULL,
  `15Indikator` text DEFAULT NULL,
  `15Bentuk` text DEFAULT NULL,
  `15Bobot` text DEFAULT NULL,
  `16Mg_Ke` text DEFAULT NULL,
  `16Sub_CPMK` text DEFAULT NULL,
  `16Materi_Pembelajaran` text DEFAULT NULL,
  `16Metode` text DEFAULT NULL,
  `16Indikator` text DEFAULT NULL,
  `16Bentuk` text DEFAULT NULL,
  `16Bobot` text DEFAULT NULL,
  `Capaian` text NOT NULL,
  `Obyek` text NOT NULL,
  `Aktivitas` text NOT NULL,
  `Metodologi` text NOT NULL,
  `Kriteria_tugas` text NOT NULL,
  `Kriteria` text NOT NULL,
  `Jadwal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rps_1`
--

INSERT INTO `tb_rps_1` (`id`, `Matakuliah`, `Dosen`, `Kode`, `Rumpun_MK`, `Bobot_(SKS)`, `Semester`, `Tanggal_penyusunan`, `OTORISASI`, `Capaian_Pembelajaran`, `Deskrisi_Singkat_MK`, `Pustaka`, `Media_Pembelajaran`, `Team_Teaching`, `Matakuliah_Syarat`, `Pengembangan_RPS`, `Koordinator_MK`, `Ketua_Prodi`, `CPLP`, `CPMK`, `Sofwer`, `hardwer`, `status`, `alasan_penolakan`, `1Mg_Ke`, `1Sub_CPMK`, `1Materi_Pembelajaran`, `1Metode`, `1Indikator`, `1Bentuk`, `1Bobot`, `2Mg_Ke`, `2Sub_CPMK`, `2Materi_Pembelajaran`, `2Metode`, `2Indikator`, `2Bentuk`, `2Bobot`, `3Mg_Ke`, `3Sub_CPMK`, `3Materi_Pembelajaran`, `3Metode`, `3Indikator`, `3Bentuk`, `3Bobot`, `4Mg_Ke`, `4Sub_CPMK`, `4Materi_Pembelajaran`, `4Metode`, `4Indikator`, `4Bentuk`, `4Bobot`, `5Mg_Ke`, `5Sub_CPMK`, `5Materi_Pembelajaran`, `5Metode`, `5Indikator`, `5Bentuk`, `5Bobot`, `6Mg_Ke`, `6Sub_CPMK`, `6Materi_Pembelajaran`, `6Metode`, `6Indikator`, `6Bentuk`, `6Bobot`, `7Mg_Ke`, `7Sub_CPMK`, `7Materi_Pembelajaran`, `7Metode`, `7Indikator`, `7Bentuk`, `7Bobot`, `8Mg_Ke`, `8Sub_CPMK`, `8Materi_Pembelajaran`, `8Metode`, `8Indikator`, `8Bentuk`, `8Bobot`, `9Mg_Ke`, `9Sub_CPMK`, `9Materi_Pembelajaran`, `9Metode`, `9Indikator`, `9Bentuk`, `9Bobot`, `10Mg_Ke`, `10Sub_CPMK`, `10Materi_Pembelajaran`, `10Metode`, `10Indikator`, `10Bentuk`, `10Bobot`, `11Mg_Ke`, `11Sub_CPMK`, `11Materi_Pembelajaran`, `11Metode`, `11Indikator`, `11Bentuk`, `11Bobot`, `12Mg_Ke`, `12Sub_CPMK`, `12Materi_Pembelajaran`, `12Metode`, `12Indikator`, `12Bentuk`, `12Bobot`, `13Mg_Ke`, `13Sub_CPMK`, `13Materi_Pembelajaran`, `13Metode`, `13Indikator`, `13Bentuk`, `13Bobot`, `14Mg_Ke`, `14Sub_CPMK`, `14Materi_Pembelajaran`, `14Metode`, `14Indikator`, `14Bentuk`, `14Bobot`, `15Mg_Ke`, `15Sub_CPMK`, `15Materi_Pembelajaran`, `15Metode`, `15Indikator`, `15Bentuk`, `15Bobot`, `16Mg_Ke`, `16Sub_CPMK`, `16Materi_Pembelajaran`, `16Metode`, `16Indikator`, `16Bentuk`, `16Bobot`, `Capaian`, `Obyek`, `Aktivitas`, `Metodologi`, `Kriteria_tugas`, `Kriteria`, `Jadwal`) VALUES
(36, 'Komunikasi data', 'Try Adrianto Darsono, S.Kom., M.Cs , Agus Prayitno, S.Kom., M.Cs', 'A0430602', '...', 3, 5, '2019-09-01', 'hapus', 'hapus', 'Mata kuliah ini memiliki tujuan untuk memberikan pemahaman kepada mahasiswa semester 5 (lima) mengenai konsep dasar teori Komunikasi data, protokol-protokol dan arsitektur yang digunakan di dalam Komunikasi data, transmisi data,media transmisi, pengkodean', '1.	Behrouz A. F., Data Communication and Computer Networks, 5th Edition, Mc-Graw Hill, 2012.\r\n2.	William S., Data and Computer Communications, 10th Edition,Pearson, 2015\r\n', 'hapus', 'Try Adrianto Darsono', 'Tidak Ada', '..........', '...', '...', '1.	Menunjukkan sikap bertanggungjawab atas pekerjaan di bidang keahliannya secara mandiri (S9) 2.	Menguasai konsep dan teori dasar bidang informatika (P1) 3.	Menguasai teori dan penerapan bidang keahlian komputasi berbasis jaringan (P4) 4.	mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi yang memperhatikan dan menerapkan nilai humaniora yang sesuai dengan bidang keahliannya (KU1)  5.	mampu menunjukkan kinerja mandiri, bermutu, dan terukur; (KU2) 6.	mampu mendokumentasikan, menyimpan, mengamankan, dan menemukan kembali data untuk menjamin kesahihan dan mencegah plagiasi; (KU9) 7.	Mampu menganalisis kebutuhan sumber daya dalam penyelesaian masalah bidang teknologi informasi dan komunikasi (KK1)', '1.	Mahasiswa mampu memahami dan menjelaskan tentang konsep dasar dan teori mengenai komunikasi data (S9, P1, P4, KU1)  2.	Mampu memahami  prinsip  dasar  dan  proses  komunikasi  data  pada berbagai infrastruktur jaringan Komunikasi data (S9, P1,P4,KU1, KU2,KU9, KK1) 3.	Mahasiswa mampu memahami  prinsip  kerja  peralatan  komunikasi  data  pada komputer (S9, KU2, KU9, KK1)', 'MS Powerpoint', 'Laptop/Notebook, LCD, Whiteboard', 'Approved', '', '1', '-	Pendahuluan : Kontrak dan teknis perkuliahan -	Mahasiswa memahami materi perkuliahan dan kontrak perkuliahan yang akan ditempuh dalam satu semester (CPMK1)', '-	Rencana Pembelajaran Semester -	Pengantar Komunikasi data', '-	Ceramah -	Diskusi/tanya jawab -	Problem based learning -	Motivasi mengikuti perkuliahan (TM : 2x50’)', 'Mahasiswa mampu :  -	Memahami kontrak perkuliahan', 'Test (Tulis, Lisan) -	Keaktifan  -	Etika dalam PBM', '5%', '2', '-	Mahasiswa mampu menjelaskan konsep dan model Komunikasi data (CPMK1)', '1.	Pendahuluan Komunikasi data 2.	Kebutuhan komunikasi data 3.	Model komunikasi data 4.	Perkenalan internet ', '-	Pembelajaran kontektual -	Kegiatan literasi -	Mahasiswa bersama dosen membahas Komunikasi data dalam kehidupan sehari-hari. (TM : 2x50’) (BM : 2x60’)', 'Mahasiswa mampu :  -	Menjelaskan dasar Komunikasi data -	Memahami peran Komunikasi data dalam kehidupan sehari-hari -	Menjelaskan model komunikasi data dan internet', '-	Keaktifan  -	Etika dalam PBM', '5%', '3 dan 4', 'Mahasiswa mampu menjelaskan aristektur dan protokol dalam Komunikasi data (CPMK1)', '1.	Arsitektur dalam Komunikasi data 2.	Protokol-protokol dalam Komunikasi data', '-	Pembelajaran kontektual -	Kegiatan literasi -	Mahasiswa bersama dosen membahas arsitektur dan protokol yang digunakan dalam Komunikasi data  (TM : 2x50’) (BM : 2x60’)', '-	Mahasiswa dapat menyebutkan arsitektur dari tiap layer pada Komunikasi data  -	Dapat menyebutkan layer dalam OSI Model dan TCP/IP', '-	Keaktifan  -	Etika dalam PBM', '10%', '4', '-', '-', '-', '-', '-', '-', '5 dan 6', 'Mahasiswa mampu menjelaskan berbagai jenis transmisi data (CPMK2)', 'Data dan Sinyal -	Data analog dan Digital -	Sinyal Analog Periodik dan Sinyal Digital', '-	Diskusi,  -	Mahasiswa bersama dosen membedakan perbedaan data dan sinyal, data analog dan digital, jenis-jenis gangguan transmisi dan penyebab serta batasan pengiriman data (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa mampu :  -	Menjelaskan perbedaan data dan Sinyal, perbedaan data analog dan data digital  -	Menjelaskan tentang jenis-jenis gangguan transmisi  -	Menjelaskan batasan didalam pengiriman data', '-	Keaktifan  -	Etika dalam PBM', '10%', '6', '-', '-', '-', '-', '-', '-', '7', 'Mahasiswa mampu menjelaskan berbagai jenis media transmisi data (CPMK1, CPMK2)', 'Media Transmisi pada Komunikasi data', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x60’) (BM : 2x60’) (BT : 2x60’)', '-	Mahasiswa dapat memahami jenis-jenis media transmisi yang digunakan dalam Komunikasi data', '-	Keaktifan  -	Etika dalam PBM', '10%', '8', 'UJIAN TENGAH SEMESTER', 'UJIAN TENGAH SEMESTER', 'UJIAN TENGAH SEMESTER', 'UJIAN TENGAH SEMESTER', 'UJIAN TENGAH SEMESTER', 'UJIAN TENGAH SEMESTER', '9', 'Mahasiswa mampu menjelaskan proses pengkodean data (CPMK1, CPMK2)', '-	Teknik Encoding pada Komunikasi data -	Teknik Decoding pada Komunikasi data', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas teknik encoding dan decoding yang digunakan dalam Komunikasi data', '-	Keaktifan -	Etika dalam PBM', '5%', '10', 'Mahasiswa mampu menjelaskan proses deteksi dan koreksi kesalahan pada Komunikasi data (CPMK2, CPMK3)', '-	Deteksi kesalahan dalam Komunikasi data -	Koreksi kesalahan yang terjadi dalam Komunikasi data', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', '-	Mahasiswa berinteraksi dan berdiskusi mengenai suatu kasus kesalahan dalam Komunikasi data -	Mahasiswa berkelompok kecil untuk membahas kesalahan yang terjadi dan koreksi yang dapat dilakukan', '-	Keaktifan -	Etika dalam PBM', '10%', '11', 'Mahasiswa mampu menjelaskan konfigurasi dan manajemen link (CPMK2, CPMK3)', 'Data link Control', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas konfigurasi dan manajemen link pada Komunikasi data', '-	Keaktifan -	Etika dalam PBM', '10%', '12', 'Mahasiswa mampu menjelaskan proses multiplexing (CPMK2, CPMK3)', 'Multiplexing', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas materi multiplexing dalam Komunikasi data', '-	Keaktifan -	Etika dalam PBM', '5%', '13', 'Mahasiswa mampu menjelaskan berbagai protokol dan teknologi WAN (CPMK2, CPMK3)', 'Protokol dan teknologi Wide Area Network (WAN) dalam Komunikasi data', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas materi protokol dan teknologi WAN', '-	Keaktifan -	Etika dalam PBM', '5%', '14', 'Mahasiswa mampu menjelaskan cara kerja jaringan wireless cellular (CPMK2, CPMK3)', 'Jaringan Wireless Cellular', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas materi cara kerja jaringan wireless cellular', '-	Keaktifan -	Etika dalam PBM', '10%', '15', 'Mahasiswa mampu menjelaskan berbagai teknologi yang digunakan pada jaringan LAN (CPMK2, CPMK3)', '-	Overview jaringan LAN', '-	Diskusi -	Memperhatikan -	Membentuk kelompok kecil (TM : 2x50’) (BM : 2x60’) (BT : 2x50’)', 'Mahasiswa berkelompok kecil untuk membahas materi jaringan LAN', '-	Keaktifan -	Etika dalam PBM', '10%', '16', 'UJIAN AKHIR SEMESTER', 'UJIAN AKHIR SEMESTER', 'UJIAN AKHIR SEMESTER', '', 'UJIAN AKHIR SEMESTER', 'UJIAN AKHIR SEMESTER', 'a.	Mampu menjelaskan konsep dasar teori Komunikasi Data b.	Memahami dan mampu menjelaskan aristektur serta protokol-protokol yang digunakan dalam komunikasi data c.	Mampu menjelaskan dan menentukan perbedaan transmisi data, media transmisi,pengkodean data serta aspek deteksi dan koreksi kesalahan dalam Komunikasi Data d.	Mampu menjelaskan konfigurasi dan manajemen link, multiplexing, teknologi dan protokol WAN, jaringan wireless cellular dan overview jaringan LAN dalam Komunikasi Data.', 'Jurnal, presentasi kelompok sesuai materi Komunikasi Data', 'Membuat makalah, membuat presentasi kelompok', 'Analisa deskriptif, Presentasi', 'Presentasi dan makalah -	Kesesuain materi presentasi dan makalah dengan kisi-kisi materi -	Tepat waktu -	Tidak plagiat      ', 'Keaktifan tiap mahasiswa dalam kelompok (10%) -	Kualitas  presentasi dan kejelasan materi (20%) -	Terdapat diskusi pada saat presentasi (15%) -	Pembuatan makalah sesuai dengan kisi-kisi serta kerapian dalam penyusunan (35%) -	Kedalaman materi dan originalitas (tidak plagiat) (20%)', 'sesuai topik/setiap minggu'),
(53, 'pp', 'p', 'p', 'p', 3, 5, '2024-12-07', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'Approved', '', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'pp', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p'),
(56, 'Pemrograman Visual', '-', 'A-144643', '-', 3, 5, '2024-12-09', '-', '1. Menunjukkan sikap bertanggungjawab atas\r\npekerjaan di bidang keahliannya secara mandiri\r\n(S9) 2. Menguasai konsep dan teori dasar bidang\r\ninformatika (P1) 3. Menguasai teori dan\r\npenerapan bidang keahlian komputasi berbasis\r\njaringan (P4) 4. mampu mene', 'Mata kuliah ini memiliki tujuan untuk memberikan pemahaman\r\nkepada mahasiswa semester 5 (lima) mengenai konsep dasar\r\nteori Komunikasi data, protokol-protokol dan arsitektur yang\r\ndigunakan di dalam Komunikasi data, transmisi data,media\r\ntransmisi, pengko', '1. Behrouz A. F., Data Communication and Computer\r\nNetworks, 5th Edition, Mc-Graw Hill, 2012. 2. William S., Data\r\nand Computer Communications, 10th Edition,Pearson, 2015', 'Perangkat lunak\r\n(software): Perangkat keras (hardware):\r\nMS Powerpoint Laptop/Notebook, LCD,\r\nWhiteboard', 'Izak', 'Tidak ada', 'Izak ', '-', '-', '-', '-', '-', '-', 'Pending', 'kurang lengkap', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '--', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '--', '-', '-', '-', '--', '-', '-', '-', '-', '-', '-', '-', '--', '-', '-', '-', '--', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(57, 'Sistem Digital', 'p', 'A-2333', 'p', 3, 3, '2024-12-10', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'Pending', NULL, 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id_matakuliah`);

--
-- Indexes for table `rps`
--
ALTER TABLE `rps`
  ADD PRIMARY KEY (`id_rps`);

--
-- Indexes for table `tb_rps_1`
--
ALTER TABLE `tb_rps_1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id_matakuliah` int(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rps`
--
ALTER TABLE `rps`
  MODIFY `id_rps` int(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_rps_1`
--
ALTER TABLE `tb_rps_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
