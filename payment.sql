-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.infinityfree.com
-- Generation Time: Jan 29, 2026 at 12:22 AM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40766948_sys_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `act_certificate`
--

CREATE TABLE `act_certificate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `act_orange_doc` varchar(255) DEFAULT NULL,
  `act_blue_doc` varchar(255) DEFAULT NULL,
  `act_orange_expiry` date DEFAULT NULL,
  `act_blue_expiry` date DEFAULT NULL,
  `act_orange_expiry_15d` date DEFAULT NULL,
  `act_blue_expiry_15d` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `act_certificate`
--

INSERT INTO `act_certificate` (`id`, `user_id`, `act_orange_doc`, `act_blue_doc`, `act_orange_expiry`, `act_blue_expiry`, `act_orange_expiry_15d`, `act_blue_expiry_15d`, `created_at`, `updated_at`) VALUES
(5, 17, 'Upload/owner@gmail.com/act_orange.png', 'Upload/owner@gmail.com/act_blue.png', '2026-10-19', '2026-10-19', '2026-10-04', '2026-10-04', '2026-01-25 10:28:40', '2026-01-25 10:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `mode` enum('static','event') NOT NULL,
  `shift_start` datetime NOT NULL,
  `shift_end` datetime NOT NULL,
  `status` enum('present','half_day','absent') NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `shift_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `user_name`, `mode`, `shift_start`, `shift_end`, `status`, `updated_by`, `created_at`, `updated_at`, `shift_id`) VALUES
(3, 19, 'harsh (ID: 19)', 'static', '2026-01-21 22:08:00', '2026-08-22 09:08:00', 'present', 20, '2026-01-25 10:54:17', '2026-01-25 10:54:17', NULL),
(4, 18, 'karan (ID: 18)', 'static', '2026-01-09 10:00:00', '2026-01-12 09:00:00', 'present', 20, '2026-01-25 10:54:54', '2026-01-25 10:54:54', NULL),
(5, 19, 'harsh (ID: 19)', 'event', '2026-01-02 10:00:00', '2026-01-13 14:10:00', 'present', 20, '2026-01-25 13:50:06', '2026-01-25 13:50:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `id` int(11) NOT NULL,
  `contractor_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `pay_amount` decimal(10,2) NOT NULL,
  `pay_slip` varchar(255) DEFAULT NULL,
  `pay_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `contractor_name`, `email`, `contact_number`, `pay_amount`, `pay_slip`, `pay_date`, `created_at`) VALUES
(2, 'Himanshu', 'admin1@gmail.com', '9817727722', '2000.00', '/Upload/contractors/admin1@gmail.com.png', '2026-01-20', '2026-01-25 14:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `payment_track`
--

CREATE TABLE `payment_track` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_id` bigint(20) NOT NULL,
  `cash_payment` decimal(10,2) DEFAULT 0.00,
  `ni_payment` decimal(10,2) DEFAULT 0.00,
  `expense` decimal(10,2) DEFAULT 0.00,
  `payment_status` enum('pending','paid','partial') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharecode_first_aid`
--

CREATE TABLE `sharecode_first_aid` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `share_code_doc` varchar(255) DEFAULT NULL,
  `share_code_number` varchar(20) DEFAULT NULL,
  `share_code_expiry` date DEFAULT NULL,
  `share_code_expiry_15d` date DEFAULT NULL,
  `first_aid_doc` varchar(255) DEFAULT NULL,
  `first_aid_expiry` date DEFAULT NULL,
  `first_aid_expiry_1m` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sharecode_first_aid`
--

INSERT INTO `sharecode_first_aid` (`id`, `user_id`, `share_code_doc`, `share_code_number`, `share_code_expiry`, `share_code_expiry_15d`, `first_aid_doc`, `first_aid_expiry`, `first_aid_expiry_1m`, `created_at`, `updated_at`) VALUES
(5, 17, 'Upload/owner@gmail.com/share_code.png', 'WHH SBK 6PT', '2026-01-17', '2026-01-02', 'Upload/owner@gmail.com/first_aid.png', '2026-12-01', '2026-11-01', '2026-01-25 10:28:40', '2026-01-25 10:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `shift_type` enum('static','event') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `shift_name`, `shift_type`, `created_at`) VALUES
(1, 'LEEDS UNITED FOOT BALL', 'event', '2026-01-25 13:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `sia_licence`
--

CREATE TABLE `sia_licence` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sia_licence_doc` varchar(255) NOT NULL,
  `sia_licence_number` varchar(50) NOT NULL,
  `sia_licence_expiry` date NOT NULL,
  `sia_licence_expiry_3m` date DEFAULT NULL,
  `sia_licence_expiry_2m` date DEFAULT NULL,
  `sia_licence_expiry_1m` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sia_licence`
--

INSERT INTO `sia_licence` (`id`, `user_id`, `sia_licence_doc`, `sia_licence_number`, `sia_licence_expiry`, `sia_licence_expiry_3m`, `sia_licence_expiry_2m`, `sia_licence_expiry_1m`, `created_at`, `updated_at`) VALUES
(5, 17, 'Upload/owner@gmail.com/sia_licence.png', '1018 1421 2846 6978', '2028-06-18', '2028-03-18', '2028-04-18', '2028-05-18', '2026-01-25 10:28:40', '2026-01-25 10:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `signed_authentication_doc` varchar(255) DEFAULT NULL,
  `signed_screening_doc` varchar(255) DEFAULT NULL,
  `role` enum('user','admin','owner') NOT NULL DEFAULT 'user',
  `user_type` enum('event','static') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_id`, `name`, `email`, `password`, `contact`, `address`, `signed_authentication_doc`, `signed_screening_doc`, `role`, `user_type`, `is_active`, `created_at`, `updated_at`) VALUES
