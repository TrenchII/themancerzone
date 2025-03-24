-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 09, 2017 at 08:05 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

-- CHANGE WHEN GOING LIVE

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rdecrewe`
--


-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE `pfp` (
    `pfpid` int NOT NULL AUTO_INCREMENT,
    `imagename` varchar(255) NOT NULL,
    PRIMARY KEY (pfpid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `displayname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pfpid` int NOT NULL,
  `privileges` int NOT NULL,
  PRIMARY KEY (username),
  FOREIGN KEY (pfpid) REFERENCES pfp(pfpid)
  ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `lesson` (
    `lessonid` int NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` longtext NOT NULL,
    `keyword` longtext NOT NULL,
    `school` longtext NOT NULL,
    `date` DATETIME NOT NULL,
    `pfpid` int NOT NULL,
    PRIMARY KEY (lessonid),
    FOREIGN KEY (pfpid) REFERENCES pfp(pfpid) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `createdlessons` (
    `username` varchar(255) NOT NULL,
    `lessonid` int NOT NULL,
    `createid` int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (createid),
    FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (lessonid) REFERENCES lesson(lessonid) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `enrolledlessons` (
    `username` varchar(255) NOT NULL,
    `lessonid` int NOT NULL,
    `enrollid` int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (enrollid),
    FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (lessonid) REFERENCES lesson(lessonid) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `message` (
    `messageid` int NOT NULL AUTO_INCREMENT,
    `rusername` varchar(255) NOT NULL,
    `susername` varchar(255) NOT NULL,
    `message` longtext NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY  (messageid),
    FOREIGN KEY (rusername) REFERENCES users(username) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (susername) REFERENCES users(username) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP USER IF EXISTS 'webuser'@'localhost';

-- Create the user with the specified password
CREATE USER 'webuser'@'localhost' IDENTIFIED BY 'P@ssw0rd';

-- Grant all privileges on the lab9 database to webuser
GRANT ALL PRIVILEGES ON lab9.* TO 'webuser'@'localhost';

-- Apply the changes
FLUSH PRIVILEGES;