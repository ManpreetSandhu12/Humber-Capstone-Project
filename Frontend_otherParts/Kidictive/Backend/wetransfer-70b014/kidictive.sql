-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2018 at 11:00 AM
-- Server version: 5.6.39
-- PHP Version: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidictive`
--

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `platform` int(11) NOT NULL COMMENT '1=ios, 2=android',
  `device_id` varchar(255) NOT NULL,
  `notification_id` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`id`, `parent_id`, `first_name`, `last_name`, `birthday`, `username`, `password`, `profile_pic`, `platform`, `device_id`, `notification_id`, `latitude`, `longitude`, `created_at`, `updated_at`, `status`) VALUES
(32, 9, 'Demo', 'Child', '20-01-2001', 'demod32s', '6e9bece1914809fb8493146417e722f6', 'images/profile_pic/child/152316520332.jpg', 1, '', '', '19.2533256', '24.34782456', '2018-04-08 10:56:43', '2018-04-09 19:26:24', 1),
(33, 9, 'Demo', 'Child', '20-01-2001', 'demod', 'c93ccd78b2076528346216b3b2f701e6', 'images/profile_pic/child/152316604533.jpg', 0, '', '', '', '', '2018-04-08 11:10:45', '2018-04-10 17:22:29', 1),
(34, 11, 'sdfs', 'f', 'dfsd', 'fsdf', '5a12c212994e8bb3c02ee0f19bc177ff', '', 0, '', '', '', '', '2018-04-09 19:40:18', '2018-04-09 19:40:18', 1),
(35, 11, 'das', 'dasdasd', 'asdasd', 'asdasd', '202cb962ac59075b964b07152d234b70', '', 0, '', '', '', '', '2018-04-09 19:43:03', '2018-04-09 19:43:03', 1),
(37, 11, 'Demo', 'Child', '20-01-2001', 'demochild', '6e9bece1914809fb8493146417e722f6', 'images/profile_pic/child/152316520332.jpg', 0, '', '', '', '', '2018-04-10 03:35:17', '2018-04-11 06:03:11', 1),
(38, 13, 'ttyhh', 'vvv', 'rtggg', 'cccvvvv', 'bb810f7c53a25c3648decaad32c1ae0f', 'images/profile_pic/child/152316604533.jpg', 0, '', '', '', '', '2018-04-10 07:58:52', '2018-04-11 06:02:55', 1),
(39, 13, 'deep', 'singh', '10-05-2018', 'kuldeep1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'images/profile_pic/child/152316520332.jpg', 0, '15D6B7B8-E2CE-4235-9E8A-898005F746FF', '123456', '0.0', '0.0', '2018-04-10 08:19:00', '2018-04-11 06:03:18', 1),
(40, 13, 'child1', 'Singh', '11-05-2018', 'child1@gmail.com', '5a12c212994e8bb3c02ee0f19bc177ff', 'images/profile_pic/child/152342948740.jpeg', 0, '15D6B7B8-E2CE-4235-9E8A-898005F746FF', '123456', '33.743465', '-84.420173', '2018-04-11 06:51:27', '2018-04-11 10:50:48', 1),
(41, 13, 'jora', 'singh', '12-05-2018', 'jora@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'images/profile_pic/child/152349652441.jpeg', 0, '29621BF6-9028-4B71-BA88-1334F32DA05B', '123456', '30.7046', '76.7179', '2018-04-12 01:28:44', '2018-04-12 01:47:42', 1),
(42, 13, 'child2', 'singh', '21-04-2018', 'child2@gmail.com', '5a12c212994e8bb3c02ee0f19bc177ff', 'images/profile_pic/child/152351645942.jpeg', 0, '15D6B7B8-E2CE-4235-9E8A-898005F746FF', '123456', '0.0', '0.0', '2018-04-12 07:00:59', '2018-04-12 07:01:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `user_id`, `otp`, `created_at`, `updated_at`, `status`) VALUES
(1, 9, 9045, '2018-04-08 11:47:46', '2018-04-09 18:33:49', 1),
(2, 11, 6503, '2018-04-09 18:19:17', '2018-04-09 18:42:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_year` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `platform` int(11) NOT NULL COMMENT '1=ios, 2=android',
  `device_id` varchar(255) NOT NULL,
  `notification_id` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `first_name`, `last_name`, `email`, `password`, `birth_year`, `relationship`, `profile_pic`, `platform`, `device_id`, `notification_id`, `latitude`, `longitude`, `created_at`, `updated_at`, `status`) VALUES
