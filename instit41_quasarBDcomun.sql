-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-12-2022 a las 16:08:43
-- Versión del servidor: 10.3.36-MariaDB-cll-lve
-- Versión de PHP: 7.4.30

create schema blogOK;

use blogOK;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `instit41_quasarBDcomun`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categorias` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categorias`, `nombre`) VALUES
(1, 'Policiales'),
(2, 'Espectáculos'),
(3, 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `id_lugar` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id_lugar`, `nombre`) VALUES
(1, 'Sección Principal'),
(2, 'NuevoNombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posteo`
--

CREATE TABLE `posteo` (
  `id_Posteo` int(11) NOT NULL,
  `Titulo` varchar(200) NOT NULL,
  `Epigrafe` varchar(500) NOT NULL,
  `Copete` varchar(500) NOT NULL,
  `Cuerpo` varchar(10000) NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `Fuentes` varchar(45) NOT NULL,
  `Visible` tinyint(4) NOT NULL,
  `ImagenDestacada` varchar(45) NOT NULL,
  `Etiquetas` varchar(45) NOT NULL,
  `Id_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `posteo`
--

INSERT INTO `posteo` (`id_Posteo`, `Titulo`, `Epigrafe`, `Copete`, `Cuerpo`, `id_lugar`, `Fuentes`, `Visible`, `ImagenDestacada`, `Etiquetas`, `Id_Usuario`) VALUES
(1, 'hola', 'hola', 'hola', 'hola', 1, 'hola', 0, 'hola', 'hola', 1),
(3, 'Hola', 'Hola', 'Hola', 'Hola', 1, 'Hola', 1, 'Hola', 'Hola', 1),
(4, 'Prueba', 'Prueba', 'Prueba', 'Prueba', 1, 'Prueba', 3, 'Prueba', 'Prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posteo_categorias`
--

CREATE TABLE `posteo_categorias` (
  `id_posteo_categorias` int(11) NOT NULL,
  `id_posteo` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `posteo_categorias`
--

INSERT INTO `posteo_categorias` (`id_posteo_categorias`, `id_posteo`, `id_categoria`) VALUES
(1, 2, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_fechas`
--

CREATE TABLE `registro_fechas` (
  `id_registro` int(11) NOT NULL,
  `id_posteo` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipoUsuario` int(11) NOT NULL,
  `cat_usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipoUsuario`, `cat_usuario`) VALUES
(1, 'Administrador'),
(2, 'Autor'),
(3, 'Editor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `contrasenia` varchar(45) NOT NULL,
  `id_tipoUsuario` int(11) NOT NULL,
  `UltimoAcceso` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombres`, `apellidos`, `usuario`, `contrasenia`, `id_tipoUsuario`, `UltimoAcceso`) VALUES
(1, 'dePruebaOK', 'dePrueba', 'dePrueba', 'dePrueba', 1, '2022-12-06 18:02:50'),
(2, 'Administrador', 'Webmaster', 'admin', 'admin', 1, '2022-12-02 18:01:18'),
(3, 'Daian', 'Daian', 'daian', 'daian', 1, '2022-12-06 18:19:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categorias`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`id_lugar`);

--
-- Indices de la tabla `posteo`
--
ALTER TABLE `posteo`
  ADD PRIMARY KEY (`id_Posteo`),
  ADD KEY `FK_Posteo-Lugar_idx` (`id_lugar`),
  ADD KEY `FK_Posteo-Usuario_idx` (`Id_Usuario`);

--
-- Indices de la tabla `posteo_categorias`
--
ALTER TABLE `posteo_categorias`
  ADD PRIMARY KEY (`id_posteo_categorias`),
  ADD KEY `id_categoria-categorias` (`id_categoria`);

--
-- Indices de la tabla `registro_fechas`
--
ALTER TABLE `registro_fechas`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD KEY `usuario-tipo_usuario_idx` (`id_tipoUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posteo`
--
ALTER TABLE `posteo`
  MODIFY `id_Posteo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `posteo_categorias`
--
ALTER TABLE `posteo_categorias`
  MODIFY `id_posteo_categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registro_fechas`
--
ALTER TABLE `registro_fechas`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posteo`
--
ALTER TABLE `posteo`
  ADD CONSTRAINT `FK_Posteo-Lugar` FOREIGN KEY (`id_lugar`) REFERENCES `lugar` (`id_lugar`),
  ADD CONSTRAINT `FK_Posteo-Usuario` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`id_usuarios`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Usuarios-Tipo` FOREIGN KEY (`id_tipoUsuario`) REFERENCES `tipo_usuario` (`id_tipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
