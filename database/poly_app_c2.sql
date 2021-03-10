-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2021 at 08:48 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poly_app_c2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cheque`
--

CREATE TABLE `cheque` (
  `cheque_id` int(7) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `cheque_no` varchar(50) NOT NULL,
  `valid_date` date NOT NULL,
  `exchange_date` date NOT NULL,
  `cheque_value` double(10,2) NOT NULL,
  `interest` int(5) NOT NULL,
  `exchange_amt` double(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `cust_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cheque`
--

INSERT INTO `cheque` (`cheque_id`, `bank`, `cheque_no`, `valid_date`, `exchange_date`, `cheque_value`, `interest`, `exchange_amt`, `status`, `cust_id`) VALUES
(1, 'commercial', 'NV09764', '2020-12-12', '2020-11-10', 5000.00, 6, 4700.00, 'Completed ', 'D0001'),
(2, 'NSB', '12454789', '2020-12-12', '2020-11-07', 1550.00, 4, 1430.00, 'NYC ', 'Moo3'),
(3, 'BOC', 'BO256378', '2020-12-01', '2020-11-14', 9000.00, 10, 8100.00, 'NYC', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `vehicle_no` text NOT NULL,
  `contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `type`, `name`, `address`, `vehicle_no`, `contact`) VALUES
('D0001', 'Daily', 'Hasith Lakmal', 'panadura', 'WP1024', '0714789548'),
('D0002', 'Daily', 'anne fernando', 'panadura', 'WP1056', '0712457895'),
('M0001', 'Monthly', 'Dhanuka Gamage', 'Kalutara,North', 'WP1026', ''),
('M0002', 'Monthly', 'Indunil Prasad', 'colombo 03', 'gcb', '0771234567'),
('W0001', 'Weekly', 'Madusanka', 'Gampaha', '', '078 4598521'),
('W0002', 'Weekly', 'Malshan', 'colombo 03', '', '011 7841452');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_no` int(7) NOT NULL,
  `l_date` date NOT NULL,
  `amount` double(10,2) NOT NULL,
  `interest` int(5) NOT NULL,
  `value_of_interest` double(10,2) NOT NULL,
  `cust_id` varchar(10) NOT NULL,
  `l_status` tinyint(4) NOT NULL,
  `l_type` varchar(10) NOT NULL,
  `l_method` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_no`, `l_date`, `amount`, `interest`, `value_of_interest`, `cust_id`, `l_status`, `l_type`, `l_method`) VALUES
(1, '2020-12-01', 100000.00, 4, 133.34, 'D0001', 1, '', ''),
(3, '2021-01-06', 110000.00, 5, 183.33, 'D0003', 1, '', ''),
(4, '2020-12-30', 2000.00, 5, 3.33, 'D0002', 0, '', ''),
(5, '2020-11-01', 50000.00, 4, 66.67, 'M0002', 1, '', ''),
(6, '2020-12-10', 20000.00, 4, 26.67, 'D0002', 1, 'weekly', 'normal'),
(7, '2021-01-08', 100000.00, 4, 133.33, 'M0001', 1, 'daily', 'normal'),
(9, '2021-01-05', 25000.00, 6, 50.00, 'W0001', 1, 'weekly', 'sunday off'),
(10, '2021-03-09', 50000.00, 5, 83.33, 'W0002', 1, 'daily', 'sunday off');

-- --------------------------------------------------------

--
-- Table structure for table `loan_installement`
--

