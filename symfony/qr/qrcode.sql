-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2018 at 09:56 PM
-- Server version: 5.5.59-log
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL,
  `GUID` varchar(300) NOT NULL,
  `consumed` int(11) NOT NULL,
  `consumed_date` date NOT NULL,
  `consumed_by` varchar(100) NOT NULL,
  `id_no` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `GUID`, `consumed`, `consumed_date`, `consumed_by`, `id_no`) VALUES
(1, '78D09C8C-7089-48D2-AFCC-B5A675C7C4EE', 1, '2018-07-20', 'nelson', 1238),
(2, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(3, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(4, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(5, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(6, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(7, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(8, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(9, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(10, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(11, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(12, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(13, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0),
(14, '525D64CA-DB0E-444A-B487-3F6E21A0FF64', 1, '2018-07-20', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
