-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-08-2011 a las 19:10:41
-- Versión del servidor: 5.5.15
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `repositorium`
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
  `kit_id` INT(255) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `kit_id` INT(255) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


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

-- ----------------------------------------------------------
--
-- Estructura de tabla para la tabla `constituents`
--

CREATE  TABLE IF NOT EXISTS `constituents` (
  `id` INT(255) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(140) NOT NULL ,
  `sysname` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

-- ---------------------------------------------
--
-- Estructura de tabla para la tabla `kits'
--
CREATE  TABLE IF NOT EXISTS `kits` (
  `id` INT(255) NOT NULL AUTO_INCREMENT ,
  `created` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

-- ----------------------------------------------
--
-- Estructura de tabla para la relacion entre kits y contituents
--
CREATE  TABLE IF NOT EXISTS `constituents_kits` (
  `id` INT(255) NOT NULL AUTO_INCREMENT ,
  `constituent_id` INT(255) NOT NULL ,
  `kit_id` INT(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;

-- ---------------------------------------------
--
-- Estructura para la tabla `restictions`
--

CREATE  TABLE IF NOT EXISTS `restrictions` (
  `id` INT(255) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(140) NOT NULL ,
  `behaviorname` VARCHAR(45) NOT NULL ,
  `constituent_id` INT(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

-- ---------------------------------------------
--
-- Estructura para la relacion entre kits y restrictions
--

CREATE  TABLE IF NOT EXISTS `kits_restrictions` (
  `id` INT(255) NOT NULL AUTO_INCREMENT ,
  `restriction_id` INT(255) NOT NULL ,
  `kit_id` INT(255) NOT NULL ,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- ---------------------------------------------
--
-- Estructura para la relacion entre attachfiles y documents
--

CREATE  TABLE IF NOT EXISTS `attachfiles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `filename` VARCHAR(45) NOT NULL ,
  `size` INT(11) NOT NULL ,
  `type` VARCHAR(45) NOT NULL ,
  `content` LONGBLOB NOT NULL ,
  `documents_id` INT(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_folios_documents1` (`documents_id` ASC) ,
  CONSTRAINT `fk_folios_documents1`
    FOREIGN KEY (`documents_id` )
    REFERENCES `documents` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


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
INSERT INTO `constituents` (id,name,description,sysname) VALUES (0,'Content','Main content of a Document','');
INSERT INTO `constituents` (id,name,description,sysname) VALUES (1,'Attach File','Allow users to attach files to Document','attachFile');