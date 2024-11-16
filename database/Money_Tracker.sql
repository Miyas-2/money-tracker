-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for money
CREATE DATABASE IF NOT EXISTS `money` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */;
USE `money`;

-- Dumping structure for table money.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('Income','Expense') NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`category_id`),
  KEY `FK_categories_users` (`user_id`),
  CONSTRAINT `FK_categories_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table money.categories: ~20 rows (approximately)
INSERT INTO `categories` (`category_id`, `name`, `type`, `user_id`) VALUES
	(1, 'Gaji Bulanan', 'Income', 1),
	(2, 'Freelance', 'Income', 1),
	(3, 'Bonus', 'Income', 1),
	(4, 'Penghasilan Sampingan', 'Income', 1),
	(5, 'Hasil Investasi', 'Income', 1),
	(6, 'Penjualan Barang', 'Income', 1),
	(7, 'Sewa', 'Income', 1),
	(8, 'Komisi', 'Income', 1),
	(9, 'Hadiah', 'Income', 1),
	(10, 'Penghasilan Bunga Bank', 'Income', 1),
	(11, 'Makanan dan Minuman', 'Expense', 1),
	(12, 'Transportasi', 'Expense', 1),
	(13, 'Sewa Rumah', 'Expense', 1),
	(14, 'Tagihan Listrik', 'Expense', 1),
	(15, 'Tagihan Air', 'Expense', 1),
	(16, 'Tagihan Internet', 'Expense', 1),
	(17, 'Belanja Bulanan', 'Expense', 1),
	(18, 'Hiburan', 'Expense', 1),
	(19, 'Kesehatan', 'Expense', 1),
	(20, 'Pendidikan', 'Expense', 1);

-- Dumping structure for table money.expense
CREATE TABLE IF NOT EXISTS `expense` (
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`expense_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `expense_ibfk_2` (`category_id`),
  CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table money.expense: ~49 rows (approximately)
INSERT INTO `expense` (`expense_id`, `user_id`, `amount`, `date`, `category_id`, `description`) VALUES
	(1, 1, 3000000.00, '2024-11-14', 11, 'Belanja Bulanan di Supermarket'),
	(2, 1, 1500000.00, '2024-11-13', 14, 'Tagihan Listrik Bulanan'),
	(3, 1, 2000000.00, '2024-11-12', 11, 'Makan di Restoran Mewah'),
	(4, 1, 500000.00, '2024-11-11', 12, 'Transportasi Umum'),
	(5, 1, 1000000.00, '2024-11-10', 17, 'Beli Pakaian Baru'),
	(6, 1, 250000.00, '2024-11-09', 19, 'Biaya Pengobatan'),
	(7, 1, 4000000.00, '2024-11-08', 17, 'Belanja Kebutuhan Rumah'),
	(8, 1, 1800000.00, '2024-11-07', 16, 'Tagihan Internet dan Telepon'),
	(9, 1, 1200000.00, '2024-11-06', 11, 'Makan di Cafe'),
	(10, 1, 500000.00, '2024-11-05', 12, 'Bensin dan Parkir'),
	(11, 1, 250000.00, '2024-11-04', 20, 'Beli Buku dan Alat Tulis'),
	(12, 1, 1000000.00, '2024-11-03', 19, 'Biaya Kesehatan'),
	(13, 1, 600000.00, '2024-11-02', 11, 'Belanja Bulanan Mingguan'),
	(14, 1, 2000000.00, '2024-11-01', 14, 'Tagihan Listrik dan Air'),
	(15, 1, 300000.00, '2024-10-31', 11, 'Makan di Warung'),
	(16, 1, 700000.00, '2024-10-30', 12, 'Transportasi Online'),
	(17, 1, 500000.00, '2024-10-29', 20, 'Beli Buku Pelajaran'),
	(18, 1, 1500000.00, '2024-10-28', 19, 'Biaya Pengobatan Rutin'),
	(19, 1, 800000.00, '2024-10-27', 17, 'Belanja Keperluan Dapur'),
	(20, 1, 900000.00, '2024-10-26', 16, 'Tagihan Internet'),
	(21, 1, 1100000.00, '2024-10-25', 11, 'Makan di Restoran Keluarga'),
	(22, 1, 1300000.00, '2024-10-24', 12, 'Biaya Transportasi Kantor'),
	(23, 1, 1400000.00, '2024-10-23', 17, 'Beli Peralatan Elektronik'),
	(24, 1, 1600000.00, '2024-10-22', 20, 'Biaya Pendidikan'),
	(25, 1, 1700000.00, '2024-10-21', 15, 'Tagihan Air Bulanan'),
	(26, 1, 1900000.00, '2024-10-20', 11, 'Makan di Restoran'),
	(27, 1, 200000.00, '2024-10-19', 12, 'Transportasi Umum'),
	(28, 1, 300000.00, '2024-10-18', 19, 'Beli Obat-obatan'),
	(29, 1, 400000.00, '2024-10-17', 17, 'Belanja Perlengkapan Rumah'),
	(30, 1, 500000.00, '2024-10-16', 16, 'Tagihan Internet'),
	(31, 1, 600000.00, '2024-10-15', 11, 'Makan di Cafe'),
	(32, 1, 700000.00, '2024-10-14', 12, 'Biaya Transportasi'),
	(33, 1, 800000.00, '2024-10-13', 20, 'Beli Buku'),
	(34, 1, 900000.00, '2024-10-12', 19, 'Biaya Kesehatan'),
	(35, 1, 1000000.00, '2024-10-11', 17, 'Belanja Bulanan'),
	(36, 1, 1100000.00, '2024-10-10', 14, 'Tagihan Listrik'),
	(37, 1, 1200000.00, '2024-10-09', 11, 'Makan di Restoran'),
	(38, 1, 1300000.00, '2024-10-08', 12, 'Transportasi Online'),
	(39, 1, 1400000.00, '2024-10-07', 17, 'Beli Perlengkapan Kantor'),
	(40, 1, 1600000.00, '2024-10-06', 20, 'Biaya Pendidikan Anak'),
	(41, 1, 1700000.00, '2024-10-05', 15, 'Tagihan Air'),
	(42, 1, 1900000.00, '2024-10-04', 11, 'Makan di Warung'),
	(43, 1, 200000.00, '2024-10-03', 12, 'Transportasi Umum'),
	(44, 1, 300000.00, '2024-10-02', 19, 'Beli Obat'),
	(45, 1, 400000.00, '2024-10-01', 17, 'Belanja Keperluan Rumah'),
	(46, 1, 500000.00, '2024-09-30', 16, 'Tagihan Internet'),
	(47, 1, 600000.00, '2024-09-29', 11, 'Makan di Cafe'),
	(48, 1, 700000.00, '2024-09-28', 12, 'Biaya Transportasi'),
	(49, 1, 800000.00, '2024-09-27', 20, 'Beli Buku Pelajaran');