(9, 'Demo', 'Parent', 'puri.ravi0914@gmail.com', 'c93ccd78b2076528346216b3b2f701e6', '2005', 'Father', 'images/profile_pic/parent/15231660459.jpg', 1, '2324', '', '', '', '2018-04-08 10:25:08', '2018-04-08 12:02:58', 1),
(10, '', '', 'asdas@gmail.com', '5a12c212994e8bb3c02ee0f19bc177ff', 'Apr 20,2001', '', '', 0, '', '', '', '', '2018-04-09 17:58:51', '2018-04-09 17:58:51', 1),
(11, 'Demo', 'Parent', 'omeeshsharma.96@gmail.com', '5a12c212994e8bb3c02ee0f19bc177ff', '09-04-2006', 'Father', 'images/profile_pic/parent/15231652039.jpg', 0, '8BE84C44-08BE-46DC-AB64-E3670BA47851', '123456', '', '', '2018-04-09 18:09:01', '2018-04-11 06:04:01', 1),
(12, '', '', 'kuldeep@relinn.com', 'e10adc3949ba59abbe56e057f20f883e', '10-06-2018', '', '', 0, 'E8323397-8B93-4B2C-9BF4-CF901A3BC293', '123456', '', '', '2018-04-10 05:16:20', '2018-04-10 05:16:20', 1),
(13, 'kuldeep', 'singh', 'kuldeep@relinns.com', 'e10adc3949ba59abbe56e057f20f883e', '10-06-2018', 'Father', 'images/profile_pic/parent/152351645913.jpeg', 0, 'E8323397-8B93-4B2C-9BF4-CF901A3BC293', '123456', '', '', '2018-04-10 05:33:18', '2018-04-12 07:00:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `video` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `parent_id`, `child_id`, `video`, `created_at`, `updated_at`, `status`) VALUES
(5, 9, 33, 'video/15234196289.avi', '2018-04-10 17:04:24', '2018-04-11 06:05:03', 1),
(6, 9, 33, 'video/15234254029.avi', '2018-04-10 17:12:24', '2018-04-11 06:05:15', 1),
(7, 13, 39, 'video/15234196289.avi', '2018-04-10 17:12:40', '2018-04-11 06:05:29', 1),
(8, 13, 39, 'video/15234254029.avi', '2018-04-10 17:12:45', '2018-04-11 06:05:19', 1),
(9, 9, 33, 'video/15234196289.avi', '2018-04-10 17:29:25', '2018-04-11 06:04:57', 1),
(13, 9, 33, 'video/15234284299.avi', '2018-04-11 06:33:49', '2018-04-11 06:33:49', 1),
(15, 13, 40, 'video/152343282113.avi', '2018-04-11 07:47:01', '2018-04-11 07:47:01', 1),
(16, 13, 40, 'video/152343464413.3gp', '2018-04-11 08:17:24', '2018-04-11 08:17:24', 1),
(22, 13, 40, 'video/152346386613.3gp', '2018-04-11 16:24:26', '2018-04-11 16:24:26', 1),
(23, 13, 39, 'video/152349624913.mp4', '2018-04-12 01:24:09', '2018-04-12 01:24:09', 1),
(24, 13, 41, 'video/152349774013.mp4', '2018-04-12 01:49:00', '2018-04-12 01:49:00', 1),
(25, 14, 40, 'video/152351182014.3gp', '2018-04-12 05:43:40', '2018-04-12 05:43:40', 1),
(26, 14, 40, 'video/152351659814.3gp', '2018-04-12 07:03:18', '2018-04-12 07:03:18', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
