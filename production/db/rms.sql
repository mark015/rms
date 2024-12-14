-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 01:57 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `date_received` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_released` datetime NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `notif_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id`, `document_number`, `document_title`, `date_received`, `status`, `date_released`, `document_file`, `notif_status`) VALUES
(10, '000-0001', 'Awarded Employee', '2024-12-01 13:41:34', 'complete', '2024-12-01 13:55:17', '../uploads/hr-example-docs.pdf', ''),
(14, '000-0002', 'employee of the month', '2024-12-01 13:52:05', 'complete', '2024-12-01 13:55:26', '../uploads/hr-example-docs.pdf', ''),
(15, '000-0003', 'HR Docs', '2024-12-01 13:52:43', 'complete', '2024-12-01 13:55:42', '../uploads/hr-example-docs.pdf', ''),
(16, '000-0004', 'HR Docs', '2024-12-01 13:56:08', 'complete', '2024-12-01 13:58:48', '../uploads/hr-example-docs.pdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', '464da487a0286c0b7c1f00e5ed3de7d1', 'Admin'),
(2, 'user1', 'user1', '473c96b98e2f77d32eb4fe44a5dcf4b5', 'User1'),
(3, 'user2', 'user2', '473c96b98e2f77d32eb4fe44a5dcf4b5', 'User2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document`
--
ALTER TABLE `document`
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
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
