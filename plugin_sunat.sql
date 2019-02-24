-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2019 a las 23:14:14
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
-- Estructura de tabla para la tabla `clientemay`
--

CREATE TABLE `clientemay` (
  `dni` varchar(15) NOT NULL DEFAULT '',
  `nombres` varchar(50) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `razonsocial` varchar(50) DEFAULT NULL,
  `direccion` char(60) DEFAULT NULL,
  `idciudad` char(10) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  `fecregistro` date DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `captadopor` varchar(3) DEFAULT NULL,
  `idnegocio` smallint(6) DEFAULT NULL,
  `idlocal` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientemay`
--

INSERT INTO `clientemay` (`dni`, `nombres`, `ruc`, `razonsocial`, `direccion`, `idciudad`, `email`, `celular`, `descuento`, `fecregistro`, `estado`, `captadopor`, `idnegocio`, `idlocal`) VALUES
('40622700', 'HUGO', '1040612100', 'INVERSIONES DINO', 'JR JUNIN 7548', '1245', 'hames@hotmail.com', '92521478', 30, '2019-02-06', 'A', 'TIE', 113, 12300);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientemin`
--

CREATE TABLE `clientemin` (
  `dni` varchar(15) NOT NULL,
  `nombres` char(50) NOT NULL,
  `email` char(40) DEFAULT NULL,
  `celular` char(15) DEFAULT NULL,
  `fecregistro` date DEFAULT NULL,
  `idciudad` varchar(10) DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `captadopor` varchar(3) DEFAULT NULL,
  `idnegocio` smallint(6) DEFAULT NULL,
  `idlocal` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientemin`
--

INSERT INTO `clientemin` (`dni`, `nombres`, `email`, `celular`, `fecregistro`, `idciudad`, `estado`, `captadopor`, `idnegocio`, `idlocal`) VALUES
('70150728', 'LILIANA MONICA JULCA ARE', '', '973698213', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20069726', 'ROSA YOLANDA AGUIRRE PALOMI', '', '935113988', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20056257', 'YANET FLORES BAUTISTA', '', '954137083', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('19881708', 'ROSA NELI VILA ENRIQUEZ', '', '991056761', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('4553724', 'CLIFFORD KEVIN MALDONADO MIRANDA', '', '964475856', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('71924873', 'NATHALY GASPAR LIMAYLLA', '', '940528549', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('42015298', 'NORMA YUCRA CHIRINOS', '', '962747258', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('19836350', 'YOLANDA ORTIZ COLQUI', '', '201993', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('40718632', 'BRIGIDA PICHO QUISPE', '', '967248638', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('45587001', 'CRISTINA EGOAVIL ARRIOLA', '', '961479888', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('78887368', 'PAMELA', '', '939353330', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('44587849', 'JANET SALAZAR ACERO', '', '988585424', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('62944108', 'KIMBERLYN CCANTO RUDAS', '', '966415005', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('75986198', 'REBECA VELI CHUPAN', '', '940009215', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20004013', 'MARINA POMA ACCASI', '', '962214968', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('44870159', 'MELGAR REYNA DE LA CRUZ', '', '966338608', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('46147798', 'BETSY LIMA APOZA SANCHEZ', '', '931190006', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('19854412', 'NATIVA CRISPIN BARRIENTOS', '', '910685504', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('72154861', 'LUZANGEL FLORES', '', '983842739', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20437853', 'JUDITH AGUILAR DAVALOS', '', '964768476', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('47906436', 'LUCILA OSCO CASTILLON', '', '962941425', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20719954', 'DORA PAUCAR ROSALES', '', '950576556', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('47568004', 'KATERINE SILVESTRE', '', '948657590', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('44969343', 'MELINA LAURA HUAMAN', '', '996044249', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('04080777', 'IRIS ALIAGA SALAZAR', '', '990992879', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20048255', 'MIRIAN BALBIN COLQUI', '', '933205710', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('42304376', 'JESSICA HUAYNALAYA OREGON', '', '982528201', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('42225226', 'JENIFER ANGELA ALANIA PEQUIN', '', '952977952', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('80168396', 'JESENIA MERCEDES MANANI', '', '966243930', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('44744966', 'ZENIA ELIANA GALARZA LOPEZ', '', '918511747', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('40546483', 'ROSA CASAS CARHUANCHA', '', '964320389', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('80193384', 'NELIDA ARIZA ROJAS', '', '605989', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20107132', 'ENMA PEÑA ORTIZ', '', '964700405', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('44241895', 'JULI ASTO RODRIGUEZ', '', '942760510', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20016846', 'RULA MARIVEL MAMANI RIVERA', '', '939396640', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('43125649', 'VANESA PEÑA LOZANO', '', '959831076', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('20899623', 'HAYDEE ASTUCCURI TERRET', '', '964927769', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('40502536', 'GRACIELA ESPINOZA BUENDIA', '', '967681118', '2019-02-06', '120101', 'A', 'TIE', 110, 10300),
('09764965', 'MAIBE CORDOVA ALVAREZ', '', '963886895', '2019-02-06', '120101', 'A', 'TIE', 110, 10300);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cabecera`
--

CREATE TABLE `fact_cabecera` (
  `idComprobante` int(11) NOT NULL,
  `idNegocio` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idTicket` varchar(10) NOT NULL,
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
(3, 113, 12300, '103420-9', 1, 'F001', 00000005, '0101', '2019-02-24', '20:15:17', '-', '000', 0, '20602337147', 'INFOCAT SOLUCIONES SAC', 'PEN', 84.75, 15.25, 100, 0, 0, 0, 100, '2.1', '2.0', 1000, 'IGV', 'VAT', 84.75, 15.25, 1000, 'CIEN SOLES 0/100 MN', 1, '2019-02-24 17:03:45', 'AV. HUANCAVELICA 435');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_detalle`
--

CREATE TABLE `fact_detalle` (
  `codItem` int(11) NOT NULL,
  `idNegocio` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idTicket` varchar(10) NOT NULL COMMENT 'Para unit productos y tickets',
  `codUnidadMedida` varchar(3) DEFAULT 'UND',
  `cantidadItem` int(11) NOT NULL COMMENT 'cantidad de unidades del producto',
  `codProductoSUNAT` varchar(1) DEFAULT '-',
  `codProducto` varchar(15) DEFAULT NULL,
  `descripcionItem` varchar(250) NOT NULL COMMENT 'texto del producto',
  `valorUnitario` float NOT NULL COMMENT 'valor base del producto sin IGV',
  `igvUnitario` float NOT NULL COMMENT 'igv del producto calculado',
  `codTriIGV` int(11) DEFAULT '1000',
  `mtoIgvItem` float NOT NULL COMMENT 'mismo campo igvUnitario',
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

INSERT INTO `fact_detalle` (`codItem`, `idNegocio`, `idLocal`, `idTicket`, `codUnidadMedida`, `cantidadItem`, `codProductoSUNAT`, `codProducto`, `descripcionItem`, `valorUnitario`, `igvUnitario`, `codTriIGV`, `mtoIgvItem`, `valorItem`, `nomTributoIgvItem`, `codTipTributoIgvItem`, `tipAfeIGV`, `porIgvItem`, `codTriISC`, `mtoIscItem`, `mtoBaseIscItem`, `nomTributoIscItem`, `codTipTributoIscItem`, `tipSisISC`, `porIscItem`, `codTriOtroItem`, `mtoTriOtroItem`, `mtoBaseTriOtroItem`, `nomTributoIOtroItem`, `codTipTributoIOtroItem`, `porTriOtroItem`, `mtoPrecioVenta`, `mtoValorVenta`, `mtoValorReferencialUnitario`, `fechaEmision`) VALUES
(1, 113, 12300, '105', 'UND', 2, '-', '0', 'PRODUCTO GENERICO GRABADO', 5, 1.8, 1000, 0, 10, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 11.8, 10, '0.00', '2018-09-06'),
(2, 113, 12300, '103420-8', 'UND', 1, '-', 'COS-202-1202', 'PRODUCTO COS 1202', 1.19, 0.21, 1000, 0.21, 1.19, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.4, 1.19, '0.00', '2019-02-14'),
(3, 113, 12300, '103420-8', 'UND', 1, '-', 'COS-201-1126', 'PRODUCTO COS 1126', 2.12, 0.38, 1000, 0.38, 2.12, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2.5, 2.12, '0.00', '2019-02-14'),
(4, 113, 12300, '103420-8', 'UND', 1, '-', 'CO-15-483', 'PRODUCTO CO-15-483', 1.69, 0.31, 1000, 0.31, 1.69, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2, 1.69, '0.00', '2019-02-14'),
(5, 113, 12300, '103420-8', 'UND', 1, '-', 'AR-51-610', 'PRODUCTO AR-51-610', 1.36, 0.24, 1000, 0.24, 1.36, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.6, 1.36, '0.00', '2019-02-14'),
(6, 113, 12300, '103420-9', 'UND', 2, '-', '1', 'CHOCOLATE BITTER', 8.48, 3.05, 1000, 3.05, 16.95, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 20, 16.95, '0.00', '2019-02-24'),
(7, 113, 12300, '103420-9', 'UND', 1, '-', '2', 'OSO DE PELUCHE', 67.79, 12.21, 1000, 12.21, 67.79, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 80, 12.21, '0.00', '2019-02-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_series`
--

CREATE TABLE `fact_series` (
  `serieFactura` varchar(10) NOT NULL,
  `serieBoleta` varchar(10) NOT NULL,
  `serieNota` varchar(10) NOT NULL,
  `serieDebito` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_series`
--

INSERT INTO `fact_series` (`serieFactura`, `serieBoleta`, `serieNota`, `serieDebito`) VALUES
('F001', 'B001', 'B600', 'F001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketventa`
--

CREATE TABLE `ticketventa` (
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `idticket` varchar(10) NOT NULL,
  `idnegocio` smallint(6) NOT NULL,
  `idlocal` smallint(6) NOT NULL,
  `dnicliente` varchar(15) DEFAULT NULL,
  `ruccliente` varchar(15) DEFAULT NULL,
  `idusuario` smallint(6) NOT NULL,
  `idvendedor` smallint(6) DEFAULT NULL,
  `totalticket` decimal(10,2) NOT NULL,
  `totalgn` decimal(10,2) NOT NULL,
  `totaldscto` decimal(10,2) NOT NULL,
  `totalprod` smallint(4) NOT NULL,
  `pagoefectivo` decimal(10,2) DEFAULT NULL,
  `pagotarjeta` decimal(10,2) DEFAULT NULL,
  `pagocredito` decimal(10,2) DEFAULT NULL,
  `diascredito` smallint(6) DEFAULT NULL,
  `estadopago` varchar(1) DEFAULT 'P',
  `estadorevision` varchar(1) DEFAULT 'N',
  `estadoanulacion` varchar(1) DEFAULT 'N',
  `fecanulacion` date DEFAULT NULL,
  `anotacion` varchar(60) DEFAULT NULL,
  `tipoventa` varchar(3) DEFAULT 'MIN',
  `confirmado` varchar(1) DEFAULT 'N',
  `dsctoglobal` decimal(10,2) DEFAULT '0.00',
  `pagoconbillete` decimal(10,2) DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ticketventa`
--

INSERT INTO `ticketventa` (`fecha`, `hora`, `idticket`, `idnegocio`, `idlocal`, `dnicliente`, `ruccliente`, `idusuario`, `idvendedor`, `totalticket`, `totalgn`, `totaldscto`, `totalprod`, `pagoefectivo`, `pagotarjeta`, `pagocredito`, `diascredito`, `estadopago`, `estadorevision`, `estadoanulacion`, `fecanulacion`, `anotacion`, `tipoventa`, `confirmado`, `dsctoglobal`, `pagoconbillete`) VALUES
('2019-02-12', '10:28:48', '102848-1', 113, 12300, '', NULL, 423, 0, '4.60', '1.75', '0.00', 5, '4.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '10:34:20', '103420-8', 113, 12300, '', NULL, 423, 0, '7.50', '4.28', '0.00', 4, '7.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '10:38:33', '103833-4', 113, 12300, '', NULL, 423, 0, '1.10', '0.59', '0.00', 1, '1.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, '', NULL, 423, 0, '37.50', '18.48', '0.00', 10, '37.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:08:16', '110816-4', 113, 12300, '', NULL, 423, 0, '71.50', '4.97', '0.00', 3, '71.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, '', NULL, 423, 0, '17.60', '8.00', '0.00', 8, '17.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:37:33', '113733-4', 113, 12300, '', NULL, 423, 0, '3.90', '1.90', '0.00', 1, '3.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:52:31', '115231-2', 113, 12300, '', NULL, 423, 0, '23.60', '10.16', '2.40', 13, '23.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '11:59:39', '115939-3', 113, 12300, '', NULL, 423, 0, '3.40', '1.33', '0.00', 2, '3.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, '', NULL, 423, 0, '14.10', '8.11', '0.00', 5, '14.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:28:51', '122851-6', 113, 12300, '', NULL, 423, 0, '52.90', '21.93', '5.80', 3, '52.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:33:14', '123314-4', 113, 12300, '', NULL, 423, 0, '20.00', '10.30', '0.00', 1, '20.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:35:10', '123510-3', 113, 12300, '', NULL, 423, 0, '2.00', '1.41', '0.00', 2, '2.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:37:20', '123720-1', 113, 12300, '', NULL, 423, 0, '32.50', '16.11', '0.00', 4, '32.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, '', NULL, 423, 0, '9.90', '4.97', '0.00', 5, '9.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:50:36', '125036-8', 113, 12300, '', NULL, 423, 0, '9.00', '4.85', '0.00', 1, '9.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:58:45', '125845-4', 113, 12300, '', NULL, 423, 0, '16.00', '9.40', '0.00', 1, '16.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '12:59:31', '125931-8', 113, 12300, '', NULL, 423, 0, '33.30', '14.50', '5.80', 4, '33.30', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, '', NULL, 423, 0, '33.40', '19.88', '0.50', 6, '33.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '13:20:15', '132015-7', 113, 12300, '', NULL, 423, 0, '9.00', '4.85', '0.00', 1, '9.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '13:37:19', '133719-3', 113, 12300, '', NULL, 423, 0, '3.20', '1.94', '0.00', 1, '3.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '13:52:18', '135218-1', 113, 12300, '', NULL, 423, 0, '59.70', '28.60', '10.30', 4, '59.70', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MAY', 'S', '0.00', '0.00'),
('2019-02-12', '13:56:17', '135617-4', 113, 12300, '', NULL, 423, 0, '22.20', '11.00', '3.80', 2, '22.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '14:01:20', '140120-9', 113, 12300, '', NULL, 423, 0, '16.90', '8.93', '0.00', 4, '16.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '14:08:57', '140857-8', 113, 12300, '', NULL, 423, 0, '3.00', '2.02', '0.00', 1, '3.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, '', NULL, 423, 0, '12.60', '5.74', '0.00', 7, '12.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '14:16:59', '141659-4', 113, 12300, '', NULL, 423, 0, '3.30', '1.63', '0.00', 3, '3.30', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, '', NULL, 423, 0, '295.50', '59.31', '181.10', 98, '295.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MAY', 'S', '0.00', '0.00'),
('2019-02-12', '15:22:55', '152255-1', 113, 12300, '', NULL, 423, 0, '27.40', '13.87', '0.00', 4, '27.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '15:24:42', '152442-8', 113, 12300, '', NULL, 423, 0, '40.80', '20.00', '0.00', 4, '40.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '15:30:00', '153000-2', 113, 12300, '', NULL, 423, 0, '16.00', '8.35', '0.00', 2, '16.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, '', NULL, 423, 0, '11.90', '5.94', '0.00', 6, '11.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:06:23', '160623-2', 113, 12300, '', NULL, 423, 0, '2.00', '1.22', '0.00', 1, '2.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, '', NULL, 423, 0, '14.10', '6.87', '0.00', 6, '14.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:19:16', '161916-9', 113, 12300, '', NULL, 423, 0, '3.20', '1.60', '0.00', 4, '3.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:29:08', '162908-8', 113, 12300, '', NULL, 423, 0, '1.60', '0.70', '0.00', 1, '1.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:40:24', '164024-9', 113, 12300, '', NULL, 423, 0, '19.20', '11.40', '0.00', 2, '19.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:45:03', '164503-6', 113, 12300, '', NULL, 423, 0, '53.00', '26.30', '0.00', 4, '53.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:56:35', '165635-3', 113, 12300, '', NULL, 423, 0, '3.20', '-0.48', '0.00', 1, '3.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '16:57:45', '165745-4', 113, 12300, '', NULL, 423, 0, '9.00', '4.68', '2.50', 4, '9.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:00:58', '170058-2', 113, 12300, '', NULL, 423, 0, '34.00', '18.90', '0.00', 2, '34.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:17:19', '171719-6', 113, 12300, '', NULL, 423, 0, '32.00', '14.60', '0.00', 1, '32.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:24:48', '172448-9', 113, 12300, '', NULL, 423, 0, '5.80', '3.62', '0.00', 4, '5.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:27:17', '172717-8', 113, 12300, '', NULL, 423, 0, '2.00', '0.56', '0.00', 1, '2.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:28:45', '172845-6', 113, 12300, '', NULL, 423, 0, '4.40', '3.02', '0.00', 3, '4.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:35:01', '173501-6', 113, 12300, '', NULL, 423, 0, '2.50', '1.36', '0.00', 2, '2.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:37:38', '173738-7', 113, 12300, '', NULL, 423, 0, '0.90', '0.40', '0.00', 1, '0.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, '', NULL, 423, 0, '34.70', '14.69', '6.10', 7, '34.70', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, '', NULL, 423, 0, '11.40', '4.34', '0.00', 6, '11.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:47:21', '174721-8', 113, 12300, '', NULL, 423, 0, '1.10', '0.58', '0.00', 1, '1.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:48:08', '174808-3', 113, 12300, '', NULL, 423, 0, '0.80', '0.40', '0.00', 1, '0.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:54:52', '175452-5', 113, 12300, '', NULL, 423, 0, '3.50', '2.00', '0.00', 1, '3.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:56:42', '175642-9', 113, 12300, '', NULL, 423, 0, '6.40', '3.31', '0.00', 2, '6.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '17:57:59', '175759-8', 113, 12300, '', NULL, 423, 0, '9.10', '3.98', '0.00', 3, '9.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:10:04', '181004-4', 113, 12300, '', NULL, 423, 0, '0.80', '0.30', '0.00', 1, '0.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:10:56', '181056-9', 113, 12300, '', NULL, 423, 0, '4.00', '1.97', '0.00', 2, '4.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:16:47', '181647-7', 113, 12300, '', NULL, 423, 0, '2.80', '1.34', '0.00', 1, '2.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:18:19', '181819-8', 113, 12300, '', NULL, 423, 0, '0.50', '0.11', '0.00', 1, '0.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:23:13', '182313-1', 113, 12300, '', NULL, 423, 0, '6.40', '2.36', '0.20', 7, '6.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:32:06', '183206-9', 113, 12300, '', NULL, 423, 0, '6.00', '2.40', '1.20', 12, '6.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:33:16', '183316-8', 113, 12300, '', NULL, 423, 0, '1.00', '0.70', '0.00', 1, '1.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:34:14', '183414-8', 113, 12300, '', NULL, 423, 0, '9.50', '7.10', '0.00', 1, '9.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:42:17', '184217-1', 113, 12300, '', NULL, 423, 0, '6.00', '2.40', '1.20', 12, '6.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:50:42', '185042-1', 113, 12300, '', NULL, 423, 0, '2.00', '1.04', '0.00', 1, '2.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, '', NULL, 423, 0, '403.80', '124.30', '131.30', 92, '403.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '18:59:24', '185924-6', 113, 12300, '', NULL, 423, 0, '6.00', '2.40', '1.20', 12, '6.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:00:58', '190058-2', 113, 12300, '', NULL, 423, 0, '9.30', '3.56', '0.70', 2, '9.30', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:04:20', '190420-3', 113, 12300, '', NULL, 423, 0, '9.20', '3.93', '0.80', 2, '9.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:06:24', '190624-5', 113, 12300, '', NULL, 423, 0, '1.20', '0.70', '0.00', 2, '1.20', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:16:00', '191600-3', 113, 12300, '', NULL, 423, 0, '1.00', '0.42', '0.00', 1, '1.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:20:16', '192016-8', 113, 12300, '', NULL, 423, 0, '6.80', '2.60', '1.20', 1, '6.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:25:52', '192552-2', 113, 12300, '', NULL, 423, 0, '15.00', '8.55', '0.00', 3, '15.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:38:16', '193816-7', 113, 12300, '', NULL, 423, 0, '5.10', '4.07', '0.00', 2, '5.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:41:00', '194100-2', 113, 12300, '', NULL, 423, 0, '7.90', '4.59', '0.00', 4, '7.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, '', NULL, 423, 0, '49.80', '19.33', '16.30', 8, '49.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:55:59', '195559-2', 113, 12300, '', NULL, 423, 0, '5.60', '3.28', '0.00', 6, '5.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:57:34', '195734-3', 113, 12300, '', NULL, 423, 0, '13.80', '6.00', '0.00', 1, '13.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '19:59:42', '195942-3', 113, 12300, '', NULL, 423, 0, '15.90', '7.90', '0.00', 1, '15.90', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:01:48', '200148-5', 113, 12300, '', NULL, 423, 0, '4.80', '2.50', '0.00', 3, '4.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:02:56', '200256-8', 113, 12300, '', NULL, 423, 0, '3.50', '1.83', '0.00', 2, '3.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:04:04', '200404-5', 113, 12300, '', NULL, 423, 0, '18.60', '11.55', '0.00', 2, '18.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:04:55', '200455-7', 113, 12300, '', NULL, 423, 0, '17.80', '11.03', '0.00', 3, '17.80', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:06:06', '200606-2', 113, 12300, '', NULL, 423, 0, '62.60', '31.41', '4.40', 4, '62.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, '', NULL, 423, 0, '22.00', '11.97', '0.00', 10, '22.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:10:43', '201043-4', 113, 12300, '', NULL, 423, 0, '6.10', '1.75', '0.00', 6, '6.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:12:30', '201230-6', 113, 12300, '', NULL, 423, 0, '33.30', '16.20', '0.00', 5, '33.30', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:14:26', '201426-3', 113, 12300, '', NULL, 423, 0, '20.50', '10.19', '0.00', 3, '20.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, '', NULL, 423, 0, '7.50', '3.09', '0.00', 6, '7.50', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:25:33', '202533-7', 113, 12300, '', NULL, 423, 0, '14.40', '7.45', '0.00', 4, '14.40', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:34:51', '203451-9', 113, 12300, '', NULL, 423, 0, '5.00', '2.50', '0.00', 1, '5.00', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:38:22', '203822-5', 113, 12300, '', NULL, 423, 0, '1.60', '0.70', '0.00', 1, '1.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, '', NULL, 423, 0, '11.60', '4.92', '0.00', 6, '11.60', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '20:59:35', '205935-9', 113, 12300, '', NULL, 423, 0, '3.10', '0.77', '0.80', 1, '3.10', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, '', NULL, 423, 0, '90.70', '39.32', '25.60', 46, '90.70', '0.00', '0.00', 15, 'P', 'N', 'N', NULL, NULL, 'MIN', 'S', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketventadetalle`
--

CREATE TABLE `ticketventadetalle` (
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `idticket` varchar(10) NOT NULL,
  `idnegocio` smallint(6) NOT NULL,
  `idlocal` smallint(6) NOT NULL,
  `nroitem` tinyint(4) NOT NULL,
  `codproducto` varchar(15) NOT NULL,
  `codbarra` varchar(15) NOT NULL,
  `cantidad` float NOT NULL,
  `idpresentacion` varchar(20) NOT NULL,
  `precioventa` float NOT NULL,
  `descuento` float NOT NULL,
  `precioneto` float NOT NULL,
  `dnicliente` varchar(15) DEFAULT NULL,
  `ruccliente` int(15) DEFAULT NULL,
  `idvendedor` smallint(6) DEFAULT NULL,
  `idusuario` smallint(6) NOT NULL,
  `factorgn` float NOT NULL,
  `contenido` tinyint(4) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `tipocompra` varchar(3) DEFAULT 'IMP',
  `marketing` varchar(3) DEFAULT 'X',
  `etiqueta` varchar(1) DEFAULT 'X'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ticketventadetalle`
--

INSERT INTO `ticketventadetalle` (`fecha`, `hora`, `idticket`, `idnegocio`, `idlocal`, `nroitem`, `codproducto`, `codbarra`, `cantidad`, `idpresentacion`, `precioventa`, `descuento`, `precioneto`, `dnicliente`, `ruccliente`, `idvendedor`, `idusuario`, `factorgn`, `contenido`, `estado`, `tipocompra`, `marketing`, `etiqueta`) VALUES
('2019-02-12', '10:28:48', '102848-1', 113, 12300, 1, 'PI-74-36', '07436', 1, 'pack x 2', 1, 0, 1, '', NULL, 0, 423, 0.47, 6, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:28:48', '102848-1', 113, 12300, 2, 'PI-74-79', '07479', 1, 'pack x 2', 1, 0, 1, '', NULL, 0, 423, 0.36, 6, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:28:48', '102848-1', 113, 12300, 3, 'PI-74-79', '07479', 1, 'pack x 2', 1, 0, 1, '', NULL, 0, 423, 0.36, 6, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:28:48', '102848-1', 113, 12300, 4, 'AR-51-406', '051406', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.83, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:28:48', '102848-1', 113, 12300, 5, 'AR-51-407', '051407', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.83, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:34:20', '103420-8', 113, 12300, 1, 'COS-202-1202', '2021202', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '10:34:20', '103420-8', 113, 12300, 2, 'COS-201-1126', '2011126', 1, 'unidad', 2.5, 0, 2.5, '', NULL, 0, 423, 1.17, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '10:34:20', '103420-8', 113, 12300, 3, 'CO-15-483', '15483', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.78, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:34:20', '103420-8', 113, 12300, 4, 'AR-51-610', '051610', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.64, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '10:38:33', '103833-4', 113, 12300, 1, 'COS-101-210', '101210', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.51, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 1, 'RE-98-578', '98578', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 2, 'SET-75-143', '075143', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.26, 48, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 3, 'COS-201-1119', '2011119', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 3, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 4, 'COS-202-1014', '2021014', 1, 'unidad', 7.9, 0, 7.9, '', NULL, 0, 423, 4.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 5, 'COS-202-1235', '2021235', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 2.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 6, 'COS-202-1157', '2021157', 1, 'unidad', 5.5, 0, 5.5, '', NULL, 0, 423, 2.92, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 7, 'COS-202-1025', '2021025', 1, 'unidad', 0.9, 0, 0.9, '', NULL, 0, 423, 0.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 8, 'COS-202-1663', '2021663', 1, 'unidad', 6, 0, 6, '', NULL, 0, 423, 3.17, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:00:29', '110029-7', 113, 12300, 9, 'COS-202-1202', '2021202', 2, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:08:16', '110816-4', 113, 12300, 1, 'RE-98-464', '98464', 1, 'unidad', 16, 0, 16, '', NULL, 0, 423, 8.2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:08:16', '110816-4', 113, 12300, 2, 'VI-78-59-D', '07859D', 1, 'unidad', 10.5, 0, 10.5, '', NULL, 0, 423, 3.33, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:08:16', '110816-4', 113, 12300, 3, 'RM11-162', 'X11162', 1, 'unidad', 45, 0, 45, '', NULL, 0, 423, 55, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 1, 'AR-251-1002', '2511002', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 2, 'AR-50-860', '050860', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.96, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 3, 'AR-50-568P', '050568P', 1, 'unidad', 2.7, 0, 2.7, '', NULL, 0, 423, 1.43, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 4, 'AR-51-202', '051202', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 1.15, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 5, 'AR-51-201', '051201', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 1.15, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 6, 'COS-202-1261', '2021261', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.67, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 7, 'LL-93-462', '93462', 1, 'unidad', 2.5, 0, 2.5, '', NULL, 0, 423, 1.03, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:35:15', '113515-6', 113, 12300, 8, 'COS-101-204', '101204', 1, 'unidad', 3, 0, 3, '', NULL, 0, 423, 1.21, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:37:33', '113733-4', 113, 12300, 1, 'SAV-300-1008', '3001008', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '11:52:31', '115231-2', 113, 12300, 1, 'RE-98-330', '098330', 12, 'unidad', 1.6, 15, 1.4, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:52:31', '115231-2', 113, 12300, 2, 'AR-52-520', '52520', 1, 'unidad', 6.8, 0, 6.8, '', NULL, 0, 423, 2.64, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:59:39', '115939-3', 113, 12300, 1, 'AR-50-856', '050856', 1, 'unidad', 1.8, 0, 1.8, '', NULL, 0, 423, 0.88, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '11:59:39', '115939-3', 113, 12300, 2, 'DI-41-724-D', '041724D', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 1.19, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, 1, 'COS-202-1132', '2021132', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.58, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, 2, 'CO-14-126-L', '014126L', 1, 'unidad', 2.7, 0, 2.7, '', NULL, 0, 423, 0.84, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, 3, 'AR-50-776', '050776', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.34, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, 4, 'COS-202-1202', '2021202', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:18:17', '121817-9', 113, 12300, 5, 'RE-98-429', '98429', 1, 'unidad', 7.5, 0, 7.5, '', NULL, 0, 423, 3.6, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:28:51', '122851-6', 113, 12300, 1, 'RE-98-480', '98480', 1, 'unidad', 5.5, 10, 5, '', NULL, 0, 423, 2.87, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:28:51', '122851-6', 113, 12300, 2, 'PEL-267-1055', '2671055', 1, 'unidad', 49.5, 10, 44.6, '', NULL, 0, 423, 26, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:28:51', '122851-6', 113, 12300, 3, 'RE-98-370', '098370', 1, 'unidad', 3.7, 10, 3.3, '', NULL, 0, 423, 2.1, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:33:14', '123314-4', 113, 12300, 1, 'PEL-67-126', '67126', 1, 'unidad', 20, 0, 20, '', NULL, 0, 423, 9.7, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:35:10', '123510-3', 113, 12300, 1, 'AR-52-124', '052124', 1, 'pack x 2', 1, 0, 1, '', NULL, 0, 423, 0.33, 6, 'OK', 'IMP', 'PR', 'X'),
('2019-02-12', '12:35:10', '123510-3', 113, 12300, 2, 'AR-50-793', '050793', 1, 'pack x 3', 1, 0, 1, '', NULL, 0, 423, 0.26, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:37:20', '123720-1', 113, 12300, 1, 'CAR-91-280', '091280', 1, 'unidad', 5.8, 0, 5.8, '', NULL, 0, 423, 3.14, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:37:20', '123720-1', 113, 12300, 2, 'COS-202-1645', '2021645', 1, 'unidad', 14.9, 0, 14.9, '', NULL, 0, 423, 7.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:37:20', '123720-1', 113, 12300, 3, 'COS-202-1129', '2021129', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 3, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:37:20', '123720-1', 113, 12300, 4, 'COS-202-1232', '2021232', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 2.75, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, 1, 'COS-101-211', '101211', 1, 'paquete x 4', 4.5, 0, 4.5, '', NULL, 0, 423, 1.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, 2, 'VI-78-427', '078427', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, 3, 'VI-78-266', '078266', 1, 'unidad', 0.4, 0, 0.4, '', NULL, 0, 423, 0.48, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, 4, 'COS-202-1649', '2021649', 1, 'unidad', 2.9, 0, 2.9, '', NULL, 0, 423, 1.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:47:35', '124735-8', 113, 12300, 5, 'COS-202-1026', '2021026', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:50:36', '125036-8', 113, 12300, 1, 'COS-101-201', '101201', 1, 'unidad', 9, 0, 9, '', NULL, 0, 423, 4.15, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:58:45', '125845-4', 113, 12300, 1, 'RE-98-553', '98553', 1, 'unidad', 16, 0, 16, '', NULL, 0, 423, 6.6, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:59:31', '125931-8', 113, 12300, 1, 'ES-97-264', '097264', 1, 'unidad', 3.2, 15, 2.7, '', NULL, 0, 423, 1.3, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '12:59:31', '125931-8', 113, 12300, 2, 'SAV-300-1012', '3001012', 1, 'unidad', 3.9, 15, 3.3, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:59:31', '125931-8', 113, 12300, 3, 'REL-265-1001', '2651001', 1, 'unidad', 19, 15, 16.2, '', NULL, 0, 423, 9.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '12:59:31', '125931-8', 113, 12300, 4, 'PEL-67-138', '67138', 1, 'unidad', 13, 15, 11.1, '', NULL, 0, 423, 6, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 1, 'CA-10-43-N-4', '01043N4', 1, 'unidad', 2.2, 0, 2.2, '', NULL, 0, 423, 1.46, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 2, 'DI-41-996', '041996', 1, 'unidad', 9.9, 0, 9.9, '', NULL, 0, 423, 3.37, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 3, 'COS-202-1164', '2021164', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 1.38, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 4, 'ES-97-245', '097245', 1, 'unidad', 6.9, 0, 6.9, '', NULL, 0, 423, 3.1, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 5, 'PIR-80-151', '80151', 1, 'unidad', 4, 0, 4, '', NULL, 0, 423, 1.29, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:14:20', '131420-3', 113, 12300, 6, 'COS-202-1092', '2021092', 1, 'unidad', 5, 10, 4.5, '', NULL, 0, 423, 2.92, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '13:20:15', '132015-7', 113, 12300, 1, 'COS-101-201', '101201', 1, 'unidad', 9, 0, 9, '', NULL, 0, 423, 4.15, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:37:19', '133719-3', 113, 12300, 1, 'MO-95-165', '95165', 1, 'unidad', 3.2, 0, 3.2, '', NULL, 0, 423, 1.26, 24, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '13:52:18', '135218-1', 113, 12300, 1, 'RE-98-552', '98552', 3, 'unidad', 19, 15, 16.2, '', NULL, 0, 423, 8.5, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '13:52:18', '135218-1', 113, 12300, 2, 'RE-98-535', '98535', 1, 'unidad', 13, 15, 11.1, '', NULL, 0, 423, 5.6, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '13:56:17', '135617-4', 113, 12300, 1, 'RE-98-535', '98535', 2, 'unidad', 13, 15, 11.1, '', NULL, 0, 423, 5.6, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:01:20', '140120-9', 113, 12300, 1, 'COS-101-211', '101211', 2, 'paquete x 4', 4.5, 0, 4.5, '', NULL, 0, 423, 1.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:01:20', '140120-9', 113, 12300, 2, 'COS-202-1079', '2021079', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 1.17, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:01:20', '140120-9', 113, 12300, 3, 'COS-201-1119', '2011119', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 3, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:08:57', '140857-8', 113, 12300, 1, 'AN-30-279-D', '030279D', 1, 'unidad', 3, 0, 3, '', NULL, 0, 423, 0.98, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, 1, 'COS-202-1154', '2021154', 2, 'unidad', 2.3, 0, 2.3, '', NULL, 0, 423, 1.04, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, 2, 'GO-71-496', '071496', 1, 'unidad', 1.8, 0, 1.8, '', NULL, 0, 423, 0.82, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, 3, 'GO-71-406', '071406', 2, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 1.18, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, 4, 'GO-71-569', '071569', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:11:27', '141127-2', 113, 12300, 5, 'AN-33-58', '03358', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.88, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:16:59', '141659-4', 113, 12300, 1, 'COS-202-1025', '2021025', 1, 'unidad', 0.9, 0, 0.9, '', NULL, 0, 423, 0.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:16:59', '141659-4', 113, 12300, 2, 'COS-202-1202', '2021202', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:16:59', '141659-4', 113, 12300, 3, 'COS-202-1134', '2021134', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.54, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 1, 'PEL-67-138', '67138', 2, 'unidad', 13, 40, 7.8, '', NULL, 0, 423, 6, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 2, 'PEL-67-139', '67139', 2, 'unidad', 18, 40, 10.8, '', NULL, 0, 423, 7.39, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 3, 'RE-98-329', '098329', 3, 'unidad', 3.2, 40, 1.9, '', NULL, 0, 423, 2.2, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 4, 'RE-98-457', '98457', 2, 'unidad', 8, 40, 4.8, '', NULL, 0, 423, 4.2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 5, 'PEL-67-136', '67136', 1, 'unidad', 13, 40, 7.8, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 6, 'PEL-67-137', '67137', 1, 'unidad', 13, 40, 7.8, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 7, 'RE-98-327', '098327', 8, 'unidad', 1.4, 40, 0.8, '', NULL, 0, 423, 1.04, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 8, 'LL-93-426', '093426', 2, 'unidad', 1.7, 40, 1, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 9, 'MO-95-168', '95168', 3, 'unidad', 6.4, 40, 3.8, '', NULL, 0, 423, 2.64, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 10, 'COS-101-151', '0101151', 2, 'unidad', 1.6, 40, 1, '', NULL, 0, 423, 0.8, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 11, 'CO-15-477', '15477', 1, 'unidad', 2.5, 40, 1.5, '', NULL, 0, 423, 0.98, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 12, 'CO-15-490', '15490', 1, 'unidad', 4, 40, 2.4, '', NULL, 0, 423, 1.38, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 13, 'RE-98-576', '98576', 2, 'unidad', 2, 40, 1.2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 14, 'RE-98-580', '98580', 2, 'unidad', 2, 40, 1.2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 15, 'RE-98-578', '98578', 1, 'unidad', 2, 40, 1.2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 16, 'RE-98-580', '98580', 1, 'unidad', 2, 40, 1.2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 17, 'AR-53-127', '053127', 2, 'blister x 12', 6, 40, 3.6, '', NULL, 0, 423, 2.3, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 18, 'COS-101-223', '101223', 1, 'blister x 12', 8.4, 40, 5, '', NULL, 0, 423, 3, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 19, 'COS-101-198', '101198', 1, 'caja x 10', 10, 40, 6, '', NULL, 0, 423, 3.4, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 20, 'RE-98-369', '098369', 3, 'unidad', 14.4, 40, 8.6, '', NULL, 0, 423, 7.7, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 21, 'VI-78-422', '078422', 2, 'unidad', 1.2, 40, 0.7, '', NULL, 0, 423, 0.6, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 22, 'VI-78-159', '078159', 2, 'unidad', 0.6, 40, 0.4, '', NULL, 0, 423, 0.27, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 23, 'VI-78-266', '078266', 2, 'unidad', 0.4, 40, 0.2, '', NULL, 0, 423, 0.48, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 24, 'SET-75-434', '075434', 2, 'unidad', 4.4, 40, 2.6, '', NULL, 0, 423, 3.4, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 25, 'RE-98-529', '98529', 4, 'unidad', 0.8, 40, 0.5, '', NULL, 0, 423, 0.3, 24, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 26, 'ES-97-226', '097226', 2, 'unidad', 0.6, 40, 0.4, '', NULL, 0, 423, 0.31, 50, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 27, 'ES-97-300', '097300', 1, 'unidad', 2.1, 40, 1.3, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 28, 'VI-78-442', '78442', 3, 'unidad', 2, 40, 1.2, '', NULL, 0, 423, 0.73, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 29, 'VI-78-440', '78440', 1, 'unidad', 2.5, 40, 1.5, '', NULL, 0, 423, 0.88, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 30, 'ES-97-296', '097296', 1, 'unidad', 1.9, 40, 1.1, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 31, 'RE-98-455', '98455', 1, 'unidad', 12.5, 40, 7.5, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 32, 'RE-98-454', '98454', 1, 'unidad', 12.5, 40, 7.5, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 33, 'LL-93-455', '93455', 1, 'unidad', 2.7, 50, 1.4, '', NULL, 0, 423, 1.13, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 34, 'LL-93-453', '93453', 1, 'unidad', 2.7, 50, 1.4, '', NULL, 0, 423, 1.13, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 35, 'LL-93-396', '093396', 1, 'unidad', 2.8, 50, 1.4, '', NULL, 0, 423, 1.2, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 36, 'LL-93-456', '93456', 1, 'unidad', 2.7, 50, 1.4, '', NULL, 0, 423, 1.13, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 37, 'AR-50-347', '050347', 1, 'blister', 1.4, 50, 0.7, '', NULL, 0, 423, 0.69, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 38, 'AR-50-346', '050346', 1, 'blister', 1.6, 50, 0.8, '', NULL, 0, 423, 1.19, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 39, 'SAV-300-1012', '3001012', 1, 'unidad', 3.9, 30, 2.7, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 40, 'COS-202-1134', '2021134', 10, 'unidad', 1, 35, 0.7, '', NULL, 0, 423, 0.54, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 41, 'LL-293-1014', '2931014', 2, 'unidad', 2.8, 35, 1.8, '', NULL, 0, 423, 1.5, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 42, 'LL-293-1008', '2931008', 2, 'unidad', 5, 35, 3.3, '', NULL, 0, 423, 2.5, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 43, 'LL-293-1013', '2931013', 2, 'unidad', 6, 35, 3.9, '', NULL, 0, 423, 2.67, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 44, 'SAV-300-1006', '3001006', 3, 'unidad', 3.9, 35, 2.5, '', NULL, 0, 423, 1.83, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 45, 'AR-250-1001', '2501001', 1, 'unidad', 3.5, 35, 2.3, '', NULL, 0, 423, 1.5, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 46, 'SAV-300-1009', '3001009', 4, 'unidad', 2, 35, 1.3, '', NULL, 0, 423, 1, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 47, 'SAV-300-1007', '3001007', 2, 'unidad', 3.9, 35, 2.5, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 48, 'PEL-267-1055', '2671055', 1, 'unidad', 49.5, 30, 34.7, '', NULL, 0, 423, 26, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '14:46:46', '144646-9', 113, 12300, 49, 'PEL-267-1015', '2671015', 1, 'unidad', 42.9, 35, 27.9, '', NULL, 0, 423, 24, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '15:22:55', '152255-1', 113, 12300, 1, 'LL-293-1006', '2931006', 1, 'unidad', 1.9, 0, 1.9, '', NULL, 0, 423, 1, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '15:22:55', '152255-1', 113, 12300, 2, 'RE-98-467', '98467', 1, 'unidad', 4.5, 0, 4.5, '', NULL, 0, 423, 2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:22:55', '152255-1', 113, 12300, 3, 'AR-52-527', '52527', 1, 'unidad', 3.5, 0, 3.5, '', NULL, 0, 423, 1.13, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:22:55', '152255-1', 113, 12300, 4, 'RE-98-450', '98450', 1, 'unidad', 17.5, 0, 17.5, '', NULL, 0, 423, 9.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:24:42', '152442-8', 113, 12300, 1, 'RE-98-454', '98454', 1, 'unidad', 12.5, 0, 12.5, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:24:42', '152442-8', 113, 12300, 2, 'RE-98-455', '98455', 1, 'unidad', 12.5, 0, 12.5, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:24:42', '152442-8', 113, 12300, 3, 'CH-292-1029', '2921029', 2, 'unidad', 7.9, 0, 7.9, '', NULL, 0, 423, 4, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '15:30:00', '153000-2', 113, 12300, 1, 'COS-101-201', '101201', 1, 'unidad', 9, 0, 9, '', NULL, 0, 423, 4.15, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '15:30:00', '153000-2', 113, 12300, 2, 'COS-202-1242', '2021242', 1, 'unidad', 7, 0, 7, '', NULL, 0, 423, 3.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 1, 'VI-78-357', '078357', 1, 'unidad', 4.9, 0, 4.9, '', NULL, 0, 423, 2.78, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 2, 'COS-101-152', '0101152', 1, 'unidad', 2.1, 0, 2.1, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 3, 'GO-71-517', '071517', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.27, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 4, 'GO-71-566', '071566', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.52, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 5, 'GO-71-570', '071570', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:04:21', '160421-2', 113, 12300, 6, 'GO-71-499', '071499', 1, 'unidad', 1.7, 0, 1.7, '', NULL, 0, 423, 0.77, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:06:23', '160623-2', 113, 12300, 1, 'RE-98-578', '98578', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, 1, 'AN-30-339', '30339', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.54, 100, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, 2, 'AN-33-30', '03330', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.5, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, 3, 'AN-30-55', '03055', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 1.18, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, 4, 'COS-202-1175', '2021175', 2, 'unidad', 2.5, 0, 2.5, '', NULL, 0, 423, 1.17, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '16:15:29', '161529-6', 113, 12300, 5, 'COS-202-1024', '2021024', 1, 'unidad', 5, 0, 5, '', NULL, 0, 423, 2.67, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '16:19:16', '161916-9', 113, 12300, 1, 'AR-50-350-1', '0503501', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.6, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:19:16', '161916-9', 113, 12300, 2, 'GO-71-579', '71579', 2, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.25, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:19:16', '161916-9', 113, 12300, 3, 'COS-202-1025', '2021025', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '16:29:08', '162908-8', 113, 12300, 1, 'RE-98-330', '098330', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:40:24', '164024-9', 113, 12300, 1, 'RE-98-553', '98553', 1, 'unidad', 16, 0, 16, '', NULL, 0, 423, 6.6, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:40:24', '164024-9', 113, 12300, 2, 'ES-97-293', '097293', 1, 'unidad', 3.2, 0, 3.2, '', NULL, 0, 423, 1.2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:45:03', '164503-6', 113, 12300, 1, 'PEL-67-121', '67121', 1, 'unidad', 32, 0, 32, '', NULL, 0, 423, 17.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:45:03', '164503-6', 113, 12300, 2, 'RE-98-552', '98552', 1, 'unidad', 19, 0, 19, '', NULL, 0, 423, 8.5, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:45:03', '164503-6', 113, 12300, 3, 'AN-30-344', '30344', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.3, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:45:03', '164503-6', 113, 12300, 4, 'AN-30-69', '03069', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.5, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:56:35', '165635-3', 113, 12300, 1, 'SET-75-167', '075167', 1, 'unidad', 3.2, 0, 3.2, '', NULL, 0, 423, 3.68, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:57:45', '165745-4', 113, 12300, 1, 'CO-15-490', '15490', 1, 'unidad', 4, 25, 3, '', NULL, 0, 423, 1.38, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '16:57:45', '165745-4', 113, 12300, 2, 'CO-15-477', '15477', 3, 'unidad', 2.5, 20, 2, '', NULL, 0, 423, 0.98, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:00:58', '170058-2', 113, 12300, 1, 'RE-98-561', '98561', 1, 'unidad', 19, 0, 19, '', NULL, 0, 423, 7.7, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:00:58', '170058-2', 113, 12300, 2, 'RE-98-538', '98538', 1, 'unidad', 15, 0, 15, '', NULL, 0, 423, 7.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:17:19', '171719-6', 113, 12300, 1, 'PEL-67-120', '67120', 1, 'unidad', 32, 0, 32, '', NULL, 0, 423, 17.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:24:48', '172448-9', 113, 12300, 1, 'AN-30-339', '30339', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.54, 100, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:24:48', '172448-9', 113, 12300, 2, 'AN-30-74', '03074', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.38, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:24:48', '172448-9', 113, 12300, 3, 'COS-202-1202', '2021202', 2, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:27:17', '172717-8', 113, 12300, 1, 'AR-51-180', '051180', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 1.44, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:28:45', '172845-6', 113, 12300, 1, 'PU-20-23-P', '02023P', 1, 'unidad', 0.4, 0, 0.4, '', NULL, 0, 423, 0.18, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:28:45', '172845-6', 113, 12300, 2, 'PU-21-433', '21433', 2, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.6, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:35:01', '173501-6', 113, 12300, 1, 'COS-202-1202', '2021202', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:35:01', '173501-6', 113, 12300, 2, 'COS-101-210', '101210', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.51, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:37:38', '173738-7', 113, 12300, 1, 'COS-202-1025', '2021025', 1, 'unidad', 0.9, 0, 0.9, '', NULL, 0, 423, 0.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 1, 'PEL-67-135', '67135', 1, 'unidad', 13, 15, 11.1, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 2, 'CO-15-489', '15489', 1, 'unidad', 4, 15, 3.4, '', NULL, 0, 423, 1.38, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 3, 'RE-98-529', '98529', 1, 'unidad', 0.8, 15, 0.7, '', NULL, 0, 423, 0.3, 24, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 4, 'SAV-300-1003', '3001003', 1, 'unidad', 0.8, 15, 0.7, '', NULL, 0, 423, 0.4, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 5, 'SAV-300-1006', '3001006', 1, 'unidad', 3.9, 15, 3.3, '', NULL, 0, 423, 1.83, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 6, 'SAV-300-1008', '3001008', 1, 'unidad', 3.9, 15, 3.3, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:40:27', '174027-1', 113, 12300, 7, 'RE-98-369', '098369', 1, 'unidad', 14.4, 15, 12.2, '', NULL, 0, 423, 7.7, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 1, 'GO-71-573', '71573', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 2, 'PI-74-205', '074205', 1, 'unidad', 3.3, 0, 3.3, '', NULL, 0, 423, 2.78, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 3, 'BR-79-123', '079123', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.66, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 4, 'GO-71-99', '07199', 1, 'unidad', 0.7, 0, 0.7, '', NULL, 0, 423, 0.38, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 5, 'PI-274-1004', '2741004', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:42:56', '174256-1', 113, 12300, 6, 'GO-71-562', '071562', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.52, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:47:21', '174721-8', 113, 12300, 1, 'VI-78-423', '078423', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.52, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:48:08', '174808-3', 113, 12300, 1, 'SAV-300-1003', '3001003', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.4, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:54:52', '175452-5', 113, 12300, 1, 'SAV-300-1014', '3001014', 1, 'unidad', 3.5, 0, 3.5, '', NULL, 0, 423, 1.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:56:42', '175642-9', 113, 12300, 1, 'AR-50-345', '050345', 1, 'pack', 0.5, 0, 0.5, '', NULL, 0, 423, 0.09, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '17:56:42', '175642-9', 113, 12300, 2, 'COS-201-1122', '2011122', 1, 'unidad', 5.9, 0, 5.9, '', NULL, 0, 423, 3, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:57:59', '175759-8', 113, 12300, 1, 'COS-202-1268', '2021268', 2, 'unidad', 2.1, 0, 2.1, '', NULL, 0, 423, 1.1, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '17:57:59', '175759-8', 113, 12300, 2, 'COS-202-1203', '2021203', 1, 'unidad', 4.9, 0, 4.9, '', NULL, 0, 423, 2.92, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '18:10:04', '181004-4', 113, 12300, 1, 'COS-101-150', '0101150', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.5, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:10:56', '181056-9', 113, 12300, 1, 'RE-98-578', '98578', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.78, 60, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:10:56', '181056-9', 113, 12300, 2, 'COS-202-1022', '2021022', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 1.25, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '18:16:47', '181647-7', 113, 12300, 1, 'PR-96-36', '09636', 1, 'unidad', 2.8, 0, 2.8, '', NULL, 0, 423, 1.46, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:18:19', '181819-8', 113, 12300, 1, 'PIR-1103-19', '0110319', 1, 'unidad', 0.5, 0, 0.5, '', NULL, 0, 423, 0.39, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:23:13', '182313-1', 113, 12300, 1, 'AR-53-107', '053107', 2, 'unidad', 0.5, 20, 0.4, '', NULL, 0, 423, 0.57, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:23:13', '182313-1', 113, 12300, 2, 'AN-30-341', '30341', 2, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.45, 100, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:23:13', '182313-1', 113, 12300, 3, 'COS-202-1134', '2021134', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.54, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '18:23:13', '182313-1', 113, 12300, 4, 'SET-75-169', '075169', 2, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.73, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:32:06', '183206-9', 113, 12300, 1, 'RE-98-332', '098332', 12, 'unidad', 0.6, 15, 0.5, '', NULL, 0, 423, 0.3, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:33:16', '183316-8', 113, 12300, 1, 'AN-33-66', '03366', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.3, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:34:14', '183414-8', 113, 12300, 1, 'RE-98-522', '98522', 1, 'unidad', 9.5, 0, 9.5, '', NULL, 0, 423, 2.4, 3, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:42:17', '184217-1', 113, 12300, 1, 'RE-98-332', '098332', 12, 'unidad', 0.6, 15, 0.5, '', NULL, 0, 423, 0.3, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:50:42', '185042-1', 113, 12300, 1, 'AR-51-612', '051612', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.96, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, 1, 'RE-98-471', '98471', 12, 'unidad', 13, 25, 9.8, '', NULL, 0, 423, 6.4, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, 2, 'RE-98-470', '98470', 13, 'unidad', 13, 25, 9.8, '', NULL, 0, 423, 6.8, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, 3, 'RE-98-326', '098326', 24, 'unidad', 3.7, 25, 2.8, '', NULL, 0, 423, 1.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, 4, 'RE-98-330', '098330', 18, 'unidad', 1.6, 25, 1.2, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:52:03', '185203-6', 113, 12300, 5, 'RE-98-370', '098370', 25, 'unidad', 3.7, 25, 2.8, '', NULL, 0, 423, 2.1, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '18:59:24', '185924-6', 113, 12300, 1, 'RE-98-332', '098332', 12, 'unidad', 0.6, 15, 0.5, '', NULL, 0, 423, 0.3, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:00:58', '190058-2', 113, 12300, 1, 'RE-98-480', '98480', 1, 'unidad', 4.5, 15, 3.8, '', NULL, 0, 423, 2.87, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:00:58', '190058-2', 113, 12300, 2, 'RE-98-480', '98480', 1, 'unidad', 6.5, 15, 5.5, '', NULL, 0, 423, 2.87, 12, 'AN', 'IMP', 'X', 'X'),
('2019-02-12', '19:00:58', '190058-2', 113, 12300, 3, 'RE-98-480', '98480', 1, 'unidad', 5.5, 0, 5.5, '', NULL, 0, 423, 2.87, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:04:20', '190420-3', 113, 12300, 1, 'RE-98-528', '98528', 1, 'unidad', 4.5, 15, 3.8, '', NULL, 0, 423, 2.4, 3, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:04:20', '190420-3', 113, 12300, 2, 'RE-98-480', '98480', 1, 'unidad', 5.5, 2, 5.4, '', NULL, 0, 423, 2.87, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:06:24', '190624-5', 113, 12300, 1, 'GO-71-579', '71579', 2, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.25, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:16:00', '191600-3', 113, 12300, 1, 'COS-202-1132', '2021132', 1, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.58, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '19:20:16', '192016-8', 113, 12300, 1, 'RE-98-457', '98457', 1, 'unidad', 8, 15, 6.8, '', NULL, 0, 423, 4.2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:25:52', '192552-2', 113, 12300, 1, 'COS-101-201', '101201', 1, 'unidad', 9, 0, 9, '', NULL, 0, 423, 4.15, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:25:52', '192552-2', 113, 12300, 2, 'COS-201-1126', '2011126', 1, 'unidad', 2.5, 0, 2.5, '', NULL, 0, 423, 1.17, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '19:25:52', '192552-2', 113, 12300, 3, 'AN-30-262', '030262', 1, 'unidad', 3.5, 0, 3.5, '', NULL, 0, 423, 1.13, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:38:16', '193816-7', 113, 12300, 1, 'AR-51-322', '051322', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.1, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:38:16', '193816-7', 113, 12300, 2, 'AN-30-336', '30336', 1, 'unidad', 3.5, 0, 3.5, '', NULL, 0, 423, 0.93, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:41:00', '194100-2', 113, 12300, 1, 'VI-78-423', '078423', 1, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.52, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:41:00', '194100-2', 113, 12300, 2, 'MO-95-165', '95165', 1, 'unidad', 3.2, 0, 3.2, '', NULL, 0, 423, 1.26, 24, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:41:00', '194100-2', 113, 12300, 3, 'LL-93-464', '93464', 1, 'unidad', 3, 0, 3, '', NULL, 0, 423, 1.19, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:41:00', '194100-2', 113, 12300, 4, 'VI-78-197', '078197', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.34, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 1, 'RE-98-478', '98478', 1, 'unidad', 20.9, 25, 15.7, '', NULL, 0, 423, 11, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 2, 'GO-71-583', '71583', 1, 'unidad', 1, 25, 0.8, '', NULL, 0, 423, 0.52, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 3, 'GO-71-559', '071559', 1, 'blister x 12', 13.4, 25, 10.1, '', NULL, 0, 423, 5.18, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 4, 'RE-98-486', '98486', 1, 'unidad', 2.6, 25, 2, '', NULL, 0, 423, 1.28, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 5, 'VI-78-228', '078228', 2, 'unidad', 1.3, 25, 1, '', NULL, 0, 423, 0.58, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 6, 'BOL-62-135', '062135', 1, 'unidad', 0.7, 25, 0.5, '', NULL, 0, 423, 0.33, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '19:44:10', '194410-1', 113, 12300, 7, 'BI-290-1014', '2901014', 1, 'unidad', 24.9, 25, 18.7, '', NULL, 0, 423, 11, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '19:55:59', '195559-2', 113, 12300, 1, 'GO-71-578', '71578', 5, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.4, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:55:59', '195559-2', 113, 12300, 2, 'RE-98-514', '98514', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.32, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:57:34', '195734-3', 113, 12300, 1, 'BI-90-146', '090146', 1, 'unidad', 13.8, 0, 13.8, '', NULL, 0, 423, 7.8, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '19:59:42', '195942-3', 113, 12300, 1, 'CH-292-1035', '2921035', 1, 'unidad', 15.9, 0, 15.9, '', NULL, 0, 423, 8, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:01:48', '200148-5', 113, 12300, 1, 'AR-50-347', '050347', 1, 'blister', 1.4, 0, 1.4, '', NULL, 0, 423, 0.69, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:01:48', '200148-5', 113, 12300, 2, 'BR-79-431', '79431', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 0.98, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:01:48', '200148-5', 113, 12300, 3, 'COS-202-1202', '2021202', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:02:56', '200256-8', 113, 12300, 1, 'SAV-300-1013', '3001013', 1, 'unidad', 2.9, 0, 2.9, '', NULL, 0, 423, 1.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:02:56', '200256-8', 113, 12300, 2, 'VI-78-197', '078197', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.34, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:04:04', '200404-5', 113, 12300, 1, 'BI-90-224', '90224', 1, 'unidad', 17, 0, 17, '', NULL, 0, 423, 6.41, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:04:04', '200404-5', 113, 12300, 2, 'GO-71-531', '071531', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.64, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:04:55', '200455-7', 113, 12300, 1, 'BI-90-224', '90224', 1, 'unidad', 17, 0, 17, '', NULL, 0, 423, 6.41, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:04:55', '200455-7', 113, 12300, 2, 'PU-20-23-P', '02023P', 2, 'unidad', 0.4, 0, 0.4, '', NULL, 0, 423, 0.18, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:06:06', '200606-2', 113, 12300, 1, 'PEL-67-134', '67134', 2, 'unidad', 15, 15, 12.8, '', NULL, 0, 423, 6.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:06:06', '200606-2', 113, 12300, 2, 'PEL-267-1045', '2671045', 1, 'unidad', 19, 0, 19, '', NULL, 0, 423, 10, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:06:06', '200606-2', 113, 12300, 3, 'PEL-67-139', '67139', 1, 'unidad', 18, 0, 18, '', NULL, 0, 423, 7.39, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 1, 'BR-79-429', '79429', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.59, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 2, 'BR-79-430', '79430', 1, 'unidad', 2, 0, 2, '', NULL, 0, 423, 1.02, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 3, 'VI-78-435', '078435', 1, 'unidad', 2.2, 0, 2.2, '', NULL, 0, 423, 1.03, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 4, 'VI-78-440', '78440', 1, 'unidad', 2.5, 0, 2.5, '', NULL, 0, 423, 0.88, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 5, 'AR-50-345', '050345', 2, 'pack', 0.5, 0, 0.5, '', NULL, 0, 423, 0.09, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 6, 'AR-50-344', '050344', 1, 'pack', 0.5, 0, 0.5, '', NULL, 0, 423, 0.09, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 7, 'AR-50-345-1', '0503451', 1, 'pack', 0.5, 0, 0.5, '', NULL, 0, 423, 0.09, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 8, 'COS-202-1100', '2021100', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2.15, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:08:30', '200830-7', 113, 12300, 9, 'COS-202-1152', '2021152', 1, 'unidad', 7.9, 0, 7.9, '', NULL, 0, 423, 4, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:10:43', '201043-4', 113, 12300, 1, '8LLA-21-2', '0212', 3, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.87, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:10:43', '201043-4', 113, 12300, 2, 'COS-101-210', '101210', 2, 'unidad', 1.1, 0, 1.1, '', NULL, 0, 423, 0.51, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:10:43', '201043-4', 113, 12300, 3, 'VI-78-427', '078427', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.72, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:12:30', '201230-6', 113, 12300, 1, 'GUA-268-1003', '2681003', 1, 'unidad', 16.9, 0, 16.9, '', NULL, 0, 423, 10, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:12:30', '201230-6', 113, 12300, 2, 'RE-98-327', '098327', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 1.04, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:12:30', '201230-6', 113, 12300, 3, 'LL-93-463', '93463', 2, 'unidad', 3, 0, 3, '', NULL, 0, 423, 1.03, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:12:30', '201230-6', 113, 12300, 4, 'PU-27-328', '27328', 1, 'unidad', 9, 0, 9, '', NULL, 0, 423, 4, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:14:26', '201426-3', 113, 12300, 1, 'COS-101-202', '101202', 1, 'unidad', 3, 0, 3, '', NULL, 0, 423, 1.36, 10, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:14:26', '201426-3', 113, 12300, 2, 'COS-202-1029', '2021029', 1, 'unidad', 1.5, 0, 1.5, '', NULL, 0, 423, 0.75, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:14:26', '201426-3', 113, 12300, 3, 'RE-98-464', '98464', 1, 'unidad', 16, 0, 16, '', NULL, 0, 423, 8.2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, 1, 'AR-51-409', '051409', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.83, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, 2, 'AR-50-345-1', '0503451', 1, 'pack', 0.5, 0, 0.5, '', NULL, 0, 423, 0.09, 36, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, 3, 'COS-202-1132', '2021132', 2, 'unidad', 1, 0, 1, '', NULL, 0, 423, 0.58, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, 4, 'AR-51-618P', '51618P', 1, 'blister x 9', 3.6, 0, 3.6, '', NULL, 0, 423, 2, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:23:45', '202345-4', 113, 12300, 5, 'COS-202-1026', '2021026', 1, 'unidad', 0.6, 0, 0.6, '', NULL, 0, 423, 0.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:25:33', '202533-7', 113, 12300, 1, 'COS-202-1053', '2021053', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:25:33', '202533-7', 113, 12300, 2, 'PU-21-428', '021428', 1, 'unidad', 4.4, 0, 4.4, '', NULL, 0, 423, 1.29, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:25:33', '202533-7', 113, 12300, 3, 'COS-202-1055', '2021055', 1, 'unidad', 2.2, 0, 2.2, '', NULL, 0, 423, 1.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:25:33', '202533-7', 113, 12300, 4, 'AR-251-1002', '2511002', 1, 'unidad', 3.9, 0, 3.9, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:34:51', '203451-9', 113, 12300, 1, 'LL-293-1010', '2931010', 1, 'unidad', 5, 0, 5, '', NULL, 0, 423, 2.5, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:38:22', '203822-5', 113, 12300, 1, 'RE-98-330', '098330', 1, 'unidad', 1.6, 0, 1.6, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, 1, 'COS-201-1004', '2011004', 2, 'unidad', 1.3, 0, 1.3, '', NULL, 0, 423, 0.75, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, 2, 'COS-101-150', '0101150', 1, 'unidad', 0.8, 0, 0.8, '', NULL, 0, 423, 0.5, 1, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, 3, 'COS-201-1028', '2011028', 1, 'unidad', 2.3, 0, 2.3, '', NULL, 0, 423, 1.38, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, 4, 'COS-202-1643', '2021643', 1, 'unidad', 1.4, 0, 1.4, '', NULL, 0, 423, 0.63, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:43:07', '204307-7', 113, 12300, 5, 'COS-202-1019', '2021019', 1, 'unidad', 4.5, 0, 4.5, '', NULL, 0, 423, 2.67, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '20:59:35', '205935-9', 113, 12300, 1, 'COS-201-1005', '2011005', 1, 'unidad', 3.9, 20, 3.1, '', NULL, 0, 423, 2.33, 1, 'OK', 'NAC', 'X', 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 1, 'CO-15-480', '15480', 3, 'unidad', 2.5, 20, 2, '', NULL, 0, 423, 0.98, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 2, 'CO-14-243', '014243', 4, 'unidad', 9.6, 20, 7.7, '', NULL, 0, 423, 3.2, 1, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 3, 'AR-51-203', '051203', 3, 'unidad', 1, 20, 0.8, '', NULL, 0, 423, 1.15, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 4, 'AR-50-270-1', '0502701', 2, 'unidad', 1.2, 20, 1, '', NULL, 0, 423, 1.02, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 5, 'AR-50-262', '050262', 1, 'unidad', 2.8, 20, 2.2, '', NULL, 0, 423, 1.94, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 6, 'AR-50-859', '050859', 4, 'unidad', 2, 25, 1.5, '', NULL, 0, 423, 0.88, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 7, 'PIR-80-151', '80151', 3, 'unidad', 4, 25, 3, '', NULL, 0, 423, 1.29, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 8, 'AR-251-1002', '2511002', 1, 'unidad', 3.9, 25, 2.9, '', NULL, 0, 423, 2, 1, 'OK', 'NAC', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 9, 'AN-30-327N', '030327N', 3, 'unidad', 5, 25, 3.8, '', NULL, 0, 423, 1.99, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 10, 'RE-98-509', '98509', 5, 'unidad', 0.6, 25, 0.5, '', NULL, 0, 423, 0.32, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 11, 'RE-98-512', '98512', 3, 'unidad', 0.6, 25, 0.5, '', NULL, 0, 423, 0.32, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 12, 'RE-98-508', '98508', 2, 'unidad', 0.6, 25, 0.5, '', NULL, 0, 423, 0.32, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 13, 'BOL-62-135', '062135', 1, 'unidad', 0.7, 25, 0.5, '', NULL, 0, 423, 0.33, 12, 'OK', 'IMP', NULL, 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 14, 'RE-98-511', '98511', 1, 'unidad', 0.6, 25, 0.5, '', NULL, 0, 423, 0.32, 12, 'OK', 'IMP', 'X', 'X'),
('2019-02-12', '21:03:50', '210350-2', 113, 12300, 15, 'RE-98-330', '098330', 10, 'unidad', 1.6, 25, 1.2, '', NULL, 0, 423, 0.9, 1, 'OK', 'IMP', 'X', 'X');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientemay`
--
ALTER TABLE `clientemay`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `clientemin`
--
ALTER TABLE `clientemin`
  ADD PRIMARY KEY (`dni`);

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
-- Indices de la tabla `ticketventa`
--
ALTER TABLE `ticketventa`
  ADD PRIMARY KEY (`idticket`,`fecha`,`hora`,`idnegocio`,`idlocal`) USING BTREE;

--
-- Indices de la tabla `ticketventadetalle`
--
ALTER TABLE `ticketventadetalle`
  ADD PRIMARY KEY (`fecha`,`idticket`,`idnegocio`,`idlocal`,`hora`,`nroitem`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fact_cabecera`
--
ALTER TABLE `fact_cabecera`
  MODIFY `idComprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fact_detalle`
--
ALTER TABLE `fact_detalle`
  MODIFY `codItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