(17, NULL, 'Himanshu Swami', 'owner@gmail.com', '12345', '971751020', 'H. NO. 101/9 , Subhash Nagar ,Near DSD College ,Gurgaon', 'Upload/owner@gmail.com/authentication_signed.png', 'Upload/owner@gmail.com/screening_signed.png', 'owner', 'event', 1, '2026-01-25 10:28:40', '2026-01-25 10:34:42'),
(18, 1003, 'karan', 'user@gmail.com', '09876', '971751020', 'H. NO. 101/9 , Subhash Nagar ,Near DSD College ,Gurgaon', 'Upload/owner@gmail.com/authentication_signed.png', 'Upload/owner@gmail.com/screening_signed.png', 'user', 'event', 1, '2026-01-25 10:28:40', '2026-01-25 13:18:48'),
(19, NULL, 'harsh', 'user1@gmail.com', '', '971751020', 'H. NO. 101/9 , Subhash Nagar ,Near DSD College ,Gurgaon', 'Upload/owner@gmail.com/authentication_signed.png', 'Upload/owner@gmail.com/screening_signed.png', 'user', 'event', 1, '2026-01-25 10:28:40', '2026-01-25 10:29:05'),
(20, 1001, 'sanjeev', 'admin@gmail.com', '12345', '971751020', 'H. NO. 101/9 , Subhash Nagar ,Near DSD College ,Gurgaon', 'Upload/owner@gmail.com/authentication_signed.png', 'Upload/owner@gmail.com/screening_signed.png', 'admin', 'event', 1, '2026-01-25 10:28:40', '2026-01-25 10:39:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `act_certificate`
--
ALTER TABLE `act_certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_act_user` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attendance_user` (`user_id`),
  ADD KEY `fk_attendance_updated_by` (`updated_by`);

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payment_track`
--
ALTER TABLE `payment_track`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_user` (`user_id`),
  ADD KEY `fk_payment_attendance` (`attendance_id`);

--
-- Indexes for table `sharecode_first_aid`
--
ALTER TABLE `sharecode_first_aid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_share_user` (`user_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sia_licence`
--
ALTER TABLE `sia_licence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sia_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `act_certificate`
--
ALTER TABLE `act_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_track`
--
ALTER TABLE `payment_track`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sharecode_first_aid`
--
ALTER TABLE `sharecode_first_aid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sia_licence`
--
ALTER TABLE `sia_licence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `act_certificate`
--
ALTER TABLE `act_certificate`
  ADD CONSTRAINT `fk_act_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_track`
--
ALTER TABLE `payment_track`
  ADD CONSTRAINT `fk_payment_attendance` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sharecode_first_aid`
--
ALTER TABLE `sharecode_first_aid`
  ADD CONSTRAINT `fk_share_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sia_licence`
--
ALTER TABLE `sia_licence`
  ADD CONSTRAINT `fk_sia_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
