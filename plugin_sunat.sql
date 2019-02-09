-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2019 a las 00:43:13
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plugin_sunat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cabecera`
--

CREATE TABLE `fact_cabecera` (
  `codFactura` varchar(15) NOT NULL,
  `fechaEmision` date NOT NULL COMMENT 'Formato YYYY-MM-DD',
  `horaEmision` varchar(8) NOT NULL COMMENT 'Formato 24hs HH;mm:ss',
  `dniRUC` varchar(11) NOT NULL COMMENT 'Ingresar Numero RUC o DNI',
  `razonSocial` varchar(250) NOT NULL COMMENT 'Nombre apellido o Razon social',
  `tipoMoneda` varchar(3) NOT NULL COMMENT 'PEN = soles, USD = Dolares',
  `costoFinal` float NOT NULL COMMENT 'Costos Finales',
  `IGVFinal` float NOT NULL COMMENT 'IGV Final',
  `totalFinal` float NOT NULL COMMENT 'Venta Final'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_cabecera`
--

INSERT INTO `fact_cabecera` (`codFactura`, `fechaEmision`, `horaEmision`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`) VALUES
('FF60-00000004', '2018-09-06', '17:05:16', '15601863640', 'DUQUE TORRES HEIDY JULIANA', 'PEN', 1.8, 10, 11.8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_detalle`
--

CREATE TABLE `fact_detalle` (
  `codFactura` varchar(15) NOT NULL,
  `unidadMedida` varchar(100) NOT NULL COMMENT 'Texto: Unidad, Kilo, caja, lata',
  `cantidad` int(11) NOT NULL COMMENT 'cantidad de unidades del producto',
  `descripcionProducto` varchar(250) NOT NULL COMMENT 'texto del producto',
  `valorUnitario` int(11) NOT NULL COMMENT 'valor del producto sin IGV',
  `igvUnitario` int(11) NOT NULL COMMENT 'igv del producto calculado',
  `valorProducto` int(11) NOT NULL COMMENT 'cantidad * valor unitario'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_detalle`
--

INSERT INTO `fact_detalle` (`codFactura`, `unidadMedida`, `cantidad`, `descripcionProducto`, `valorUnitario`, `igvUnitario`, `valorProducto`) VALUES
('FF60-00000004', 'UNIDAD', 2, 'PRODUCTO GENERICO GRABADO', 5, 2, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
