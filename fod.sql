-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2020 at 10:21 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fod`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_uid` text DEFAULT NULL,
  `admin_email` varchar(256) NOT NULL,
  `admin_mobile` varchar(12) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `admin_status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_uid`, `admin_email`, `admin_mobile`, `admin_name`, `admin_status`) VALUES
(1, '2feaae7b889d175ebead86a33ce12bc5f8e44e9e', 'hackdroidbykhan@gmail.com', '9835555982', 'Hackdroid (Developer)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_login_id` int(11) NOT NULL,
  `admin_login_val` text NOT NULL,
  `admin_login_ref` int(11) NOT NULL,
  `admin_login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_login_id`, `admin_login_val`, `admin_login_ref`, `admin_login_time`) VALUES
(1, '$2y$12$VwC/tnt8qrjGMZ0NZu7dM.52YGvMeCAHogasMdkgV6HNF.LX9W9Vi', 1, '2020-05-11 23:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `admin_session`
--

CREATE TABLE `admin_session` (
  `admin_session_id` int(11) NOT NULL,
  `admin_session_val` text NOT NULL,
  `admin_session_ref` int(11) NOT NULL,
  `admin_session_device` text NOT NULL,
  `admin_session_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_session`
--

INSERT INTO `admin_session` (`admin_session_id`, `admin_session_val`, `admin_session_ref`, `admin_session_device`, `admin_session_time`) VALUES
(1, 'c7f8c7efb6b380d84a7640c782db510eODI4NzQ5OQ==', 1, 'Login @ Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36', '2020-07-30 08:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `admin_token`
--

CREATE TABLE `admin_token` (
  `admin_token_id` int(11) NOT NULL,
  `admin_token_val` text NOT NULL,
  `admin_token_ref` int(11) NOT NULL,
  `admin_token_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `booking_booked_on` date NOT NULL DEFAULT current_timestamp(),
  `booking_user` int(11) NOT NULL,
  `booking_number` varchar(1024) DEFAULT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_start_date` date NOT NULL,
  `booking_end_date` date NOT NULL,
  `booking_total_days` int(11) NOT NULL,
  `booking_status` int(11) DEFAULT 5,
  `booking_property` int(11) NOT NULL,
  `booked_by` int(11) DEFAULT NULL,
  `booked_by_admin` int(11) DEFAULT NULL,
  `booking_room` int(11) DEFAULT NULL,
  `booking_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `booking_room_unit` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `booking_booked_on`, `booking_user`, `booking_number`, `booking_time`, `booking_start_date`, `booking_end_date`, `booking_total_days`, `booking_status`, `booking_property`, `booked_by`, `booked_by_admin`, `booking_room`, `booking_amount`, `booking_room_unit`) VALUES
(1, '2020-04-24', 9, '2020042400001', '2020-04-24 11:01:39', '2020-04-24', '2020-10-24', 183, 2, 5, 2, NULL, 33, '5000.00', NULL),
(2, '2020-05-16', 11, '2020051600002', '2020-05-15 18:35:28', '2020-05-16', '2020-05-20', 4, 2, 5, 2, NULL, 34, '500.00', NULL),
(3, '2020-05-20', 9, '2020052000003', '2020-05-19 23:50:19', '2020-05-20', '2020-11-30', 194, 2, 5, 2, NULL, 35, '5000.00', NULL),
(4, '2020-06-22', 4, '2020062200004', '2020-06-21 21:37:57', '2020-06-24', '2020-10-22', 120, 2, 5, 2, NULL, 36, '7000.00', NULL),
(5, '2020-07-08', 17, '2020070800005', '2020-07-07 21:26:50', '2020-07-08', '2022-07-08', 730, 2, 5, NULL, NULL, 37, '6000.00', NULL),
(6, '2020-07-08', 2, '2020070800006', '2020-07-08 02:59:52', '2020-07-08', '2022-06-08', 700, 2, 5, NULL, NULL, 42, '6000.00', NULL),
(7, '2020-07-13', 18, '2020071300007', '2020-07-13 04:03:58', '2020-07-13', '2021-07-13', 365, 2, 5, NULL, NULL, 38, '6000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_pay`
--

CREATE TABLE `booking_pay` (
  `booking_pay_id` int(11) NOT NULL,
  `booking_pay_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_pay_startdate` date NOT NULL,
  `booking_pay_enddate` date NOT NULL,
  `booking_pay_elec` decimal(10,2) NOT NULL DEFAULT 0.00,
  `booking_pay_room` int(11) NOT NULL COMMENT 'Room ID',
  `booking_pay_ref` int(11) NOT NULL COMMENT 'Booking Id',
  `booking_pay_rent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `booking_pay_others` decimal(10,2) NOT NULL DEFAULT 0.00,
  `booking_pay_elect_ref` int(11) DEFAULT NULL COMMENT 'Electricity Table Id',
  `booking_pay_period` text NOT NULL,
  `booking_pay_date` date NOT NULL DEFAULT current_timestamp(),
  `booking_pay_submitted_on` timestamp NULL DEFAULT NULL,
  `booking_pay_submit_date` date DEFAULT NULL,
  `booking_pay_mode` text DEFAULT NULL,
  `booking_pay_mode_ref` text DEFAULT NULL,
  `booking_pay_status` int(11) NOT NULL DEFAULT 1 COMMENT 'Payment status Id',
  `booking_pay_is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `booking_pay_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_pay`
--

INSERT INTO `booking_pay` (`booking_pay_id`, `booking_pay_time`, `booking_pay_startdate`, `booking_pay_enddate`, `booking_pay_elec`, `booking_pay_room`, `booking_pay_ref`, `booking_pay_rent`, `booking_pay_others`, `booking_pay_elect_ref`, `booking_pay_period`, `booking_pay_date`, `booking_pay_submitted_on`, `booking_pay_submit_date`, `booking_pay_mode`, `booking_pay_mode_ref`, `booking_pay_status`, `booking_pay_is_paid`, `booking_pay_token`) VALUES
(1, '2020-04-24 11:01:39', '2020-04-24', '2020-05-24', '100.00', 33, 1, '5000.00', '99.00', NULL, '2020-04-24  - 2020-05-24', '2020-04-24', '2020-05-10 22:35:06', '2020-05-11', 'CASH IN HAND', 'NA , Amount 5000.0 has been recieved by FOD20941', 2, 1, '53b48d36192c9a6d43e3b4bd94145d60/T/1589150886/MQ=='),
(2, '2020-05-15 18:35:28', '2020-05-16', '2020-06-16', '1.00', 34, 2, '500.00', '0.00', NULL, '2020-05-16  -TO- 2020-06-16', '2020-05-16', '2020-06-21 21:36:52', '2020-06-22', 'Google PAY', '9501909482 , Amount 500.0 has been recieved by FOD20941', 2, 1, '22c8aa2e91933586b43fde78e2d71230/T/1592775172/Mg=='),
(3, '2020-05-19 23:50:19', '2020-05-20', '2020-06-20', '0.00', 35, 3, '5000.00', '100.00', NULL, '2020-05-20  -TO- 2020-06-20', '2020-05-20', '2020-06-21 20:36:47', '2020-06-22', 'pay_F5QFmnwwb6emoe', 'RAZORPAY Payment Interface , ICIC netbanking', 2, 1, 'f63ecedad76d97fb5b843e80926dbc0a/T/1592774867/Mw=='),
(4, '2020-06-21 21:37:57', '2020-06-24', '2020-07-24', '99.00', 36, 4, '7000.00', '0.00', NULL, '2020-06-24  -TO- 2020-07-24', '2020-06-22', '2020-07-13 00:37:14', '2020-07-13', 'QJrkpaSs8nDRB9kl0OY9TQ== - 9083932242', 'Online Payuomeny interface', 2, 1, 'e386b1ae7ce00ef2b176c9123494d3a1/T/1594601654/NA=='),
(5, '2020-07-08 02:59:52', '2020-07-08', '2020-07-31', '0.00', 42, 6, '4600.00', '0.00', NULL, '2020/07/08  -TO- 2020/07/31', '2020-07-08', '2020-07-13 00:37:22', '2020-07-13', 'NQ== - 9083932248', 'Online Payumoney interface', 2, 1, '760e8964cb1ca4375ec8eff22e08346c/T/1594602982/NQ=='),
(6, '2020-07-13 04:03:58', '2020-07-13', '2020-07-31', '0.00', 38, 7, '3600.00', '0.00', NULL, '2020/07/13  -TO- 2020/07/31', '2020-07-13', '2020-07-13 04:37:05', '2020-07-13', 'Ng== - 9083932318', 'Online Payumoney interface', 2, 1, 'ecac338c73204da822006cca833585d3/T/1594616405/Ng==');

-- --------------------------------------------------------

--
-- Table structure for table `booking_status`
--

CREATE TABLE `booking_status` (
  `booking_status_id` int(11) NOT NULL,
  `booking_status_val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_status`
--

INSERT INTO `booking_status` (`booking_status_id`, `booking_status_val`) VALUES
(1, 'Upcoming'),
(2, 'Active'),
(3, 'Failed'),
(4, 'Compeleted'),
(5, 'Booked');

-- --------------------------------------------------------

--
-- Table structure for table `caretaker`
--

CREATE TABLE `caretaker` (
  `caretaker_id` int(11) NOT NULL,
  `caretaker_uid` varchar(512) NOT NULL,
  `caretaker_name` varchar(512) DEFAULT NULL,
  `caretaker_email` varchar(1024) DEFAULT NULL,
  `caretaker_mobile` varchar(13) NOT NULL,
  `caretaker_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `caretaker_status` smallint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker`
--

INSERT INTO `caretaker` (`caretaker_id`, `caretaker_uid`, `caretaker_name`, `caretaker_email`, `caretaker_mobile`, `caretaker_created_at`, `caretaker_status`) VALUES
(1, 'FOD20941', 'Test 1', 'test@tset.com', '9815963210', '2020-04-10 23:36:28', 1),
(2, 'FOD95942', 'Test 2', 'test@gmail.com', '9835555982', '2020-04-10 23:39:12', 1),
(3, 'FOD93943', 'Test3', 'test@gmail.com', '9835555983', '2020-04-10 23:40:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `caretaker_login`
--

CREATE TABLE `caretaker_login` (
  `caretaker_login_id` int(11) NOT NULL,
  `caretaker_login_password` text NOT NULL,
  `caretaker_login_ref` int(11) NOT NULL,
  `caretaker_login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker_login`
--

INSERT INTO `caretaker_login` (`caretaker_login_id`, `caretaker_login_password`, `caretaker_login_ref`, `caretaker_login_time`) VALUES
(4, '$2y$12$9mLfTu4u8.dHwJwMr1tqKuRdUuWE1qdejfFZI87pVIeKKc1vOQXG.', 2, '2020-07-16 11:04:50'),
(5, '$2y$12$XII2JaLdRNx.RutSOnqD/uAowqWtaYc81pn/6sFpD8AZTOg54b1oC', 3, '2020-04-14 11:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `caretaker_mapping`
--

CREATE TABLE `caretaker_mapping` (
  `caretaker_mapping_id` int(11) NOT NULL,
  `caretaker_mapping_property` int(11) NOT NULL,
  `caretaker_mapping_caretaker` int(11) NOT NULL,
  `caretaker_mapping_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `caretaker_mapping_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker_mapping`
--

INSERT INTO `caretaker_mapping` (`caretaker_mapping_id`, `caretaker_mapping_property`, `caretaker_mapping_caretaker`, `caretaker_mapping_time`, `caretaker_mapping_added_by`) VALUES
(30, 5, 1, '2020-05-11 19:56:11', 1),
(32, 5, 2, '2020-05-15 18:36:40', 1),
(33, 1, 2, '2020-05-15 18:36:41', 1),
(34, 2, 1, '2020-07-18 02:11:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `caretaker_session`
--

CREATE TABLE `caretaker_session` (
  `caretaker_session_id` int(11) NOT NULL,
  `caretaker_session_val` text NOT NULL,
  `caretaker_session_ref` int(11) NOT NULL,
  `caretaker_session_device` text DEFAULT NULL,
  `caretaker_session_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker_session`
--

INSERT INTO `caretaker_session` (`caretaker_session_id`, `caretaker_session_val`, `caretaker_session_ref`, `caretaker_session_device`, `caretaker_session_time`) VALUES
(1, '63fe62b9c180668bf0b923356e0c5d5bODI4NTY=', 2, 'LOGIN  attempt by 9835555982 from Dalvik/2.1.0 (Linux; U; Android 8.1.0; CPH1803 Build/OPM1.171019.026)', '2020-07-16 11:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `caretaker_token`
--

CREATE TABLE `caretaker_token` (
  `caretaker_token_id` int(11) NOT NULL,
  `caretaker_token_value` text NOT NULL,
  `caretaker_token_ref` int(11) NOT NULL,
  `caretaker_token_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker_token`
--

INSERT INTO `caretaker_token` (`caretaker_token_id`, `caretaker_token_value`, `caretaker_token_ref`, `caretaker_token_time`) VALUES
(2, '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '2020-04-14 10:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaints_id` int(11) NOT NULL,
  `complaints_title` varchar(128) NOT NULL,
  `complaints_cat` int(11) NOT NULL,
  `complaints_sub_cat` int(11) NOT NULL,
  `complaints_booking` int(11) NOT NULL,
  `complaints_date` date DEFAULT NULL,
  `complaints_timstamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `complaints_remarks` text NOT NULL,
  `complaints_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaints_id`, `complaints_title`, `complaints_cat`, `complaints_sub_cat`, `complaints_booking`, `complaints_date`, `complaints_timstamp`, `complaints_remarks`, `complaints_status`) VALUES
(3, 'Electrical / Electronics issue', 1, 24, 7, '2020-07-18', '2020-07-18 06:18:05', 'Friedge is not working  ', 1),
(4, 'Electrical / Electronics issue', 1, 5, 7, '2020-07-18', '2020-07-18 06:24:58', 'Switch is not working ', 1),
(5, 'Complaints / Maintenance', 4, 11, 7, '2020-07-18', '2020-07-18 06:53:51', 'Hello kf\'jdsfkdsfd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `complaints_issue`
--

CREATE TABLE `complaints_issue` (
  `complaints_issue_id` int(11) NOT NULL,
  `complaints_issue_topic` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints_issue`
--

INSERT INTO `complaints_issue` (`complaints_issue_id`, `complaints_issue_topic`) VALUES
(1, 'Electrical / Electronics issue'),
(2, 'Plumbing issue'),
(3, 'Carpenter'),
(4, 'Complaints / Maintenance'),
(5, 'Wifi / Issue');

-- --------------------------------------------------------

--
-- Table structure for table `complaints_status`
--

CREATE TABLE `complaints_status` (
  `complaints_status_id` int(11) NOT NULL,
  `complaints_status_val` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints_status`
--

INSERT INTO `complaints_status` (`complaints_status_id`, `complaints_status_val`) VALUES
(1, 'Open'),
(2, 'Closed'),
(3, 'Assigned');

-- --------------------------------------------------------

--
-- Table structure for table `complaints_sub_issue`
--

CREATE TABLE `complaints_sub_issue` (
  `complaints_sub_issue_id` int(11) NOT NULL,
  `complaints_sub_issue_topic` varchar(256) NOT NULL,
  `complaints_sub_issue_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints_sub_issue`
--

INSERT INTO `complaints_sub_issue` (`complaints_sub_issue_id`, `complaints_sub_issue_topic`, `complaints_sub_issue_ref`) VALUES
(1, 'Tube light /Bulb not working', 1),
(2, 'Fan Issue', 1),
(3, 'Geyser is not working', 1),
(4, 'AC Failure / Ac not working', 1),
(5, 'Switches / Board issue', 1),
(6, 'RO / Water purifier', 1),
(7, 'Water leakage', 2),
(8, 'Tap blockage', 2),
(9, 'Broken Tap', 2),
(10, 'Others', 2),
(11, 'Pg Cleanliness', 4),
(12, 'Staff behaviour', 4),
(13, 'Other issue', 4),
(14, 'Wifi is not working', 5),
(15, 'Wifi speed issue', 5),
(16, 'No wifi found', 5),
(17, 'Fixing items on wall', 3),
(18, 'Others', 3),
(24, 'Friedge', 1),
(25, 'LED / TV / Remote Issue', 1),
(26, 'Dish  / Tata sky / Remote', 1),
(27, 'Microwave', 1),
(28, 'Inverter / Gensets Issue', 1);

-- --------------------------------------------------------

--
-- Table structure for table `house_keeping`
--

CREATE TABLE `house_keeping` (
  `house_keeping_id` int(11) NOT NULL,
  `house_keeping_user` int(11) NOT NULL,
  `house_keeping_booking` int(11) NOT NULL,
  `house_keeping_date` date NOT NULL,
  `house_keeping_time_ref` int(11) NOT NULL,
  `house_keeping_timing` varchar(128) NOT NULL,
  `house_keeping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `house_keeping_is_completed` smallint(6) NOT NULL DEFAULT 0,
  `house_keeping_is_paid` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `house_keeping`
--

INSERT INTO `house_keeping` (`house_keeping_id`, `house_keeping_user`, `house_keeping_booking`, `house_keeping_date`, `house_keeping_time_ref`, `house_keeping_timing`, `house_keeping_amount`, `house_keeping_is_completed`, `house_keeping_is_paid`) VALUES
(1, 12, 1, '2020-06-21', 1, 'Time slot', '100.00', 0, 1),
(2, 3, 2, '2020-06-21', 1, 'sdFdf', '60.00', 0, 1),
(4, 9, 1, '2020-06-21', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM', '102.50', 0, 1),
(5, 9, 1, '2020-06-21', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM', '102.50', 0, 1),
(6, 9, 1, '2020-06-21', 2, 'Hari Ohm Apartment - Room No 1  , 11:00AM - 12:00PM', '102.50', 0, 1),
(7, 9, 1, '2020-06-22', 2, 'Hari Ohm Apartment - Room No 1  , 11:00AM - 12:00PM , REF ::\n        FOD_PAY_22020-06-22', '102.50', 0, 1),
(8, 9, 1, '2020-06-24', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-24', '102.50', 0, 1),
(9, 9, 1, '2020-06-22', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', '102.50', 0, 1),
(10, 9, 1, '2020-06-23', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-23', '102.50', 0, 1),
(11, 9, 1, '2020-06-22', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', '102.50', 0, 1),
(12, 9, 1, '2020-06-22', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', '102.50', 0, 1),
(13, 9, 1, '2020-06-22', 1, 'Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', '102.50', 0, 1),
(14, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(15, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(16, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(17, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(18, 18, 7, '2020-07-16', 2, 'Hari Ohm Apartment - Room No 6  , 11:00AM - 12:00PM , REF ::\n        FOD_PAY_22020-07-16', '99.00', 0, 0),
(19, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(20, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 1),
(21, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(22, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 1),
(23, 18, 7, '2020-07-16', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-16', '99.00', 0, 0),
(24, 18, 7, '2020-07-17', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-17', '99.00', 0, 0),
(25, 18, 7, '2020-07-17', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-17', '99.00', 0, 0),
(26, 18, 7, '2020-07-19', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-19', '99.00', 0, 0),
(27, 18, 7, '2020-07-19', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-19', '99.00', 0, 0),
(28, 18, 7, '2020-07-22', 1, 'Hari Ohm Apartment - Room No 6  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-07-22', '99.00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `listing_type`
--

CREATE TABLE `listing_type` (
  `listing_type_id` int(11) NOT NULL,
  `listing_type_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listing_type`
--

INSERT INTO `listing_type` (`listing_type_id`, `listing_type_name`) VALUES
(1, 'Lease'),
(2, 'Care Taking');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_val` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_val`) VALUES
(1, 'Jalandhar'),
(2, 'Phagwara');

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `partner_id` int(11) NOT NULL,
  `partner_uid` varchar(1024) NOT NULL,
  `partner_email` varchar(512) NOT NULL,
  `partner_mobile` varchar(12) NOT NULL,
  `partner_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `partner_created_by` int(11) NOT NULL,
  `partner_name` varchar(256) NOT NULL,
  `partner_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`partner_id`, `partner_uid`, `partner_email`, `partner_mobile`, `partner_time`, `partner_created_by`, `partner_name`, `partner_status`) VALUES
(1, 'FODAAI202002251', 'hackdroidbykhan@gmail.com', '9835555982', '2020-02-25 14:52:34', 1, 'Md Khalid Raza', 1),
(2, 'FODANT202002252', 'dev.flatsondemand@gmail.com', '6204304229', '2020-02-25 15:10:40', 1, 'Nitin Kumar Test', 1),
(3, 'FODSTE202002273', 'abc@hmail.com', '9815963210', '2020-02-27 15:31:21', 1, 'Test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partner_login`
--

CREATE TABLE `partner_login` (
  `partner_login_id` int(11) NOT NULL,
  `partner_login_val` text NOT NULL,
  `partner_login_ref` int(11) NOT NULL,
  `partner_login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partner_login`
--

INSERT INTO `partner_login` (`partner_login_id`, `partner_login_val`, `partner_login_ref`, `partner_login_time`) VALUES
(2, '$2b$12$rkIi2wJFy3Cyrs99QqB8iucdaC22U8ChG1Jd4TbnTSSOzv./kwjKa', 1, '2020-03-17 11:02:03'),
(3, '$2y$12$b5fgiobVd3grRN.o7mA5/uv7tvvcXPoWcuDaSdGyyGIkF3uChamGK', 2, '2020-02-25 15:10:41'),
(4, '$2b$12$NLcI77ABGRA.qtaCUFHGG.EtLgtV6XOb1L2t8gf3/YXXAG6sHnExi', 3, '2020-06-28 16:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `partner_mapping`
--

CREATE TABLE `partner_mapping` (
  `partner_mapping_id` int(11) NOT NULL,
  `partner_mapping_property_name` varchar(512) NOT NULL,
  `partner_mapping_property` int(11) NOT NULL,
  `partner_mapping_partner` int(11) NOT NULL,
  `partner_mapping_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `partner_mapping_added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partner_mapping`
--

INSERT INTO `partner_mapping` (`partner_mapping_id`, `partner_mapping_property_name`, `partner_mapping_property`, `partner_mapping_partner`, `partner_mapping_time`, `partner_mapping_added_by`) VALUES
(24, 'Test Hari ohm Apartment', 1, 1, '2020-03-16 12:14:47', 1),
(30, 'Hari Ohm Apartment', 5, 1, '2020-04-10 23:54:46', 1),
(31, 'Test 2', 2, 2, '2020-05-11 19:03:34', 1),
(32, 'Test 2', 2, 1, '2020-05-11 21:55:19', 1),
(34, 'Hari Ohm Apartment', 5, 2, '2020-06-19 13:18:18', 1),
(35, 'Hari Ohm Apartment', 5, 3, '2020-06-22 21:19:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payments_id` int(11) NOT NULL,
  `payments_token` text DEFAULT NULL,
  `payments_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `payments_status` tinyint(1) DEFAULT 0,
  `payments_amount` int(11) NOT NULL,
  `payments_ref` int(11) NOT NULL,
  `payments_caretaker` int(11) DEFAULT NULL,
  `payments_settled_on` timestamp NULL DEFAULT NULL,
  `payments_mode` varchar(128) NOT NULL DEFAULT 'OFFLINE',
  `payments_is_submitted` smallint(6) NOT NULL DEFAULT 0,
  `payments_submitted_date` date DEFAULT NULL,
  `payments_submitted_ref` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payments_id`, `payments_token`, `payments_time`, `payments_status`, `payments_amount`, `payments_ref`, `payments_caretaker`, `payments_settled_on`, `payments_mode`, `payments_is_submitted`, `payments_submitted_date`, `payments_submitted_ref`) VALUES
(6, '53b48d36192c9a6d43e3b4bd94145d60/T/1589150886/MQ==', '2020-05-10 22:48:06', 1, 5000, 1, 1, NULL, 'OFFLINE', 0, NULL, NULL),
(13, '553fc92e5ded83cf9e97028d135309f6/T/1592774865/Mw==', '2020-06-21 21:27:45', 1, 5000, 3, NULL, NULL, 'ONLINE', 0, NULL, NULL),
(14, 'f63ecedad76d97fb5b843e80926dbc0a/T/1592774867/Mw==', '2020-06-21 21:27:47', 1, 5000, 3, NULL, NULL, 'ONLINE', 0, NULL, NULL),
(15, '22c8aa2e91933586b43fde78e2d71230/T/1592775172/Mg==', '2020-06-21 21:32:52', 1, 500, 2, 1, NULL, 'OFFLINE', 0, NULL, NULL),
(16, 'e386b1ae7ce00ef2b176c9123494d3a1/T/1594601654/NA==', '2020-07-13 00:54:14', 0, 7099, 4, NULL, NULL, 'ONLINE', 0, NULL, NULL),
(17, '760e8964cb1ca4375ec8eff22e08346c/T/1594602982/NQ==', '2020-07-13 01:16:22', 0, 4600, 5, NULL, NULL, 'ONLINE', 0, NULL, NULL),
(18, 'ecac338c73204da822006cca833585d3/T/1594616405/Ng==', '2020-07-13 05:00:05', 0, 3600, 6, NULL, NULL, 'ONLINE', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments_settle`
--

CREATE TABLE `payments_settle` (
  `payments_settle_id` int(11) NOT NULL,
  `payments_settle_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `payments_settle_mode` text NOT NULL,
  `payments_settle_by` int(11) NOT NULL COMMENT 'ADmin ID',
  `payments_settle_ref` int(11) NOT NULL COMMENT 'Payments Id',
  `payments_settle_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments_settle`
--

INSERT INTO `payments_settle` (`payments_settle_id`, `payments_settle_time`, `payments_settle_mode`, `payments_settle_by`, `payments_settle_ref`, `payments_settle_date`) VALUES
(9, '2020-05-11 21:52:27', 'NA , Settlement processed by FOD_PANEL_1', 1, 6, '2020-05-12'),
(15, '2020-06-21 21:32:09', 'Verify , Settlement processed by FOD_PANEL_1', 1, 13, '2020-06-22'),
(16, '2020-06-21 21:32:09', 'Verify , Settlement processed by FOD_PANEL_1', 1, 14, '2020-06-22'),
(17, '2020-06-21 21:33:47', 'NA , Settlement processed by FOD_PANEL_1 ', 1, 15, '2020-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `payment_status_id` int(11) NOT NULL,
  `payment_status_val` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`payment_status_id`, `payment_status_val`) VALUES
(1, 'Due'),
(2, 'Paid'),
(3, 'Failed'),
(4, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `payment_user_history`
--

CREATE TABLE `payment_user_history` (
  `payment_user_history_id` int(11) NOT NULL,
  `payment_user_history_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_user_history_date` date NOT NULL DEFAULT current_timestamp(),
  `payment_user_history_amount` varchar(128) NOT NULL,
  `payment_user_history_mode` varchar(512) NOT NULL,
  `payment_user_history_desc` text DEFAULT NULL,
  `payment_user_history_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_user_history`
--

INSERT INTO `payment_user_history` (`payment_user_history_id`, `payment_user_history_time`, `payment_user_history_date`, `payment_user_history_amount`, `payment_user_history_mode`, `payment_user_history_desc`, `payment_user_history_user`) VALUES
(1, '2020-06-21 14:13:00', '2020-06-21', '102.50', 'paymentMode', 'Payment made for Housekeeping service 4 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM', 9),
(2, '2020-06-21 14:18:07', '2020-06-21', '102.5', 'pay_F5Iw2NOcm4XEnp', 'Payment made for Housekeeping service 5 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM', 9),
(3, '2020-06-21 14:21:51', '2020-06-21', '102.5', 'pay_F5IzzYZ8MbyHw5', 'Payment made for Housekeeping service 6 , Hari Ohm Apartment - Room No 1  , 11:00AM - 12:00PM', 9),
(4, '2020-06-21 15:10:09', '2020-06-21', '102.5', 'pay_F5JozsvqrxURGP', 'Payment made for Housekeeping service 7 , Hari Ohm Apartment - Room No 1  , 11:00AM - 12:00PM , REF ::\n        FOD_PAY_22020-06-22', 9),
(5, '2020-06-21 21:41:56', '2020-06-22', '102.5', 'pay_F5QUrXyHzKgOrJ', 'Payment made for Housekeeping service 8 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-24', 9),
(6, '2020-06-21 21:42:14', '2020-06-22', '102.5', 'pay_F5QVAiWDOl90ep', 'Payment made for Housekeeping service 9 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', 9),
(7, '2020-06-21 21:42:34', '2020-06-22', '102.5', 'pay_F5QVXKrsjSRB0w', 'Payment made for Housekeeping service 10 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-23', 9),
(8, '2020-06-21 21:42:49', '2020-06-22', '102.5', 'pay_F5QVo0NEwvHJiP', 'Payment made for Housekeeping service 11 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', 9),
(9, '2020-06-21 21:43:05', '2020-06-22', '102.5', 'pay_F5QW4rADL8FpvY', 'Payment made for Housekeeping service 12 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', 9),
(10, '2020-06-21 21:43:19', '2020-06-22', '102.5', 'pay_F5QWKVFKtG9SIq', 'Payment made for Housekeeping service 13 , Hari Ohm Apartment - Room No 1  , 10:00AM - 11:00AM , REF ::\n        FOD_PAY_12020-06-22', 9),
(11, '2020-07-15 04:28:51', '2020-07-15', '99.00', 'MjA= - 9083934430 /T/Online Payumoney', 'Online Payumoney interface Payment for FOD_PAY_20 ', 18),
(12, '2020-07-15 05:02:01', '2020-07-15', '99.00', 'MjI= - 9083934453 /T/Online Payumoney', 'Online Payumoney interface Payment for House_keeping_payment22 ', 18);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `property_id` int(11) NOT NULL,
  `property_uid` varchar(1024) NOT NULL,
  `property_name` varchar(512) NOT NULL,
  `property_lat` decimal(12,6) NOT NULL,
  `property_long` decimal(12,6) NOT NULL,
  `property_address` varchar(512) NOT NULL,
  `property_cover_image` text NOT NULL,
  `property_type` int(11) NOT NULL,
  `property_total_room` int(11) NOT NULL,
  `property_listing_type` int(11) NOT NULL,
  `property_price` decimal(12,2) NOT NULL,
  `property_added_by` int(11) NOT NULL,
  `property_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `property_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `property_uid`, `property_name`, `property_lat`, `property_long`, `property_address`, `property_cover_image`, `property_type`, `property_total_room`, `property_listing_type`, `property_price`, `property_added_by`, `property_added_on`, `property_status`) VALUES
(1, 'FOD20201', 'Test Hari ohm Apartment', '31.244447', '75.702245', 'Near Addiction Gym Law gate Jalandhar', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60', 1, 14, 1, '6500.00', 1, '2020-02-26 17:58:23', 1),
(2, 'FOD20202', 'Test 2', '31.244447', '75.702245', 'Law gate', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60', 2, 2, 2, '2000.00', 1, '2020-02-26 19:36:54', 1),
(3, 'FOD20203', 'Test Property', '31.244447', '75.702245', 'Law gate Jalandhar', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60', 1, 6, 2, '7000.00', 1, '2020-02-27 08:47:33', 1),
(4, 'FOD20204', 'Test 3', '31.244447', '75.702245', 'Jalandhar', 'https://frntr-life-properties.oyorooms.com/living-india/propertiesServiceImages/1412/bba91d3b-0469-4785-b58d-28341025e41a.jpg', 1, 3, 1, '5000.00', 1, '2020-02-27 15:28:56', 1),
(5, 'FOD20205', 'Hari Ohm Apartment', '31.264231', '75.678843', 'Near Red apple apartment law gate', 'https://images.oyoroomscdn.com/uploads/hotel_image/90050/large/ff1c88b7c1ee241d.jpg', 1, 14, 1, '6000.00', 1, '2020-03-26 11:36:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_image`
--

CREATE TABLE `property_image` (
  `property_image_id` int(11) NOT NULL,
  `property_image_url` text NOT NULL,
  `property_image_ref` int(11) NOT NULL,
  `property_image_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `property_image_title` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property_image`
--

INSERT INTO `property_image` (`property_image_id`, `property_image_url`, `property_image_ref`, `property_image_date`, `property_image_title`) VALUES
(1, 'http://192.168.1.9/fod/panel/api/../upload/be53a0541a6d36f6ecb879fa2c584b082975FP_Refer_Earn_1000px_03.jpg', 1, '2020-02-27 10:50:43', 'Image'),
(2, 'http://192.168.1.9/fod/panel/api/../upload/be53a0541a6d36f6ecb879fa2c584b081440FP_Refer_Earn_1000px_03.jpg', 1, '2020-02-27 10:54:06', 'Image'),
(3, 'http://localhost/fod/panel/api/../upload/098f6bcd4621d373cade4e832627b4f65662FP_Refer_Earn_1000px_03.jpg', 4, '2020-02-27 15:29:48', 'test'),
(4, 'http://localhost/fod/panel/api/../upload/098f6bcd4621d373cade4e832627b4f61236Beverages.jpg', 1, '2020-03-12 15:50:34', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `property_type_id` int(11) NOT NULL,
  `property_type_val` varchar(128) NOT NULL,
  `property_type_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`property_type_id`, `property_type_val`, `property_type_image`) VALUES
(1, '1 BHK', NULL),
(2, '2 BHK', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(128) NOT NULL,
  `room_initial_reading` int(11) NOT NULL,
  `room_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `room_ref` int(11) NOT NULL,
  `room_is_vacant` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_number`, `room_initial_reading`, `room_created_at`, `room_ref`, `room_is_vacant`) VALUES
(33, 'Room No 1', 100, '2020-03-26 11:58:47', 5, 1),
(34, 'Room No 2', 100, '2020-03-26 11:58:47', 5, 1),
(35, 'Room No 3', 100, '2020-03-26 11:58:47', 5, 1),
(36, 'Room No 4', 100, '2020-03-26 11:58:47', 5, 1),
(37, 'Room No 5', 100, '2020-03-26 11:58:47', 5, 1),
(38, 'Room No 6', 100, '2020-03-26 11:58:47', 5, 1),
(39, 'Room No 7', 100, '2020-03-26 11:58:47', 5, 0),
(40, 'Room No 8', 100, '2020-03-26 11:58:47', 5, 0),
(41, 'Room No 9', 100, '2020-03-26 11:58:47', 5, 0),
(42, 'Room No 10', 100, '2020-03-26 11:58:47', 5, 1),
(43, 'Room No 11', 100, '2020-03-26 11:58:47', 5, 0),
(44, 'Room No 12', 100, '2020-03-26 11:58:47', 5, 0),
(45, 'Room No 13', 100, '2020-03-26 11:58:47', 5, 0),
(46, 'Room No 14', 100, '2020-03-26 11:58:47', 5, 0),
(47, 'Room No 1', 1234, '2020-03-26 20:02:40', 2, 0),
(48, 'Room No 2', 234, '2020-03-26 20:02:40', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `security_deposite`
--

CREATE TABLE `security_deposite` (
  `security_deposite_id` int(11) NOT NULL,
  `security_deposite_amount` varchar(256) NOT NULL,
  `security_deposite_ref` int(11) NOT NULL,
  `security_deposite_mode` varchar(512) NOT NULL,
  `security_deposite_refund` int(11) DEFAULT 0,
  `security_deposite_refund_ref` text DEFAULT NULL,
  `security_deposite_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security_deposite`
--

INSERT INTO `security_deposite` (`security_deposite_id`, `security_deposite_amount`, `security_deposite_ref`, `security_deposite_mode`, `security_deposite_refund`, `security_deposite_refund_ref`, `security_deposite_time`) VALUES
(28, '5000', 1, 'OFFLINE MODE CARE APP', 0, NULL, '2020-04-24 11:01:39'),
(29, '5000', 2, 'OFFLINE MODE CARE APP', 0, NULL, '2020-05-15 18:35:28'),
(31, '5000', 3, 'OFFLINE MODE CARE APP', 0, NULL, '2020-05-19 23:50:19'),
(32, '5000', 4, 'OFFLINE MODE CARE APP', 0, NULL, '2020-06-21 21:37:57'),
(33, '5000', 5, 'MODE OFFLINE COLLECTION Account hackdroidbykhan@gmail.com', 0, NULL, '2020-07-07 21:26:50'),
(35, '5000', 6, 'MODE OFFLINE COLLECTION Account hackdroidbykhan@gmail.com', 0, NULL, '2020-07-08 02:59:52'),
(36, '5000', 7, 'MODE OFFLINE COLLECTION Account hackdroidbykhan@gmail.com', 0, NULL, '2020-07-13 04:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(11) NOT NULL,
  `time_slot_timing` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `time_slot_timing`) VALUES
(1, '10:00AM - 11:00AM'),
(2, '11:00AM - 12:00PM'),
(3, '12:00PM - 01:00PM'),
(4, '01:00PM - 02:00PM'),
(5, '02:00PM - 03:00PM'),
(6, '03:00PM - 04:00Pm');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_uid` varchar(1024) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_name` varchar(512) DEFAULT NULL,
  `user_email` varchar(512) DEFAULT NULL,
  `user_father` varchar(512) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created_by` int(11) DEFAULT NULL,
  `user_profile_image` text DEFAULT NULL,
  `user_is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_uid`, `user_phone`, `user_name`, `user_email`, `user_father`, `user_created_at`, `user_created_by`, `user_profile_image`, `user_is_verified`) VALUES
(2, 'n2gsmP6ncSSOmULp3elIfezVpPV2', '9835555978', 'khalid raza khan', 'hackdroidbykhan@gmail.com', 'yusuf khan', '2020-03-18 11:29:50', NULL, NULL, 0),
(3, 'CbAFtVKy7tYoBU8yrerW79st8Lf2', '9815963213', 'MD KHALID RAZA KHAN', 'mokhalidrazakhan@gmail.com', 'Yusuf Khan', '2020-03-18 11:32:27', NULL, NULL, 0),
(4, 'k8FsBZMOVdWyYX8GQ5LuudMc89x2', '6204304229', 'MD KHALID RAZA KHAN', 'test@flatsondemand.co.in', 'Yusuf khan', '2020-03-18 11:44:12', NULL, NULL, 0),
(8, 'Ez8wvBA46uQt3w6tmirJ6tCtPW02', '7764002009', 'Khalid', 'hackdroidbykhan@test.in', 'test', '2020-04-17 11:36:17', NULL, NULL, 0),
(9, 'nLUlFKXtMcaryhnqBKSg2iJ7AeA3', '9501909482', 'NITIN', 'nitin@gmail.com', 'Father name', '2020-04-17 11:37:59', NULL, NULL, 0),
(10, 'si1YqkEPcSNQypmQyBiYTbvRd653', '9608196082', 'test', 'test@fod.in', 'test', '2020-04-17 11:41:16', NULL, NULL, 0),
(11, 'Z9crOaASYdNxuiD0BA8vCaxWbWm2', '9835555981', 'name test', 'hackdroidbykhan@gmail.co', 'name', '2020-04-19 16:57:13', NULL, 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_170721_5565700659862436449.jpg?alt=media&token=cc52f696-3e0a-4eb4-acab-b66762303220', 1),
(12, 'bFhlM32da7WSZ92MjHjnDixA95V2', '9835555980', 'name', 'test1@fod.in', 'name', '2020-04-20 12:48:48', 2, 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_165358_3192539495334719328.jpg?alt=media&token=4f99b41a-8438-4fea-bbef-86ba842ebf27', 1),
(13, 'Sp4rxzHv3bOP4Q3rTQuTwmjlvfv1', '9876543210', 'kjsdfks', 'hackdroidbykhan@gmail.comd', 'ksdfs', '2020-05-11 23:24:18', NULL, NULL, 0),
(17, 'tlzeuyYYpuTEIenZuCHjXryvqdD3', '9876543214', 'FOD USER', NULL, NULL, '2020-07-04 03:37:02', NULL, NULL, 0),
(18, '3GiZcODLkBYatk7OHwHhmzBwNAF3', '9835555982', 'MD KHALID RAZA KHAN', NULL, 'Yusuf khan', '2020-07-08 06:14:21', NULL, 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_164102_9073336102315679122.jpg?alt=media&token=4817d7f2-964f-46a9-9e43-91370db1f3f9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE `user_document` (
  `user_document_id` int(11) NOT NULL,
  `user_document_type` varchar(1024) NOT NULL,
  `user_document_url` text DEFAULT NULL,
  `user_document_ref` int(11) NOT NULL,
  `user_document_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_document_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_document`
--

INSERT INTO `user_document` (`user_document_id`, `user_document_type`, `user_document_url`, `user_document_ref`, `user_document_time`, `user_document_by`) VALUES
(1, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_163818_8037514173238468252.jpg?alt=media&token=d91aae65-73e7-4c68-a2c8-337792754b90', 12, '2020-04-22 11:09:07', 2),
(2, 'PASSPORT_ADHAAR_FRONT', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_164004_6594408883500086064.jpg?alt=media&token=ec2efa27-fe67-41d2-8c3a-2fddf9d61eb3', 12, '2020-04-22 11:10:23', 2),
(3, 'PASSPORT_ADHAAR_BACK', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_164025_2164409968657695450.jpg?alt=media&token=5d5c66fd-7e53-4421-a877-62b7b19517fd', 12, '2020-04-22 11:10:43', 2),
(4, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_165324_4090091863584560636.jpg?alt=media&token=f15928e1-5b58-487e-a5c2-80b4821e062b', 12, '2020-04-22 11:23:57', 2),
(5, 'PASSPORT_ADHAAR_FRONT', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_165427_4884565465865590227.jpg?alt=media&token=2e216021-77f0-4d9d-be49-5448c08af40b', 12, '2020-04-22 11:24:41', 2),
(6, 'PASSPORT_ADHAAR_BACK', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_165443_4672619112956024031.jpg?alt=media&token=efafd1aa-7fed-434b-8092-3e6c65b3504b', 12, '2020-04-22 11:24:56', 2),
(7, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_170703_4919568792146136509.jpg?alt=media&token=7fcec1d2-b7e1-49b0-98e2-93c52493814e', 11, '2020-04-22 11:37:20', 2),
(8, 'PASSPORT_ADHAAR_BACK', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_170737_1762669207114047317.jpg?alt=media&token=49a2bd7d-e2f0-4928-9aa2-1a7b88940c6a', 11, '2020-04-22 11:37:51', 2),
(9, 'PASSPORT_ADHAAR_FRONT', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200422_170753_6275436829630127504.jpg?alt=media&token=6d0788e4-5a0c-4e7c-92a7-b3bc93986228', 11, '2020-04-22 11:38:07', 2),
(10, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200423_012420_6256711401886134484.jpg?alt=media&token=fe5604e9-0e9c-438d-b5f5-22be308c89bc', 10, '2020-04-22 19:54:37', 2),
(11, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_163815_45944193330804256.jpg?alt=media&token=43ecd515-9a90-48d3-9bc1-9546aa83eb04', 18, '2020-07-16 11:08:41', 2),
(12, 'PASSPORT_ADHAAR_FRONT', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_163843_2098579402753082885.jpg?alt=media&token=0580c735-36df-4d87-9da1-48be51325743', 18, '2020-07-16 11:09:04', 2),
(13, 'COLLEGE_ID_CARD', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_164241_7881331050933270966.jpg?alt=media&token=1ce37580-59be-43eb-8b2a-c6b4325cb06c', 18, '2020-07-16 11:13:02', 2),
(14, 'PASSPORT_ADHAAR_FRONT', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_164306_4291146755793735877.jpg?alt=media&token=8df4bad3-63ce-40e0-a212-0a9f72f300e7', 18, '2020-07-16 11:13:22', 2),
(15, 'PASSPORT_ADHAAR_BACK', 'https://firebasestorage.googleapis.com/v0/b/fodv2-be234.appspot.com/o/FOD_USER_DOCS%2Fdocuments%2Fstorage%2Femulated%2F0%2FAndroid%2Fdata%2Fcom.flatsondemand.fod.care%2Ffiles%2FPictures%2FIMG_20200716_164325_5510419627493821873.jpg?alt=media&token=21b08f89-9002-47db-9bf8-4955f91b5b84', 18, '2020-07-16 11:13:43', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_profile_id` int(11) NOT NULL,
  `user_profile_address` varchar(1024) NOT NULL,
  `user_profile_city` varchar(1024) NOT NULL,
  `user_profile_country` varchar(512) NOT NULL,
  `user_profile_zipcode` varchar(256) NOT NULL,
  `user_profile_res_contact` varchar(128) NOT NULL,
  `user_profile_visa_number` varchar(128) NOT NULL,
  `user_profile_passport_number` varchar(128) NOT NULL,
  `user_profile_ref` int(11) NOT NULL,
  `user_profile_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_profile_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_profile_id`, `user_profile_address`, `user_profile_city`, `user_profile_country`, `user_profile_zipcode`, `user_profile_res_contact`, `user_profile_visa_number`, `user_profile_passport_number`, `user_profile_ref`, `user_profile_time`, `user_profile_created_by`) VALUES
(1, 'test', 'test', 'test', '147777', '9835559285', 'NA', 'NA', 12, '2020-04-22 11:25:13', 2),
(2, 'Hariom apartment room no 10', 'law gate Jalandhar', 'Punjab India', '144411', '9835555982', 'NA', '514917588198', 3, '2020-04-22 13:00:58', 2),
(3, 'Jalandhar', 'Jalandhar ', 'Punjab India', '144411', '9510909482', 'NA', 'NA', 9, '2020-04-22 11:44:30', 2),
(4, 'Govindpur kesahwe barauni', 'begusarai', 'Bihar India', '851134', '9431094310', '514917588198', '514917588198', 4, '2020-04-22 12:57:21', 2),
(5, 'Jalandhar', 'Jalandhar', 'Punjab', '144411', '9835555982', 'NA', 'NA', 11, '2020-04-22 11:38:30', 2),
(6, 'Govindpur kesawe ', 'begusarai', 'Bihar India', '851134', '9835555982', 'NA', '514917588198', 18, '2020-07-16 11:15:02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_wishlist`
--

CREATE TABLE `user_wishlist` (
  `user_wishlist_id` int(11) NOT NULL,
  `user_wishlist_user` int(11) NOT NULL,
  `user_wishlist_property` int(11) NOT NULL,
  `user_wishlist_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `uid_admin` (`admin_uid`) USING HASH;

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`admin_login_id`),
  ADD KEY `admin_ref` (`admin_login_ref`);

--
-- Indexes for table `admin_session`
--
ALTER TABLE `admin_session`
  ADD PRIMARY KEY (`admin_session_id`),
  ADD KEY `admi_reff` (`admin_session_ref`);

--
-- Indexes for table `admin_token`
--
ALTER TABLE `admin_token`
  ADD PRIMARY KEY (`admin_token_id`),
  ADD KEY `ref_admkldf` (`admin_token_ref`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `property_refe` (`booking_property`),
  ADD KEY `user_refefe` (`booking_user`),
  ADD KEY `admin_refefe` (`booked_by_admin`),
  ADD KEY `sttsus_reffe` (`booking_status`),
  ADD KEY `booking_room-reff` (`booking_room`),
  ADD KEY `bookedby` (`booked_by`);

--
-- Indexes for table `booking_pay`
--
ALTER TABLE `booking_pay`
  ADD PRIMARY KEY (`booking_pay_id`),
  ADD KEY `booking_ref` (`booking_pay_ref`),
  ADD KEY `booking_room` (`booking_pay_room`),
  ADD KEY `status` (`booking_pay_status`);

--
-- Indexes for table `booking_status`
--
ALTER TABLE `booking_status`
  ADD PRIMARY KEY (`booking_status_id`);

--
-- Indexes for table `caretaker`
--
ALTER TABLE `caretaker`
  ADD PRIMARY KEY (`caretaker_id`);

--
-- Indexes for table `caretaker_login`
--
ALTER TABLE `caretaker_login`
  ADD PRIMARY KEY (`caretaker_login_id`),
  ADD KEY `caretaker_id_ref` (`caretaker_login_ref`);

--
-- Indexes for table `caretaker_mapping`
--
ALTER TABLE `caretaker_mapping`
  ADD PRIMARY KEY (`caretaker_mapping_id`),
  ADD KEY `oropeorvfv_property` (`caretaker_mapping_property`),
  ADD KEY `caretaker` (`caretaker_mapping_caretaker`),
  ADD KEY `admindfdf` (`caretaker_mapping_added_by`);

--
-- Indexes for table `caretaker_session`
--
ALTER TABLE `caretaker_session`
  ADD PRIMARY KEY (`caretaker_session_id`),
  ADD KEY `sdfdfdf` (`caretaker_session_ref`);

--
-- Indexes for table `caretaker_token`
--
ALTER TABLE `caretaker_token`
  ADD PRIMARY KEY (`caretaker_token_id`),
  ADD KEY `ref_user` (`caretaker_token_ref`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaints_id`),
  ADD KEY `catyef` (`complaints_cat`),
  ADD KEY `sudbhf` (`complaints_sub_cat`),
  ADD KEY `bookingjshd` (`complaints_booking`),
  ADD KEY `sttays` (`complaints_status`);

--
-- Indexes for table `complaints_issue`
--
ALTER TABLE `complaints_issue`
  ADD PRIMARY KEY (`complaints_issue_id`);

--
-- Indexes for table `complaints_status`
--
ALTER TABLE `complaints_status`
  ADD PRIMARY KEY (`complaints_status_id`);

--
-- Indexes for table `complaints_sub_issue`
--
ALTER TABLE `complaints_sub_issue`
  ADD PRIMARY KEY (`complaints_sub_issue_id`),
  ADD KEY `refdhf` (`complaints_sub_issue_ref`);

--
-- Indexes for table `house_keeping`
--
ALTER TABLE `house_keeping`
  ADD PRIMARY KEY (`house_keeping_id`),
  ADD KEY `userdhfkdsf` (`house_keeping_user`),
  ADD KEY `booking` (`house_keeping_booking`),
  ADD KEY `ffdgghg` (`house_keeping_time_ref`);

--
-- Indexes for table `listing_type`
--
ALTER TABLE `listing_type`
  ADD PRIMARY KEY (`listing_type_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`partner_id`),
  ADD UNIQUE KEY `partner_uid` (`partner_uid`) USING HASH,
  ADD KEY `created_by` (`partner_created_by`);

--
-- Indexes for table `partner_login`
--
ALTER TABLE `partner_login`
  ADD PRIMARY KEY (`partner_login_id`),
  ADD KEY `partner_ref_lign` (`partner_login_ref`);

--
-- Indexes for table `partner_mapping`
--
ALTER TABLE `partner_mapping`
  ADD PRIMARY KEY (`partner_mapping_id`),
  ADD KEY `propert_ref` (`partner_mapping_property`),
  ADD KEY `parnert_ref` (`partner_mapping_partner`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payments_id`),
  ADD KEY `caretaker_refdjs` (`payments_caretaker`),
  ADD KEY `booking_payments` (`payments_ref`);

--
-- Indexes for table `payments_settle`
--
ALTER TABLE `payments_settle`
  ADD PRIMARY KEY (`payments_settle_id`),
  ADD KEY `by` (`payments_settle_by`),
  ADD KEY `refdsdf` (`payments_settle_ref`);

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`payment_status_id`);

--
-- Indexes for table `payment_user_history`
--
ALTER TABLE `payment_user_history`
  ADD PRIMARY KEY (`payment_user_history_id`),
  ADD KEY `sjksdjhfiser_user` (`payment_user_history_user`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`property_id`),
  ADD UNIQUE KEY `property_uid` (`property_uid`) USING HASH,
  ADD KEY `property_type_ref` (`property_type`),
  ADD KEY `peroperty_lisintg_ref` (`property_listing_type`),
  ADD KEY `added_by` (`property_added_by`);

--
-- Indexes for table `property_image`
--
ALTER TABLE `property_image`
  ADD PRIMARY KEY (`property_image_id`),
  ADD KEY `peropwfjh+ref` (`property_image_ref`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`property_type_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room Ref` (`room_ref`);

--
-- Indexes for table `security_deposite`
--
ALTER TABLE `security_deposite`
  ADD PRIMARY KEY (`security_deposite_id`),
  ADD KEY `booking_rerffe` (`security_deposite_ref`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_phone` (`user_phone`),
  ADD KEY `fdcreaw` (`user_created_by`);

--
-- Indexes for table `user_document`
--
ALTER TABLE `user_document`
  ADD PRIMARY KEY (`user_document_id`),
  ADD KEY `rerfdgd` (`user_document_ref`),
  ADD KEY `craetd_hbvy` (`user_document_by`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_profile_id`),
  ADD KEY `reefs_sdfjh` (`user_profile_ref`),
  ADD KEY `cfeated_by_caretaker` (`user_profile_created_by`);

--
-- Indexes for table `user_wishlist`
--
ALTER TABLE `user_wishlist`
  ADD PRIMARY KEY (`user_wishlist_id`),
  ADD KEY `shfhjfuiser` (`user_wishlist_user`),
  ADD KEY `properowrkf` (`user_wishlist_property`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `admin_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_session`
--
ALTER TABLE `admin_session`
  MODIFY `admin_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_token`
--
ALTER TABLE `admin_token`
  MODIFY `admin_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `booking_pay`
--
ALTER TABLE `booking_pay`
  MODIFY `booking_pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `booking_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `caretaker`
--
ALTER TABLE `caretaker`
  MODIFY `caretaker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `caretaker_login`
--
ALTER TABLE `caretaker_login`
  MODIFY `caretaker_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `caretaker_mapping`
--
ALTER TABLE `caretaker_mapping`
  MODIFY `caretaker_mapping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `caretaker_session`
--
ALTER TABLE `caretaker_session`
  MODIFY `caretaker_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `caretaker_token`
--
ALTER TABLE `caretaker_token`
  MODIFY `caretaker_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaints_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaints_issue`
--
ALTER TABLE `complaints_issue`
  MODIFY `complaints_issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaints_status`
--
ALTER TABLE `complaints_status`
  MODIFY `complaints_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaints_sub_issue`
--
ALTER TABLE `complaints_sub_issue`
  MODIFY `complaints_sub_issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `house_keeping`
--
ALTER TABLE `house_keeping`
  MODIFY `house_keeping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `listing_type`
--
ALTER TABLE `listing_type`
  MODIFY `listing_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `partner_login`
--
ALTER TABLE `partner_login`
  MODIFY `partner_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partner_mapping`
--
ALTER TABLE `partner_mapping`
  MODIFY `partner_mapping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments_settle`
--
ALTER TABLE `payments_settle`
  MODIFY `payments_settle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `payment_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_user_history`
--
ALTER TABLE `payment_user_history`
  MODIFY `payment_user_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_image`
--
ALTER TABLE `property_image`
  MODIFY `property_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `property_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `security_deposite`
--
ALTER TABLE `security_deposite`
  MODIFY `security_deposite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `user_document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `user_profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_wishlist`
--
ALTER TABLE `user_wishlist`
  MODIFY `user_wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD CONSTRAINT `admin_ref` FOREIGN KEY (`admin_login_ref`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `admin_session`
--
ALTER TABLE `admin_session`
  ADD CONSTRAINT `admi_reff` FOREIGN KEY (`admin_session_ref`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `admin_token`
--
ALTER TABLE `admin_token`
  ADD CONSTRAINT `ref_admkldf` FOREIGN KEY (`admin_token_ref`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `admin_refefe` FOREIGN KEY (`booked_by_admin`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `bookedby` FOREIGN KEY (`booked_by`) REFERENCES `caretaker` (`caretaker_id`),
  ADD CONSTRAINT `booking_room-reff` FOREIGN KEY (`booking_room`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `property_refe` FOREIGN KEY (`booking_property`) REFERENCES `property` (`property_id`),
  ADD CONSTRAINT `sttsus_reffe` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`booking_status_id`),
  ADD CONSTRAINT `user_refefe` FOREIGN KEY (`booking_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `booking_pay`
--
ALTER TABLE `booking_pay`
  ADD CONSTRAINT `booking_ref` FOREIGN KEY (`booking_pay_ref`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `booking_room` FOREIGN KEY (`booking_pay_room`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `status` FOREIGN KEY (`booking_pay_status`) REFERENCES `payment_status` (`payment_status_id`);

--
-- Constraints for table `caretaker_login`
--
ALTER TABLE `caretaker_login`
  ADD CONSTRAINT `caretaker_id_ref` FOREIGN KEY (`caretaker_login_ref`) REFERENCES `caretaker` (`caretaker_id`);

--
-- Constraints for table `caretaker_mapping`
--
ALTER TABLE `caretaker_mapping`
  ADD CONSTRAINT `admindfdf` FOREIGN KEY (`caretaker_mapping_added_by`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `caretaker` FOREIGN KEY (`caretaker_mapping_caretaker`) REFERENCES `caretaker` (`caretaker_id`),
  ADD CONSTRAINT `oropeorvfv_property` FOREIGN KEY (`caretaker_mapping_property`) REFERENCES `property` (`property_id`);

--
-- Constraints for table `caretaker_session`
--
ALTER TABLE `caretaker_session`
  ADD CONSTRAINT `sdfdfdf` FOREIGN KEY (`caretaker_session_ref`) REFERENCES `caretaker` (`caretaker_id`);

--
-- Constraints for table `caretaker_token`
--
ALTER TABLE `caretaker_token`
  ADD CONSTRAINT `ref_user` FOREIGN KEY (`caretaker_token_ref`) REFERENCES `caretaker` (`caretaker_id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `bookingjshd` FOREIGN KEY (`complaints_booking`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `catyef` FOREIGN KEY (`complaints_cat`) REFERENCES `complaints_issue` (`complaints_issue_id`),
  ADD CONSTRAINT `sttays` FOREIGN KEY (`complaints_status`) REFERENCES `complaints_status` (`complaints_status_id`),
  ADD CONSTRAINT `sudbhf` FOREIGN KEY (`complaints_sub_cat`) REFERENCES `complaints_sub_issue` (`complaints_sub_issue_id`);

--
-- Constraints for table `complaints_sub_issue`
--
ALTER TABLE `complaints_sub_issue`
  ADD CONSTRAINT `refdhf` FOREIGN KEY (`complaints_sub_issue_ref`) REFERENCES `complaints_issue` (`complaints_issue_id`);

--
-- Constraints for table `house_keeping`
--
ALTER TABLE `house_keeping`
  ADD CONSTRAINT `booking` FOREIGN KEY (`house_keeping_booking`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `ffdgghg` FOREIGN KEY (`house_keeping_time_ref`) REFERENCES `time_slot` (`time_slot_id`),
  ADD CONSTRAINT `userdhfkdsf` FOREIGN KEY (`house_keeping_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `partner`
--
ALTER TABLE `partner`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`partner_created_by`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `partner_login`
--
ALTER TABLE `partner_login`
  ADD CONSTRAINT `partner_ref_lign` FOREIGN KEY (`partner_login_ref`) REFERENCES `partner` (`partner_id`);

--
-- Constraints for table `partner_mapping`
--
ALTER TABLE `partner_mapping`
  ADD CONSTRAINT `parnert_ref` FOREIGN KEY (`partner_mapping_partner`) REFERENCES `partner` (`partner_id`),
  ADD CONSTRAINT `propert_ref` FOREIGN KEY (`partner_mapping_property`) REFERENCES `property` (`property_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `booking_payments` FOREIGN KEY (`payments_ref`) REFERENCES `booking_pay` (`booking_pay_id`),
  ADD CONSTRAINT `caretaker_refdjs` FOREIGN KEY (`payments_caretaker`) REFERENCES `caretaker` (`caretaker_id`);

--
-- Constraints for table `payments_settle`
--
ALTER TABLE `payments_settle`
  ADD CONSTRAINT `by` FOREIGN KEY (`payments_settle_by`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `refdsdf` FOREIGN KEY (`payments_settle_ref`) REFERENCES `payments` (`payments_id`);

--
-- Constraints for table `payment_user_history`
--
ALTER TABLE `payment_user_history`
  ADD CONSTRAINT `sjksdjhfiser_user` FOREIGN KEY (`payment_user_history_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `added_by` FOREIGN KEY (`property_added_by`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `peroperty_lisintg_ref` FOREIGN KEY (`property_listing_type`) REFERENCES `listing_type` (`listing_type_id`),
  ADD CONSTRAINT `property_type_ref` FOREIGN KEY (`property_type`) REFERENCES `property_type` (`property_type_id`);

--
-- Constraints for table `property_image`
--
ALTER TABLE `property_image`
  ADD CONSTRAINT `peropwfjh+ref` FOREIGN KEY (`property_image_ref`) REFERENCES `property` (`property_id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room Ref` FOREIGN KEY (`room_ref`) REFERENCES `property` (`property_id`);

--
-- Constraints for table `security_deposite`
--
ALTER TABLE `security_deposite`
  ADD CONSTRAINT `booking_rerffe` FOREIGN KEY (`security_deposite_ref`) REFERENCES `booking` (`booking_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fdcreaw` FOREIGN KEY (`user_created_by`) REFERENCES `caretaker` (`caretaker_id`);

--
-- Constraints for table `user_document`
--
ALTER TABLE `user_document`
  ADD CONSTRAINT `craetd_hbvy` FOREIGN KEY (`user_document_by`) REFERENCES `caretaker` (`caretaker_id`),
  ADD CONSTRAINT `rerfdgd` FOREIGN KEY (`user_document_ref`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `cfeated_by_caretaker` FOREIGN KEY (`user_profile_created_by`) REFERENCES `caretaker` (`caretaker_id`),
  ADD CONSTRAINT `reefs_sdfjh` FOREIGN KEY (`user_profile_ref`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_wishlist`
--
ALTER TABLE `user_wishlist`
  ADD CONSTRAINT `properowrkf` FOREIGN KEY (`user_wishlist_property`) REFERENCES `property` (`property_id`),
  ADD CONSTRAINT `shfhjfuiser` FOREIGN KEY (`user_wishlist_user`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
