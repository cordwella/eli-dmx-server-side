-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2015 at 09:34 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lightsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id_cat` int(11) NOT NULL,
  `category` varchar(20) NOT NULL COMMENT 'Calling this that because reasons'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_cat`, `category`) VALUES
(1, 'General'),
(2, 'Wheeler''s Luck');

-- --------------------------------------------------------

--
-- Table structure for table `lights`
--

CREATE TABLE IF NOT EXISTS `lights` (
`channel` int(2) NOT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lights`
--

INSERT INTO `lights` (`channel`, `name`) VALUES
(1, 'Full Big Left'),
(2, 'Full Big Center'),
(3, 'Full Big Right'),
(4, 'Zoom Spot'),
(5, 'Downstage Left'),
(6, 'Downstage Right'),
(7, 'Center Stage Right'),
(8, 'Center Stage Left'),
(9, 'Blue (small)'),
(10, 'Blue (big)'),
(11, 'Red'),
(12, 'Work'),
(13, 'Left (on side)'),
(14, 'Right (on side)'),
(15, 'Floor Far Left'),
(16, 'Floor Left'),
(17, 'Floor Center'),
(18, 'Floor Right'),
(19, 'Floor Far Right'),
(20, 'Upstage Far Left'),
(21, 'Upstage Left'),
(22, 'Upstage Center'),
(23, 'Upstage Right'),
(24, 'Upstage Far Right');

-- --------------------------------------------------------

--
-- Table structure for table `scenes`
--

CREATE TABLE IF NOT EXISTS `scenes` (
`id` int(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `chan1` int(3) DEFAULT NULL COMMENT 'Value as percent from one to 100 for channel 1 in this scene',
  `chan2` int(3) DEFAULT NULL,
  `chan3` int(3) DEFAULT NULL,
  `chan4` int(3) DEFAULT NULL,
  `chan5` int(3) DEFAULT NULL,
  `chan6` int(3) DEFAULT NULL,
  `chan7` int(3) DEFAULT NULL,
  `chan8` int(3) DEFAULT NULL,
  `chan9` int(3) DEFAULT NULL,
  `chan10` int(3) DEFAULT NULL,
  `chan11` int(3) DEFAULT NULL,
  `chan12` int(3) DEFAULT NULL,
  `chan13` int(3) DEFAULT NULL,
  `chan14` int(3) DEFAULT NULL,
  `chan15` int(3) DEFAULT NULL,
  `chan16` int(3) DEFAULT NULL,
  `chan17` int(3) DEFAULT NULL,
  `chan18` int(3) DEFAULT NULL,
  `chan19` int(3) DEFAULT NULL,
  `chan20` int(3) DEFAULT NULL,
  `chan21` int(3) DEFAULT NULL,
  `chan22` int(3) DEFAULT NULL,
  `chan23` int(3) DEFAULT NULL,
  `chan24` int(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scenes`
--

INSERT INTO `scenes` (`id`, `name`, `category_id`, `chan1`, `chan2`, `chan3`, `chan4`, `chan5`, `chan6`, `chan7`, `chan8`, `chan9`, `chan10`, `chan11`, `chan12`, `chan13`, `chan14`, `chan15`, `chan16`, `chan17`, `chan18`, `chan19`, `chan20`, `chan21`, `chan22`, `chan23`, `chan24`) VALUES
(1, 'All Lights', 1, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100),
(2, 'Stage ', 1, 70, 70, 70, 30, 100, 100, 100, 100, 100, 70, 90, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, 100, 100, 100, 100),
(3, 'Floor', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, 80, 100, 100, 100, 100, 100, 100, NULL, NULL, NULL, NULL, NULL),
(4, 'Heaven', 2, 100, NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Ending', 2, 40, 25, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id_cat`), ADD UNIQUE KEY `name` (`category`);

--
-- Indexes for table `lights`
--
ALTER TABLE `lights`
 ADD PRIMARY KEY (`channel`);

--
-- Indexes for table `scenes`
--
ALTER TABLE `scenes`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lights`
--
ALTER TABLE `lights`
MODIFY `channel` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `scenes`
--
ALTER TABLE `scenes`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
