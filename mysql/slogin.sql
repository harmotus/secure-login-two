-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 12:45 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `slogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pubkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `email`, `pubkey`) VALUES
(1, 'alex', 'alex@harmotus.nnl', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDghdfeCLh4tMyFuX/JSy+SU5VsHwz0A8vE4xAQhOMbomtaRXsCJ+6RMl9PLq9kgOW76v5obs7K+Fx3mL8nR1SE1Eqyo+F18VBa9gxyGYfG/n1Sunm/pxOXRSF3RWvT+6ezKGoKp7N/aqhfdRJVicHMFhlGFBu/Y51NP9OJsia1xwIDAQAB'),
(2, 'anna', 'anna@harmotus.nnl', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOmSvz1uR5N/L9acV+Ino/5i5KLtw9FW1lzPycRjxNi4piHPRiNaUEp20TH47ODe6gJ7U8Pr+mLeSI+q56zBDeuro1dL+bUblTtCroi5oHhDt3nk2dBpdlFkw65fBSjrj+IyW695DAkaDWJH5RpQAA6F7yI03Kw7eXqDjjTHE0SwIDAQAB');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
