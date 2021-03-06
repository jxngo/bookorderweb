-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2021 at 02:26 AM
-- Server version: 8.0.26
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group4710`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookrequests`
--

CREATE TABLE `bookrequests` (
  `id` int NOT NULL,
  `cid` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `booktitle` varchar(255) NOT NULL,
  `authornames` varchar(255) NOT NULL,
  `edition` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `isbn` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `acctype` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `acctype`, `email`, `password`, `firstname`, `lastname`) VALUES
(1, 'staff', 'group4710@gmail.com', 'admin', 'Super', 'Admin'),
(6, 'professor', 'martyn.jandrew@gmail.com', 'XxMMhdp', 'Andrew', 'Martyn'),
(7, 'professor', 'mconway1022@icloud.com', 'password1', 'Madison', 'Conway'),
(37, 'staff', 'admin2@admin.com', 'admin2', 'admin2', 'admin2'),
(38, 'professor', 'johndoe@gmail.com', 'password', 'John', 'Joe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookrequests`
--
ALTER TABLE `bookrequests`
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
-- AUTO_INCREMENT for table `bookrequests`
--
ALTER TABLE `bookrequests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
