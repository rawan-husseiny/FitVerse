-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 09:31 PM
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
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outfits`
--

CREATE TABLE `outfits` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `body_shape` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `style_profiles`
--

CREATE TABLE `style_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `clothes_type` varchar(50) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `body_shape` varchar(50) DEFAULT NULL,
  `top_size` varchar(10) DEFAULT NULL,
  `bottom_size` varchar(10) DEFAULT NULL,
  `dress_size` varchar(10) DEFAULT NULL,
  `jean_size` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `style_profiles`
--

INSERT INTO `style_profiles` (`id`, `user_id`, `clothes_type`, `height`, `weight`, `body_shape`, `top_size`, `bottom_size`, `dress_size`, `jean_size`, `created_at`) VALUES
(1, 1, 'Social occasions', 170, 62, 'Hourglass', 's', 'm', 't', 85, '2026-05-04 20:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `age`, `gender`, `created_at`, `photo`) VALUES
(1, 'Rawan', 'Husseiny', 'ronahussieny675@gmail.com', '$2y$10$XAnckNTpA8ENOQ.X1Cj35e0x2gHn6MiKamsHFo3dK7mISIeovJ0oy', '01065212708', 20, 'Female', '2026-05-04 20:19:44', 'image-web/user_1_1777926244.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_outfits`
--

CREATE TABLE `user_outfits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `outfit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outfits`
--
ALTER TABLE `outfits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `style_profiles`
--
ALTER TABLE `style_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_outfits`
--
ALTER TABLE `user_outfits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `outfit_id` (`outfit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outfits`
--
ALTER TABLE `outfits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `style_profiles`
--
ALTER TABLE `style_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_outfits`
--
ALTER TABLE `user_outfits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `style_profiles`
--
ALTER TABLE `style_profiles`
  ADD CONSTRAINT `style_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_outfits`
--
ALTER TABLE `user_outfits`
  ADD CONSTRAINT `user_outfits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_outfits_ibfk_2` FOREIGN KEY (`outfit_id`) REFERENCES `outfits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
