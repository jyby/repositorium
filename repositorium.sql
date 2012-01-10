-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Servidor: 50.63.244.112
-- Tiempo de generación: 09-01-2012 a las 20:24:31
-- Versión del servidor: 5.0.91
-- Versión de PHP: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `repositorium`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attachfiles`
--

CREATE TABLE `attachfiles` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(45) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `content` longblob NOT NULL,
  `document_id` int(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_folios_documents1` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constituents`
--

CREATE TABLE `constituents` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(140) NOT NULL,
  `sysname` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constituents_kits`
--

CREATE TABLE `constituents_kits` (
  `id` int(255) NOT NULL auto_increment,
  `constituent_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias`
--

CREATE TABLE `criterias` (
  `id` int(255) NOT NULL auto_increment,
  `repository_id` int(255) NOT NULL,
  `question` text NOT NULL,
  `answer_1` varchar(255) NOT NULL,
  `answer_2` varchar(255) NOT NULL,
  `documentpack_size` int(11) NOT NULL default '0',
  `documentpack_cost` int(11) NOT NULL default '0',
  `documentupload_cost` int(11) NOT NULL default '0',
  `documentvalidation_reward` int(11) NOT NULL,
  `challenge_reward` int(11) NOT NULL default '0',
  `penalization_a` double NOT NULL,
  `penalization_b` double NOT NULL,
  `depenalization_a` double NOT NULL,
  `depenalization_b` double NOT NULL,
  `minchallenge_size` int(11) NOT NULL,
  `maxchallenge_size` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias_documents`
--

CREATE TABLE `criterias_documents` (
  `id` int(255) NOT NULL auto_increment,
  `document_id` int(255) NOT NULL,
  `criteria_id` int(255) NOT NULL,
  `official_answer` tinyint(1) default NULL,
  `total_answers_1` int(255) NOT NULL,
  `total_answers_2` int(255) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `challengeable` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterias_users`
--

CREATE TABLE `criterias_users` (
  `id` int(255) NOT NULL auto_increment,
  `user_id` int(255) NOT NULL,
  `criteria_id` int(255) NOT NULL,
  `challenge_size` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE `documents` (
  `id` int(255) NOT NULL auto_increment,
  `title` varchar(512) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `repository_id` int(255) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `kit_id` int(255) NOT NULL default '0',
  `warned` tinyint(1) NOT NULL,
  `warned_score` int(11) NOT NULL,
  `warned_documents` varchar(512) NOT NULL,
  `warned_score_title` int(11) NOT NULL,
  `warned_score_tags` int(11) NOT NULL,
  `warned_score_text` int(11) NOT NULL,
  `warned_score_files` int(11) NOT NULL,
  `warned_score_files_sha` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experts`
--

CREATE TABLE `experts` (
  `id` int(255) NOT NULL auto_increment,
  `user_id` int(255) NOT NULL,
  `repository_id` int(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits`
--

CREATE TABLE `kits` (
  `id` int(255) NOT NULL auto_increment,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits_restrictions`
--

CREATE TABLE `kits_restrictions` (
  `id` int(255) NOT NULL auto_increment,
  `restriction_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositories`
--

CREATE TABLE `repositories` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `url` varchar(32) NOT NULL,
  `user_id` int(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `min_points` int(11) NOT NULL default '0',
  `download_cost` int(11) NOT NULL default '10',
  `upload_cost` int(11) NOT NULL default '10',
  `documentpack_size` int(255) NOT NULL,
  `challenge_reward` int(255) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '1',
  `kit_id` int(255) NOT NULL default '0',
  `pdr_tittle` int(11) NOT NULL,
  `pdr_tags` int(11) NOT NULL,
  `pdr_text` int(11) NOT NULL,
  `pdr_files` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositories_users`
--

CREATE TABLE `repositories_users` (
  `id` int(255) NOT NULL auto_increment,
  `repository_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `points` int(255) NOT NULL,
  `watching` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restrictions`
--

CREATE TABLE `restrictions` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(140) NOT NULL,
  `behaviorname` varchar(45) NOT NULL,
  `constituent_id` int(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` int(255) NOT NULL auto_increment,
  `document_id` int(255) NOT NULL,
  `tag` varchar(20) default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=223 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL auto_increment,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `is_administrator` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
