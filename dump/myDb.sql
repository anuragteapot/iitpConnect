-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 07, 2019 at 04:27 PM
-- Server version: 8.0.17
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabShare`
--

CREATE TABLE `cabShare` (
  `cabid` int(11) NOT NULL,
  `calendarid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `location` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isAllday` tinyint(4) NOT NULL DEFAULT '0',
  `endDate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `startDate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `useCreationPopup` tinyint(4) NOT NULL DEFAULT '1',
  `rawClass` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fullDate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `borderColor` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dragBgColor` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checked` tinyint(4) NOT NULL DEFAULT '0',
  `category` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE `claim` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `claimDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employeeMaster`
--

CREATE TABLE `employeeMaster` (
  `id` int(11) NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `eid` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dept` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `designation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sex` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `joiningDate` datetime NOT NULL,
  `cellPhone` int(11) NOT NULL DEFAULT '0',
  `empType` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidayList`
--

CREATE TABLE `holidayList` (
  `id` int(11) NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `holidayDate` datetime NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidayList`
--

INSERT INTO `holidayList` (`id`, `name`, `holidayDate`, `type`) VALUES
(1, 'New Year\'s Day', '2018-01-01 00:00:00', 0),
(2, 'Guru Govind Singh\'s Birthday', '2018-01-05 00:00:00', 0),
(3, 'Makar Sankranti', '2018-01-14 00:00:00', 0),
(4, 'Pongal', '2018-01-14 00:00:00', 0),
(5, 'Basant Panchami/Sri Panchami', '2018-01-22 00:00:00', 0),
(6, 'Republic Day', '2018-01-26 00:00:00', 1),
(7, 'Guru Ravidas\'s Birthday', '2018-01-31 00:00:00', 0),
(8, 'Swami Dayananda Saraswati Jayanti', '2018-02-10 00:00:00', 0),
(9, 'Maha Shivaratri/Shivaratri', '2018-02-14 00:00:00', 1),
(10, 'Shivaji Jayanti', '2018-02-19 00:00:00', 0),
(11, 'Holika Dahana', '2018-03-01 00:00:00', 0),
(12, 'Holi', '2018-03-02 00:00:00', 1),
(13, 'Chaitra Sukladi/Gudi Padava/Ugadi/Cheti Chand', '2018-03-18 00:00:00', 0),
(14, 'Rama Navami', '2018-03-25 00:00:00', 1),
(15, 'Mahavir Jayanti', '2018-03-29 00:00:00', 1),
(16, 'Good Friday', '2018-03-30 00:00:00', 1),
(17, 'Hazarat Ali\'s Birthday', '2018-04-01 00:00:00', 0),
(18, 'Easter Day', '2018-04-01 00:00:00', 0),
(19, 'Vaisakhi/Vishu', '2018-04-14 00:00:00', 0),
(20, 'Mesadi', '2018-04-14 00:00:00', 0),
(21, 'Vaisakhadi(Bengal)/Bahag Bihu (Assam)', '2018-04-15 00:00:00', 0),
(22, 'Buddha Purnima/Vesak', '2018-04-30 00:00:00', 1),
(23, 'Guru Rabindranath\'s birthday', '2018-05-09 00:00:00', 0),
(24, 'Jamat Ul-Vida', '2018-06-05 00:00:00', 0),
(25, 'Idu\'l Fitr', '2018-06-16 00:00:00', 1),
(26, 'Rath Yatra', '2018-07-14 00:00:00', 0),
(27, 'Independence Day', '2018-08-15 00:00:00', 1),
(28, 'Parsi New Year\'s day/Nauraj', '2018-08-17 00:00:00', 0),
(29, 'Id-ul-Zuha(Bakrid)', '2018-08-22 00:00:00', 1),
(30, 'Onam', '2018-08-25 00:00:00', 0),
(31, 'Raksha Bandhan (Rakhi)', '2018-08-26 00:00:00', 0),
(32, 'Janmashtarni (Vaishnav)', '2018-09-03 00:00:00', 1),
(33, 'Ganesh Chaturthi/Vinayaka Chaturthi', '2018-09-13 00:00:00', 0),
(34, 'Muharram/Ashura', '2018-09-21 00:00:00', 1),
(35, 'Mahatma Gandhi Jayanti', '2018-10-02 00:00:00', 1),
(36, 'Dussehra', '2018-10-19 00:00:00', 1),
(37, 'Maharishi Valmiki\'s Birthday', '2018-10-24 00:00:00', 0),
(38, 'Karaka Chaturthi (Karva Chouth)', '2018-10-27 00:00:00', 0),
(39, 'Deepavali (South India)', '2018-11-06 00:00:00', 0),
(40, 'Naraka Chaturdasi', '2018-11-06 00:00:00', 0),
(41, 'Diwali (Deepavali)', '2018-11-07 00:00:00', 1),
(42, 'Govardhan Puja', '2018-11-08 00:00:00', 0),
(43, 'Bhai Duj', '2018-11-09 00:00:00', 0),
(44, 'Pratihar Sashthi or Surya Sashthi (Chhat Puja)', '2018-11-13 00:00:00', 0),
(45, 'Milad-un-Nabi or Id-e- Milad (birthday of Prophet Mohammad)', '2018-11-21 00:00:00', 1),
(46, 'Guru Nanak\'s Birthday', '2018-11-23 00:00:00', 1),
(47, 'Guru Teg Bahadur\'s Martyrdom Day', '2018-11-24 00:00:00', 0),
(48, 'Christmas Eve', '2018-12-24 00:00:00', 0),
(49, 'Christmas Day', '2018-12-25 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hostel_info`
--

CREATE TABLE `hostel_info` (
  `id` int(11) NOT NULL,
  `hostel_name` varchar(50) NOT NULL,
  `blocks` varchar(50) NOT NULL,
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaveHistory`
--

CREATE TABLE `leaveHistory` (
  `leaveId` int(11) NOT NULL,
  `empCode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dateFrom` datetime NOT NULL,
  `dayFrom` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dateUpto` datetime NOT NULL,
  `dayUpto` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sdateFrom` datetime NOT NULL,
  `sdayFrom` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sdateUpto` datetime NOT NULL,
  `sdayUpto` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `numDays` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `stationLeaveing` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `applicationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purpose` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `leaveAddress` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `leaveArrangement` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `leaveStatus` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaveType`
--

CREATE TABLE `leaveType` (
  `id` int(11) NOT NULL,
  `type` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `maxday` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaveType`
--

INSERT INTO `leaveType` (`id`, `type`, `name`, `maxday`) VALUES
(1, 'SL', 'Station Leave', 0),
(2, 'CL', 'Casual Leave', 8),
(3, 'EL', 'Earned Leave', 300),
(4, 'V', 'Vacation', 60),
(5, 'ML', 'Medical Leave', 0),
(6, 'DL', 'Duty Leave', 0),
(7, 'SCL', 'Special Casual Leave', 15),
(8, 'LPW', 'Leave for Project Work', 0),
(9, '_SL', 'Sabatical Leave', 0),
(10, 'EOL', 'Extra Ordinary leave', 0),
(11, 'RH', 'Restricted Holiday', 2);

-- --------------------------------------------------------

--
-- Table structure for table `occupants`
--

CREATE TABLE `occupants` (
  `id` int(100) NOT NULL,
  `room_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `roll` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `supervision` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `hostel_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `occupantsHistory`
--

CREATE TABLE `occupantsHistory` (
  `id` int(11) NOT NULL,
  `room_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `roll` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `previous` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `hostel_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `shares` int(11) NOT NULL DEFAULT '0',
  `reports` int(11) NOT NULL DEFAULT '0',
  `title` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `entryDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rstatus`
--

CREATE TABLE `rstatus` (
  `id` int(100) NOT NULL,
  `room_id` varchar(100) NOT NULL,
  `dt` varchar(100) NOT NULL,
  `rs` varchar(100) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `single` int(10) NOT NULL,
  `hostel_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(100) NOT NULL,
  `room_id` varchar(50) NOT NULL,
  `beds` int(10) NOT NULL,
  `chairs` int(10) NOT NULL,
  `tables` int(10) NOT NULL,
  `fans` int(10) NOT NULL,
  `tubelights` int(10) NOT NULL,
  `hostel_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `institute` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phonenumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `followers` int(11) NOT NULL DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Require user to reset password on next login',
  `activation` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `block`, `sendEmail`, `admin`, `address`, `institute`, `phonenumber`, `followers`, `registerDate`, `lastvisitDate`, `params`, `lastResetTime`, `resetCount`, `otpKey`, `otep`, `requireReset`, `activation`) VALUES
(1, 'Anurag', 'anu1601cs', 'anuragvns1111@gmail.com', '31f41472b5fba8cd43db38fecaaed8bf2798d390', 0, 0, 1, '', '', '0', 0, '2019-05-07 00:00:00', '2019-05-07 00:00:00', '', '0000-00-00 00:00:00', 0, '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_keys`
--

CREATE TABLE `user_keys` (
  `ukid` int(10) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isLoggedIn` int(1) NOT NULL DEFAULT '0',
  `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_keys`
--

INSERT INTO `user_keys` (`ukid`, `uid`, `token`, `ip`, `isLoggedIn`) VALUES
(1, 1, 'b63694dbccdecbb5d5cfdaac52eb2e6c22880d50', '127.0.0.1', 1),
(2, 1, 'b63694dbccdecbb5d5cfdaac52eb2e6c22880d50', '::1', 1),
(3, 1, 'b8b418df373966766faaf53dc9891c18b3ef06cf1789faacf6047b5952230ea1b0c8250d7f219732', '172.20.0.1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabShare`
--
ALTER TABLE `cabShare`
  ADD PRIMARY KEY (`cabid`);

--
-- Indexes for table `claim`
--
ALTER TABLE `claim`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `employeeMaster`
--
ALTER TABLE `employeeMaster`
  ADD PRIMARY KEY (`id`,`eid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidayList`
--
ALTER TABLE `holidayList`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostel_info`
--
ALTER TABLE `hostel_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaveHistory`
--
ALTER TABLE `leaveHistory`
  ADD PRIMARY KEY (`leaveId`);

--
-- Indexes for table `leaveType`
--
ALTER TABLE `leaveType`
  ADD PRIMARY KEY (`id`,`type`);

--
-- Indexes for table `occupants`
--
ALTER TABLE `occupants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `occupantsHistory`
--
ALTER TABLE `occupantsHistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `rstatus`
--
ALTER TABLE `rstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`,`email`);

--
-- Indexes for table `user_keys`
--
ALTER TABLE `user_keys`
  ADD PRIMARY KEY (`ukid`,`uid`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabShare`
--
ALTER TABLE `cabShare`
  MODIFY `cabid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `claim`
--
ALTER TABLE `claim`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employeeMaster`
--
ALTER TABLE `employeeMaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidayList`
--
ALTER TABLE `holidayList`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `hostel_info`
--
ALTER TABLE `hostel_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leaveHistory`
--
ALTER TABLE `leaveHistory`
  MODIFY `leaveId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaveType`
--
ALTER TABLE `leaveType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `occupants`
--
ALTER TABLE `occupants`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `occupantsHistory`
--
ALTER TABLE `occupantsHistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rstatus`
--
ALTER TABLE `rstatus`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_keys`
--
ALTER TABLE `user_keys`
  MODIFY `ukid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claim`
--
ALTER TABLE `claim`
  ADD CONSTRAINT `claim_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claim_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`pid`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_keys`
--
ALTER TABLE `user_keys`
  ADD CONSTRAINT `user_keys_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
