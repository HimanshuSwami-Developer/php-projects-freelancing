-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2026 at 10:32 PM
-- Server version: 10.6.24-MariaDB-cll-lve
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ereal_state`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','manager') DEFAULT 'manager',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@example.com', 'admin', 'active', '2025-11-12 07:13:07', '2025-11-12 07:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `enquire_table`
--

CREATE TABLE `enquire_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  `bhk_type` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquire_table`
--

INSERT INTO `enquire_table` (`id`, `name`, `email`, `number`, `bhk_type`, `created_at`) VALUES
(1, 'Himanshu swami', 'himanshuswami2810@gmail.com', '9718751020', '1 BHK', '2025-11-13 17:46:37'),
(2, 'Gold', 'himanshuswami2810@gmail.com', '9718751020', '2 BHK', '2025-11-13 17:55:39'),
(3, 'Himanshu Swami', 'admin1@gmail.com', '09718751020', '2 BHK', '2026-01-26 15:16:38'),
(4, 'Himanshu swami', 'himanshuswami2810@gmail.com', '9718751020', '2 BHK', '2026-01-26 18:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `property_type` enum('sale','portfolio') NOT NULL DEFAULT 'portfolio',
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `beds` int(11) DEFAULT 0,
  `baths` int(11) DEFAULT 0,
  `area` int(11) DEFAULT NULL,
  `image_thumbnail` text DEFAULT NULL,
  `images_gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images_gallery`)),
  `status` enum('new','active','inactive') DEFAULT 'new',
  `rating` decimal(2,1) DEFAULT 0.0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `room_type`, `property_type`, `location`, `type`, `beds`, `baths`, `area`, `image_thumbnail`, `images_gallery`, `status`, `rating`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Shiva Apartment', '3BHK', 'sale', 'Delhi NCR & Kotputli', '3BHK - 4 Flats Apartment', 3, 1, 200, 'Uploads/shiva_apartment/thumb.jpg', '[\"Uploads\\/shiva_apartment\\/1.jpg\",\"Uploads\\/shiva_apartment\\/2.jpg\",\"Uploads\\/shiva_apartment\\/3.jpg\",\"Uploads\\/shiva_apartment\\/4.jpg\",\"Uploads\\/shiva_apartment\\/5.jpg\",\"Uploads\\/shiva_apartment\\/6.jpg\",\"Uploads\\/shiva_apartment\\/7.jpg\"]', 'new', 4.7, 'Bright, airy apartment with stunning city view near Cyber Hub.', '2026-01-27 17:03:28', '2026-01-28 18:42:44'),
(2, 'Rudra Apartment', '2BHK', 'sale', 'Delhi NCR & Kotputli', '2BHK - 8 Flats Apartment', 2, 2, 125, 'Uploads/rudra_apartment/thumb.jpg', '[\"Uploads\\/rudra_apartment\\/1.jpg\"]', 'new', 4.3, 'Spacious villa with private garden and two-car parking.', '2026-01-27 17:03:28', '2026-01-28 18:42:54'),
(3, 'Radhe Apartment', '3BHK', 'sale', 'Kotputli', '3BHK - 4 Flats Apartment', 3, 2, 450, 'Uploads/radhe_apartment/thumb.jpg', '[\"Uploads\\/radhe_apartment\\/1.jpg\",\"Uploads\\/radhe_apartment\\/2.jpg\",\"Uploads\\/radhe_apartment\\/3.jpg\",\"Uploads\\/radhe_apartment\\/4.jpg\"]', 'new', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:43:03'),
(4, 'Om Sai Apartment', '3BHK', 'portfolio', 'Delhi NCR', '3BHK - 8 Flats Apartment', 3, 2, 200, 'Uploads/om_sai_apartment/thumb.jpg', '[\"Uploads\\/om_sai_apartment\\/1.jpg\",\"Uploads\\/om_sai_apartment\\/2.jpg\",\"Uploads\\/om_sai_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:45:53'),
(5, 'Om Apartment', '3BHK', 'portfolio', 'Delhi NCR', '3BHK - 4 Flats Apartment', 3, 2, 120, 'Uploads/om_apartment/thumb.jpg', '[\"Uploads\\/om_apartment\\/1.jpg\",\"Uploads\\/om_apartment\\/2.jpg\",\"Uploads\\/om_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 03:22:13'),
(6, 'Maa Vashno Apartment', '4BHK', 'portfolio', 'Delhi NCR & Kotputli', '4BHK - 4 Flats Apartment', 4, 1, 120, 'Uploads/maa_vashno_apartment/thumb.jpg', '[\"Uploads\\/maa_vashno_apartment\\/1.jpg\",\"Uploads\\/maa_vashno_apartment\\/2.jpg\",\"Uploads\\/maa_vashno_apartment\\/3.jpg\",\"Uploads\\/maa_vashno_apartment\\/4.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 03:22:38'),
(7, 'Laxmi Apartment', '4BHK', 'portfolio', 'Delhi NCR & Kotputli', '4BHK - 4 Flats Apartment', 4, 2, 139, 'Uploads/laxmi_apartment/thumb.jpg', '[\"Uploads\\/laxmi_apartment\\/1.jpg\",\"Uploads\\/laxmi_apartment\\/2.jpg\",\"Uploads\\/laxmi_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:13:22'),
(8, 'Kashi Apartment', '2BHK', 'portfolio', 'Kotputli', '2BHK - 4 Flats Apartment', 2, 1, 166, 'Uploads/kashi_apartment/thumb.jpg', '[\"Uploads\\/kashi_apartment\\/1.jpg\",\"Uploads\\/kashi_apartment\\/2.jpg\",\"Uploads\\/kashi_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:12:32'),
(9, 'Guru Ji Apartment', '3BHK', 'portfolio', 'Delhi NCR', '3BHK - 4 Flats Apartment', 3, 2, 150, 'Uploads/guru_ji_apartment/thumb.jpg', '[\"Uploads\\/guru_ji_apartment\\/1.jpg\",\"Uploads\\/guru_ji_apartment\\/2.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:11:58'),
(10, 'Gayatri Apartment', '3BHK', 'portfolio', 'Delhi NCR', '3BHK - 8 Flats Apartment', 3, 2, 200, 'Uploads/gayatri_apartment/thumb.jpg', '[\"Uploads\\/gayatri_apartment\\/1.jpg\",\"Uploads\\/gayatri_apartment\\/2.jpg\",\"Uploads\\/gayatri_apartment\\/3.jpg\"]', 'active', 4.7, 'Bright, airy apartment with stunning city view near Cyber Hub.', '2026-01-27 17:03:28', '2026-01-28 18:11:02'),
(11, 'Gauri Apartment', '3BHK', 'portfolio', 'Delhi NCR & Kotputli', '3BHK - 4 Flats Apartment', 3, 2, 230, 'Uploads/gauri_apartment/thumb.jpg', '[\"Uploads\\/gauri_apartment\\/1.jpg\",\"Uploads\\/gauri_apartment\\/2.jpg\",\"Uploads\\/gauri_apartment\\/3.jpg\"]', 'active', 4.3, 'Spacious villa with private garden and two-car parking.', '2026-01-27 17:03:28', '2026-01-28 18:10:35'),
(12, 'Ganga Apartment', '3BHK', 'portfolio', 'Delhi NCR', '3BHK - 4 Flats Apartment', 3, 2, 200, 'Uploads/ganga_apartment/thumb.jpg', '[\"Uploads\\/ganga_apartment\\/1.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:08:41'),
(13, 'Durga Apartment', '3BHK', 'portfolio', 'Delhi NCR & Kotputli', '3BHK - 8 Flats Apartment', 3, 2, 200, 'Uploads/durga_apartment/thumb.jpg', '[\"Uploads\\/durga_apartment\\/1.jpg\",\"Uploads\\/durga_apartment\\/2.jpg\",\"Uploads\\/durga_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:08:15'),
(14, 'Bala Ji Apartment', '3BHK', 'portfolio', 'Kotputli', '3BHK - 4 Flats Apartment', 3, 2, 153, 'Uploads/bala_ji_apartment/thumb.jpg', '[\"Uploads\\/bala_ji_apartment\\/1.jpg\",\"Uploads\\/bala_ji_apartment\\/2.jpg\",\"Uploads\\/bala_ji_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:07:27'),
(15, 'Shiva Apartment', '2BHK', 'portfolio', 'Kotputli', '2BHK - 8 Flats Apartment', 2, 1, 200, 'Uploads/shiva_apartment/thumb.jpg', '[\"Uploads\\/shiva_apartment\\/1.jpg\",\"Uploads\\/shiva_apartment\\/2.jpg\",\"Uploads\\/shiva_apartment\\/3.jpg\",\"Uploads\\/shiva_apartment\\/4.jpg\"]', 'active', 4.7, 'Bright, airy apartment with stunning city view near Cyber Hub.', '2026-01-27 17:03:28', '2026-01-28 18:05:16'),
(16, 'Bala Ji Apartment', '2BHK', 'portfolio', 'Delhi NCR & Kotputli', '2BHK - 4 Flats Apartment', 2, 1, 153, 'Uploads/bala_ji_apartment/thumb.jpg', '[\"Uploads\\/bala_ji_apartment\\/1.jpg\",\"Uploads\\/bala_ji_apartment\\/2.jpg\",\"Uploads\\/bala_ji_apartment\\/3.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:04:31'),
(17, 'Radhe Apartment', '2BHK', 'portfolio', 'Delhi NCR', '2BHK - 20 Flats Apartment', 2, 1, 450, 'Uploads/radhe_apartment/thumb.jpg', '[\"Uploads\\/radhe_apartment\\/1.jpg\",\"Uploads\\/radhe_apartment\\/2.jpg\",\"Uploads\\/radhe_apartment\\/3.jpg\",\"Uploads\\/radhe_apartment\\/4.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:03:27'),
(18, 'Gauri Apartment', '4BHK', 'portfolio', 'Delhi NCR', '4BHK - 4 Flats Apartment', 4, 2, 230, 'Uploads/gauri_apartment/thumb.jpg', '[\"Uploads\\/gauri_apartment\\/1.jpg\",\"Uploads\\/gauri_apartment\\/2.jpg\",\"Uploads\\/gauri_apartment\\/3.jpg\"]', 'active', 4.3, 'Spacious villa with private garden and two-car parking.', '2026-01-27 17:03:28', '2026-01-28 18:02:14'),
(19, 'Guru Ji Apartment', '2BHK', 'portfolio', 'Kotputli', '2BHK - 4 Flats Apartment', 2, 1, 150, 'Uploads/guru_ji_apartment/thumb.jpg', '[\"Uploads\\/guru_ji_apartment\\/1.jpg\",\"Uploads\\/guru_ji_apartment\\/2.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:01:06'),
(20, 'Ganga Apartment', '2BHK', 'portfolio', 'Kotputli', '2BHK - 4 Flats Apartment', 2, 1, 200, 'Uploads/ganga_apartment/thumb.jpg', '[\"Uploads\\/ganga_apartment\\/1.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 18:00:06'),
(21, 'Tirupati Apartment', '3BHK', 'portfolio', 'Delhi NCR & Kotputli', '3BHK - 20 Flats Apartment', 3, 2, 200, 'Uploads/tirupati_apartment/thumb.jpg', '[\"Uploads\\/tirupati_apartment\\/1.jpg\",\"Uploads\\/tirupati_apartment\\/2.jpg\",\"Uploads\\/tirupati_apartment\\/3.jpg\",\"Uploads\\/tirupati_apartment\\/4.jpg\",\"Uploads\\/tirupati_apartment\\/5.jpg\"]', 'active', 4.8, 'Ideal for singles or working professionals. Compact and modern.', '2026-01-27 17:03:28', '2026-01-28 17:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `visit_booking`
--

CREATE TABLE `visit_booking` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_location` varchar(255) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `visit_date` date NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visit_booking`
--

INSERT INTO `visit_booking` (`id`, `property_id`, `property_name`, `property_location`, `customer_name`, `customer_phone`, `customer_email`, `visit_date`, `booking_date`, `status`) VALUES
(1, 1, 'Modern 2BHK Apartment in Gurugram', 'Gurugram, HR', 'Himanshu', '9718751020', 'himanshuswami2810@gmail.com', '2025-11-13', '2025-11-12 07:00:57', 'pending'),
(2, 2, 'Luxury 3BHK Villa in Sohna Road', 'Sohna Road, Gurugram', 'Kartik', '9718751020', 'himanshuswami2810@gmail.com', '2025-11-13', '2025-11-12 17:05:57', 'confirmed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `enquire_table`
--
ALTER TABLE `enquire_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visit_booking`
--
ALTER TABLE `visit_booking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enquire_table`
--
ALTER TABLE `enquire_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `visit_booking`
--
ALTER TABLE `visit_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
