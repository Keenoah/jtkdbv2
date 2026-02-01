-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2026 at 01:16 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jtkdbv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created`, `modified`) VALUES
(1, 'HAZWAN', '', '2026-01-11 15:20:22', '2026-01-11 15:20:22'),
(2, 'admin', '$2y$10$vD1RIy3bm3XD0IMczFX/q.9iVguOrcnUZVIHOmcCO0VaUJOVU.Jmi', '2026-01-12 01:15:28', '2026-01-13 07:36:51'),
(3, 'Haziq', '$2y$10$vD1RIy3bm3XD0IMczFX/q.9iVguOrcnUZVIHOmcCO0VaUJOVU.Jmi', '2026-01-12 01:26:52', '2026-01-13 07:37:05'),
(4, 'Filzatul', '$2y$10$r0oylhBGizHQ2DLEPWffF.xEl0Kd6SxsDxrEKVL5kirJDQaHK37Lm', '2026-01-12 01:26:52', '2026-01-12 01:26:52'),
(5, 'Nurazrin', '$2y$10$ExomrBb5L7zD5Wa1HH3by.Oyz1P4lJ/Ydn.yKMPO5FxUtUgvViPbe', '2026-01-12 01:26:52', '2026-01-12 01:26:52'),
(6, 'Iman', '$2y$10$guF0DNYkY9uVbXO/B1ttC.e6/PZxV.t0JA.5Cc3tO7vVO.ZFMS9ZG', '2026-01-12 01:26:53', '2026-01-12 01:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `officer_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `complaint_text` text,
  `status` varchar(20) DEFAULT 'Submitted',
  `file_path` varchar(255) DEFAULT NULL,
  `employer_name` varchar(255) DEFAULT NULL,
  `employer_address` text,
  `employer_tel` int DEFAULT NULL,
  `employer_email` varchar(255) DEFAULT NULL,
  `person_in_charge` varchar(255) DEFAULT NULL,
  `comp_name_1` varchar(255) DEFAULT NULL,
  `comp_ic_1` int DEFAULT NULL,
  `comp_name_2` varchar(255) DEFAULT NULL,
  `comp_ic_2` int DEFAULT NULL,
  `comp_name_3` varchar(255) DEFAULT NULL,
  `comp_ic_3` int DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `officer_id`, `admin_id`, `category`, `complaint_text`, `status`, `file_path`, `employer_name`, `employer_address`, `employer_tel`, `employer_email`, `person_in_charge`, `comp_name_1`, `comp_ic_1`, `comp_name_2`, `comp_ic_2`, `comp_name_3`, `comp_ic_3`, `created`, `modified`) VALUES