CREATE TABLE `loan_installement` (
  `id` int(7) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `li_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `paid` double(10,2) NOT NULL DEFAULT '0.00',
  `installement_amt` double(10,2) NOT NULL,
  `interest_amt` double(10,2) NOT NULL,
  `remaining_int_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remaining_amt` double(10,2) NOT NULL,
  `loan_no` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_installement`
--

INSERT INTO `loan_installement` (`id`, `start_date`, `li_date`, `duration`, `month`, `year`, `paid`, `installement_amt`, `interest_amt`, `remaining_int_amt`, `remaining_amt`, `loan_no`) VALUES
(1, '', '2021-03-10', 1, '2021', '3', 100.00, 16.67, 83.33, '0.00', 49983.33, 10),
(2, '2021-03-10', '2021-04-30', 43, '2021', '4', 1000.00, 0.00, 3583.19, '2583.19', 52566.52, 10);

-- --------------------------------------------------------

--
-- Table structure for table `special_days`
--

CREATE TABLE `special_days` (
  `id` int(11) NOT NULL,
  `poyaday` varchar(50) NOT NULL,
  `day_index` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `special_days`
--

INSERT INTO `special_days` (`id`, `poyaday`, `day_index`) VALUES
(1, '2021-01-28', 4),
(2, '2021-02-26', 5),
(3, '2021-03-28', 0),
(4, '2021-04-26', 1),
(5, '2021-05-26', 3),
(6, '2021-06-24', 4),
(7, '2021-07-23', 5),
(8, '2021-08-22', 0),
(9, '2021-09-20', 1),
(10, '2021-10-20', 3),
(11, '2021-11-18', 4),
(12, '2021-12-18', 6);

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE `summary` (
  `id` int(11) NOT NULL,
  `year` varchar(500) NOT NULL,
  `month` varchar(500) NOT NULL,
  `loanAMT` decimal(18,2) NOT NULL DEFAULT '0.00',
  `debtAMT` decimal(18,2) NOT NULL DEFAULT '0.00',
  `createDate` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `summary`
--

INSERT INTO `summary` (`id`, `year`, `month`, `loanAMT`, `debtAMT`, `createDate`) VALUES
(1, '2020', '12', '140000.00', '0.00', '2020-12-29'),
(2, '2020', '01', '0.00', '0.00', '2020-12-29'),
(3, '2020', '02', '0.00', '0.00', '2020-12-29'),
(4, '2020', '03', '0.00', '0.00', '2020-12-29'),
(5, '2020', '04', '0.00', '0.00', '2020-12-29'),
(6, '2020', '05', '0.00', '0.00', '2020-12-29'),
(7, '2020', '06', '0.00', '0.00', '2020-12-29'),
(8, '2020', '07', '0.00', '0.00', '2020-12-29'),
(9, '2020', '08', '0.00', '0.00', '2020-12-29'),
(10, '2020', '09', '0.00', '0.00', '2020-12-29'),
(11, '2020', '10', '0.00', '0.00', '2020-12-29'),
(12, '2020', '11', '0.00', '0.00', '2020-12-29'),
(13, '2021', '01', '272000.00', '17013.07', '2021-01-06'),
(14, '2021', '02', '0.00', '0.00', '2021-01-06'),
(15, '2021', '03', '125000.00', '816.67', '2021-01-06'),
(16, '2021', '04', '0.00', '0.00', '2021-01-06'),
(17, '2021', '05', '0.00', '0.00', '2021-01-06'),
(18, '2021', '06', '0.00', '0.00', '2021-01-06'),
(19, '2021', '07', '0.00', '0.00', '2021-01-06'),
(20, '2021', '08', '0.00', '0.00', '2021-01-06'),
(21, '2021', '09', '0.00', '0.00', '2021-01-06'),
(22, '2021', '10', '0.00', '0.00', '2021-01-06'),
(23, '2021', '11', '0.00', '0.00', '2021-01-06'),
(24, '2021', '12', '0.00', '0.00', '2021-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'sa', '698d51a19d8a121ce581499d7b701668');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cheque`
--
ALTER TABLE `cheque`
  ADD PRIMARY KEY (`cheque_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_no`);

--
-- Indexes for table `loan_installement`
--
ALTER TABLE `loan_installement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_days`
--
ALTER TABLE `special_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cheque`
--
ALTER TABLE `cheque`
  MODIFY `cheque_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_no` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `loan_installement`
--
ALTER TABLE `loan_installement`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `special_days`
--
ALTER TABLE `special_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
