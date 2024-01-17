-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2023 a las 02:40:05
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL,
  `Titulo` varchar(100) NOT NULL,
  `Estado` varchar(100) NOT NULL,
  `Ultima fecha de modificación` date NOT NULL,
  `Prioridad` varchar(100) NOT NULL,
  `Solicitante` varchar(100) NOT NULL,
  `Asignado a - técnico` varchar(100) NOT NULL,
  `Asignado a - grupo técnico` varchar(100) NOT NULL,
  `Categoría` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`id`, `Titulo`, `Estado`, `Ultima fecha de modificación`, `Prioridad`, `Solicitante`, `Asignado a - técnico`, `Asignado a - grupo técnico`, `Categoría`) VALUES
(1, 'permiso para consultar ', 'en curso', '2023-11-15', 'urgente', 'Yelipza del Carmen', 'Vixleris  Mata', 'dirrecion de informatica y sistemas', 'DDS - permiso logia para módulos'),
(2, 'cambio de estatus', 'en curso', '2023-11-20', 'Urgente', 'Milagros Marin', 'Carolina', 'Dirección de informática y sistemas', 'otros');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
