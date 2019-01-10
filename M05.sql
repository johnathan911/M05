-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2018 at 04:50 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `M05`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_token`
--

CREATE TABLE `access_token` (
  `id` int(11) NOT NULL,
  `fbid` varchar(52) DEFAULT NULL,
  `access_token` varchar(522) NOT NULL,
  `gender` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `has_used` int(1) DEFAULT NULL,
  `last_use` varchar(53) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `num_used` varchar(53) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `access_token`
--

INSERT INTO `access_token` (`id`, `fbid`, `access_token`, `gender`, `has_used`, `last_use`, `num_used`) VALUES
(1631, '1175810725769570', 'EAADnMyPiCO8BADIKvZChMHKrxDGSMm6cfqiejnjjP0o2R4h8I9YpMUqE2ywu3ePRR42PH7EJVA4Epkk41BZBfaQmfXqHcALzKnuFVloSyvXUmwVUrHbbLiFGTKn3UZATH3dUahwZBpLTZCosmkBWBT3s6KWdU6ghZAZCVrjk0pb3IyxDOfJhQjLGWegQbZCTguBQokK0KGPvYwZDZD', '', NULL, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `user` varchar(52) NOT NULL,
  `pass` varchar(52) NOT NULL,
  `email` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `fullname`, `user`, `pass`, `email`) VALUES
(13, 'linh', 'admin1', '123456', 'abc@gmail.com'),
(14, 'administrator', 'admin2', '123456', 'abc'),
(15, 'linh develop', 'developer', '123456', 'a@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `package_nhom`
--

CREATE TABLE `package_nhom` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package_nhom`
--

INSERT INTO `package_nhom` (`id`, `name`, `description`, `user_id`, `create_time`) VALUES
(22, 'Showbiz', 'show biz cua admin1', 13, '2023-10-18 00:00:00'),
(23, 'Showbiz', 'showbiz của developer', 15, '2024-10-18 00:00:00'),
(25, 'Showbi', 'show biz co', 13, '2024-10-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_keyword`
--

CREATE TABLE `post_keyword` (
  `name` varchar(100) NOT NULL,
  `id_post` varchar(52) NOT NULL,
  `time_post` varchar(52) NOT NULL,
  `luot_thich` int(11) NOT NULL,
  `luot_comment` int(52) NOT NULL,
  `luot_share` int(52) NOT NULL,
  `target_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` int(11) NOT NULL,
  `fbid` varchar(100) NOT NULL,
  `name` varchar(52) NOT NULL,
  `time_add` varchar(52) NOT NULL,
  `last_get_post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `fbid`, `name`, `time_add`, `last_get_post`) VALUES
(1, '1234', 'Trương Huy San', '1539655350', 0),
(2, '123', 'ABC', '1540351355', NULL),
(3, 'd2ff', 'dfs', '1540351464', NULL),
(4, '1fdsf', 'fdsafdsaf', '1540351591', NULL),
(5, '12345', '42dfsq', '1540352285', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_target`
--

CREATE TABLE `tbl_group_target` (
  `group_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_group_target`
--

INSERT INTO `tbl_group_target` (`group_id`, `target_id`) VALUES
(22, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_token`
--
ALTER TABLE `access_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_nhom`
--
ALTER TABLE `package_nhom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_keyword`
--
ALTER TABLE `post_keyword`
  ADD PRIMARY KEY (`id_post`),
  ADD UNIQUE KEY `id_post` (`id_post`),
  ADD KEY `target_id` (`target_id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fbid` (`fbid`);

--
-- Indexes for table `tbl_group_target`
--
ALTER TABLE `tbl_group_target`
  ADD PRIMARY KEY (`group_id`,`target_id`),
  ADD UNIQUE KEY `group_id` (`group_id`,`target_id`),
  ADD KEY `target_id` (`target_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_token`
--
ALTER TABLE `access_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1632;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `package_nhom`
--
ALTER TABLE `package_nhom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_nhom`
--
ALTER TABLE `package_nhom`
  ADD CONSTRAINT `package_nhom_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `member` (`id`);

--
-- Constraints for table `post_keyword`
--
ALTER TABLE `post_keyword`
  ADD CONSTRAINT `post_keyword_ibfk_1` FOREIGN KEY (`target_id`) REFERENCES `target` (`id`);

--
-- Constraints for table `tbl_group_target`
--
ALTER TABLE `tbl_group_target`
  ADD CONSTRAINT `tbl_group_target_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `package_nhom` (`id`),
  ADD CONSTRAINT `tbl_group_target_ibfk_2` FOREIGN KEY (`target_id`) REFERENCES `target` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
