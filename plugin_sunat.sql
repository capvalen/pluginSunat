-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-02-2019 a las 18:55:09
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
  `sumDescTotal` varchar(4) DEFAULT '0.00',
  `sumOtrosCargos` int(11) DEFAULT '0',
  `sumTotalAnticipos` int(11) DEFAULT '0',
  `sumImpVenta` int(11) NOT NULL COMMENT 'El mismo campo de totalFinal',
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
  `comprobanteFechado` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_cabecera`
--

INSERT INTO `fact_cabecera` (`idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`) VALUES
(1, 113, 12300, '105', 1, 'F001', 00000003, '0101', '2018-09-06', '17:05:16', '-', '000', 6, '15601863640', 'DUQUE TORRES HEIDY JULIANA', 'PEN', 1.8, 10, 11.8, '0.00', 0, 0, 0, '2.1', '2.0', 1000, 'IGV', 'VAT', 10, 1.8, 1000, 'ONCE SOLES 80/100 MN', 1, '2019-02-15 11:08:26'),
(2, 113, 12300, '103420-8', 3, 'B001', 00000001, '0101', '2019-02-14', '15:44:15', '-', '000', 0, '00000000', 'CLIENTE SIN DOCUMENTO', 'PEN', 6.36, 1.14, 7.5, '0.00', 0, 0, 8, '2.1', '2.0', 1000, 'IGV', 'VAT', 6.36, 1.14, 1000, 'SIETE SOLES 50/100 MN', 1, '2019-02-15 11:07:18');

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
  `mtoValorReferencialUnitario` varchar(4) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fact_detalle`
--

INSERT INTO `fact_detalle` (`codItem`, `idNegocio`, `idLocal`, `idTicket`, `codUnidadMedida`, `cantidadItem`, `codProductoSUNAT`, `codProducto`, `descripcionItem`, `valorUnitario`, `igvUnitario`, `codTriIGV`, `mtoIgvItem`, `valorItem`, `nomTributoIgvItem`, `codTipTributoIgvItem`, `tipAfeIGV`, `porIgvItem`, `codTriISC`, `mtoIscItem`, `mtoBaseIscItem`, `nomTributoIscItem`, `codTipTributoIscItem`, `tipSisISC`, `porIscItem`, `codTriOtroItem`, `mtoTriOtroItem`, `mtoBaseTriOtroItem`, `nomTributoIOtroItem`, `codTipTributoIOtroItem`, `porTriOtroItem`, `mtoPrecioVenta`, `mtoValorVenta`, `mtoValorReferencialUnitario`) VALUES
(1, 113, 12300, '105', 'UND', 2, '-', '0', 'PRODUCTO GENERICO GRABADO', 5, 1.8, 1000, 0, 10, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 11.8, 10, '0.00'),
(2, 113, 12300, '103420-8', 'UND', 1, '-', 'COS-202-1202', 'PRODUCTO COS 1202', 1.19, 0.21, 1000, 0.21, 1.19, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.4, 1.19, '0.00'),
(3, 113, 12300, '103420-8', 'UND', 1, '-', 'COS-201-1126', 'PRODUCTO COS 1126', 2.12, 0.38, 1000, 0.38, 2.12, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2.5, 2.12, '0.00'),
(4, 113, 12300, '103420-8', 'UND', 1, '-', 'CO-15-483', 'PRODUCTO CO-15-483', 1.69, 0.31, 1000, 0.31, 1.69, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 2, 1.69, '0.00'),
(5, 113, 12300, '103420-8', 'UND', 1, '-', 'AR-51-610', 'PRODUCTO AR-51-610', 1.36, 0.24, 1000, 0.24, 1.36, 'IGV', 'VAT', 10, 18, '-', 0, 0, '', '', '', 15, '-', '', '', '', '', 15, 1.6, 1.36, '0.00');

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

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fact_cabecera`
--
ALTER TABLE `fact_cabecera`
  MODIFY `idComprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fact_detalle`
--
ALTER TABLE `fact_detalle`
  MODIFY `codItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