-- Dumping structure for table money.income
CREATE TABLE IF NOT EXISTS `income` (
  `income_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`income_id`),
  KEY `user_id` (`user_id`),
  KEY `income_ibfk_2` (`category_id`),
  CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `income_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table money.income: ~62 rows (approximately)
INSERT INTO `income` (`income_id`, `user_id`, `amount`, `date`, `description`, `category_id`) VALUES
	(1, 1, 5000000.00, '2024-11-14', 'Gaji Bulanan November', 1),
	(2, 1, 2000000.00, '2024-11-13', 'Proyek Freelance', 2),
	(3, 1, 1000000.00, '2024-11-12', 'Bonus Kinerja', 3),
	(4, 1, 2500000.00, '2024-11-11', 'Hadiah Ulang Tahun', 9),
	(5, 1, 1500000.00, '2024-11-10', 'Komisi Penjualan', 8),
	(6, 1, 300000.00, '2024-11-09', 'Bunga Deposito', 10),
	(7, 1, 4000000.00, '2024-11-08', 'Gaji Bulanan Oktober', 1),
	(8, 1, 1800000.00, '2024-11-07', 'Proyek Freelance', 2),
	(9, 1, 1200000.00, '2024-11-06', 'Bonus Kinerja', 3),
	(10, 1, 500000.00, '2024-11-05', 'Sewa', 7),
	(11, 1, 250000.00, '2024-11-04', 'Penjualan Barang', 6),
	(12, 1, 1000000.00, '2024-11-03', 'Hadiah', 9),
	(13, 1, 600000.00, '2024-11-02', 'Komisi', 8),
	(14, 1, 2000000.00, '2024-11-01', 'Hasil Investasi', 5),
	(15, 1, 300000.00, '2024-10-31', 'Penghasilan Sampingan', 4),
	(16, 1, 700000.00, '2024-10-30', 'Gaji Bulanan September', 1),
	(17, 1, 2500000.00, '2024-10-29', 'Proyek Freelance', 2),
	(18, 1, 1500000.00, '2024-10-28', 'Bonus Kinerja', 3),
	(19, 1, 800000.00, '2024-10-27', 'Sewa', 7),
	(20, 1, 900000.00, '2024-10-26', 'Hasil Investasi', 5),
	(21, 1, 1100000.00, '2024-10-25', 'Penjualan Barang', 6),
	(22, 1, 1300000.00, '2024-10-24', 'Komisi', 8),
	(23, 1, 1400000.00, '2024-10-23', 'Hadiah', 9),
	(24, 1, 1600000.00, '2024-10-22', 'Gaji Bulanan Agustus', 1),
	(25, 1, 1700000.00, '2024-10-21', 'Proyek Freelance', 2),
	(26, 1, 1900000.00, '2024-10-20', 'Bonus Kinerja', 3),
	(27, 1, 200000.00, '2024-10-19', 'Sewa', 7),
	(28, 1, 300000.00, '2024-10-18', 'Hasil Investasi', 5),
	(29, 1, 400000.00, '2024-10-17', 'Penjualan Barang', 6),
	(30, 1, 500000.00, '2024-10-16', 'Komisi', 8),
	(31, 1, 600000.00, '2024-10-15', 'Hadiah', 9),
	(32, 1, 700000.00, '2024-10-14', 'Gaji Bulanan Juli', 1),
	(33, 1, 800000.00, '2024-10-13', 'Proyek Freelance', 2),
	(34, 1, 900000.00, '2024-10-12', 'Bonus Kinerja', 3),
	(35, 1, 1000000.00, '2024-10-11', 'Sewa', 7),
	(36, 1, 1100000.00, '2024-10-10', 'Hasil Investasi', 5),
	(37, 1, 1200000.00, '2024-10-09', 'Penjualan Barang', 6),
	(38, 1, 1300000.00, '2024-10-08', 'Komisi', 8),
	(39, 1, 1400000.00, '2024-10-07', 'Hadiah', 9),
	(40, 1, 1600000.00, '2024-10-06', 'Gaji Bulanan Agustus', 1),
	(41, 1, 1700000.00, '2024-10-05', 'Proyek Freelance', 2),
	(42, 1, 1900000.00, '2024-10-04', 'Bonus Kinerja', 3),
	(43, 1, 200000.00, '2024-10-03', 'Sewa', 7),
	(44, 1, 300000.00, '2024-10-02', 'Hasil Investasi', 5),
	(45, 1, 400000.00, '2024-10-01', 'Penjualan Barang', 6),
	(46, 1, 500000.00, '2024-09-30', 'Komisi', 8),
	(47, 1, 600000.00, '2024-09-29', 'Hadiah', 9),
	(48, 1, 700000.00, '2024-09-28', 'Gaji Bulanan Juli', 1),
	(49, 1, 800000.00, '2024-09-27', 'Proyek Freelance', 2),
	(50, 1, 900000.00, '2024-09-26', 'Bonus Kinerja', 3),
	(51, 1, 1000000.00, '2024-09-25', 'Sewa', 7),
	(52, 1, 1100000.00, '2024-09-24', 'Hasil Investasi', 5),
	(53, 1, 1200000.00, '2024-09-23', 'Penjualan Barang', 6),
	(54, 1, 1300000.00, '2024-09-22', 'Komisi', 8),
	(55, 1, 1400000.00, '2024-09-21', 'Hadiah', 9),
	(56, 1, 1600000.00, '2024-09-20', 'Gaji Bulanan Agustus', 1),
	(57, 1, 1700000.00, '2024-09-19', 'Proyek Freelance', 2),
	(58, 1, 1900000.00, '2024-09-18', 'Bonus Kinerja', 3),
	(59, 1, 200000.00, '2024-09-17', 'Sewa', 7),
	(60, 1, 300000.00, '2024-09-16', 'Hasil Investasi', 5),
	(61, 1, 400000.00, '2024-09-15', 'Penjualan Barang', 6),
	(62, 1, 500000.00, '2024-09-14', 'Komisi', 8);

-- Dumping structure for table money.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table money.users: ~1 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `profile_photo`) VALUES
	(1, 'Moh Ilyass', '$2y$10$fLsU3Ngc9oMtDsogaSZYWO9a5OAtlVTWlxQSBLynPdas1BLfhTLN6', 'miyas@gmail.com', '1_6735ee14aa505.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
