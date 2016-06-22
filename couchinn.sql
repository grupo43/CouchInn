-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `couchinn`;
CREATE DATABASE `couchinn` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `couchinn`;

DROP TABLE IF EXISTS `accepted_reservation`;
CREATE TABLE `accepted_reservation` (
  `reservation_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  KEY `reservation_id` (`reservation_id`),
  CONSTRAINT `accepted_reservation_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `couch`;
CREATE TABLE `couch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` varchar(32) COLLATE utf8_bin NOT NULL,
  `description` tinytext COLLATE utf8_bin NOT NULL,
  `type` varchar(32) COLLATE utf8_bin NOT NULL,
  `city` varchar(255) COLLATE utf8_bin NOT NULL,
  `capacity` tinyint(2) unsigned NOT NULL,
  `publication_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `type` (`type`),
  KEY `city` (`city`),
  CONSTRAINT `couch_ibfk_2` FOREIGN KEY (`type`) REFERENCES `couch_type` (`name`) ON UPDATE CASCADE,
  CONSTRAINT `couch_ibfk_4` FOREIGN KEY (`owner`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `couch_picture`;
CREATE TABLE `couch_picture` (
  `couch_id` int(10) unsigned NOT NULL,
  `picture1` varchar(255) COLLATE utf8_bin NOT NULL,
  `picture2` varchar(255) COLLATE utf8_bin NOT NULL,
  `picture3` varchar(255) COLLATE utf8_bin NOT NULL,
  `picture4` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `picture5` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`couch_id`),
  CONSTRAINT `couch_picture_ibfk_3` FOREIGN KEY (`couch_id`) REFERENCES `couch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `couch_type`;
CREATE TABLE `couch_type` (
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `enabled` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `user` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '150.00',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user` (`user`),
  CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`email`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `q&a`;
CREATE TABLE `q&a` (
  `user` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `couch_id` int(10) unsigned NOT NULL,
  `question` varchar(255) COLLATE utf8_bin NOT NULL,
  `answer` varchar(255) COLLATE utf8_bin NOT NULL,
  KEY `user` (`user`),
  KEY `couch_id` (`couch_id`),
  CONSTRAINT `q&a_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`email`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `q&a_ibfk_5` FOREIGN KEY (`couch_id`) REFERENCES `couch` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `couch_id` int(10) unsigned NOT NULL,
  `user` varchar(255) COLLATE utf8_bin NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `couch_id` (`couch_id`),
  KEY `user` (`user`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`couch_id`) REFERENCES `couch` (`id`),
  CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(70) COLLATE utf8_bin NOT NULL,
  `birthdate` date NOT NULL,
  `phone_number` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- 2016-06-22 17:34:52
