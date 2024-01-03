-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2023 at 09:12 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_luanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bhyt`
--

DROP TABLE IF EXISTS `bhyt`;
CREATE TABLE IF NOT EXISTS `bhyt` (
  `Dot` int(11) NOT NULL AUTO_INCREMENT,
  `NTG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gia` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`Dot`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bhyt`
--

INSERT INTO `bhyt` (`Dot`, `NTG`, `Gia`) VALUES
(1, '30/01/2023', '170000.100'),
(2, '13/05/2023', '170000.100'),
(3, '23/10/2026', '160000.000');

-- --------------------------------------------------------

--
-- Table structure for table `cthd`
--

DROP TABLE IF EXISTS `cthd`;
CREATE TABLE IF NOT EXISTS `cthd` (
  `MaHD` int(11) NOT NULL,
  `MSSV` int(11) NOT NULL,
  `ThanhTien` decimal(10,3) NOT NULL,
  `SoThang` int(11) NOT NULL,
  PRIMARY KEY (`MSSV`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
CREATE TABLE IF NOT EXISTS `hoadon` (
  `MaHD` int(11) NOT NULL AUTO_INCREMENT,
  `Dot` int(11) NOT NULL,
  `NgayXuat` date NOT NULL,
  `Total` decimal(13,2) DEFAULT NULL,
  `Type` tinyint(4) NOT NULL,
  PRIMARY KEY (`MaHD`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khoa`
--

DROP TABLE IF EXISTS `khoa`;
CREATE TABLE IF NOT EXISTS `khoa` (
  `IDKhoa` int(11) NOT NULL AUTO_INCREMENT,
  `TenKhoa` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IDKhoa`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khoa`
--

INSERT INTO `khoa` (`IDKhoa`, `TenKhoa`) VALUES
(1, 'Khoa Công Nghệ'),
(2, 'Khoa Ngoại Ngữ'),
(15, 'teét 23'),
(4, 'Khoa Kinh Tế'),
(14, 'teét 2'),
(13, 'test'),
(5, 'Khoa Kinh Tế2');

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

DROP TABLE IF EXISTS `lop`;
CREATE TABLE IF NOT EXISTS `lop` (
  `IDLop` int(11) NOT NULL AUTO_INCREMENT,
  `TenLop` char(13) COLLATE utf8_unicode_ci NOT NULL,
  `SiSo` int(11) DEFAULT NULL,
  `IDKhoa` int(11) NOT NULL,
  `IDNienKhoa` int(11) NOT NULL,
  PRIMARY KEY (`IDLop`),
  KEY `fk_lop_nienkhoa` (`IDNienKhoa`),
  KEY `fk_lop_khoa` (`IDKhoa`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lop`
--

INSERT INTO `lop` (`IDLop`, `TenLop`, `SiSo`, `IDKhoa`, `IDNienKhoa`) VALUES
(112, 'K17CNTT2', 303, 1, 48),
(2, 'K17NV', 15, 2, 3),
(3, 'K16CNTT', 32, 1, 54),
(4, 'K16NV2', 20, 2, 2),
(25, 'K18CNTT1', 12, 1, 55),
(26, 'K18HV1', 24, 2, 1),
(27, 'K18NV', 21, 2, 1),
(28, 'S4AV2', 30, 2, 1),
(21, 'a2213', 243, 4, 54),
(30, 'K19CNTT1', 24, 1, 56),
(32, 'K19CNTT2', 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `nienkhoa`
--

DROP TABLE IF EXISTS `nienkhoa`;
CREATE TABLE IF NOT EXISTS `nienkhoa` (
  `IDNienKhoa` int(11) NOT NULL AUTO_INCREMENT,
  `NamHoc` char(11) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`IDNienKhoa`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nienkhoa`
--

INSERT INTO `nienkhoa` (`IDNienKhoa`, `NamHoc`) VALUES
(1, '2012'),
(2, '2013'),
(3, '2015'),
(4, '2016'),
(5, '2017'),
(55, '2021'),
(56, '2022'),
(48, '2018'),
(54, '2019');

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

DROP TABLE IF EXISTS `sinhvien`;
CREATE TABLE IF NOT EXISTS `sinhvien` (
  `MSSV` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `Ho` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Ten` char(13) COLLATE utf8_unicode_ci NOT NULL,
  `GioiTinh` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NgaySinh` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TenLop` char(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhuongXa` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `QuanHuyen` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TinhThanh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MaTheBHYT` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SoThangDong` smallint(6) DEFAULT NULL,
  `SoTienDong` decimal(13,3) DEFAULT NULL,
  `SoCCCD` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GhiChu` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TinhTrang` int(1) DEFAULT NULL,
  `Dot` int(11) DEFAULT NULL,
  PRIMARY KEY (`MSSV`),
  KEY `fk_TenLopSV_TenLop` (`TenLop`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`MSSV`, `Ho`, `Ten`, `GioiTinh`, `NgaySinh`, `TenLop`, `PhuongXa`, `QuanHuyen`, `TinhThanh`, `MaTheBHYT`, `SoThangDong`, `SoTienDong`, `SoCCCD`, `GhiChu`, `TinhTrang`, `Dot`) VALUES
('220304', 'Đỗ Hoàng', 'Long', 'Nam', '21/10/2004', 'K18CNTT1', 'Phường Tân Biên', 'Thành phố Biên Hòa', 'Tỉnh Đồng Nai', '4757523062123', 1, '160000.000', '075204010304', 'Đợt 2', 2, 3),
('220230', 'Thái Hoàng Anh', 'Linh', 'Nữ', '28/08/2004', 'K17CNTT2', 'Xã Xuân Hiệp', 'Huyện Xuân Lộc', 'Tỉnh Đồng Nai', '', 6, '704.025', '276103883', 'Đợt 2', 0, 2),
('220332', 'Trần Hạnh', 'Nhị', 'Nữ', '15/05/2002', 'K17CNTT2', 'Xã Long An', 'Huyện Long Thành', 'Tỉnh Đồng Nai', '', 1, '704.025', '364161933', 'Đợt 2', 0, 1),
('220223', 'Nguyễn Văn', 'Hưng', 'Nam', '26/07/2004', 'K16CNTT', 'Xã An Hòa', 'Thành phố Biên Hòa', 'Tỉnh Đồng Nai', '4 75 752 655 9516', 6, '1020000.600', '272991575', 'Đợt 2', 1, 3),
('220490', 'Lê Quang', 'Nam', 'Nam', '12/10/2004', 'K17CNTT2', 'Phường Trảng Dài', 'Thành phố Biên Hòa', 'Tỉnh Đồng Nai', '', 1, '160000.000', '0964532458', 'Đợt 2', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TK` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `MK` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `Email` char(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SDT` char(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MSSV` bigint(6) DEFAULT NULL,
  `Quyen` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`ID`, `TK`, `MK`, `Email`, `SDT`, `MSSV`, `Quyen`) VALUES
(1, 'staff', 'staff', '', '11111', NULL, 'staff'),
(2, 'student', 'student1', '', '22222', 1, 'student'),
(3, 'admin', 'admin', '', '33333', NULL, 'admin'),
(7, 'student4', 'student4', '', '77777', 4, 'student');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
