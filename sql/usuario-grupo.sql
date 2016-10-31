-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2016 a las 23:00:13
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_aulas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `descripcion`) VALUES
(1, 'administrador', 'administrador unrn'),
(7, 'bedel', 'bedel unrn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `recordarme_codigo` varchar(40) DEFAULT NULL,
  `estado` tinyint(1) UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ultima_sesion` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_usuario`, `contraseña`, `email`, `recordarme_codigo`, `estado`, `nombre`, `apellido`, `telefono`, `ultima_sesion`) VALUES
(1, 'administrador unrn', '$2y$08$GjNYMBqLQ5e08LQtG5R/WOpK51JYTkkQZJal3Tj9F96dxWot.QqxK', 'admin@admin.com', 'C/PrjmRDxrm.mEUXKggM0O', 1, 'administrador', 'unrn', '', 1477939972),
(2, 'Elias Geronimo Relmuan', '$2y$08$JdRnxqmTUVHv6L8Hk8eYzuIc6FmCNCuTYxOe/EiVAkOKryqbJ2sEm', 'eliasrelmuan@gmail.com', '1MUPRJZAnDojZMKFS16Tiu', 1, 'Elias Geronimo', 'Relmuan', '243242342343', 1477851629),
(6, 'juan perez', '$2y$08$OSKWtxYQAAvwKctqTlGc7e8mC3XMwErHpeIuvCRI8JuJM81lNWjJS', 'pepe@hotmail.com', NULL, 1, 'gerardo', 'perez', '', NULL),
(13, 'pepjadasdas', '', '', NULL, 0, 'Juan', 'Gonzales', '5555555555', 1477709773);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_grupo`
--

CREATE TABLE `usuario_grupo` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED NOT NULL,
  `grupo_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`id`, `usuario_id`, `grupo_id`) VALUES
(40, 1, 1),
(31, 2, 7),
(53, 13, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`usuario_id`,`grupo_id`),
  ADD KEY `fk_users_groups_users1_idx` (`usuario_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`grupo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
