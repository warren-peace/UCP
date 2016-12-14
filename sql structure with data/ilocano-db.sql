-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2016 at 05:33 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilocano-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `affix-tble`
--

CREATE TABLE IF NOT EXISTS `affix-tble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(8) NOT NULL,
  `infix` varchar(8) NOT NULL,
  `suffix` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `affix-tble`
--

INSERT INTO `affix-tble` (`id`, `prefix`, `infix`, `suffix`) VALUES
(2, 'mang', '', 'en'),
(3, 'ag', '', ''),
(4, 'ag', '', 'en'),
(5, 'na', '', ''),
(6, 'mangi', '', ''),
(7, '', 'um', ''),
(8, 'mang', '', ''),
(9, '', '', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `corpus-mix-tble`
--

CREATE TABLE IF NOT EXISTS `corpus-mix-tble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagged-sentence` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `corpus-mix-tble`
--

INSERT INTO `corpus-mix-tble` (`id`, `tagged-sentence`) VALUES
(1, 'adda/C ngem/C awan/N ading/N ko/N'),
(2, 'tapno/C mangan/V kan/N'),
(3, 'tapno/N mangan/V ading/N'),
(4, 'apay/C awan/N ading/N'),
(5, 'apay/C ading/N awan/N');

-- --------------------------------------------------------

--
-- Table structure for table `dictionary-tble`
--

CREATE TABLE IF NOT EXISTS `dictionary-tble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dictionary-tble`
--

INSERT INTO `dictionary-tble` (`id`, `name`) VALUES
(1, 'aak'),
(2, 'anak'),
(3, 'aangsan'),
(4, 'aba'),
(5, 'ababa'),
(6, 'ababaw'),
(7, 'abaga'),
(8, 'mangan');

-- --------------------------------------------------------

--
-- Table structure for table `pos-tble`
--

CREATE TABLE IF NOT EXISTS `pos-tble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dictionary-id` int(11) NOT NULL,
  `pos` varchar(5) NOT NULL,
  `prefix` varchar(8) NOT NULL,
  `infix` varchar(8) NOT NULL,
  `suffix` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `pos-tble`
--

INSERT INTO `pos-tble` (`id`, `dictionary-id`, `pos`, `prefix`, `infix`, `suffix`) VALUES
(1, 1, 'N', '', '', ''),
(2, 2, 'N', 'an', '', ''),
(3, 2, 'N', '', '', ''),
(4, 2, 'V', 'ag', '', ''),
(5, 2, 'V', 'mangi', '', ''),
(6, 2, 'V', 'i', '', ''),
(7, 2, 'V', 'mang', '', 'en'),
(8, 2, 'V', 'ag', '', 'en'),
(9, 3, 'N', '', '', ''),
(10, 4, 'N', '', '', ''),
(11, 5, 'Adj', 'na', '', ''),
(12, 5, 'V', '', 'um', ''),
(13, 6, 'Adj', '', '', ''),
(14, 6, 'V', '', 'um', ''),
(15, 7, 'N', '', '', ''),
(16, 7, 'V', ' mangi', '', ''),
(17, 8, 'V', 'mang', '', 'en'),
(18, 8, 'V', '', '', ''),
(19, 8, 'V', 'mang', '', ''),
(20, 8, 'V', '', '', 'en');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
