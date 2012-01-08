-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-12-2011 a las 14:59:06
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `repositorio`
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcar la base de datos para la tabla `constituents_kits`
--

INSERT INTO `constituents_kits` (`id`, `constituent_id`, `kit_id`) VALUES
(7, 1, 7),
(8, 1, 8),
(9, 1, 9);

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
  `status` varchar(20) NOT NULL DEFAULT 'fgh',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Volcar la base de datos para la tabla `documents`
--

INSERT INTO `documents` (`id`, `title`, `content`, `user_id`, `created`, `modified`, `repository_id`, `active`, `kit_id`, `status`) VALUES
(2, 'DocumentoPrueba1', '1 Tuner + 1 or more non-Tuner monsters\r\nWhen a Spell, Trap, Spell/Trap effect, or Effect Monster''s effect is activated that destroys a card(s) on the field: You can Tribute this card; negate the activation and destroy it. During the End Phase, if this card negated an effect this way during this turn: You can Special Summon this card from your Graveyard.\r\n', 4, '2011-12-03 16:33:02', '2011-12-03 16:33:02', 2, 1, 5, 'asd'),
(3, 'gfjdskfjsdlkfjldskjflkdsj', 'vsdjlkvjsdlvjhlksdhvljdshlvhdslkvkjsdlv', 4, '2011-12-03 16:36:24', '2011-12-03 16:36:24', 2, 1, 5, 'xcvhjh'),
(4, 'DocumentoPrueba1222fdgregregregf', 'rewgtrgbtrgbrtdgbrthrhtrhdrtgfbgfbgfb\r\nfdgregregergdscsdcsdcsdcsdcsdcdsc\r\nefvfdggregregfer', 4, '2011-12-04 14:53:17', '2011-12-04 14:53:17', 2, 1, 5, 'cxv'),
(5, 'documentoBLABLABLA', 'blablablablabla pruebas para los tags', 4, '2011-12-05 01:49:40', '2011-12-05 01:49:43', 2, 1, 5, 'vxcv'),
(23, 'jhgj', 'khjnbkjbkjb', 3, '2011-12-05 23:49:39', '2011-12-05 23:49:39', 3, 1, 6, '0'),
(24, 'jhgj', 'khjnbkjbkjb', 3, '2011-12-05 23:49:50', '2011-12-05 23:49:50', 3, 1, 6, '0'),
(25, 'jhgjgrtgrgrtregre', 'khjnbkjbkjbcdsvsdv', 3, '2011-12-05 23:50:37', '2011-12-05 23:50:37', 3, 1, 6, '0'),
(26, 'jhgjgrtgrgrtregrecxvcxvcxvcx', 'khjnbkjbkjbcdsvsdvdcdscdsc', 3, '2011-12-05 23:54:51', '2011-12-05 23:54:51', 3, 1, 6, '0'),
(27, 'ghjgjghjghjghjghjgj', 'khjnbkjbkjbcdsvsdvdcdscdscjgvhmgfhgfhgfhgfhgfhgfghvhjbkhb', 3, '2011-12-06 00:05:07', '2011-12-06 00:05:07', 3, 1, 6, '0'),
(28, 'ghjgjghjghjghjghjgjvcbcbcvbcbvcbvcvbcb', 'khjnbkjbkjbcdsvsdvdcdscdscjgvhmgfhgfhgfhgfhgfhgfghvhjbkhb', 3, '2011-12-06 00:06:17', '2011-12-06 00:06:17', 3, 1, 6, 'fgh'),
(29, 'Hola', 'Hola', 3, '2011-12-06 01:08:03', '2011-12-06 01:08:03', 4, 1, 7, 'fgh'),
(30, 'Hola', 'Hola', 4, '2011-12-06 08:54:21', '2011-12-06 08:54:21', 3, 1, 6, 'fgh'),
(31, 'AVL', 'build an AVL tree from 1,2,3,4,5', 4, '2011-12-06 09:16:57', '2011-12-06 09:16:57', 6, 1, 10, 'fgh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_tagsnews`
--

CREATE TABLE IF NOT EXISTS `documents_tagsnews` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `document_id` int(255) NOT NULL,
  `tagsnew_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `documents_tagsnews`
--

INSERT INTO `documents_tagsnews` (`id`, `document_id`, `tagsnew_id`) VALUES
(1, 2, 2),
(2, 4, 2),
(3, 2, 1),
(4, 2, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `experts`
--

INSERT INTO `experts` (`id`, `user_id`, `repository_id`, `created`, `modified`, `active`) VALUES
(1, 3, 1, '2011-12-03 16:07:16', '2011-12-03 16:07:16', 1),
(2, 4, 2, '2011-12-03 16:32:14', '2011-12-03 16:32:14', 1),
(3, 4, 3, '2011-12-05 09:04:13', '2011-12-05 09:04:13', 1),
(4, 3, 4, '2011-12-05 23:12:42', '2011-12-05 23:12:42', 1),
(5, 3, 5, '2011-12-06 00:19:40', '2011-12-06 00:19:40', 1),
(6, 3, 6, '2011-12-06 01:02:42', '2011-12-06 01:02:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits`
--

CREATE TABLE IF NOT EXISTS `kits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcar la base de datos para la tabla `kits`
--

INSERT INTO `kits` (`id`, `created`) VALUES
(7, '2011-12-05 23:12:41'),
(8, '2011-12-06 00:19:20'),
(9, '2011-12-06 00:19:40'),
(10, '2011-12-06 01:02:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits_restrictions`
--

CREATE TABLE IF NOT EXISTS `kits_restrictions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `restriction_id` int(255) NOT NULL,
  `kit_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `kit_id` (`kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `pdr_tittle` int(11) NOT NULL,
  `pdr_tags` int(11) NOT NULL,
  `pdr_text` int(11) NOT NULL,
  `pdr_files` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `repositories`
--

INSERT INTO `repositories` (`id`, `name`, `url`, `user_id`, `description`, `created`, `modified`, `min_points`, `download_cost`, `upload_cost`, `documentpack_size`, `challenge_reward`, `active`, `kit_id`, `pdr_tittle`, `pdr_tags`, `pdr_text`, `pdr_files`) VALUES
(2, 'Repositorio11111', 'repotest', 4, 'sdsadsadascsdvsdvsd', '2011-12-03 16:32:14', '2011-12-03 16:32:14', 0, 100, 100, 2, 0, 1, 5, 0, 0, 0, 0),
(3, 'sinarchivo', 'archivo', 4, 'lalala', '2011-12-05 09:04:13', '2011-12-05 09:04:13', 0, 0, 0, 0, 0, 1, 6, 0, 0, 0, 0),
(4, 'sdcdscdsc', 'kakon', 3, 'sadasdasdsaczxczcdescripcion', '2011-12-05 23:12:42', '2011-12-05 23:12:42', 0, 100, 100, 1, 0, 1, 7, 0, 0, 0, 0),
(5, 'asdsadsa', 'asdddddd', 3, 'xzczxcqwdwwqdwqwqcwqccacxccsac', '2011-12-06 00:19:40', '2011-12-06 00:19:40', 0, 100, 100, 1, 0, 1, 9, 0, 0, 0, 0),
(6, 'TESTFOOOO', 'ponderacion', 3, 'test que deberia tener las ponderaciones', '2011-12-06 01:02:42', '2011-12-06 01:02:42', 0, 100, 100, 1, 0, 1, 10, 11, 22, 33, 44);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcar la base de datos para la tabla `repositories_users`
--

INSERT INTO `repositories_users` (`id`, `repository_id`, `user_id`, `points`, `watching`) VALUES
(1, 1, 1, 0, 0),
(2, 1, 2, 0, 0),
(3, 1, 3, 0, 0),
(4, 2, 1, 0, 0),
(5, 2, 2, 0, 0),
(6, 2, 3, 0, 0),
(7, 2, 4, 0, 0),
(8, 3, 1, 0, 0),
(9, 3, 2, 0, 0),
(10, 3, 3, 0, 0),
(11, 3, 4, 0, 0),
(12, 4, 1, 0, 0),
(13, 4, 2, 0, 0),
(14, 4, 3, 0, 0),
(15, 4, 4, 0, 0),
(16, 5, 1, 0, 0),
(17, 5, 2, 0, 0),
(18, 5, 3, 0, 0),
(19, 5, 4, 0, 0),
(20, 6, 1, 0, 0),
(21, 6, 2, 0, 0),
(22, 6, 3, 0, 0),
(23, 6, 4, 0, 0);

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

--
-- Volcar la base de datos para la tabla `restrictions`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Volcar la base de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `document_id`, `tag`, `created`, `modified`) VALUES
(4, 2, 'TCG', '2011-12-03 16:33:02', '2011-12-03 16:33:02'),
(5, 2, 'cards', '2011-12-03 16:33:02', '2011-12-03 16:33:02'),
(6, 2, 'yugioh', '2011-12-03 16:33:02', '2011-12-03 16:33:02'),
(7, 3, 'TCG', '2011-12-03 16:36:24', '2011-12-03 16:36:24'),
(8, 3, 'bla', '2011-12-03 16:36:24', '2011-12-03 16:36:24'),
(9, 4, 'test', '2011-12-04 14:53:17', '2011-12-04 14:53:17'),
(10, 4, 'bla', '2011-12-04 14:53:17', '2011-12-04 14:53:17'),
(11, 4, 'gato', '2011-12-04 14:53:17', '2011-12-04 14:53:17'),
(12, 23, 'xfvfd', '2011-12-05 23:49:39', '2011-12-05 23:49:39'),
(13, 24, 'errr', '2011-12-05 23:49:50', '2011-12-05 23:49:50'),
(14, 24, 'aaaa', '2011-12-05 23:49:50', '2011-12-05 23:49:50'),
(15, 25, 'fdsf', '2011-12-05 23:50:37', '2011-12-05 23:50:37'),
(16, 25, 'weqwewe', '2011-12-05 23:50:37', '2011-12-05 23:50:37'),
(17, 26, 'aaa', '2011-12-05 23:54:51', '2011-12-05 23:54:51'),
(18, 26, 'rrrr', '2011-12-05 23:54:51', '2011-12-05 23:54:51'),
(19, 26, 'vvvv', '2011-12-05 23:54:51', '2011-12-05 23:54:51'),
(20, 27, 'aaaaa', '2011-12-06 00:05:07', '2011-12-06 00:05:07'),
(21, 27, 'uuuu', '2011-12-06 00:05:07', '2011-12-06 00:05:07'),
(22, 27, 'oooo', '2011-12-06 00:05:07', '2011-12-06 00:05:07'),
(23, 28, 'eeee', '2011-12-06 00:06:17', '2011-12-06 00:06:17'),
(24, 28, 'aaaaaa', '2011-12-06 00:06:17', '2011-12-06 00:06:17'),
(25, 29, 'hola', '2011-12-06 01:08:03', '2011-12-06 01:08:03'),
(26, 30, 'tag', '2011-12-06 08:54:21', '2011-12-06 08:54:21'),
(27, 30, 'hola', '2011-12-06 08:54:21', '2011-12-06 08:54:21'),
(28, 31, 'AVL', '2011-12-06 09:16:57', '2011-12-06 09:16:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags_news`
--

CREATE TABLE IF NOT EXISTS `tags_news` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `value` varchar(20) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `tags_news`
--

INSERT INTO `tags_news` (`id`, `value`, `created`, `modified`) VALUES
(1, 'Tag_test1', '2011-12-04 21:20:24', '2011-12-04 21:20:27'),
(2, 'tag_test2', '2011-12-04 21:20:30', '2011-12-04 21:20:34'),
(3, 'tag3', '2011-12-05 01:22:41', '2011-12-05 01:22:44'),
(4, 'tag4', '2011-12-05 01:22:46', '2011-12-05 01:22:50');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `salt`, `is_administrator`, `created`, `modified`, `active`) VALUES
(1, 'annonymous', 'annonymous', 'annonymous', '', '', 0, '2011-06-23 15:54:33', '2011-06-23 15:54:33', 1),
(2, 'admin@example.com', 'admin', 'user', 'fbe82ab72970b9940724512227185348eac9d7fd', '1738993739', 1, '2011-06-23 15:55:17', '2011-06-23 15:55:17', 1),
(3, 'lerojasrojas@gmail.com', 'Leonardo', 'Rojas', '048de2befffbaf7688ee12a8fadd47fa0a0b0309', '467040159', 0, '2011-12-03 16:00:42', '2011-12-03 16:00:42', 1),
(4, 'kaka@hotmail.com', 'kaka', 'mojon', '1281ba76d97c7ea3db12cbc1300e2c6cb4382a9e', '2094331067', 0, '2011-12-03 16:30:06', '2011-12-03 16:30:06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `warned_documents`
--

CREATE TABLE IF NOT EXISTS `warned_documents` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_created_warning_document` int(255) NOT NULL,
  `id_existing_document` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_created_warning_document` (`id_created_warning_document`),
  UNIQUE KEY `id_existin_document` (`id_existing_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `warned_documents`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `kits_restrictions`
--
ALTER TABLE `kits_restrictions`
  ADD CONSTRAINT `kits_restrictions_ibfk_1` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
