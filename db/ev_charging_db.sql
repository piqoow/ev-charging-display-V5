-- Adminer 4.8.1 MySQL 8.0.35-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `ev_charging_db`;
CREATE DATABASE `ev_charging_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ev_charging_db`;

DROP TABLE IF EXISTS `charging_log`;
CREATE TABLE `charging_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ev_id` varchar(100) NOT NULL,
  `time` time NOT NULL,
  `energy` varchar(20) NOT NULL,
  `savedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `charging_status`;
CREATE TABLE `charging_status` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `ev_id` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `voltase` float NOT NULL,
  `arus` float NOT NULL,
  `inpower` float NOT NULL,
  `inenergy` float NOT NULL,
  `infrequency` float NOT NULL,
  `inpf` float NOT NULL,
  `insert_status` enum('0','1') NOT NULL,
  `status_code` enum('0','1') NOT NULL,
  `jenis_kendaraan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `current_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `charging_status` (`id_status`, `ev_id`, `status`, `voltase`, `arus`, `inpower`, `inenergy`, `infrequency`, `inpf`, `insert_status`, `status_code`, `jenis_kendaraan`, `current_time`) VALUES
(1,	'EV01',	'OFF',	0,	0,	0,	0,	0,	0,	'0',	'0',	'IONIQ',	'2023-12-18 10:50:49'),
(2,	'EV02',	'OFF',	0,	0,	0,	0,	0,	0,	'0',	'0',	'',	'0000-00-00 00:00:00'),
(3,	'EV03',	'OFF',	0,	0,	0,	0,	0,	0,	'0',	'0',	'',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `evgate`;
CREATE TABLE `evgate` (
  `evgate_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(50) DEFAULT NULL,
  `charger_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `voltage` varchar(50) DEFAULT NULL,
  `current` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `power` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `energy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `insert_status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_code` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `updated_log` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`evgate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `evgate` (`evgate_id`, `customer_id`, `charger_status`, `voltage`, `current`, `power`, `energy`, `insert_status`, `status_code`, `time`, `updated_log`) VALUES
(1,	'EV01',	'Unavailable',	'0',	'0',	'0',	'0.0 kWh',	'1',	NULL,	'00:00:00',	'2024-06-03 10:01:31'),
(4,	'EV02',	'Unavailable',	'0',	'0',	'0',	'0.0 kWh',	'1',	NULL,	'00:00:00',	'2024-06-03 10:01:31');

DROP TABLE IF EXISTS `voucher_ms`;
CREATE TABLE `voucher_ms` (
  `id_voucher` int NOT NULL AUTO_INCREMENT,
  `ev_id` varchar(5) NOT NULL,
  `voucher` varchar(5) NOT NULL,
  `usage_status` enum('Terpakai','Belum Terpakai') NOT NULL,
  `usage_date` date NOT NULL,
  PRIMARY KEY (`id_voucher`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `voucher_ms` (`id_voucher`, `ev_id`, `voucher`, `usage_status`, `usage_date`) VALUES
(42,	'ev01',	'rhXaX',	'Terpakai',	'2023-02-06'),
(43,	'ev01',	'zo6pk',	'Terpakai',	'2023-02-06'),
(44,	'EV01',	'12311',	'Terpakai',	'2023-02-06'),
(45,	'EV02',	'12311',	'Terpakai',	'2023-02-06'),
(46,	'EV03',	'12311',	'Terpakai',	'2023-02-06'),
(51,	'EV01',	'05794',	'Terpakai',	'2023-09-10'),
(52,	'EV01',	'15300',	'Terpakai',	'2023-09-10'),
(53,	'EV03',	'37833',	'Terpakai',	'2023-09-10'),
(54,	'EV01',	'16961',	'Belum Terpakai',	'2023-09-10'),
(55,	'EV01',	'67915',	'Terpakai',	'2023-09-10'),
(56,	'EV03',	'59030',	'Terpakai',	'2023-09-10'),
(57,	'EV03',	'82322',	'Terpakai',	'2023-09-10'),
(58,	'EV03',	'48145',	'Terpakai',	'2023-09-11'),
(59,	'EV03',	'25912',	'Terpakai',	'2023-09-11'),
(60,	'EV03',	'70441',	'Terpakai',	'2023-09-11'),
(61,	'ev03',	'61263',	'Terpakai',	'2023-09-11'),
(62,	'EV02',	'77092',	'Belum Terpakai',	'2023-09-11'),
(63,	'EV03',	'14763',	'Terpakai',	'2023-09-12'),
(64,	'EV03',	'30651',	'Belum Terpakai',	'2023-09-13'),
(65,	'EV03',	'52559',	'Terpakai',	'2023-09-13'),
(66,	'EV03',	'00601',	'Terpakai',	'2023-09-13'),
(67,	'EV03',	'58580',	'Terpakai',	'2023-09-14'),
(68,	'EV03',	'25741',	'Terpakai',	'2023-09-15'),
(69,	'EV03',	'63563',	'Terpakai',	'2023-09-15'),
(70,	'EV03',	'47376',	'Terpakai',	'2023-09-18'),
(71,	'EV03',	'78014',	'Terpakai',	'2023-09-18'),
(72,	'EV03',	'20522',	'Terpakai',	'2023-09-19'),
(73,	'EV03',	'75188',	'Terpakai',	'2023-09-19'),
(74,	'EV03',	'18329',	'Terpakai',	'2023-09-19'),
(75,	'EV03',	'55400',	'Terpakai',	'2023-09-19'),
(76,	'EV03',	'93083',	'Terpakai',	'2023-09-19'),
(77,	'EV03',	'68233',	'Terpakai',	'2023-09-19'),
(78,	'EV03',	'83611',	'Terpakai',	'2023-09-20'),
(79,	'EV03',	'80840',	'Terpakai',	'2023-09-20'),
(80,	'EV03',	'22814',	'Terpakai',	'2023-09-20'),
(81,	'EV03',	'99563',	'Terpakai',	'2023-09-20'),
(82,	'EV03',	'37722',	'Terpakai',	'2023-09-21'),
(83,	'EV03',	'48032',	'Terpakai',	'2023-09-25'),
(84,	'EV03',	'43088',	'Terpakai',	'2023-09-25'),
(85,	'EV03',	'03815',	'Terpakai',	'2023-09-26'),
(86,	'EV11',	'53965',	'Belum Terpakai',	'2023-09-26'),
(87,	'EV03',	'62924',	'Belum Terpakai',	'2023-09-29'),
(88,	'EV03',	'66299',	'Terpakai',	'2023-09-29'),
(89,	'EV03',	'42893',	'Terpakai',	'2023-09-29'),
(90,	'EV03',	'34039',	'Terpakai',	'2023-09-29'),
(91,	'EV03',	'46665',	'Terpakai',	'2023-09-29'),
(92,	'EV03',	'30060',	'Terpakai',	'2023-09-29'),
(93,	'EV03',	'49495',	'Terpakai',	'2023-09-29'),
(94,	'EV03',	'45629',	'Terpakai',	'2023-10-02'),
(95,	'EV03',	'06110',	'Terpakai',	'2023-10-03'),
(96,	'EV03',	'16931',	'Terpakai',	'2023-10-03'),
(97,	'EV03',	'69050',	'Terpakai',	'2023-10-03'),
(98,	'EV03',	'50835',	'Terpakai',	'2023-10-03'),
(99,	'EV03',	'00594',	'Terpakai',	'2023-10-04'),
(100,	'EV03',	'93398',	'Terpakai',	'2023-10-06'),
(101,	'EV03',	'26827',	'Terpakai',	'2023-10-09'),
(102,	'ev03',	'89876',	'Terpakai',	'2023-10-25');

-- 2024-06-03 10:01:31
