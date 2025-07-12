-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 05:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banquet_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banquets`
--

CREATE TABLE `banquets` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Remarks` varchar(250) NOT NULL DEFAULT 'waiting for approval',
  `status` enum('pending','approved','rejected','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banquets`
--

INSERT INTO `banquets` (`id`, `owner_id`, `name`, `location`, `capacity`, `price`, `description`, `image`, `created_at`, `Remarks`, `status`) VALUES
(11, 4, 'marquee', 'north nazimabad karachi', 300, 120000.00, 'Marquee Banquet is an elegant and spacious event venue designed to host a wide range of occasions — from weddings and engagements to corporate events and birthday parties. With a seating capacity of up to 500 guests, modern lighting, air-conditioned halls, and premium décor,', '../../uploads/1752258039_arne-hellin-mhZBBx3BIwc-unsplash (1).jpg', '2025-07-11 18:20:39', 'waiting for approval', 'pending'),
(12, 3, 'Royal Grand Banquet', 'clifton phase 6', 600, 220000.00, 'Royal Grand Banquet is an elegant and spacious event venue designed to host a wide range of occasions — from weddings and engagements to corporate events and birthday parties. With a seating capacity of up to 500 guests, modern lighting, air-conditioned halls, and premium décor, this banquet ensures a luxurious and memorable experience for you and your guests.', '../../uploads/1752258222_thomas-william-OAVqa8hQvWI-unsplash (1).jpg', '2025-07-11 18:23:42', 'waiting for approval', 'pending'),
(13, 5, 'Concord', 'sakhi hassan north nazimabad', 400, 150000.00, 'Concord Banquet redefines elegance and hospitality for your most cherished moments. Whether it\'s a grand wedding, corporate gala, or festive celebration, our spacious hall, ambient lighting, and contemporary décor create the perfect atmosphere. With a guest capacity of up to 400, in-house catering, and professional event coordination,', '../../uploads/1752258638_soulseeker-creative-photography-nX5Xfn65R6Y-unsplash (1).jpg', '2025-07-11 18:30:38', 'waiting for approval', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `banquet_images`
--

CREATE TABLE `banquet_images` (
  `id` int(11) NOT NULL,
  `banquet_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banquet_owner`
--

CREATE TABLE `banquet_owner` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banquet_owner`
--

INSERT INTO `banquet_owner` (`id`, `name`, `email`, `phone`, `password`, `status`, `created_at`) VALUES
(3, 'saif u rehman', 'saif@gmail.com', '0316323652', '$2y$10$EjwqYuBYgm2G7qVshLInn.yE78qqxtBETLyJ6kfkEDweLUCUDDp0W', 'approved', '2025-07-10 04:52:29'),
(4, 'umar alam', 'umar@gmail.com', '03452654655', '$2y$10$ZI6rQHYxeAft0942zSufu.7habbydYoBIWA.F.FCldtAYoT1HOjTq', 'approved', '2025-07-10 05:57:41'),
(5, 'faraz', 'faraz@gmail.com', '03490830516', '$2y$10$pqBqvbwsVxwo6VDzsXxDZ.n/3IXHHowXPGvASJy3KG5d5DXHhG/rm', 'approved', '2025-07-11 18:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `banquet_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `event_type` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `payment_status` enum('pending','advance','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'imran', 'ik775239@gmail.com', '03162811932', '$2y$10$nHq6oocGSxAGfPhpDx01C.3su6xvCLTZL2W7CLndlMxjZDxS1aIse', '2025-07-05 10:08:41'),
(2, 'subhan', 'subhan@gmail.com', '03182243809', '$2y$10$3Vk9m/6PdhHtIYSi6c.CU.0aPlsuEprTq1cUdlLWe5bwxq4vWmcYG', '2025-07-06 03:36:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `banquets`
--
ALTER TABLE `banquets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `banquet_images`
--
ALTER TABLE `banquet_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banquet_id` (`banquet_id`);

--
-- Indexes for table `banquet_owner`
--
ALTER TABLE `banquet_owner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `banquet_id` (`banquet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banquets`
--
ALTER TABLE `banquets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `banquet_images`
--
ALTER TABLE `banquet_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banquet_owner`
--
ALTER TABLE `banquet_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banquets`
--
ALTER TABLE `banquets`
  ADD CONSTRAINT `banquets_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `banquet_owner` (`id`);

--
-- Constraints for table `banquet_images`
--
ALTER TABLE `banquet_images`
  ADD CONSTRAINT `banquet_images_ibfk_1` FOREIGN KEY (`banquet_id`) REFERENCES `banquets` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`banquet_id`) REFERENCES `banquets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
