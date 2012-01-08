-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-12-2011 a las 10:13:57
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `repodelfin`
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
  `documents_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_folios_documents1` (`documents_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `attachfiles`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `constituents`
--

INSERT INTO `constituents` (`id`, `name`, `description`, `sysname`) VALUES
(0, 'Content', 'Main content of a Document', ''),
(1, 'Attach File', 'Allow users to attach files to Document', 'attachFile');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constituents_kits`
--

CREATE TABLE IF NOT EXISTS `constituents_kits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `constituent_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `constituents_kits`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `criterias`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `criterias_documents`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `criterias_users`
--


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
  `status` varchar(20) NOT NULL DEFAULT 'asd',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `documents`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_tagsnews`
--

CREATE TABLE IF NOT EXISTS `documents_tagsnews` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `document_id` int(255) NOT NULL,
  `tagsnew_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_id` (`document_id`),
  UNIQUE KEY `document_id_2` (`document_id`),
  KEY `document_id_3` (`document_id`),
  KEY `tagsnew_id` (`tagsnew_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `documents_tagsnews`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `experts`
--

INSERT INTO `experts` (`id`, `user_id`, `repository_id`, `created`, `modified`, `active`) VALUES
(1, 3, 1, '2011-12-05 21:47:37', '2011-12-05 21:47:37', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits`
--

CREATE TABLE IF NOT EXISTS `kits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `kits`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits_restrictions`
--

CREATE TABLE IF NOT EXISTS `kits_restrictions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `restriction_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `kits_restrictions`
--


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `repositories`
--

INSERT INTO `repositories` (`id`, `name`, `url`, `user_id`, `description`, `created`, `modified`, `min_points`, `download_cost`, `upload_cost`, `documentpack_size`, `challenge_reward`, `active`, `kit_id`) VALUES
(1, 'hola', 'hola', 3, 'asdf', '2011-12-05 21:47:37', '2011-12-05 21:47:37', 0, 0, 0, 0, 0, 1, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `repositories_users`
--

INSERT INTO `repositories_users` (`id`, `repository_id`, `user_id`, `points`, `watching`) VALUES
(1, 1, 3, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `restrictions`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `similarity_coefficients`
--

CREATE TABLE IF NOT EXISTS `similarity_coefficients` (
  `repository_id` int(255) NOT NULL,
  `pdr_tittle` int(11) NOT NULL,
  `pdr_files` int(11) NOT NULL,
  `pdr_tags` int(11) NOT NULL,
  UNIQUE KEY `repository_id_2` (`repository_id`),
  KEY `repository_id` (`repository_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `similarity_coefficients`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `tags`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags_news`
--

CREATE TABLE IF NOT EXISTS `tags_news` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `value` varchar(20) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `tags_news`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `salt`, `is_administrator`, `created`, `modified`, `active`) VALUES
(3, 'kaka@hotmail.com', 'kakita', '>(', 'c5cb59e8b52893e6378651e6a66c44a21a54ed57', '1963046546', 0, '2011-12-05 21:46:49', '2011-12-05 21:46:49', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `warned_documents`
--

CREATE TABLE IF NOT EXISTS `warned_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_created_warning_document` int(255) NOT NULL,
  `id_existing_document` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_created_warning_document` (`id_created_warning_document`),
  KEY `id_existing_document` (`id_existing_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `warned_documents`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `attachfiles`
--
ALTER TABLE `attachfiles`
  ADD CONSTRAINT `fk_folios_documents1` FOREIGN KEY (`documents_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documents_tagsnews`
--
ALTER TABLE `documents_tagsnews`
  ADD CONSTRAINT `documents_tagsnews_ibfk_2` FOREIGN KEY (`tagsnew_id`) REFERENCES `tags_news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `documents_tagsnews_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `similarity_coefficients`
--
ALTER TABLE `similarity_coefficients`
  ADD CONSTRAINT `similarity_coefficients_ibfk_1` FOREIGN KEY (`repository_id`) REFERENCES `repositories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `warned_documents`
--
ALTER TABLE `warned_documents`
  ADD CONSTRAINT `id_created_warning_document` FOREIGN KEY (`id_created_warning_document`) REFERENCES `documents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_existing_document` FOREIGN KEY (`id_existing_document`) REFERENCES `documents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
