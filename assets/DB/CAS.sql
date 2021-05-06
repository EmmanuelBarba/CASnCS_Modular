-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2020 a las 02:07:09
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
-- Base de datos: `cas &`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_taller`
--

CREATE TABLE `admin_taller` (
  `id_taller` int(11) NOT NULL,
  `nombre_taller` varchar(20) DEFAULT NULL,
  `Intro_taller` text DEFAULT NULL,
  `Descripción_taller` text DEFAULT NULL,
  `image_taller` varchar(200) DEFAULT NULL,
  `fecha_taller` varchar(45) DEFAULT NULL,
  `hora_taller` varchar(45) DEFAULT NULL,
  `empleados_id_empleado` int(11) NOT NULL,
  `vehiculos_id_vehiculo` int(11) NOT NULL,
  `vehiculos_año_vehiculo` int(4) NOT NULL,
  `ordenServicio_id_orden` int(11) NOT NULL,
  `clientes_id_clientes` int(11) NOT NULL,
  `telefono_taller` int(10) DEFAULT NULL,
  `domicilio_taller` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombre_cliente` varchar(45) DEFAULT NULL,
  `domicilio_cliente` varchar(45) DEFAULT NULL,
  `correo_cliente` varchar(45) NOT NULL,
  `tel_cliente` int(11) DEFAULT NULL,
  `empresa_cliente` varchar(45) DEFAULT NULL,
  `hora_cliente` varchar(45) DEFAULT NULL,
  `fechacliente` varchar(45) DEFAULT NULL,
  `vehiculos_id_vehiculo` int(11) NOT NULL,
  `vehiculos_año_vehiculo` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre_empleado` varchar(45) DEFAULT NULL,
  `domicilio_empleado` varchar(45) DEFAULT NULL,
  `tel_empleado` int(11) NOT NULL,
  `correo_empleado` varchar(45) DEFAULT NULL,
  `AreaTrabajo` varchar(45) DEFAULT NULL,
  `IdTaller(consulta Notaller)` int(11) DEFAULT NULL,
  `fecha_empleado` varchar(45) DEFAULT NULL,
  `hora_empleado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenservicio`
--

CREATE TABLE `ordenservicio` (
  `id_orden` int(11) NOT NULL,
  `fecha_orden` varchar(45) DEFAULT NULL,
  `descripcionFalla_orden` varchar(1000) DEFAULT NULL,
  `observaciones_orden` text DEFAULT NULL,
  `informeTecnico_orden` varchar(45) DEFAULT NULL,
  `presupuesto_orden` float DEFAULT NULL,
  `Insumos_orden` varchar(45) DEFAULT NULL,
  `estado_orden` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenservicio_has_clientes`
--

