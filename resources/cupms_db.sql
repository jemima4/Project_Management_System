-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2020 at 05:06 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cupms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `id` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`id`, `email`, `password`) VALUES
('1', 'admin1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
('2', 'admin2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `department_tb`
--

CREATE TABLE `department_tb` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department_tb`
--

INSERT INTO `department_tb` (`id`, `name`) VALUES
('1', 'Pharmacy'),
('2', 'Animal Science'),
('3', 'Biology'),
('4', 'Computer Science'),
('5', 'Chemistry'),
('6', 'Architecture'),
('7', 'Law'),
('8', 'Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_tb`
--

CREATE TABLE `lecturer_tb` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `departmentname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lecturer_tb`
--

INSERT INTO `lecturer_tb` (`id`, `name`, `email`, `password`, `departmentname`) VALUES
('654321', 'John Parker', 'johnparker@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Chemistry'),
('754321', 'Clark Kent', 'kent1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Law'),
('854321', 'Bruce Wayne', 'waynetech@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Chemistry');

-- --------------------------------------------------------

--
-- Table structure for table `project_tb`
--

CREATE TABLE `project_tb` (
  `id` varchar(50) NOT NULL,
  `matricno` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` text NOT NULL,
  `comment` text NOT NULL,
  `grade` varchar(2) NOT NULL,
  `lectid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_tb`
--

CREATE TABLE `student_tb` (
  `matricno` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `departmentname` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lecturerid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_tb`
--

INSERT INTO `student_tb` (`matricno`, `name`, `departmentname`, `level`, `password`, `lecturerid`) VALUES
('123410', 'Wade Wilson', 'Animal Science', '100', 'e10adc3949ba59abbe56e057f20f883e', '654321'),
('123411', 'Tom Holland', 'Computer Science', '500', 'e10adc3949ba59abbe56e057f20f883e', '754321'),
('123456', 'Andrew Smith', 'Biology', '400', 'e10adc3949ba59abbe56e057f20f883e', '654321'),
('123457', 'Steve Axel', 'Biology', '200', 'e10adc3949ba59abbe56e057f20f883e', '654321'),
('123458', 'Harley Quinzel', 'Psychology', '200', 'e10adc3949ba59abbe56e057f20f883e', '654321'),
('123459', 'Harvey Dent', 'Biology', '400', 'e10adc3949ba59abbe56e057f20f883e', '654321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturer_tb`
--
ALTER TABLE `lecturer_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_tb`
--
ALTER TABLE `project_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_tb`
--
ALTER TABLE `student_tb`
  ADD PRIMARY KEY (`matricno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
