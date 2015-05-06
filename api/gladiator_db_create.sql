-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2015 at 04:35 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gladiator_db`
--

-- --------------------------------------------------------

USE gladiator_db;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `points` int(10) DEFAULT 0,
  `profile_pic` varchar(200) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY (`phone`),
  UNIQUE KEY (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone`, `password`, `name`, `points`, `profile_pic`) VALUES
(1, 'wsksmadaan@gmail.com', '7705499426', '', 'Simran Kaur', 200, 'simran.jpg'),
(2, 'nishita.mohan@pioneer-inc.com', '4256230699', '', 'Nishita Mohan', 100, 'nishita.jpg'),
(3, 'smohan36@gmail.com', '4254990334', '', 'Surender Mohan', 50, 'surender.jpg'),
(4, 'ksmadaan@gmail.com', '4046109974', '', 'KS Madaan', 60, 'madaan.jpg')
;

--
-- Table structure for table `user_points`
--

CREATE TABLE IF NOT EXISTS `user_points` (
  `user_points_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_id` varchar(50) NOT NULL,
  `reward_type` tinyint  DEFAULT 0,
  `points` int(10) NOT NULL DEFAULT 0,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user_points` (`user_id`, `store_id`, `points`) VALUES
(1, '76.temp', 10),
(2, 'Test.1', 20),
(3, '76.temp', 10),
(4, '76.temp', 10),
(4, '76.temp', 20),
(4, 'Test.1', 10),
(3, 'Test.2', 20)
;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
