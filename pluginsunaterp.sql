-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2019 a las 21:00:36
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
-- Base de datos: `pluginsunaterp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `cliRuc` varchar(11) NOT NULL,
  `cliRazonSocial` varchar(250) NOT NULL,
  `cliComercial` varchar(250) NOT NULL,
  `cliDomicilio` varchar(250) NOT NULL,
  `cliTelefono` varchar(50) NOT NULL,
  `cliActivo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `cliRuc`, `cliRazonSocial`, `cliComercial`, `cliDomicilio`, `cliTelefono`, `cliActivo`) VALUES
(1, '00000000', 'Cliente simple', 'Sin documento', '-', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cabecera`
--

DROP TABLE IF EXISTS `fact_cabecera`;
CREATE TABLE `fact_cabecera` (
  `idComprobante` int(11) NOT NULL,
  `idNegocio` int(11) DEFAULT '0',
  `idLocal` int(11) DEFAULT '0',
  `idTicket` varchar(10) NOT NULL DEFAULT '0',
  `factTipoDocumento` int(11) DEFAULT '0' COMMENT 'B(3),F(1)',
  `factSerie` varchar(10) DEFAULT '',
  `factCorrelativo` int(8) UNSIGNED ZEROFILL DEFAULT '00000000',
  `tipOperacion` varchar(4) DEFAULT '0101',
  `fechaEmision` date NOT NULL COMMENT 'Formato YYYY-MM-DD',
  `horaEmision` time NOT NULL COMMENT 'Formato 24hs HH;mm:ss',
  `fechaVencimiento` varchar(1) DEFAULT '-',
  `codLocalEmisor` varchar(3) DEFAULT '000',
  `tipDocUsuario` int(11) NOT NULL DEFAULT '0' COMMENT '0 sin DNI, 1 Dni, 6 RUC',
  `dniRUC` varchar(11) NOT NULL DEFAULT '00000000' COMMENT 'Ingresar Numero RUC o DNI',
  `razonSocial` varchar(250) NOT NULL DEFAULT 'CLIENTE SIN DOCUMENTO' COMMENT 'Nombre apellido o Razon social',
  `tipoMoneda` varchar(3) DEFAULT 'PEN' COMMENT 'PEN = soles, USD = Dolares',
  `costoFinal` float NOT NULL COMMENT 'Costos Finales',
  `IGVFinal` float NOT NULL COMMENT 'IGV Final',
  `totalFinal` float NOT NULL COMMENT 'Venta Final',
  `sumDescTotal` float DEFAULT '0',
  `sumOtrosCargos` float DEFAULT '0',
  `sumTotalAnticipos` float DEFAULT '0',
  `sumImpVenta` float NOT NULL COMMENT 'El mismo campo de totalFinal',
  `ublVersionId` varchar(3) DEFAULT '2.1',
  `customizationId` varchar(3) DEFAULT '2.0',
  `ideTributo` int(11) DEFAULT '1000',
  `nomTributo` varchar(3) DEFAULT 'IGV',
  `codTipTributo` varchar(3) DEFAULT 'VAT',
  `mtoBaseImponible` float NOT NULL COMMENT 'igual columna costoFinal',
  `mtoTributo` float NOT NULL COMMENT 'igual columna IGVFinal',
  `codLeyenda` int(11) DEFAULT '1000' COMMENT 'Siempre 1000',
  `desLeyenda` varchar(100) NOT NULL,
  `comprobanteEmitido` int(11) DEFAULT '0' COMMENT '1 emitido, 0 sin emitir aun',
  `comprobanteFechado` varchar(50) DEFAULT '',
  `cliDireccion` varchar(250) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_cabecera`
--

INSERT INTO `fact_cabecera` (`idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`, `cliDireccion`) VALUES
(1, 113, 12300, '105', 1, 'F001', 00000003, '0101', '2018-09-06', '17:05:16', '-', '000', 6, '15601863640', 'DUQUE TORRES HEIDY JULIANA', 'PEN', 1.8, 10, 11.8, 2, 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 10, 1.8, 1000, 'ONCE SOLES 80/100 MN', 1, '2019-02-15 11:08:26', ''),
(2, 113, 12300, '103420-8', 1, 'F001', 00000004, '0101', '2019-02-14', '15:44:15', '-', '000', 0, '00000000', 'CLIENTE SIN DOCUMENTO', 'PEN', 6.36, 1.14, 7.5, 0, 0, 0, 8, '2.1', '2.0', 1000, 'IGV', 'VAT', 6.36, 1.14, 1000, 'SIETE SOLES 50/100 MN', 1, '2019-02-22 18:59:18', ''),
(3, 113, 12300, '103420-9', 1, 'F001', 00000005, '0101', '2019-02-24', '20:15:17', '-', '000', 0, '20602337147', 'INFOCAT SOLUCIONES SAC', 'PEN', 84.75, 15.25, 100, 0, 0, 0, 100, '2.1', '2.0', 1000, 'IGV', 'VAT', 84.75, 15.25, 1000, 'CIEN SOLES 0/100 MN', 1, '2019-02-24 17:03:45', 'AV. HUANCAVELICA 435'),
(26, 0, 0, '0', 3, 'INT001', 00000010, '0101', '2019-02-28', '14:02:30', '-', '000', 0, '', '', 'PEN', 0, 0, 0, 0, 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 0, 0, 1000, ' SOLES 0/100 MN', 1, '2019-02-28 14:02:30', ''),
(27, 0, 0, '0', 3, 'INT001', 00000011, '0101', '2019-02-28', '14:02:31', '-', '000', 0, '', '', 'PEN', 0, 0, 0, 0, 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 0, 0, 1000, ' SOLES 0/100 MN', 1, '2019-02-28 14:02:31', ''),
(28, 0, 0, '0', 3, 'INT001', 00000012, '0101', '2019-02-28', '14:02:52', '-', '000', 0, '', '', 'PEN', 0, 0, 0, 0, 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 0, 0, 1000, ' SOLES 0/100 MN', 1, '2019-02-28 14:02:52', ''),
(29, 0, 0, '0', 3, 'INT001', 00000013, '0101', '2019-02-28', '14:03:22', '-', '000', 0, '', '', 'PEN', 0, 0, 0, 0, 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 0, 0, 1000, ' SOLES 0/100 MN', 1, '2019-02-28 14:03:22', ''),
(30, 0, 0, '0', 3, 'INT001', 00000014, '0101', '2019-02-28', '14:03:33', '-', '000', 0, '', '', 'PEN', 63.81, 11.49, 75.3, 0, 0, 0, 75.3, '2.1', '2.0', 1000, 'IGV', 'VAT', 63.81, 11.49, 1000, 'SETENTA Y CINCO SOLES 30/100 MN', 1, '2019-02-28 14:03:33', ''),
(31, 0, 0, '0', 3, 'INT001', 00000015, '0101', '2019-02-28', '14:04:16', '-', '000', 0, '', '', 'PEN', 63.81, 11.49, 75.3, 0, 0, 0, 75.3, '2.1', '2.0', 1000, 'IGV', 'VAT', 63.81, 11.49, 1000, 'SETENTA Y CINCO SOLES 30/100 MN', 1, '2019-02-28 14:04:16', ''),
(32, 0, 0, '0', 3, 'B001', 00000001, '0101', '2019-02-28', '14:06:35', '-', '000', 0, '', '', 'PEN', 75.94, 13.67, 89.61, 0, 0, 0, 89.61, '2.1', '2.0', 1000, 'IGV', 'VAT', 75.94, 13.67, 1000, 'OCHENTA Y NUEVE SOLES 61/100 MN', 1, '2019-02-28 14:06:35', ''),
(33, 0, 0, '0', 3, 'B001', 00000002, '0101', '2019-02-28', '14:06:50', '-', '000', 0, '', '', 'PEN', 75.94, 13.67, 89.61, 0, 0, 0, 89.61, '2.1', '2.0', 1000, 'IGV', 'VAT', 75.94, 13.67, 1000, 'OCHENTA Y NUEVE SOLES 61/100 MN', 1, '2019-02-28 14:06:50', ''),
(34, 0, 0, '0', 3, 'B001', 00000003, '0101', '2019-02-28', '14:09:34', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 31.91, 5.74, 37.65, 0, 0, 0, 37.65, '2.1', '2.0', 1000, 'IGV', 'VAT', 31.91, 5.74, 1000, 'TREINTA Y SIETE SOLES 65/100 MN', 1, '2019-02-28 14:09:34', ''),
(35, 0, 0, '0', 3, 'B001', 00000004, '0101', '2019-02-28', '14:11:20', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 8.47, 1.53, 10, 0, 0, 0, 10, '2.1', '2.0', 1000, 'IGV', 'VAT', 8.47, 1.53, 1000, 'DIEZ SOLES 0/100 MN', 1, '2019-02-28 14:11:20', ''),
(36, 0, 0, '0', 3, 'B001', 00000005, '0101', '2019-02-28', '14:12:23', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 16.95, 3.05, 20, 0, 0, 0, 20, '2.1', '2.0', 1000, 'IGV', 'VAT', 16.95, 3.05, 1000, 'VEINTE SOLES 0/100 MN', 1, '2019-02-28 14:12:23', ''),
(37, 0, 0, '0', 3, 'B001', 00000006, '0101', '2019-02-28', '14:12:46', '-', '000', 1, '44475064', 'carlos', 'PEN', 16.95, 3.05, 20, 0, 0, 0, 20, '2.1', '2.0', 1000, 'IGV', 'VAT', 16.95, 3.05, 1000, 'VEINTE SOLES 0/100 MN', 1, '2019-02-28 14:12:46', ''),
(38, 0, 0, '0', 3, 'B001', 00000007, '0101', '2019-02-28', '14:14:00', '-', '000', 1, '44475064', 'carlos', 'PEN', 74.26, 13.37, 87.63, 0, 0, 0, 87.63, '2.1', '2.0', 1000, 'IGV', 'VAT', 74.26, 13.37, 1000, 'OCHENTA Y SIETE SOLES 63/100 MN', 1, '2019-02-28 14:14:00', ''),
(39, 0, 0, '0', 3, 'B001', 00000008, '0101', '2019-02-28', '14:14:27', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 33.03, 5.94, 38.97, 0, 0, 0, 38.97, '2.1', '2.0', 1000, 'IGV', 'VAT', 33.03, 5.94, 1000, 'TREINTA Y OCHO SOLES 97/100 MN', 1, '2019-02-28 14:14:27', ''),
(40, 0, 0, '0', 3, 'B001', 00000009, '0101', '2019-02-28', '14:17:54', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 8.47, 1.53, 10, 0, 0, 0, 10, '2.1', '2.0', 1000, 'IGV', 'VAT', 8.47, 1.53, 1000, 'DIEZ SOLES 0/100 MN', 1, '2019-02-28 14:17:54', ''),
(41, 0, 0, '0', 3, 'B001', 00000010, '0101', '2019-02-28', '14:18:12', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 8.47, 1.53, 10, 0, 0, 0, 10, '2.1', '2.0', 1000, 'IGV', 'VAT', 8.47, 1.53, 1000, 'DIEZ SOLES 0/100 MN', 1, '2019-02-28 14:18:12', ''),
(42, 0, 0, '0', 3, 'B001', 00000011, '0101', '2019-02-28', '14:18:29', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 11.01, 1.98, 12.99, 0, 0, 0, 12.99, '2.1', '2.0', 1000, 'IGV', 'VAT', 11.01, 1.98, 1000, 'DOCE SOLES 99/100 MN', 1, '2019-02-28 14:18:29', ''),
(43, 0, 0, '0', 3, 'B001', 00000012, '0101', '2019-02-28', '14:18:42', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 11.01, 1.98, 12.99, 0, 0, 0, 12.99, '2.1', '2.0', 1000, 'IGV', 'VAT', 11.01, 1.98, 1000, 'DOCE SOLES 99/100 MN', 1, '2019-02-28 14:18:42', ''),
(44, 0, 0, '0', 3, 'B001', 00000013, '0101', '2019-02-28', '14:19:03', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 110.08, 19.82, 129.9, 0, 0, 0, 129.9, '2.1', '2.0', 1000, 'IGV', 'VAT', 110.08, 19.82, 1000, 'CIENTO VEINTINUEVE SOLES 90/100 MN', 1, '2019-02-28 14:19:03', ''),
(45, 0, 0, '0', 3, 'B001', 00000014, '0101', '2019-02-28', '14:23:35', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 110.08, 19.82, 129.9, 0, 0, 0, 129.9, '2.1', '2.0', 1000, 'IGV', 'VAT', 110.08, 19.82, 1000, 'CIENTO VEINTINUEVE SOLES 90/100 MN', 1, '2019-02-28 14:23:35', ''),
(46, 0, 0, '0', 3, 'B001', 00000015, '0101', '2019-02-28', '14:24:30', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 110.08, 19.82, 129.9, 0, 0, 0, 129.9, '2.1', '2.0', 1000, 'IGV', 'VAT', 110.08, 19.82, 1000, 'CIENTO VEINTINUEVE SOLES 90/100 MN', 1, '2019-02-28 14:24:30', ''),
(47, 0, 0, '0', 3, 'B001', 00000016, '0101', '2019-02-28', '14:25:49', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 110.08, 19.82, 129.9, 0, 0, 0, 129.9, '2.1', '2.0', 1000, 'IGV', 'VAT', 110.08, 19.82, 1000, 'CIENTO VEINTINUEVE SOLES 90/100 MN', 1, '2019-02-28 14:25:49', ''),
(48, 0, 0, '0', 3, 'B001', 00000017, '0101', '2019-02-28', '14:26:01', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 204.13, 36.74, 240.87, 0, 0, 0, 240.87, '2.1', '2.0', 1000, 'IGV', 'VAT', 204.13, 36.74, 1000, 'DOSCIENTOS CUARENTA SOLES 87/100 MN', 1, '2019-02-28 14:26:01', ''),
(49, 0, 0, '0', 3, 'B001', 00000018, '0101', '2019-02-28', '14:32:45', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 71.99, 12.96, 84.95, 0, 0, 0, 84.95, '2.1', '2.0', 1000, 'IGV', 'VAT', 71.99, 12.96, 1000, 'OCHENTA Y CUATRO SOLES 95/100 MN', 1, '2019-02-28 14:32:45', ''),
(50, 0, 0, '0', 3, 'B001', 00000019, '0101', '2019-02-28', '14:33:12', '-', '000', 1, '00000000', 'Cliente sin documento', 'PEN', 71.99, 12.96, 84.95, 0, 0, 0, 84.95, '2.1', '2.0', 1000, 'IGV', 'VAT', 71.99, 12.96, 1000, 'OCHENTA Y CUATRO SOLES 95/100 MN', 1, '2019-02-28 14:33:12', ''),
(51, 0, 0, '0', 3, 'B001', 00000020, '0101', '2019-02-28', '14:49:45', '-', '000', 6, '20600180259', 'Estación de Servicios ANRY', 'PEN', 67.8, 12.2, 80, 0, 0, 0, 80, '2.1', '2.0', 1000, 'IGV', 'VAT', 67.8, 12.2, 1000, 'OCHENTA SOLES 0/100 MN', 1, '2019-02-28 14:49:45', ''),
(52, 0, 0, '0', 3, 'F001', 00000006, '0101', '2019-02-28', '14:50:52', '-', '000', 6, '20600180259', 'Estación de Servicios ANRY', 'PEN', 67.34, 12.12, 79.46, 0, 0, 0, 79.46, '2.1', '2.0', 1000, 'IGV', 'VAT', 67.34, 12.12, 1000, 'SETENTA Y NUEVE SOLES 46/100 MN', 1, '2019-02-28 14:50:52', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_detalle`
--

DROP TABLE IF EXISTS `fact_detalle`;
CREATE TABLE `fact_detalle` (
  `codItem` int(11) NOT NULL,
  `idNegocio` int(11) DEFAULT '0',
  `idLocal` int(11) DEFAULT '0',
  `idTicket` varchar(10) DEFAULT '' COMMENT 'Para unit productos y tickets',
  `facSerieCorre` varchar(50) NOT NULL,
  `codUnidadMedida` varchar(3) DEFAULT 'GLI',
  `cantidadItem` float NOT NULL COMMENT 'cantidad de unidades del producto',
  `codProductoSUNAT` varchar(1) DEFAULT '-',
  `codProducto` varchar(15) DEFAULT NULL,
  `descripcionItem` varchar(250) NOT NULL COMMENT 'texto del producto',
  `valorUnitario` float NOT NULL COMMENT 'valor base del producto sin IGV',
  `igvUnitario` float NOT NULL COMMENT 'igv del producto calculado',
  `codTriIGV` int(11) DEFAULT '1000',
  `mtoIgvItem` float NOT NULL COMMENT 'cantidad * igvUnitario',
  `valorItem` float NOT NULL COMMENT 'cantidad * valor unitario (sin IGV)',
  `nomTributoIgvItem` varchar(3) DEFAULT 'IGV',
  `codTipTributoIgvItem` varchar(3) DEFAULT 'VAT',
  `tipAfeIGV` int(11) DEFAULT '10',
  `porIgvItem` int(11) DEFAULT '18',
  `codTriISC` varchar(1) DEFAULT '-',
  `mtoIscItem` int(11) DEFAULT '0',
  `mtoBaseIscItem` int(11) DEFAULT '0',
  `nomTributoIscItem` varchar(1) DEFAULT '',
  `codTipTributoIscItem` varchar(1) DEFAULT '',
  `tipSisISC` varchar(1) DEFAULT '',
  `porIscItem` int(1) DEFAULT '15',
  `codTriOtroItem` varchar(1) DEFAULT '-',
  `mtoTriOtroItem` varchar(1) DEFAULT '',
  `mtoBaseTriOtroItem` varchar(1) DEFAULT '',
  `nomTributoIOtroItem` varchar(1) DEFAULT '',
  `codTipTributoIOtroItem` varchar(1) DEFAULT '',
  `porTriOtroItem` int(11) DEFAULT '15',
  `mtoPrecioVenta` float NOT NULL COMMENT '(valor unitario + igv) * cantidad',
  `mtoValorVenta` float NOT NULL COMMENT 'valor unitario * cantidad',
  `mtoValorReferencialUnitario` varchar(4) DEFAULT '0.00',
  `fechaEmision` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_detalle`
--

INSERT INTO `fact_detalle` (`codItem`, `idNegocio`, `idLocal`, `idTicket`, `facSerieCorre`, `codUnidadMedida`, `cantidadItem`, `codProductoSUNAT`, `codProducto`, `descripcionItem`, `valorUnitario`, `igvUnitario`, `codTriIGV`, `mtoIgvItem`, `valorItem`, `nomTributoIgvItem`, `codTipTributoIgvItem`, `tipAfeIGV`, `porIgvItem`, `codTriISC`, `mtoIscItem`, `mtoBaseIscItem`, `nomTributoIscItem`, `codTipTributoIscItem`, `tipSisISC`, `porIscItem`, `codTriOtroItem`, `mtoTriOtroItem`, `mtoBaseTriOtroItem`, `nomTributoIOtroItem`, `codTipTributoIOtroItem`, `porTriOtroItem`, `mtoPrecioVenta`, `mtoValorVenta`, `mtoValorReferencialUnitario`, `fechaEmision`) VALUES
(1, 113, 12300, '105', '', 'UND', 2, '-', '0', 'PRODUCTO GENERICO GRABADO', 5, 1.8, 1000, 0, 10, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 11.8, 10, '0.00', '2018-09-06'),
(2, 113, 12300, '103420-8', '', 'UND', 1, '-', 'COS-202-1202', 'PRODUCTO COS 1202', 1.19, 0.21, 1000, 0.21, 1.19, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.4, 1.19, '0.00', '2019-02-14'),
(3, 113, 12300, '103420-8', '', 'UND', 1, '-', 'COS-201-1126', 'PRODUCTO COS 1126', 2.12, 0.38, 1000, 0.38, 2.12, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2.5, 2.12, '0.00', '2019-02-14'),
(4, 113, 12300, '103420-8', '', 'UND', 1, '-', 'CO-15-483', 'PRODUCTO CO-15-483', 1.69, 0.31, 1000, 0.31, 1.69, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2, 1.69, '0.00', '2019-02-14'),
(5, 113, 12300, '103420-8', '', 'UND', 1, '-', 'AR-51-610', 'PRODUCTO AR-51-610', 1.36, 0.24, 1000, 0.24, 1.36, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.6, 1.36, '0.00', '2019-02-14'),
(6, 113, 12300, '103420-9', '', 'UND', 2, '-', '1', 'CHOCOLATE BITTER', 8.48, 3.05, 1000, 3.05, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-24'),
(7, 113, 12300, '103420-9', '', 'UND', 1, '-', '2', 'OSO DE PELUCHE', 67.79, 12.21, 1000, 12.21, 67.79, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 80, 12.21, '0.00', '2019-02-24'),
(8, 0, 0, '', '', 'GLI', 4.055, '-', '1', '', 10.45, 1.88, 1000, 1.88, 42.37, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.33, 42.37, '0.00', '2019-02-28'),
(9, 0, 0, '', '', 'GLI', 4, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 44.04, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 44.04, '0.00', '2019-02-28'),
(10, 0, 0, '', '', 'GLI', 2, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 22.02, '0.00', '2019-02-28'),
(11, 0, 0, '', '', 'GLI', 2, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 22.02, '0.00', '2019-02-28'),
(12, 0, 0, '', '', 'GLI', 6, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 62.7, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.33, 62.7, '0.00', '2019-02-28'),
(13, 0, 0, '', '', 'GLI', 2, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 25.98, 22.02, '0.00', '2019-02-28'),
(14, 0, 0, '', '', 'GLI', 6, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 62.7, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 73.98, 62.7, '0.00', '2019-02-28'),
(15, 0, 0, '', '', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(16, 0, 0, '', '', 'GLI', 1.622, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-28'),
(17, 0, 0, '', '2.000', 'GLI', 0, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 25.98, 22.02, '0.00', '2019-02-28'),
(18, 0, 0, '', '4.000', 'GLI', 0, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 41.8, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 49.32, 41.8, '0.00', '2019-02-28'),
(19, 0, 0, '', 'INT001-00000015', 'GLI', 2, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 25.98, 22.02, '0.00', '2019-02-28'),
(20, 0, 0, '', 'INT001-00000015', 'GLI', 4, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 41.8, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 49.32, 41.8, '0.00', '2019-02-28'),
(21, 0, 0, '', 'B001-00000001', 'GLI', 5, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 55.05, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 64.95, 55.05, '0.00', '2019-02-28'),
(22, 0, 0, '', 'B001-00000001', 'GLI', 2, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 20.9, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 24.66, 20.9, '0.00', '2019-02-28'),
(23, 0, 0, '', 'B001-00000002', 'GLI', 5, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 55.05, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 64.95, 55.05, '0.00', '2019-02-28'),
(24, 0, 0, '', 'B001-00000002', 'GLI', 2, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 20.9, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 24.66, 20.9, '0.00', '2019-02-28'),
(25, 0, 0, '', 'B001-00000003', 'GLI', 1, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 11.01, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 11.01, '0.00', '2019-02-28'),
(26, 0, 0, '', 'B001-00000003', 'GLI', 2, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 20.9, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 24.66, 20.9, '0.00', '2019-02-28'),
(27, 0, 0, '', 'B001-00000004', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(28, 0, 0, '', 'B001-00000005', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(29, 0, 0, '', 'B001-00000005', 'GLI', 0.811, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 8.47, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.47, '0.00', '2019-02-28'),
(30, 0, 0, '', 'B001-00000006', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(31, 0, 0, '', 'B001-00000006', 'GLI', 0.811, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 8.47, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.47, '0.00', '2019-02-28'),
(32, 0, 0, '', 'B001-00000007', 'GLI', 2, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 22.02, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 25.98, 22.02, '0.00', '2019-02-28'),
(33, 0, 0, '', 'B001-00000007', 'GLI', 5, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 1.88, 52.25, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 61.65, 52.25, '0.00', '2019-02-28'),
(34, 0, 0, '', 'B001-00000008', 'GLI', 3, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 33.03, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 38.97, 33.03, '0.00', '2019-02-28'),
(35, 0, 0, '', 'B001-00000009', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(36, 0, 0, '', 'B001-00000010', 'GLI', 0.77, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 8.48, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 10, 8.48, '0.00', '2019-02-28'),
(37, 0, 0, '', 'B001-00000011', 'GLI', 1, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 11.01, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 11.01, '0.00', '2019-02-28'),
(38, 0, 0, '', 'B001-00000012', 'GLI', 1, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 11.01, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 12.99, 11.01, '0.00', '2019-02-28'),
(39, 0, 0, '', 'B001-00000013', 'GLI', 10, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 1.98, 110.1, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 129.9, 110.1, '0.00', '2019-02-28'),
(40, 0, 0, '', 'B001-00000014', 'GLI', 10, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 19.8, 110.1, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 129.9, 110.1, '0.00', '2019-02-28'),
(41, 0, 0, '', 'B001-00000015', 'GLI', 10, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 19.8, 110.1, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 129.9, 110.1, '0.00', '2019-02-28'),
(42, 0, 0, '', 'B001-00000016', 'GLI', 10, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 19.8, 110.1, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 129.9, 110.1, '0.00', '2019-02-28'),
(43, 0, 0, '', 'B001-00000017', 'GLI', 10, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 19.8, 110.1, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 129.9, 110.1, '0.00', '2019-02-28'),
(44, 0, 0, '', 'B001-00000017', 'GLI', 9, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 16.92, 94.05, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 110.97, 94.05, '0.00', '2019-02-28'),
(45, 0, 0, '', 'B001-00000018', 'GLI', 5, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 9.9, 55.05, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 64.95, 55.05, '0.00', '2019-02-28'),
(46, 0, 0, '', 'B001-00000018', 'GLI', 1.622, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 3.05, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-28'),
(47, 0, 0, '', 'B001-00000019', 'GLI', 5, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 9.9, 55.05, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 64.95, 55.05, '0.00', '2019-02-28'),
(48, 0, 0, '', 'B001-00000019', 'GLI', 1.622, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 3.05, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-28'),
(49, 0, 0, '', 'B001-00000020', 'GLI', 4.619, '-', '0', 'Gasolina', 11.01, 1.98, 1000, 9.15, 50.86, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 60, 50.86, '0.00', '2019-02-28'),
(50, 0, 0, '', 'B001-00000020', 'GLI', 1.622, '-', '1', 'Petróleo', 10.45, 1.88, 1000, 3.05, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-28'),
(51, 0, 0, '', 'F001-00000006', 'GLI', 3.871, '-', '0', 'Gasolina', 13.14, 2.36, 1000, 9.14, 50.86, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 60, 50.86, '0.00', '2019-02-28'),
(52, 0, 0, '', 'F001-00000006', 'GLI', 1.622, '-', '1', 'Petróleo', 10.17, 1.83, 1000, 2.97, 16.5, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 19.46, 16.5, '0.00', '2019-02-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_series`
--

DROP TABLE IF EXISTS `fact_series`;
CREATE TABLE `fact_series` (
  `serieFactura` varchar(10) NOT NULL,
  `serieBoleta` varchar(10) NOT NULL,
  `serieNota` varchar(10) NOT NULL,
  `serieDebito` varchar(10) NOT NULL,
  `serieOpcional` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_series`
--

INSERT INTO `fact_series` (`serieFactura`, `serieBoleta`, `serieNota`, `serieDebito`, `serieOpcional`) VALUES
('F001', 'B001', 'B600', 'F001', 'INT001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `idProductos` int(11) NOT NULL,
  `prodDescripcion` varchar(250) NOT NULL,
  `idUnidad` int(11) NOT NULL,
  `prodPrecio` float NOT NULL,
  `prodActivo` int(11) NOT NULL DEFAULT '1' COMMENT '1 activo/ 0 inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProductos`, `prodDescripcion`, `idUnidad`, `prodPrecio`, `prodActivo`) VALUES
(1, 'Petróleo', 1, 12.33, 1),
(2, 'Gasolina', 1, 12.99, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE `unidades` (
  `idUnidad` int(11) NOT NULL,
  `undDescipcion` varchar(250) NOT NULL,
  `undSunat` varchar(10) NOT NULL,
  `undActivo` int(11) NOT NULL DEFAULT '1' COMMENT '1 activo/ 0 inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`idUnidad`, `undDescipcion`, `undSunat`, `undActivo`) VALUES
(1, 'Galón', 'GLI', 1),
(2, 'Litro', 'LTR', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `fact_cabecera`
--
ALTER TABLE `fact_cabecera`
  ADD PRIMARY KEY (`idComprobante`);

--
-- Indices de la tabla `fact_detalle`
--
ALTER TABLE `fact_detalle`
  ADD PRIMARY KEY (`codItem`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProductos`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`idUnidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fact_cabecera`
--
ALTER TABLE `fact_cabecera`
  MODIFY `idComprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `fact_detalle`
--
ALTER TABLE `fact_detalle`
  MODIFY `codItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProductos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `idUnidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
