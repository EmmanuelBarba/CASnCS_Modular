-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2021 a las 19:42:28
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
-- Base de datos: `c&cs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_taller`
--

CREATE TABLE `admin_taller` (
  `id_taller` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre_taller` varchar(50) NOT NULL,
  `tel_taller` varchar(10) NOT NULL,
  `mail_taller` varchar(50) NOT NULL,
  `ciudad_taller` varchar(50) NOT NULL,
  `pass_taller` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `orden_servicio`
  ADD CONSTRAINT `analisis_ibfk_5` FOREIGN KEY (`taller_hasorden`) 
REFERENCES `empleados` (`id_empleados`);

ALTER TABLE `orden_servicio`
  ADD CONSTRAINT `analisis_ibfk_6` FOREIGN KEY (`taller_hasordenes`) 
REFERENCES `admin_taller` (`id_taller`);


--
-- Volcado de datos para la tabla `admin_taller`
--

INSERT INTO `admin_taller` (`id_taller`, `nombre_taller`, `tel_taller`, `mail_taller`, `ciudad_taller`, `pass_taller`) VALUES
(1, 'Taller el Guero', '3781043547', 'gueroautomotriz@gmail.com', 'Tepatitlán', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre_cliente` varchar(50) NOT NULL,
  `domicilio_cliente` varchar(50) NOT NULL,
  `correo_cliente` varchar(50) NOT NULL,
  `tel_cliente` varchar(10) NOT NULL,
  `date_cliente` datetime NOT NULL,
  `taller_hasclient` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `clientes`
  ADD CONSTRAINT `analisis_ibfk_2` FOREIGN KEY (`taller_hasclient`) 
REFERENCES `admin_taller` (`id_taller`);

-- --------------------------------------------------------
CREATE TABLE `carros` (
  `id_carro` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `client_hascarro` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `carros`
  ADD CONSTRAINT `analisis_ibfk_4` FOREIGN KEY (`client_hascarro`) 
REFERENCES `clientes` (`id_clientes`);

CREATE TABLE `orden_servicio` (
  `id_sg` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `taller_hassg` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `orden_servicio`
  ADD CONSTRAINT `analisis_ibfk_3` FOREIGN KEY (`taller_hassg`) 
REFERENCES `clientes` (`id_clientes`);


--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleados` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `taller_hasemploy` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `empleados`
  ADD CONSTRAINT `analisis_ibfk_1` FOREIGN KEY (`taller_hasemploy`) 
REFERENCES `admin_taller` (`id_taller`);
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
  ADD KEY `taller_hasclient` (`taller_hasclient`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleados`),
  ADD KEY `id_taller` (`taller_hasemploy`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_taller`
--
ALTER TABLE `admin_taller`
  MODIFY `id_taller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
