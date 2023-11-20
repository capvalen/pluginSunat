CREATE TABLE `facturador` (
 `idFacturador` int(11) NOT NULL AUTO_INCREMENT,
 `idComprobante` int(11) NOT NULL,
 `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0 falta enviar, 1 enviado',
 `factFecha` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`idFacturador`)
) ENGINE=MyISAM AUTO_INCREMENT=685 DEFAULT CHARSET=latin1