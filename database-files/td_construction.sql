-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 01:42 PM
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
-- Database: `td_construction`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `userID` int(11) DEFAULT NULL,
  `sunday_start` time DEFAULT NULL,
  `sunday_end` time DEFAULT NULL,
  `monday_start` time DEFAULT NULL,
  `monday_end` time DEFAULT NULL,
  `tuesday_start` time DEFAULT NULL,
  `tuesday_end` time DEFAULT NULL,
  `wednesday_start` time DEFAULT NULL,
  `wednesday_end` time DEFAULT NULL,
  `thursday_start` time DEFAULT NULL,
  `thursday_end` time DEFAULT NULL,
  `friday_start` time DEFAULT NULL,
  `friday_end` time DEFAULT NULL,
  `saturday_start` time DEFAULT NULL,
  `saturday_end` time DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_assignments`
--

CREATE TABLE `job_assignments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_role` varchar(255) DEFAULT NULL,
  `assigned_date` date DEFAULT curdate(),
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_assignments`
--

INSERT INTO `job_assignments` (`id`, `user_id`, `job_role`, `assigned_date`, `username`) VALUES
(23, 57, 'Safety Dude', '2025-05-08', 'joe'),
(24, 58, 'Equipment Operator', '2025-05-08', 'cecil');

-- --------------------------------------------------------

--
-- Table structure for table `timelogs`
--

CREATE TABLE `timelogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` enum('clock_in','clock_out') NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timelogs`
--

INSERT INTO `timelogs` (`id`, `user_id`, `action`, `timestamp`, `username`) VALUES
(97, 57, 'clock_in', '2025-05-08 11:10:20', 'joe'),
(98, 57, 'clock_out', '2025-05-08 11:10:20', 'joe'),
(99, 57, 'clock_out', '2025-05-08 11:10:21', 'joe'),
(100, 57, 'clock_in', '2025-05-08 11:10:21', 'joe'),
(101, 57, 'clock_in', '2025-05-08 11:10:21', 'joe'),
(102, 57, 'clock_in', '2025-05-08 11:10:21', 'joe'),
(103, 57, 'clock_in', '2025-05-08 11:10:22', 'joe'),
(104, 57, 'clock_out', '2025-05-08 11:10:22', 'joe'),
(105, 57, 'clock_out', '2025-05-08 11:10:22', 'joe'),
(106, 58, 'clock_in', '2025-05-08 13:20:11', 'cecil'),
(107, 58, 'clock_out', '2025-05-08 13:20:11', 'cecil'),
(108, 54, 'clock_in', '2025-05-08 14:09:57', 's'),
(109, 54, 'clock_out', '2025-05-08 14:09:57', 's');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `hourly_rate` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fullname`, `username`, `password`, `position`, `dob`, `admin_password`, `role`, `hourly_rate`) VALUES
(54, 's', 's', '$2y$10$PtYfteaPm8mI70uXmPMateXTsnJm7Gz5aN2J/b6dda2f0kp8xvE5G', 'Supervisor', '1111-11-11', NULL, '', 54.00),
(56, 'a', 'a', '$2y$10$pqe8C6NC2xDnAbjNPzA.nuP1eZNGuiNSz5JG0WG0fFRjDCsrDmWve', 'Administrator', '1111-11-11', NULL, '', 1.00),
(57, 'Joe Mama', 'joe', '$2y$10$qqPsVYyzXLWIbDk67QOV2.mdtmPWDoGjrD85EIuDKhjhLNAeYMwBW', 'Employee', '1111-11-11', NULL, '', 0.00),
(58, 'ceasar', 'cecil', '$2y$10$2XCIQdHnA64WrnMEc1FEkOnzkn6945l/EgeHCpjIOITowyrQxktNm', 'Employee', '1111-11-11', NULL, '', 5656.01);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD KEY `fk_availability_userID` (`userID`);

--
-- Indexes for table `job_assignments`
--
ALTER TABLE `job_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timelogs`
--
ALTER TABLE `timelogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job_assignments`
--
ALTER TABLE `job_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `timelogs`
--
ALTER TABLE `timelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `fk_availability_userID` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
