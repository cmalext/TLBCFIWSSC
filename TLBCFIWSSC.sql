-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 18, 2015 at 10:34 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `capstone_karla`
--

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE IF NOT EXISTS `billings` (
  `id` int(10) unsigned NOT NULL,
  `month_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client` int(11) NOT NULL,
  `consumption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` float(8,2) NOT NULL,
  `status` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unit_normal` int(11) NOT NULL,
  `price_normal` float(8,2) NOT NULL,
  `unit_excess` int(11) NOT NULL,
  `price_excess` float(8,2) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `dynamic_number` float NOT NULL,
  `penalty` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `billings`
--

INSERT INTO `billings` (`id`, `month_year`, `client`, `consumption`, `total`, `status`, `user`, `created_at`, `updated_at`, `unit_normal`, `price_normal`, `unit_excess`, `price_excess`, `payment_type`, `dynamic_number`, `penalty`) VALUES
(10, '2015-01', 2, '11', 225.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:57:08', 10, 200.00, 1, 25.00, 1, 300, 1000),
(11, '2015-01', 3, '12', 250.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:57:11', 10, 200.00, 1, 25.00, 1, 500, 0),
(12, '2015-01', 4, '13', 275.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:56:52', 10, 200.00, 1, 25.00, 1, 500, 0),
(13, '2015-01', 5, '14', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:56:46', 10, 200.00, 1, 25.00, 1, 500, 0),
(14, '2015-01', 6, '11', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:57:05', 15, 300.00, 1, 30.00, 1, 500, 0),
(15, '2015-01', 7, '12', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:56:49', 15, 300.00, 1, 30.00, 1, 500, 0),
(16, '2015-01', 8, '13', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:56:43', 15, 300.00, 1, 30.00, 1, 500, 0),
(17, '2015-01', 9, '14', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:57:16', 15, 300.00, 1, 30.00, 1, 300, 0),
(18, '2015-01', 10, '15', 300.00, 1, 1, '2015-01-19 17:55:11', '2015-01-24 17:57:19', 15, 300.00, 1, 30.00, 1, 300, 0),
(19, '2015-02', 1, '10', 200.00, 1, 1, '2015-02-19 18:10:44', '2015-02-25 18:14:30', 10, 200.00, 1, 25.00, 1, 200, 0),
(20, '2015-02', 2, '11', 225.00, 1, 1, '2015-02-19 18:10:46', '2015-02-25 18:14:27', 10, 200.00, 1, 25.00, 1, 225, 0),
(21, '2015-02', 3, '11', 225.00, 1, 1, '2015-02-19 18:10:46', '2015-02-25 18:14:33', 10, 200.00, 1, 25.00, 1, 225, 0),
(22, '2015-02', 4, '11', 225.00, 1, 1, '2015-02-19 18:10:47', '2015-02-25 18:14:21', 10, 200.00, 1, 25.00, 1, 500, 0),
(23, '2015-02', 5, '10', 200.00, 1, 1, '2015-02-19 18:10:47', '2015-02-25 18:14:14', 10, 200.00, 1, 25.00, 1, 200, 0),
(24, '2015-02', 6, '11', 300.00, 1, 1, '2015-02-19 18:10:48', '2015-02-25 18:14:24', 15, 300.00, 1, 30.00, 1, 300, 0),
(25, '2015-02', 7, '11', 300.00, 1, 1, '2015-02-19 18:10:49', '2015-02-25 18:14:17', 15, 300.00, 1, 30.00, 1, 300, 0),
(26, '2015-02', 8, '11', 300.00, 1, 1, '2015-02-19 18:10:49', '2015-02-25 18:14:10', 15, 300.00, 1, 30.00, 1, 1000, 0),
(27, '2015-02', 9, '11', 300.00, 1, 1, '2015-02-19 18:10:49', '2015-02-25 18:14:36', 15, 300.00, 1, 30.00, 1, 500, 0),
(28, '2015-02', 10, '11', 300.00, 1, 1, '2015-02-19 18:10:50', '2015-02-25 18:14:39', 15, 300.00, 1, 30.00, 1, 300, 0),
(29, '2015-03', 1, '1', 200.00, 1, 1, '2015-03-19 18:33:13', '2015-03-24 16:12:39', 10, 200.00, 1, 25.00, 1, 200, 0),
(30, '2015-03', 2, '1', 200.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:31', 10, 200.00, 1, 25.00, 1, 1000, 0),
(31, '2015-03', 3, '1', 200.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:42', 10, 200.00, 1, 25.00, 1, 200, 0),
(32, '2015-03', 4, '1', 200.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:23', 10, 200.00, 1, 25.00, 1, 200, 0),
(33, '2015-03', 5, '1', 200.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:16', 10, 200.00, 1, 25.00, 1, 300, 0),
(34, '2015-03', 6, '1', 300.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:28', 15, 300.00, 1, 30.00, 1, 300, 0),
(35, '2015-03', 7, '1', 300.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:19', 15, 300.00, 1, 30.00, 1, 400, 0),
(36, '2015-03', 8, '1', 300.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:11', 15, 300.00, 1, 30.00, 1, 500, 0),
(37, '2015-03', 9, '1', 300.00, 1, 1, '2015-03-19 18:33:14', '2015-03-24 16:12:45', 15, 300.00, 1, 30.00, 1, 300, 0),
(38, '2015-03', 10, '1', 300.00, 1, 1, '2015-03-19 18:33:15', '2015-03-24 16:12:51', 15, 300.00, 1, 30.00, 1, 500, 0),
(39, '2015-04', 1, '19', 425.00, 1, 1, '2015-04-19 16:16:26', '2015-04-24 16:21:08', 10, 200.00, 1, 25.00, 1, 1000, 0),
(40, '2015-04', 2, '7', 200.00, 1, 1, '2015-04-19 16:16:26', '2015-04-24 16:21:03', 10, 200.00, 1, 25.00, 1, 200, 0),
(41, '2015-04', 3, '6', 200.00, 1, 1, '2015-04-19 16:16:26', '2015-04-24 16:21:13', 10, 200.00, 1, 25.00, 1, 500, 0),
(42, '2015-04', 4, '5', 200.00, 1, 1, '2015-04-19 16:16:26', '2015-04-24 16:20:52', 10, 200.00, 1, 25.00, 1, 200, 0),
(43, '2015-04', 5, '5', 200.00, 1, 1, '2015-04-19 16:16:26', '2015-04-24 16:20:14', 10, 200.00, 1, 25.00, 1, 200, 0),
(44, '2015-04', 6, '7', 300.00, 1, 1, '2015-04-19 16:16:27', '2015-04-24 16:20:59', 15, 300.00, 1, 30.00, 1, 300, 0),
(45, '2015-04', 7, '6', 300.00, 1, 1, '2015-04-19 16:16:27', '2015-04-24 16:20:52', 15, 300.00, 1, 30.00, 1, 300, 0),
(46, '2015-04', 8, '5', 300.00, 1, 1, '2015-04-19 16:16:27', '2015-04-24 16:19:38', 15, 300.00, 1, 30.00, 1, 500, 0),
(47, '2015-04', 9, '4', 300.00, 1, 1, '2015-04-19 16:16:27', '2015-04-24 16:21:17', 15, 300.00, 1, 30.00, 1, 300, 0),
(48, '2015-04', 10, '3', 300.00, 1, 1, '2015-04-19 16:16:27', '2015-05-09 16:47:12', 15, 300.00, 1, 30.00, 1, 300, 0),
(49, '2015-05', 1, '20', 450.00, 1, 1, '2015-05-19 16:53:40', '2015-05-24 18:00:33', 10, 200.00, 1, 25.00, 1, 450, 0),
(50, '2015-05', 2, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:25', 10, 200.00, 1, 25.00, 1, 500, 0),
(51, '2015-05', 3, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:37', 10, 200.00, 1, 25.00, 1, 450, 0),
(52, '2015-05', 4, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:19', 10, 200.00, 1, 25.00, 1, 450, 0),
(53, '2015-05', 5, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:13', 10, 200.00, 1, 25.00, 1, 450, 0),
(54, '2015-05', 6, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:22', 15, 300.00, 1, 30.00, 1, 450, 0),
(55, '2015-05', 7, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:15', 15, 300.00, 1, 30.00, 1, 500, 0),
(56, '2015-05', 8, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:09', 15, 300.00, 1, 30.00, 1, 500, 0),
(57, '2015-05', 9, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:40', 15, 300.00, 1, 30.00, 1, 500, 0),
(58, '2015-05', 10, '20', 450.00, 1, 1, '2015-05-19 16:53:41', '2015-05-24 18:00:45', 15, 300.00, 1, 30.00, 1, 450, 0),
(59, '2015-06', 1, '10', 200.00, 1, 1, '2015-06-19 18:01:45', '2015-06-24 18:03:05', 10, 200.00, 1, 25.00, 1, 300, 0),
(60, '2015-06', 2, '10', 200.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:03:01', 10, 200.00, 1, 25.00, 1, 200, 0),
(61, '2015-06', 3, '10', 200.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:03:08', 10, 200.00, 1, 25.00, 1, 500, 0),
(62, '2015-06', 4, '10', 200.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:02:55', 10, 200.00, 1, 25.00, 1, 200, 0),
(63, '2015-06', 5, '10', 200.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:02:46', 10, 200.00, 1, 25.00, 1, 200, 0),
(64, '2015-06', 6, '10', 300.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:02:58', 15, 300.00, 1, 30.00, 1, 300, 0),
(65, '2015-06', 7, '10', 300.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:02:50', 15, 300.00, 1, 30.00, 1, 1000, 0),
(66, '2015-06', 8, '10', 300.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:02:43', 15, 300.00, 1, 30.00, 1, 300, 0),
(67, '2015-06', 9, '10', 300.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:03:12', 15, 300.00, 1, 30.00, 1, 300, 0),
(68, '2015-06', 10, '10', 300.00, 1, 1, '2015-06-19 18:01:46', '2015-06-24 18:03:16', 15, 300.00, 1, 30.00, 1, 300, 0),
(69, '2015-07', 1, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:14', 10, 200.00, 1, 25.00, 1, 1000, 0),
(70, '2015-07', 2, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:11', 10, 200.00, 1, 25.00, 1, 500, 0),
(71, '2015-07', 3, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:20', 10, 200.00, 1, 25.00, 1, 500, 0),
(72, '2015-07', 4, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:03', 10, 200.00, 1, 25.00, 1, 450, 0),
(73, '2015-07', 5, '21', 475.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:10:56', 10, 200.00, 1, 25.00, 1, 475, 0),
(74, '2015-07', 6, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:06', 15, 300.00, 1, 30.00, 1, 450, 0),
(75, '2015-07', 7, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:10:59', 15, 300.00, 1, 30.00, 1, 450, 0),
(76, '2015-07', 8, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:10:53', 15, 300.00, 1, 30.00, 1, 450, 0),
(77, '2015-07', 9, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:25', 15, 300.00, 1, 30.00, 1, 1000, 0),
(78, '2015-07', 10, '20', 450.00, 1, 1, '2015-07-19 18:05:06', '2015-07-24 18:11:30', 15, 300.00, 1, 30.00, 1, 450, 0),
(99, '2015-09', 1, '120', 3075.00, 0, 1, '2015-09-27 02:35:00', '2015-09-27 19:38:11', 1, 100.00, 1, 25.00, 0, 0, 0),
(100, '2015-09', 2, '120', 3075.00, 0, 1, '2015-09-27 02:35:00', '2015-09-27 19:38:11', 1, 100.00, 1, 25.00, 0, 0, 0),
(101, '2015-09', 3, '120', 3075.00, 0, 1, '2015-09-27 02:35:00', '2015-09-27 19:38:11', 1, 100.00, 1, 25.00, 0, 0, 0),
(102, '2015-09', 4, '120', 3075.00, 0, 1, '2015-09-27 02:35:01', '2015-09-27 19:38:11', 1, 100.00, 1, 25.00, 0, 0, 0),
(103, '2015-09', 5, '119', 3050.00, 0, 1, '2015-09-27 02:35:01', '2015-09-27 19:38:11', 1, 100.00, 1, 25.00, 0, 0, 0),
(104, '2015-09', 6, '120', 3670.00, 1, 1, '2015-09-27 02:35:01', '2015-09-28 00:07:50', 1, 100.00, 1, 30.00, 1, 4000, 0),
(105, '2015-09', 7, '120', 3670.00, 0, 1, '2015-09-27 02:35:01', '2015-09-27 19:38:11', 1, 100.00, 1, 30.00, 0, 0, 0),
(106, '2015-09', 8, '1', 100.00, 1, 1, '2015-09-27 02:35:01', '2015-09-27 03:28:18', 1, 100.00, 1, 30.00, 1, 100, 0),
(107, '2015-09', 9, '120', 3670.00, 0, 1, '2015-09-27 02:35:01', '2015-09-27 19:38:11', 1, 100.00, 1, 30.00, 0, 0, 0),
(108, '2015-09', 10, '120', 3670.00, 0, 1, '2015-09-27 02:35:01', '2015-09-27 19:38:11', 1, 100.00, 1, 30.00, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL,
  `meter_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership` float NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `start_billing` varchar(2555) COLLATE utf8_unicode_ci NOT NULL,
  `amount_paid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `meter_id`, `membership`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `address`, `type`, `status`, `start_billing`, `amount_paid`, `user`, `created_at`, `updated_at`) VALUES
