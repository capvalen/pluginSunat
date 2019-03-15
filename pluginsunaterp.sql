-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2019 a las 03:08:51
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
  `cliDireccion` varchar(250) DEFAULT '',
  `factPlaca` varchar(15) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_detalle`
--

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_series`
--

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
  MODIFY `idComprobante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fact_detalle`
--
ALTER TABLE `fact_detalle`
  MODIFY `codItem` int(11) NOT NULL AUTO_INCREMENT;

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
