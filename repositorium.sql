-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-01-2012 a las 14:12:46
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `repo2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attachfiles`
--

CREATE TABLE IF NOT EXISTS `attachfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(45) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `content` longblob NOT NULL,
  `document_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_folios_documents1` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constituents`
--

CREATE TABLE IF NOT EXISTS `constituents` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(140) NOT NULL,
  `sysname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constituents_kits`
--

CREATE TABLE IF NOT EXISTS `constituents_kits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `constituent_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias`
--

CREATE TABLE IF NOT EXISTS `criterias` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `repository_id` int(255) NOT NULL,
  `question` text NOT NULL,
  `answer_1` varchar(255) NOT NULL,
  `answer_2` varchar(255) NOT NULL,
  `documentpack_size` int(11) NOT NULL DEFAULT '0',
  `documentpack_cost` int(11) NOT NULL DEFAULT '0',
  `documentupload_cost` int(11) NOT NULL DEFAULT '0',
  `documentvalidation_reward` int(11) NOT NULL,
  `challenge_reward` int(11) NOT NULL DEFAULT '0',
  `penalization_a` double NOT NULL,
  `penalization_b` double NOT NULL,
  `depenalization_a` double NOT NULL,
  `depenalization_b` double NOT NULL,
  `minchallenge_size` int(11) NOT NULL,
  `maxchallenge_size` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias_documents`
--

CREATE TABLE IF NOT EXISTS `criterias_documents` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `document_id` int(255) NOT NULL,
  `criteria_id` int(255) NOT NULL,
  `official_answer` tinyint(1) DEFAULT NULL,
  `total_answers_1` int(255) NOT NULL,
  `total_answers_2` int(255) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `challengeable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias_users`
--

CREATE TABLE IF NOT EXISTS `criterias_users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `criteria_id` int(255) NOT NULL,
  `challenge_size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `repository_id` int(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `kit_id` int(255) NOT NULL DEFAULT '0',
  `warned` tinyint(1) NOT NULL,
  `warned_score` int(11) NOT NULL,
  `warned_documents` varchar(512) NOT NULL,
  `warned_score_title` int(11) NOT NULL,
  `warned_score_text` int(11) NOT NULL,
  `warned_score_tags` int(11) NOT NULL,
  `warned_score_files` int(11) NOT NULL,
  `warned_score_files_sha` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experts`
--

CREATE TABLE IF NOT EXISTS `experts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `repository_id` int(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits`
--

CREATE TABLE IF NOT EXISTS `kits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits_restrictions`
--

CREATE TABLE IF NOT EXISTS `kits_restrictions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `restriction_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositories`
--

CREATE TABLE IF NOT EXISTS `repositories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(32) NOT NULL,
  `user_id` int(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `min_points` int(11) NOT NULL DEFAULT '0',
  `download_cost` int(11) NOT NULL DEFAULT '10',
  `upload_cost` int(11) NOT NULL DEFAULT '10',
  `documentpack_size` int(255) NOT NULL,
  `challenge_reward` int(255) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `kit_id` int(255) NOT NULL DEFAULT '0',
  `pdr_tittle` int(11) NOT NULL,
  `pdr_tags` int(11) NOT NULL,
  `pdr_text` int(11) NOT NULL,
  `pdr_files` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositories_users`
--

CREATE TABLE IF NOT EXISTS `repositories_users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `repository_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `points` int(255) NOT NULL,
  `watching` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restrictions`
--

CREATE TABLE IF NOT EXISTS `restrictions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(140) NOT NULL,
  `behaviorname` varchar(45) NOT NULL,
  `constituent_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `document_id` int(255) NOT NULL,
  `tag` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `is_administrator` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- -------------------------------------------------

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `salt`, `is_administrator`, `created`, `modified`, `active`) VALUES
(1, 'annonymous', 'annonymous', 'annonymous', '', '', 0, '2011-06-23 15:54:33', '2011-06-23 15:54:33', 1),
(2, 'admin@example.com', 'admin', 'user', 'fbe82ab72970b9940724512227185348eac9d7fd', '1738993739', 1, '2011-06-23 15:55:17', '2011-06-23 15:55:17', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Datos base para contituents base
--
INSERT INTO `constituents` (id,name,description,sysname) VALUES (0,'Content','Main content of a Document','content');
INSERT INTO `constituents` (id,name,description,sysname) VALUES (1,'Attach File','Allow users to attach files to Document','attachFile');


