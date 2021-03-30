-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2021 at 09:37 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `vehicle_no` text NOT NULL,
  `contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `type`, `reg_no`, `name`, `address`, `vehicle_no`, `contact`) VALUES
('D0001', 'Daily', 'HL123456', 'Hasith Lakmal', 'panadura', 'WP1024', '0714789548'),
('D0002', 'Daily', 'AF789456', 'anne fernando', 'panadura', 'WP1056', '0712457895'),
('M0001', 'Monthly', '', 'Dhanuka Gamage', 'Kalutara,North', 'WP1026', '0714789548'),
('M0002', 'Monthly', '', 'Indunil Prasad', 'colombo 03', 'gcb', '0771234567'),
('W0001', 'Weekly', '', 'Madusanka', 'Gampaha', '', '078 4598521'),
('W0002', 'Weekly', '', 'Malshan', 'colombo 03', '', '011 7841452');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_no` int(7) NOT NULL,
  `l_date` date NOT NULL,
  `amount` double(10,2) NOT NULL,
  `interest` int(5) NOT NULL,
  `no_installements` int(11) NOT NULL,
  `rental` double(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `end_date` text NOT NULL,
  `cust_id` varchar(10) NOT NULL,
  `l_status` tinyint(4) NOT NULL,
  `l_type` varchar(10) NOT NULL,
  `l_method` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_no`, `l_date`, `amount`, `interest`, `no_installements`, `rental`, `duration`, `end_date`, `cust_id`, `l_status`, `l_type`, `l_method`) VALUES
(1, '2021-02-01', 30000.00, 10, 60, 600.00, 60, '2021-04-04', 'D0001', 1, 'daily', 'normal'),
(2, '2021-03-10', 200000.00, 7, 8, 28500.00, 56, '2021-05-05', 'D0002', 1, 'weekly', 'normal'),
(3, '2021-02-03', 10000.00, 8, 60, 200.00, 58, '2021-04-12', 'M0001', 1, 'daily', 'sunday off'),
(4, '2021-03-10', 200000.00, 7, 8, 28500.00, 56, '2021-05-14', 'M0002', 1, 'weekly', 'sunday off');

-- --------------------------------------------------------

--
-- Table structure for table `loan_installement`
--

CREATE TABLE `loan_installement` (
  `id` int(7) NOT NULL,
  `li_date` date NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `paid` double(10,2) NOT NULL DEFAULT '0.00',
  `arrears` double(10,2) NOT NULL,
  `total_paid` double(10,2) NOT NULL,
  `brought_forward` decimal(10,2) NOT NULL DEFAULT '0.00',
  `loan_no` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_installement`
--

INSERT INTO `loan_installement` (`id`, `li_date`, `month`, `year`, `paid`, `arrears`, `total_paid`, `brought_forward`, `loan_no`) VALUES
(1, '2021-03-04', '03', '2021', 13000.00, 5000.00, 13000.00, '23000.00', 1),
(2, '2021-03-17', '03', '2021', 28500.00, 0.00, 28500.00, '199500.00', 2);

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
(1, '2021', '03', '710000.00', '53700.00', '2021-03-16'),
(2, '2021', '01', '0.00', '0.00', '2021-03-16'),
(3, '2021', '02', '0.00', '0.00', '2021-03-16'),
(4, '2021', '04', '0.00', '0.00', '2021-03-16'),
(5, '2021', '05', '0.00', '0.00', '2021-03-16'),
(6, '2021', '06', '0.00', '0.00', '2021-03-16'),
(7, '2021', '07', '0.00', '0.00', '2021-03-16'),
(8, '2021', '08', '0.00', '0.00', '2021-03-16'),
(9, '2021', '09', '0.00', '0.00', '2021-03-16'),
(10, '2021', '10', '0.00', '0.00', '2021-03-16'),
(11, '2021', '11', '0.00', '0.00', '2021-03-16'),
(12, '2021', '12', '0.00', '0.00', '2021-03-16');

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
  MODIFY `cheque_id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_no` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
