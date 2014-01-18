-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-04-2013 a las 11:46:21
-- Versión del servidor: 5.5.29
-- Versión de PHP: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instances`
--

CREATE TABLE IF NOT EXISTS `instances` (
  `instance_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the id for this instance',
  `instance_token` varchar(64) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  `db_user` varchar(32) NOT NULL,
  `db_password` varchar(32) NOT NULL,
  `db_name` varchar(32) NOT NULL,
  `db_driver` varchar(32) NOT NULL,
  `db_host` varchar(32) NOT NULL,
  `db_debug` tinyint(1) NOT NULL,
  `fecha_creacion` int(11) NOT NULL COMMENT 'fecha de creacion de esta instancia',
  `status` enum('prueba','cliente','moroso','prospecto') CHARACTER SET utf8 NOT NULL DEFAULT 'prueba',
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`instance_id`),
  KEY `instance_token` (`instance_token`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instance_request`
--

CREATE TABLE IF NOT EXISTS `instance_request` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) DEFAULT NULL,
  `email` varchar(32) NOT NULL,
  `fecha` int(11) NOT NULL,
  `ip` varchar(19) NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_validated` int(11) DEFAULT NULL,
  `date_installed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_request`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_cambio`
--

CREATE TABLE IF NOT EXISTS `tipos_cambio` (
  `id_tipo_cambio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'sera el id del registro en  la tabla',
  `id_moneda_base` int(11) NOT NULL COMMENT 'El id de la moneda base de cada una de las empresas de las instancias, no se deben de repetir registros en esta tabla con el mismo  id_moneda_base.',
  `codigo_moneda_base` varchar(3) NOT NULL COMMENT 'codigo ISO de la moneda ejemplo: MXN, USD',
  `json_equivalencias` text NOT NULL COMMENT 'un json que contenga la equivalencia de la moneda base en las demás monedas activadas en el sistema.',
  PRIMARY KEY (`id_tipo_cambio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Guardara los tipos de cambio de todas las monedas base que haya en las instancia' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `last_seen` datetime NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
