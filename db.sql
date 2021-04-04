-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 31, 2021 at 05:29 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.3
CREATE DATABASE misc;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `misc`
--

-- --------------------------------------------------------

--
-- Table structure for table `Education`
--

CREATE TABLE `Education` (
  `profile_id` int NOT NULL,
  `institution_id` int NOT NULL,
  `rank_` int DEFAULT NULL,
  `year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Education`
--

INSERT INTO `Education` (`profile_id`, `institution_id`, `rank_`, `year`) VALUES
(28, 15, 1, 2010),
(28, 16, 2, 2015);

-- --------------------------------------------------------

--
-- Table structure for table `Institution`
--

CREATE TABLE `Institution` (
  `institution_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Institution`
--

INSERT INTO `Institution` (`institution_id`, `name`) VALUES
(16, 'Bachelor\'s'),
(6, 'Duke University'),
(15, 'High School'),
(11, 'm'),
(7, 'Michigan State University'),
(8, 'Mississippi State University'),
(14, 'mm'),
(9, 'Montana State University'),
(13, 'mooooooo'),
(12, 'mx'),
(5, 'Stanford University'),
(4, 'University of Cambridge'),
(1, 'University of Michigan'),
(3, 'University of Oxford'),
(2, 'University of Virginia');

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE `Position` (
  `position_id` int NOT NULL,
  `profile_id` int DEFAULT NULL,
  `rank_` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Position`
--

INSERT INTO `Position` (`position_id`, `profile_id`, `rank_`, `year`, `description`) VALUES
(27, 28, 1, 2016, 'Software Engineer ');

-- --------------------------------------------------------

--
-- Table structure for table `Profile`
--

CREATE TABLE `Profile` (
  `profile_id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` text,
  `last_name` text,
  `email` text,
  `headline` text,
  `summary` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Profile`
--

INSERT INTO `Profile` (`profile_id`, `user_id`, `first_name`, `last_name`, `email`, `headline`, `summary`) VALUES
(28, 1, 'Jack', 'Dawn', 'JackDawn@gmail.com', 'Software Engineer', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`) VALUES
(1, 'UMSI', 'umsi@umich.edu', '1a52e17fa899cf40fb04cfc42e6352f1'),
(2, 'Chuck', 'csev@umich.edu', '1a52e17fa899cf40fb04cfc42e6352f1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Education`
--
ALTER TABLE `Education`
  ADD PRIMARY KEY (`profile_id`,`institution_id`),
  ADD KEY `education_ibfk_2` (`institution_id`);

--
-- Indexes for table `Institution`
--
ALTER TABLE `Institution`
  ADD PRIMARY KEY (`institution_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `position_ibfk_1` (`profile_id`);

--
-- Indexes for table `Profile`
--
ALTER TABLE `Profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `profile_ibfk_2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`),
  ADD KEY `email_2` (`email`),
  ADD KEY `password_2` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Institution`
--
ALTER TABLE `Institution`
  MODIFY `institution_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Position`
--
ALTER TABLE `Position`
  MODIFY `position_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `Profile`
--
ALTER TABLE `Profile`
  MODIFY `profile_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Education`
--
ALTER TABLE `Education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `education_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `Institution` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Position`
--
ALTER TABLE `Position`
  ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Profile`
--
ALTER TABLE `Profile`
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
