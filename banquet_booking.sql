-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 09:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
(18, 4, 'marquee', 'sharah-e-noor jahan', 400, '75000.00', 'SkyDec Banquet is a modern and elegant event space designed to make your special moments unforgettable. Whether you\'re planning a wedding, birthday, corporate gathering, or a family function, our spacious hall, beautiful décor, and professional staff ensure a flawless experience.\r\n\r\n', '../../uploads/1753589936_library-of-congress-xPes12KkVUg-unsplash-min.jpg', '2025-07-23 15:56:12', 'rejected', 'rejected'),
(21, 6, 'Concord', 'north nazimabad karachi', 600, '120000.00', 'Concord Banquet is a premium event venue designed to make your special occasions truly unforgettable. Located in a prime area, it offers a perfect blend of elegance and modern amenities. With spacious halls, ambient lighting, and exceptional service, Concord Banquet is ideal for weddings, corporate events, birthdays, and more. ', '../../uploads/1754043462_andra-c-taylor-jr-Qd-lPUtupYA-unsplash (1).jpg', '2025-08-01 10:17:42', 'waiting for approval', 'pending');

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

--
-- Dumping data for table `banquet_images`
--

INSERT INTO `banquet_images` (`id`, `banquet_id`, `image`, `uploaded_at`) VALUES
(12, 18, '1753591078_8622_andra-c-taylor-jr-Qd-lPUtupYA-unsplash-min.jpg', '2025-07-27 04:37:58'),
(13, 18, '1753591078_3586_diogo-nunes-7eCcYQ-zOpc-unsplash-min.jpg', '2025-07-27 04:37:58'),
(14, 18, '1753591078_8073_quang-nguyen-vinh-pWzgTOpAYKM-unsplash-min.jpg', '2025-07-27 04:37:58'),
(24, 21, '1754044024_2821_jordan-arnold-Ul07QK2AR-0-unsplash (1).jpg', '2025-08-01 10:27:04'),
(25, 21, '1754044024_1675_keith-tanner-Cqr7gf5N22E-unsplash (1).jpg', '2025-08-01 10:27:04'),
(26, 21, '1754044024_6493_andra-c-taylor-jr-Qd-lPUtupYA-unsplash (1).jpg', '2025-08-01 10:27:04'),
(27, 21, '1754044024_9829_richard-sosa-oPyWP1LrCsg-unsplash (1).jpg', '2025-08-01 10:27:04');

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
  `status` enum('pending','approved','rejected') DEFAULT 'approved',
  `owner_image` varchar(250) NOT NULL DEFAULT 'owner_img',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banquet_owner`
--

INSERT INTO `banquet_owner` (`id`, `name`, `email`, `phone`, `password`, `status`, `owner_image`, `created_at`) VALUES
(3, 'saif u rehman', 'saif@gmail.com', '0316323652', '$2y$10$EjwqYuBYgm2G7qVshLInn.yE78qqxtBETLyJ6kfkEDweLUCUDDp0W', 'rejected', 'owner_img', '2025-07-10 04:52:29'),
(4, 'umar alam', 'umar@gmail.com', '03452654655', '$2y$10$ZI6rQHYxeAft0942zSufu.7habbydYoBIWA.F.FCldtAYoT1HOjTq', 'approved', 'imran-img2.jpg', '2025-07-10 05:57:41'),
(5, 'faraz', 'faraz@gmail.com', '03490830516', '$2y$10$pqBqvbwsVxwo6VDzsXxDZ.n/3IXHHowXPGvASJy3KG5d5DXHhG/rm', 'approved', 'imran-img.jpg', '2025-07-11 18:26:21'),
(6, 'qasim', 'qasim@gmail.com', '1351303212', '$2y$10$vWYBZLoIGoPek2BlehG6MeroOYH9u/At4kP/zuZ9uyWRkhAoooSOq', 'approved', 'owner_img', '2025-07-12 15:32:16'),
(8, 'anus', 'anus@gmail.com', '0398454654', '$2y$10$uH6HvvLUl31JaCF12GcEy.68pGEOKXnbDJjrpXXVcUixc8b0Tg1HO', 'approved', 'owner_img', '2025-08-01 09:47:52');

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
  `payment_option` varchar(250) NOT NULL,
  `notes` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(250) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `payment_status` enum('pending','advance','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `banquet_id`, `date`, `time_slot`, `payment_option`, `notes`, `address`, `amount`, `payment_method`, `status`, `payment_status`, `created_at`) VALUES
(19, 1, 18, '2025-08-15', 'Evening (7 PM - 11 PM)', '0', '', '', 0, '', 'pending', 'pending', '2025-07-27 05:47:17'),
(20, 2, 18, '2025-08-14', 'Morning (10 AM - 2 PM)', '0', '', '', 0, '', 'pending', 'pending', '2025-07-30 10:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `catering_services`
--

CREATE TABLE `catering_services` (
  `id` int(11) NOT NULL,
  `banquet_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_head` decimal(10,2) NOT NULL,
  `min_guests` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catering_services`
--

INSERT INTO `catering_services` (`id`, `banquet_id`, `owner_id`, `title`, `description`, `price_per_head`, `min_guests`, `status`, `created_at`) VALUES
(2, 18, 4, 'chicken', 'chicken biryani,\nchicken qorma,\ncooldrink', '1200.00', 100, 'active', '2025-08-05 07:34:38'),
(3, 18, 4, 'Beef', 'Beef Biryani,\r\nBeef Qorma,\r\nCooldrink,', '1600.00', 100, 'active', '2025-08-05 07:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `rating`, `created_at`) VALUES
(1, 'Subhan ansari', 'subhanansarirr4@gmail.com', 'frrefggdgv', 2, '2025-08-09 07:52:30');

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
(2, 'subhan', 'subhan@gmail.com', '03182243809', '$2y$10$3Vk9m/6PdhHtIYSi6c.CU.0aPlsuEprTq1cUdlLWe5bwxq4vWmcYG', '2025-07-06 03:36:21'),
(3, 'qasim', 'qasim@gmail.com', '1351303212', '$2y$10$vWB0nfAktNKpXiTRHyTfJuSN8ENQLXjAS/mh/r5u8P8qp.KC8/kvW', '2025-08-01 05:34:10'),
(4, 'khan', 'khan@gmail.com', '031546654', '$2y$10$HyCT4QdY.h5LMtCbYwYK4ulZLe4EvfBmWzsTeu7PB9kqjPXAuVXGS', '2025-08-04 06:05:28');

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
-- Indexes for table `catering_services`
--
ALTER TABLE `catering_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `banquet_images`
--
ALTER TABLE `banquet_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `banquet_owner`
--
ALTER TABLE `banquet_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `catering_services`
--
ALTER TABLE `catering_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
