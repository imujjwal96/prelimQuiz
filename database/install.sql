-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2016 at 04:55 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prelim_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `username` varchar(128) NOT NULL,
  `1` varchar(64) NOT NULL,
  `2` varchar(64) NOT NULL,
  `3` varchar(64) NOT NULL,
  `4` varchar(64) NOT NULL,
  `5` varchar(64) NOT NULL,
  `6` varchar(64) NOT NULL,
  `7` varchar(64) NOT NULL,
  `8` varchar(64) NOT NULL,
  `9` varchar(64) NOT NULL,
  `10` varchar(64) NOT NULL,
  `11` varchar(64) NOT NULL,
  `12` varchar(64) NOT NULL,
  `13` varchar(64) NOT NULL,
  `14` varchar(64) NOT NULL,
  `15` varchar(64) NOT NULL,
  `16` varchar(64) NOT NULL,
  `17` varchar(64) NOT NULL,
  `18` varchar(64) NOT NULL,
  `19` varchar(64) NOT NULL,
  `20` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`),
  ADD KEY `level` (`points`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