(1, '111-111-100', 500, 'Dennis', '', 'Reynolds', '', '', 'Philadelphia', 0, 0, '2015-02', '500', 1, '2015-02-01 01:18:21', '2015-09-20 01:18:21'),
(2, '111-111-101', 500, 'Deandra', '', 'Reynolds', '', '', 'Philadelphia', 0, 0, '2015-01', '1000', 1, '2015-01-01 01:41:36', '2015-09-20 01:42:18'),
(3, '111-111-102', 500, 'Frank', 'Middlename', 'Reynolds', 'reynolds.frank@gmail.com', '09224884697', 'Philadelphia', 0, 0, '2015-01', '1000', 1, '2015-01-01 01:57:31', '2015-09-20 02:06:49'),
(4, '111-111-103', 500, 'Ronald', '', 'Mc Donald', '', '', 'Philadelphia', 0, 0, '2015-01', '1000', 1, '2015-01-01 02:08:07', '2015-09-20 04:48:45'),
(5, '111-111-104', 500, 'Charlie', '', 'Day', '', '', 'Philadelphia', 0, 1, '2015-01', '600', 1, '2015-01-01 02:15:39', '2015-09-29 04:40:00'),
(6, '111-111-105', 500, 'Ted', '', 'Mosby', '', '', 'New York', 1, 1, '2015-01', '500', 1, '2014-12-31 16:50:15', '2015-09-29 04:46:58'),
(7, '111-111-106', 500, 'Marshal', '', 'Eriksen', '', '', 'New York', 1, 0, '2015-01', '500', 1, '2014-12-31 16:51:01', '2014-12-31 16:51:01'),
(8, '111-111-108', 500, 'Lilly', '', 'Aldrin', '', '', 'New York', 1, 2, '2015-01', '500', 1, '2014-12-31 16:52:22', '2015-09-27 15:16:39'),
(9, '111-111-109', 500, 'Robin', '', 'Sherbatsky', '', '', 'New York', 1, 0, '2015-01', '500', 1, '2014-12-31 17:03:03', '2014-12-31 17:03:03'),
(10, '111-111-110', 500, 'Barney', 'Middlename', 'Stinson', '', '', 'New York', 1, 0, '2015-01', '500', 1, '2014-12-31 17:03:37', '2015-10-10 00:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE IF NOT EXISTS `dates` (
  `id` int(10) unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'collect', '20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'release', '30', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'notice', '10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'cutoff', '15', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `extra_billings`
--

CREATE TABLE IF NOT EXISTS `extra_billings` (
  `id` int(10) unsigned NOT NULL,
  `billing` varchar(2555) COLLATE utf8_unicode_ci NOT NULL,
  `total` float(8,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `client` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `extra_billings`
--

INSERT INTO `extra_billings` (`id`, `billing`, `total`, `description`, `user`, `created_at`, `updated_at`, `client`) VALUES
(1, '2015-02', 500.00, 'Pipe Repair', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8),
(2, '2015-07', 500.00, 'Pipe Repair\r\n', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9),
(3, '2015-10', 10.00, '10', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE IF NOT EXISTS `histories` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `type`, `type_id`, `content`, `user`, `status`, `created_at`, `updated_at`) VALUES
(1, 'client/profile/1', 1, 'Lastname, Firstname Middlename. Created an account Reynolds, Dennis ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(2, 'client/profile/2', 2, 'Lastname, Firstname Middlename. Created an account Reynolds, Deandra ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(3, 'client/profile/2', 2, 'Lastname, Firstname Middlename. updated an account Reynolds, Deandra ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(4, 'client/profile/3', 3, 'Lastname, Firstname Middlename. Created an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(5, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(6, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(7, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(8, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(9, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(10, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Mc Donalds, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(11, 'client/profile/3', 3, 'Lastname, Firstname Middlename. updated an account Reynolds, Frank ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(12, 'client/profile/4', 4, 'Lastname, Firstname Middlename. Created an account Mc Donald, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(13, 'client/profile/4', 4, 'Lastname, Firstname Middlename. updated an account Mc Donald, Ronald ', 1, 2, '2015-09-20 10:14:05', '2015-09-20 02:14:05'),
(14, 'client/profile/5', 5, 'Lastname, Firstname Middlename. Created an account Day, Charlie ', 1, 2, '2015-09-20 10:50:08', '2015-09-20 02:50:08'),
(15, 'client/profile/5', 5, 'Lastname, Firstname Middlename. updated an account Day, Charlie ', 1, 2, '2015-09-20 10:50:08', '2015-09-20 02:50:08'),
(16, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(17, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(18, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(19, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(20, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(21, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(22, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(23, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(24, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(25, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(26, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(27, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(28, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-20 12:26:44', '2015-09-20 04:26:44'),
(29, 'client/result?user=5', 5, 'Lastname, Firstname Middlename added a user and extra billing for  2015-09', 1, 2, '2015-09-21 11:12:27', '2015-09-21 03:12:27'),
(30, 'client/profile/4', 4, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-21 11:12:27', '2015-09-21 03:12:27'),
(31, 'client/profile/4', 4, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-21 11:12:27', '2015-09-21 03:12:27'),
(32, 'client/result?user=1', 1, 'Lastname, Firstname Middlename added a user and extra billing for  2015-09', 1, 2, '2015-09-21 11:12:27', '2015-09-21 03:12:27'),
(33, 'client/result?user=1', 1, 'Lastname, Firstname Middlename added a user and extra billing for  2015-09', 1, 2, '2015-09-21 11:12:27', '2015-09-21 03:12:27'),
(34, 'client/result?user=2', 2, 'Lastname, Firstname Middlename added a user and extra billing for  2015-09', 1, 2, '2015-09-23 00:26:36', '2015-09-22 16:26:36'),
(35, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-09-23 00:26:36', '2015-09-22 16:26:36'),
(36, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-09-23 00:26:36', '2015-09-22 16:26:36'),
(37, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-23 00:26:36', '2015-09-22 16:26:36'),
(38, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-23 00:26:36', '2015-09-22 16:26:36'),
(39, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-09-24 06:03:46', '2015-09-23 22:03:46'),
(40, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:15', '2015-01-24 18:00:15'),
(41, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:16', '2015-01-24 18:00:16'),
(42, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:16', '2015-01-24 18:00:16'),
(43, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-02', 1, 2, '2015-01-25 02:00:16', '2015-01-24 18:00:16'),
(44, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-02', 1, 2, '2015-01-25 02:00:16', '2015-01-24 18:00:16'),
(45, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-02', 1, 2, '2015-01-25 02:00:16', '2015-01-24 18:00:16'),
(46, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(47, 'client/profile/6', 6, 'Lastname, Firstname Middlename. Created an account Mosby, Ted ', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(48, 'client/profile/7', 7, 'Lastname, Firstname Middlename. Created an account Eriksen, Marshal ', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(49, 'client/profile/8', 8, 'Lastname, Firstname Middlename. Created an account Aldrin, Lilly ', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(50, 'client/profile/9', 9, 'Lastname, Firstname Middlename. Created an account Sherbatsky, Robin ', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(51, 'client/profile/10', 10, 'Lastname, Firstname Middlename. Created an account Stinson, Barney Middlename', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(52, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(53, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-02', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(54, 'client/result?user=8', 8, 'Lastname, Firstname Middlename added a user and extra billing for  2015-02', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(55, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(56, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(57, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(58, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(59, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(60, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-01', 1, 2, '2015-01-25 02:00:17', '2015-01-24 18:00:17'),
(61, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-02', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(62, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-03', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(63, 'client/result?user=9', 9, 'Lastname, Firstname Middlename added a user and extra billing for  2015-07', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(64, 'client/profile/10', 10, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(65, 'client/profile/10', 10, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(66, 'client/profile/10', 10, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(67, 'client/profile/10', 10, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-26 10:26:38', '2015-09-26 02:26:38'),
(68, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-09-27 15:41:47', '2015-09-27 07:41:47'),
(69, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-27 15:41:47', '2015-09-27 07:41:47'),
(70, 'billing', 0, 'Lastname, Firstname Middlename deleted the imported bills for the current billing', 1, 2, '2015-09-27 15:41:47', '2015-09-27 07:41:47'),
(71, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-27 15:41:47', '2015-09-27 07:41:47'),
(72, 'client/profile/8', 8, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-27 23:20:51', '2015-09-27 15:20:51'),
(73, 'billing', 0, 'Lastname, Firstname Middlename uploaded a billing for 2015-09', 1, 2, '2015-09-29 17:18:38', '2015-09-29 09:18:38'),
(74, 'client/profile/11', 11, 'Lastname, Firstname Middlename. Created an account lastname, 123123 123123', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(75, 'client/profile/12', 12, 'Lastname, Firstname Middlename. Created an account lastname, 123123 123123', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(76, 'client/profile/13', 13, 'Lastname, Firstname Middlename. Created an account lastname, 123123 123123', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(77, 'client/profile/14', 14, 'Lastname, Firstname Middlename. Created an account lastname, 123123 123123', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(78, 'client/profile/12', 12, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(79, 'client/profile/12', 12, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(80, 'client/profile/12', 12, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(81, 'client/profile/12', 12, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(82, 'client/profile/12', 12, 'Lastname, Firstname Middlename banned a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(83, 'client/profile/12', 12, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(84, 'client/profile/12', 12, 'Lastname, Firstname Middlename disabled a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(85, 'client/profile/12', 12, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-29 17:18:39', '2015-09-29 09:18:39'),
(86, 'client/profile/12', 12, 'Lastname, Firstname Middlename disabled a client. ', 1, 2, '2015-09-29 17:18:40', '2015-09-29 09:18:40'),
(87, 'client/profile/12', 12, 'Lastname, Firstname Middlename activated a client. ', 1, 2, '2015-09-29 17:18:40', '2015-09-29 09:18:40'),
(88, 'client/profile/5', 5, 'Lastname, Firstname Middlename disabled a client. ', 1, 2, '2015-09-29 17:18:40', '2015-09-29 09:18:40'),
(89, 'client/profile/6', 6, 'Lastname, Firstname Middlename disabled a client. ', 1, 2, '2015-09-29 17:18:40', '2015-09-29 09:18:40'),
(90, 'client/result?user=1', 1, 'Lastname, Firstname Middlename added a user and extra billing for  2015-10', 1, 0, '2015-10-02 20:22:25', '2015-10-02 20:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` float(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unit` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `type`, `price`, `created_at`, `updated_at`, `unit`) VALUES
(1, 'membership', 500.00, '2015-09-20 02:58:47', '2015-09-27 02:34:39', 0),
(2, 'vat', 0.00, '2015-09-20 02:58:47', '2015-09-27 02:34:39', 0),
(3, 'billing_a', 100.00, '2015-09-20 02:58:47', '2015-09-27 02:34:31', 1),
(4, 'billing_a_excess', 25.00, '2015-09-20 02:58:47', '2015-01-19 17:53:58', 1),
(5, 'billing_b', 100.00, '2015-09-20 02:58:47', '2015-09-27 02:34:39', 1),
(6, 'billing_b_excess', 30.00, '2015-09-20 02:58:47', '2015-01-19 17:53:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `address`, `email`, `password`, `contact`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lastname', 'Firstname', 'Middlename', 'Miami LLC', 'capstone.karla@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', '', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client`),
  ADD KEY `client_2` (`client`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meter_id` (`meter_id`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_billings`
--
ALTER TABLE `extra_billings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
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
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `extra_billings`
--
ALTER TABLE `extra_billings`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
