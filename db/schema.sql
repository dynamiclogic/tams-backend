-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2015 at 12:59 PM
-- Server version: 5.5.44-0+deb7u1
-- PHP Version: 5.6.13-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tams`
--
CREATE DATABASE IF NOT EXISTS `tams` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tams`;

-- --------------------------------------------------------

--
-- Table structure for table `api_auth`
--

DROP TABLE IF EXISTS `api_auth`;
CREATE TABLE IF NOT EXISTS `api_auth` (
`api_auth_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `practice` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
`asset_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2147483647 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_types`
--

DROP TABLE IF EXISTS `asset_types`;
CREATE TABLE IF NOT EXISTS `asset_types` (
`asset_type_id` int(11) NOT NULL,
  `type_value` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
`attribute_id` int(11) NOT NULL,
  `attribute_label` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attributes_indexes`
--

DROP TABLE IF EXISTS `attributes_indexes`;
CREATE TABLE IF NOT EXISTS `attributes_indexes` (
`attribute_index_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attributes_values`
--

DROP TABLE IF EXISTS `attributes_values`;
CREATE TABLE IF NOT EXISTS `attributes_values` (
`attribute_value_id` int(10) NOT NULL,
  `attribute_value` varchar(255) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
`location_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=713 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
`media_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `images` longblob,
  `voice_memo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=607 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_auth`
--
ALTER TABLE `api_auth`
 ADD PRIMARY KEY (`api_auth_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
 ADD PRIMARY KEY (`asset_id`), ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `asset_types`
--
ALTER TABLE `asset_types`
 ADD PRIMARY KEY (`asset_type_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
 ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `attributes_indexes`
--
ALTER TABLE `attributes_indexes`
 ADD PRIMARY KEY (`attribute_index_id`), ADD KEY `asset_id` (`asset_id`), ADD KEY `attribute_id` (`attribute_id`), ADD KEY `attribute_value_id` (`attribute_value_id`);

--
-- Indexes for table `attributes_values`
--
ALTER TABLE `attributes_values`
 ADD PRIMARY KEY (`attribute_value_id`), ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
 ADD PRIMARY KEY (`location_id`), ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
 ADD PRIMARY KEY (`media_id`), ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_auth`
--
ALTER TABLE `api_auth`
MODIFY `api_auth_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2147483647;
--
-- AUTO_INCREMENT for table `asset_types`
--
ALTER TABLE `asset_types`
MODIFY `asset_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `attributes_indexes`
--
ALTER TABLE `attributes_indexes`
MODIFY `attribute_index_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attributes_values`
--
ALTER TABLE `attributes_values`
MODIFY `attribute_value_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=713;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=607;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
ADD CONSTRAINT `assets_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `asset_types` (`asset_type_id`);

--
-- Constraints for table `attributes_indexes`
--
ALTER TABLE `attributes_indexes`
ADD CONSTRAINT `attributes_indexes_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`),
ADD CONSTRAINT `attributes_indexes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`attribute_id`),
ADD CONSTRAINT `attributes_indexes_ibfk_3` FOREIGN KEY (`attribute_value_id`) REFERENCES `attributes_values` (`attribute_value_id`);

--
-- Constraints for table `attributes_values`
--
ALTER TABLE `attributes_values`
ADD CONSTRAINT `attributes_values_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
