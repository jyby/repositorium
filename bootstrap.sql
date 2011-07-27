-- phpMyAdmin SQL Dump
-- version 3.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-06-2011 a las 15:56:51
-- Versión del servidor: 5.5.12
-- Versión de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cc51ag1_2011_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contextos`
--

CREATE TABLE IF NOT EXISTS `contextos` (
  `id_contexto` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id_contexto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios`
--

CREATE TABLE IF NOT EXISTS `criterios` (
  `id_criterio` int(255) NOT NULL AUTO_INCREMENT,
  `id_contexto` int(255) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta_1` text NOT NULL,
  `respuesta_2` text NOT NULL,
  `tamano_pack` int(11) NOT NULL,
  `costo_pack` int(11) NOT NULL,
  `costo_envio` int(11) NOT NULL,
  `bono_documento_enviado_validado` int(11) NOT NULL,
  `funcion_penalizacion_a` double NOT NULL,
  `funcion_penalizacion_b` double NOT NULL,
  `funcion_despenalizacion_a` double NOT NULL,
  `funcion_despenalizacion_b` double NOT NULL,
  `tamano_minimo_desafio` int(11) NOT NULL,
  PRIMARY KEY (`id_criterio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `id_documento` int(255) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `autor` int(255) NOT NULL COMMENT 'se refiere a id_usuario',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `id_dominio` int(255) NOT NULL COMMENT 'se refiere a id_contexto',
  `premiado_validacion` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expertos`
--

CREATE TABLE IF NOT EXISTS `expertos` (
  `id_experto` int(255) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(255) NOT NULL,
  `id_contexto` int(255) NOT NULL,
  PRIMARY KEY (`id_experto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_desafios`
--

CREATE TABLE IF NOT EXISTS `informacion_desafios` (
  `id_estadisticas` int(255) NOT NULL AUTO_INCREMENT,
  `id_documento` int(255) NOT NULL,
  `id_criterio` int(255) NOT NULL,
  `total_respuestas_1_no_validado` int(255) NOT NULL,
  `total_respuestas_2_no_validado` int(255) NOT NULL,
  `respuesta_oficial_de_un_experto` tinyint(1) DEFAULT NULL,
  `total_respuestas_1_como_desafio` int(255) NOT NULL,
  `total_respuestas_2_como_desafio` int(255) NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `preguntable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_estadisticas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `asociacion_id` int(255) NOT NULL AUTO_INCREMENT,
  `id_documento` int(255) NOT NULL,
  `tag` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`asociacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamano_desafios`
--

CREATE TABLE IF NOT EXISTS `tamano_desafios` (
  `id_desafio` int(255) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(255) NOT NULL,
  `id_criterio` int(255) NOT NULL,
  `c_preguntas` int(11) NOT NULL,
  PRIMARY KEY (`id_desafio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `puntos` int(11) NOT NULL DEFAULT '0',
  `es_administrador` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `nombre`, `apellido`, `password`, `salt`, `puntos`, `es_administrador`, `created`, `modified`) VALUES
(1, 'annonymous', 'annonymous', 'annonymous', '', '', 0, 0, '2011-06-23 15:54:33', '2011-06-23 15:54:33'),
(2, 'admin@example.com', 'admin', 'user', 'fbe82ab72970b9940724512227185348eac9d7fd', '1738993739', 0, 1, '2011-06-23 15:55:17', '2011-06-23 15:55:17');