(7, 6, 25, 3, 'Salary', 'Saye kerja sebagai bakery, gaji saye masih sikit walaupun tahun 2026. gaji saye masih 1400. saye berkaj sudah 2 tahun. ', 'Settled', NULL, 'Mira Cake House', 'Taman Desa Ilmu, kota asamarahan', 13, 'akimnyenye223@gmail.com', 'Rauf Bin Hasyim', '', 0, '', 0, '', 0, '2026-01-19 08:23:49', '2026-01-19 08:38:05'),
(8, 7, 10, 3, 'General', 'General complaint', 'Pending', 'evidence_1768813150_754.png', 'Morrow Cafe', 'Morrow Pundana, 92380 Shah Alam', 19, 'morrow@mail.com', 'Mohd Akmal', 'Ali', 19, 'Abu', 19, '', 0, '2026-01-19 08:59:10', '2026-01-20 02:58:02'),
(9, 4, 9, 3, 'Termination', 'Kena pecat tanpa notis', 'Settled', NULL, 'Arked Selama', 'Arked Selama, Perak', 2147483647, 'maria@arked.com', 'Pn. Maria', '', 0, '', 0, '', 0, '2026-01-20 05:55:26', '2026-01-20 05:55:54'),
(10, 4, 8, 3, 'Termination', 'Pecat tak kasi gaji', 'In Progress', 'evidence_1768889027_954.jpg', 'Rapid Pundana', 'Rapid Pundana, Shah Alam', 1125236364, 'rapid@gmail.com', 'Kasim Selamat', '', 0, '', 0, '', 0, '2026-01-20 06:03:47', '2026-01-20 06:04:10'),
(11, 9, 6, 3, 'Salary', 'Gaji tak cukup', 'Settled', 'evidence_1768890120_533.jpg', 'Mira Cake House ', 'Alam budiman', 13, 'linyin@gmail.com', 'Lin Yin', '', 0, '', 0, '', 0, '2026-01-20 06:22:01', '2026-01-20 06:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`id`, `name`, `department`, `email`, `created`, `modified`) VALUES
(1, 'Officer Farah', 'Salary', 'sarah@admin.com', '2026-01-11 15:21:29', '2026-01-13 07:09:11'),
(3, 'Officer Ahmad', 'General', 'ahmad@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(4, 'Officer Siti', 'General', 'siti@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(5, 'Officer Muthu', 'General', 'muthu@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(6, 'Officer Sarah', 'Salary', 'sarah@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(8, 'Officer Firdaus', 'Termination', 'firdaus@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(9, 'Officer Wong', 'Termination', 'wong@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(10, 'Officer Bella', 'Termination', 'bella@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(11, 'Officer Rajesh', 'Foreign Worker', 'rajesh@jtk.gov.my', '2026-01-12 10:05:28', '2026-01-12 10:05:28'),
(24, 'Officer Aiman', 'General', 'aiman@jtk.gov.my', '2026-01-16 10:25:27', '2026-01-16 10:25:27'),
(25, 'Officer Salman', 'Salary', 'salman@jtk.gov.my', '2026-01-16 10:27:34', '2026-01-16 10:27:34'),
(27, 'Officer Amin', 'Foreign Worker', 'amin@jtk.gov.my', '2026-01-19 08:43:46', '2026-01-19 08:43:46'),
(29, 'Officer Syed', 'Foreign Worker', 'syed@jtk.gov.my', '2026-01-20 02:46:16', '2026-01-20 02:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `ic_number` int DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `address` text,
  `email` varchar(255) DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `ic_number`, `gender`, `age`, `nationality`, `address`, `email`, `phone`, `password`, `created`, `modified`) VALUES
(1, 'HAZIQ HAZWAN', 2147483647, 'Male', 21, 'Malaysian', '1432, Jalan Mutiara 1/6, 09700 Karangan, Kedah', 'haziq@gmail.com', 116113480, '$2y$10$u0560.WvN6S.I9/X7l7fD.LwXhJq3fMvP5K6eL6b5Fz7G8h9iJkLm', '2026-01-11 11:15:39', '2026-01-11 11:16:41'),
(2, 'FILZATUL WAWA', 2147483647, 'Female', NULL, 'Malaysian', '123, Kuching, Sarawak', 'wawa@admin.com', 1161134588, '$2y$10$Wou8my1G8A2WlkSK7c3Ylej1upV0HHfMIpxukIfzZeU0TOLszI76y', '2026-01-11 03:37:54', '2026-01-11 11:38:15'),
(3, 'HAZIQ HAZWAN ZAHARI', 2147483647, 'Male', NULL, 'Malaysian', '1432, Taman Mutiara, Kulim, Kedah', 'haziq@user.com', 1261134588, '$2y$10$VUVUJfZdEH7X9pL0CR2bWOtyqKEZPXSs.EUfI7.I8liVyHfSqPN0a', '2026-01-11 03:43:52', '2026-01-11 06:16:15'),
(4, 'Nur Filzatul Najwa ', 2147483647, 'Female', 22, 'Malaysian', '1222, Jalan Mutiara, Taman Mutiara, 9700 Karangan, Kedah', 'najwa@gmail.com', 1161134588, '$2y$10$EmSZEXhe8D8SnekuDf14TOmg0jJ5twcLS/IFtJP.E6hKxFMLviPgC', '2026-01-13 01:51:30', '2026-01-13 01:51:30'),
(5, 'Nur Filzatul Najwa', 40510, 'Female', 22, 'Malaysian', 'No.123, Kampung Tak Tahu, Sarawak', 'nurfilzatulnajwa@gmail.com', 17, '$2y$10$rQMZRo4Gdzn4fGC4ngVg0.sOneFg8x5XNyj7WI9Pbhw/vWlMOYLQ2', '2026-01-16 09:39:14', '2026-01-16 09:39:14'),
(6, 'Muhammad Iman Bin Yunus', 70510, 'Male', 20, 'Malaysian', 'Kampung Wawasan,94650, Kabong', 'imanyunus803@gmail.com', 13, '$2y$10$YjfSBq47UPKWpc5n8DFmY.MMdFP8FxiSLwUq7GtnttAhke87J7Msq', '2026-01-19 08:18:06', '2026-01-19 08:18:06'),
(7, 'Aminah Amin', 10203, 'Female', 39, 'Malaysian', 'Taman Mutiara, Jalan Lama, 19199, Pulau Pinang', 'aminah@gmail.com', 11, '$2y$10$4LDbDE4LWsv8wR/tJfcfGuDhziwKLb0u9E4sTdjJl24SUHZdFKaKm', '2026-01-19 08:55:35', '2026-01-19 08:55:35'),
(8, 'Aminah Amin', 10203, 'Female', 39, 'Malaysian', 'Taman Mawar, Jalan Hang Tuah', 'aminah@mail.com', 11, '$2y$10$7AjpN3qhHgNCRH/OgsFWB.DykT5Eo9gvmG/nLQ316McbjNPeSGXiC', '2026-01-19 09:05:28', '2026-01-19 09:05:28'),
(9, 'Muhammad Iman Bin Yunus', 40510, 'Male', 22, 'Malaysian', 'Uitm Puncak Perdana', 'imanyunus00@gmail.com', 13, '$2y$10$wk6WnXslFhopnnPAsA/ezug7qbORLVIhHdWGWZC/oEGrXyrlRDVG6', '2026-01-20 06:18:58', '2026-01-20 06:18:58'),
(11, 'Muhd Keen', 2147483647, 'Male', 22, 'Malaysian', '123, Jalan Jerung, Taman Jerung, 09000 Kulim, Kedah', 'muhdkeen@gmail.com', 1161134580, '$2y$10$HkvzhOMwBnqNqwQUVv5Yz.cU6dO.doRKOBeMLS6azgIXeN7Y2v88W', '2026-01-24 13:17:00', '2026-01-24 13:17:00'),
(12, 'Muhd Hazwan', 2147483647, 'Male', 22, 'Malaysian', '123, Jalan Bulan, 09000 Bachok, Kelantan', 'hazwan@gmail.com', 1161134580, '$2y$10$VUVLUzQVrpY7ZLHsLYeqM.D2TUWvStEPVYqgEFQgljF1Ra4N4gqIS', '2026-01-24 13:41:15', '2026-01-24 13:41:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `officer_id` (`officer_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`id`),
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
