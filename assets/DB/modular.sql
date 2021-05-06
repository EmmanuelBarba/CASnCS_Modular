-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2021 a las 19:48:18
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `modular`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_taller`
--

CREATE TABLE `admin_taller` (
  `id_taller` int(11) NOT NULL,
  `nombre_taller` varchar(50) NOT NULL,
  `tel_taller` varchar(10) NOT NULL,
  `mail_taller` varchar(50) NOT NULL,
  `domicilio_taller` varchar(50) NOT NULL,
  `ciudad_taller` varchar(50) NOT NULL,
  `pass_taller` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `domicilio_cliente` varchar(50) NOT NULL,
  `correo_cliente` varchar(50) NOT NULL,
  `tel_cliente` varchar(10) NOT NULL,
  `date_cliente` datetime NOT NULL,
  `taller_hasclient` int(11) NOT NULL,
  `pass_client` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleados` int(11) NOT NULL,
  `nombre_empleado` varchar(50) NOT NULL,
  `tel_empleado` varchar(10) NOT NULL,
  `mail_empleado` varchar(30) NOT NULL,
  `dom_empleado` varchar(50) NOT NULL,
  `AreaTrabajo` varchar(30) NOT NULL,
  `pass_empleado` int(100) NOT NULL,
  `taller_hasemploy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_servicio`
--

CREATE TABLE `orden_servicio` (
  `id_sg` int(11) NOT NULL,
  `fecha_orden` datetime NOT NULL DEFAULT current_timestamp(),
  `falla_coche` varchar(1000) NOT NULL,
  `observaciones_coche` varchar(50) NOT NULL,
  `informe_tecnico` varchar(500) NOT NULL,
  `insumos_orden` varchar(500) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  `ticket` varchar(1000) NOT NULL,
  `marca_coche` varchar(30) NOT NULL,
  `modelo_coche` varchar(30) NOT NULL,
  `matricula_coche` varchar(15) NOT NULL,
  `num_serie` varchar(17) NOT NULL,
  `año_coche` year(4) NOT NULL,
  `submodelo_coche` varchar(50) NOT NULL,
  `placas_coche` varchar(9) NOT NULL,
  `info_coche` varchar(200) NOT NULL,
  `client_hasorden` int(11) NOT NULL,
  `taller_hasordenes` int(11) NOT NULL,
  `empleado_hasorden` int(11) NOT NULL,
  `estado_orden` enum('Recepcionado','En Espera','En proceso','Finalizado','Ticket','Agenda','Garantias') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_taller`
--
ALTER TABLE `admin_taller`
  ADD PRIMARY KEY (`id_taller`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clientes`),
  ADD KEY `analisis_ibfk_2` (`taller_hasclient`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleados`),
  ADD KEY `analisis_ibfk_1` (`taller_hasemploy`);

--
-- Indices de la tabla `orden_servicio`
--
ALTER TABLE `orden_servicio`
  ADD PRIMARY KEY (`id_sg`),
  ADD KEY `analisis_ibfk_3` (`client_hasorden`),
  ADD KEY `analisis_ibfk_5` (`empleado_hasorden`),
  ADD KEY `analisis_ibfk_6` (`taller_hasordenes`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_taller`
--
ALTER TABLE `admin_taller`
  MODIFY `id_taller` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleados` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_servicio`
--
ALTER TABLE `orden_servicio`
  MODIFY `id_sg` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `analisis_ibfk_2` FOREIGN KEY (`taller_hasclient`) REFERENCES `admin_taller` (`id_taller`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `analisis_ibfk_1` FOREIGN KEY (`taller_hasemploy`) REFERENCES `admin_taller` (`id_taller`);

--
-- Filtros para la tabla `orden_servicio`
--
ALTER TABLE `orden_servicio`
  ADD CONSTRAINT `analisis_ibfk_3` FOREIGN KEY (`client_hasorden`) REFERENCES `clientes` (`id_clientes`),
  ADD CONSTRAINT `analisis_ibfk_5` FOREIGN KEY (`empleado_hasorden`) REFERENCES `empleados` (`id_empleados`),
  ADD CONSTRAINT `analisis_ibfk_6` FOREIGN KEY (`taller_hasordenes`) REFERENCES `admin_taller` (`id_taller`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
