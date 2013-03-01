-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Mrz 2013 um 16:53
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `masterprojekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `place` int(11) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `game`
--

INSERT INTO `game` (`_id`, `id`, `username`, `place`) VALUES
(1, 1, 'Guest', 2),
(2, 1, 'testuser', 1),
(3, 2, 'Guest', 2),
(4, 2, 'Guest', 1),
(5, 3, 'Guest', 2),
(6, 3, 'Guest', 1),
(7, 4, 'testuser2', 2),
(8, 4, 'Guest', 1),
(9, 5, 'testuser', 3),
(10, 5, 'testuser3', 2),
(11, 5, 'testuser2', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'testuser', '8eee3efdde1eb6cf6639a58848362bf4'),
(2, 'testuser1', '8eee3efdde1eb6cf6639a58848362bf4'),
(3, 'testuser2', '8eee3efdde1eb6cf6639a58848362bf4'),
(4, 'testuser3', '8eee3efdde1eb6cf6639a58848362bf4');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
