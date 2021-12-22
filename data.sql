-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 02:26 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwt_pweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_phone`, `is_active`, `is_admin`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 0, 1, 1, 0, '0000-00-00', 0, '0000-00-00'),
(3, 'dummy1', 'dummy1@gmail.com', 'dummy1', 8111, 1, 0, 1, '2021-12-22', 0, '0000-00-00'),
(5, 'dummy3', 'dummy3@gmail.com', 'dummy3', 8111, 1, 1, 1, '2021-12-22', 0, '0000-00-00'),
(7, 'dummy100', 'dummy100@gmail.com', 'dummy100', 0, 1, 1, 1, '2021-12-22', 0, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
