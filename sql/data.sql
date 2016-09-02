-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-09-2016 a las 14:03:44
-- Versión del servidor: 5.5.29
-- Versión de PHP: 5.3.10-1ubuntu3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gestion_aulas`
--

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id`, `nombre`, `capacidad`, `Edificio_id`) VALUES
(1, 'Aula 1', 50, 1),
(2, 'Aula 2', 50, 1),
(3, 'Aula 3', 50, 1),
(4, 'Aula 4', 50, 1),
(5, 'Aula 5', 50, 1),
(6, 'Aula 6', 50, 1),
(7, 'Aula 7', 50, 1),
(8, 'Aula 8', 50, 1),
(9, 'Aula 9', 50, 1),
(10, 'Aula 10', 30, 1),
(11, 'Aula Magna', 200, 1),
(12, 'Laboratorio de Informática Aplicada', 20, 1),
(13, 'Aula de Infromática', 24, 1),
(14, 'Laboratorio de Docencia 1', 30, 1),
(15, 'Laboratorio de Docencia 2', 18, 1),
(16, 'Laboratorio de Docencia 3', 30, 1),
(17, 'Laboratorio de Docencia 4', 18, 1);

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id`, `nombre`) VALUES
(1, 'LICENCIATURA EN KINESIOLOGÍA Y FISIATRÍA'),
(2, 'LICENCIATURA EN COMUNICACIÓN SOCIAL'),
(3, 'LICENCIATURA EN SISTEMAS'),
(4, 'LICENCIATURA EN CIENCIAS DEL AMBIENTE'),
(5, 'INGENIERÍA AGRONÓMICA'),
(6, 'ABOGACÍA');

--
-- Volcado de datos para la tabla `edificio`
--

INSERT INTO `edificio` (`id`, `nombre`, `Localidad_id`) VALUES
(1, 'Campus', 1);

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`id`, `nombre`, `Sede_id`) VALUES
(1, 'Viedma', 1);

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`id`, `nombre`) VALUES
(1, 'Atlántica');

--
-- Volcado de datos para la tabla `tipo_recurso`
--

INSERT INTO `tipo_recurso` (`id`, `nombre`) VALUES
(1, 'Proyector');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
