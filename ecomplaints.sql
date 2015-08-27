-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2015 at 01:29 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecomplaints`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `username` varchar(25) NOT NULL,
  `step1password` varchar(75) NOT NULL,
  `step2password` varchar(75) NOT NULL,
  `loginhistory` varchar(250) NOT NULL,
`adminid` int(11) NOT NULL,
  `emailid` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
`complaintid` int(11) NOT NULL,
  `userid` int(15) NOT NULL,
  `deptid` int(4) NOT NULL,
  `status` varchar(15) NOT NULL,
  `subject` varchar(35) NOT NULL,
  `body` varchar(150) NOT NULL,
  `feedback` varchar(50) NOT NULL,
  `traversaldetails` varchar(250) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `sitename` varchar(35) NOT NULL,
  `sitestatus` int(1) NOT NULL,
  `allowregister` int(1) NOT NULL,
  `allowlogin` int(1) NOT NULL,
  `stopaddingcomplaints` int(1) NOT NULL,
  `supportemail` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`sitename`, `sitestatus`, `allowregister`, `allowlogin`, `stopaddingcomplaints`, `supportemail`) VALUES
('E-complaints', 1, 1, 1, 0, 'sadakpramodh@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
`contactuid` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `ipaddress1` varchar(100) NOT NULL,
  `ipaddress2` varchar(100) NOT NULL,
  `ipaddress3` varchar(100) NOT NULL,
  `userid` varchar(15) DEFAULT NULL,
  `email` varchar(25) NOT NULL,
  `replay` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
`deptid` int(4) NOT NULL,
  `deptname` varchar(25) NOT NULL,
  `visibility` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `users` varchar(15) NOT NULL,
  `status` int(1) NOT NULL,
`roleid` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`userid` int(15) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `deptid` int(4) NOT NULL,
  `aadhar` int(15) NOT NULL,
  `status` int(1) NOT NULL,
  `key` int(15) NOT NULL,
  `block` int(1) NOT NULL,
  `address` varchar(40) NOT NULL,
  `phno` int(13) NOT NULL,
  `gender` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
 ADD PRIMARY KEY (`complaintid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
 ADD PRIMARY KEY (`contactuid`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
 ADD PRIMARY KEY (`deptid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
MODIFY `complaintid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
MODIFY `contactuid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `deptid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `roleid` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userid` int(15) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
