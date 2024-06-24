-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2024 a las 01:09:14
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpcomanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id_pedido` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado_detalle` varchar(40) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `demora` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id_pedido`, `id_menu`, `cantidad`, `estado_detalle`, `id_usuario`, `demora`, `activo`) VALUES
(4, 11, 1, '', 0, 0, 1),
(4, 13, 1, '', 0, 0, 0),
(5, 17, 1, '', 0, 0, 1),
(5, 13, 1, 'Terminado', 2, 15, 0),
(5, 13, 1, 'Terminado', 2, 15, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `sector` varchar(40) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `nombre`, `precio`, `sector`, `activo`) VALUES
(39, 'Ensalada de lechuga  tomates y cebolla', 409, 'cocina', 1),
(41, 'empanada de carne', 1900, 'cocina', 1),
(42, 'empanada de pollo', 1910, 'cocina', 1),
(43, 'empanada de jamón y queso', 1860, 'cocina', 1),
(44, 'empanada de verdura', 1790, 'cocina', 1),
(45, 'empanada de humita', 1690, 'cocina', 1),
(46, 'pizza mozzarella', 2000, 'cocina', 1),
(47, 'pizza napolitana', 2200, 'cocina', 1),
(48, 'pizza de cebolla', 1990, 'cocina', 1),
(49, 'pizza de anchoas', 2010, 'cocina', 1),
(50, 'sopa', 700, 'cocina', 1),
(51, 'vermout', 1900, 'bar', 1),
(52, 'coca cola zero', 1805, 'bar', 1),
(53, 'vino', 600, 'bar', 1),
(54, 'leche en polvo', 1170, 'cocina', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL,
  `estado_mesa` varchar(30) NOT NULL,
  `tipoComentario` varchar(15) NOT NULL,
  `comentario` varchar(200) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `estado_mesa`, `tipoComentario`, `comentario`, `activo`) VALUES
(4, 'con cliente esperando', 'negativo', 'la atención deja mucho que desear', 0),
(5, 'con cliente esperando', 'positivo', 'por lo menos me atienden', 1),
(6, 'con cliente comiendo', '', '\r', 1),
(7, 'con cliente pagando', 'negativo', 'comida cara\r', 1),
(8, 'con cliente esperando', '', '\r', 1),
(9, 'con cliente comiendo', '', '\r', 1),
(10, 'con cliente esperando', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `estado_pedido` varchar(30) NOT NULL,
  `tiempoEstimado` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `estado_pedido`, `tiempoEstimado`, `id_mesa`, `activo`, `fecha`, `id_usuario`, `foto`) VALUES
(23, 'Listo para servir', 12, 2, 1, '2024-06-17', 2, 'c:\\fotos\\3.png\r'),
(24, 'en preparacion', 20, 2, 1, '2024-06-17', 2, 'c:\\fotos\\4.png\r');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `mail` varchar(40) DEFAULT NULL,
  `rol` varchar(50) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `mail`, `rol`, `activo`) VALUES
(1, 'Pablo', 'Rotela', 'pablo.rotela@gmail.com', 'admin', 1),
(2, 'Cindy', 'Mello', 'cmello2342@gmail.com', 'socio', 1),
(3, 'Carlos', 'Rotela', 'caio@gmail.com', 'socio', 1),
(4, 'Alvarez', 'Apellido1', 'mail1@gmail.com', 'mozo', 1),
(5, 'Adela', 'Apellido2', 'mail2@gmail.com', 'cocinero', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