CREATE TABLE `ordenservicio_has_clientes` (
  `ordenServicio_id_orden` int(11) NOT NULL,
  `clientes_id_clientes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenservicio_has_empleados`
--

CREATE TABLE `ordenservicio_has_empleados` (
  `ordenServicio_id_orden` int(11) NOT NULL,
  `empleados_id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `marca_vehiculo` varchar(45) DEFAULT NULL,
  `modelo_vehiculo` varchar(45) DEFAULT NULL,
  `matricula_vehiculo` varchar(15) DEFAULT NULL,
  `año_vehiculo` int(4) NOT NULL,
  `NoSerial_vehiculo` varchar(17) DEFAULT NULL,
  `vehiculoscol` varchar(45) DEFAULT NULL,
  `nobre_dueño(consulta nombre cliente)` varchar(45) DEFAULT NULL,
  `hora_vehiculo` varchar(45) DEFAULT NULL,
  `fecha_vehiculo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_has_empleados`
--

CREATE TABLE `vehiculos_has_empleados` (
  `vehiculos_id_vehiculo` int(11) NOT NULL,
  `vehiculos_año_vehiculo` int(4) NOT NULL,
  `empleados_id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_has_ordenservicio`
--

CREATE TABLE `vehiculos_has_ordenservicio` (
  `vehiculos_id_vehiculo` int(11) NOT NULL,
  `vehiculos_año_vehiculo` int(4) NOT NULL,
  `ordenServicio_id_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_taller`
--
ALTER TABLE `admin_taller`
  ADD PRIMARY KEY (`id_taller`,`clientes_id_clientes`),
  ADD KEY `fk_admin_taller_empleados_idx` (`empleados_id_empleado`),
  ADD KEY `fk_admin_taller_vehiculos1_idx` (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`),
  ADD KEY `fk_admin_taller_ordenServicio1_idx` (`ordenServicio_id_orden`),
  ADD KEY `fk_admin_taller_clientes1_idx` (`clientes_id_clientes`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clientes`,`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`),
  ADD KEY `fk_clientes_vehiculos1_idx` (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `ordenservicio`
--
ALTER TABLE `ordenservicio`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indices de la tabla `ordenservicio_has_clientes`
--
ALTER TABLE `ordenservicio_has_clientes`
  ADD PRIMARY KEY (`ordenServicio_id_orden`,`clientes_id_clientes`),
  ADD KEY `fk_ordenServicio_has_clientes_clientes1_idx` (`clientes_id_clientes`),
  ADD KEY `fk_ordenServicio_has_clientes_ordenServicio1_idx` (`ordenServicio_id_orden`);

--
-- Indices de la tabla `ordenservicio_has_empleados`
--
ALTER TABLE `ordenservicio_has_empleados`
  ADD PRIMARY KEY (`ordenServicio_id_orden`,`empleados_id_empleado`),
  ADD KEY `fk_ordenServicio_has_empleados_empleados1_idx` (`empleados_id_empleado`),
  ADD KEY `fk_ordenServicio_has_empleados_ordenServicio1_idx` (`ordenServicio_id_orden`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`,`año_vehiculo`);

--
-- Indices de la tabla `vehiculos_has_empleados`
--
ALTER TABLE `vehiculos_has_empleados`
  ADD PRIMARY KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`,`empleados_id_empleado`),
  ADD KEY `fk_vehiculos_has_empleados_empleados1_idx` (`empleados_id_empleado`),
  ADD KEY `fk_vehiculos_has_empleados_vehiculos1_idx` (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`);

--
-- Indices de la tabla `vehiculos_has_ordenservicio`
--
ALTER TABLE `vehiculos_has_ordenservicio`
  ADD PRIMARY KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`,`ordenServicio_id_orden`),
  ADD KEY `fk_vehiculos_has_ordenServicio_ordenServicio1_idx` (`ordenServicio_id_orden`),
  ADD KEY `fk_vehiculos_has_ordenServicio_vehiculos1_idx` (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`);

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
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenservicio`
--
ALTER TABLE `ordenservicio`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin_taller`
--
ALTER TABLE `admin_taller`
  ADD CONSTRAINT `fk_admin_taller_clientes1` FOREIGN KEY (`clientes_id_clientes`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_admin_taller_empleados` FOREIGN KEY (`empleados_id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_admin_taller_ordenServicio1` FOREIGN KEY (`ordenServicio_id_orden`) REFERENCES `ordenservicio` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_admin_taller_vehiculos1` FOREIGN KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`, `año_vehiculo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_vehiculos1` FOREIGN KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`, `año_vehiculo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ordenservicio_has_clientes`
--
ALTER TABLE `ordenservicio_has_clientes`
  ADD CONSTRAINT `fk_ordenServicio_has_clientes_clientes1` FOREIGN KEY (`clientes_id_clientes`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordenServicio_has_clientes_ordenServicio1` FOREIGN KEY (`ordenServicio_id_orden`) REFERENCES `ordenservicio` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ordenservicio_has_empleados`
--
ALTER TABLE `ordenservicio_has_empleados`
  ADD CONSTRAINT `fk_ordenServicio_has_empleados_empleados1` FOREIGN KEY (`empleados_id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordenServicio_has_empleados_ordenServicio1` FOREIGN KEY (`ordenServicio_id_orden`) REFERENCES `ordenservicio` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vehiculos_has_empleados`
--
ALTER TABLE `vehiculos_has_empleados`
  ADD CONSTRAINT `fk_vehiculos_has_empleados_empleados1` FOREIGN KEY (`empleados_id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vehiculos_has_empleados_vehiculos1` FOREIGN KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`, `año_vehiculo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vehiculos_has_ordenservicio`
--
ALTER TABLE `vehiculos_has_ordenservicio`
  ADD CONSTRAINT `fk_vehiculos_has_ordenServicio_ordenServicio1` FOREIGN KEY (`ordenServicio_id_orden`) REFERENCES `ordenservicio` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vehiculos_has_ordenServicio_vehiculos1` FOREIGN KEY (`vehiculos_id_vehiculo`,`vehiculos_año_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`, `año_vehiculo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
