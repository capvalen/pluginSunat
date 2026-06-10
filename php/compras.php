<?php
include __DIR__.'/conexion.php';
date_default_timezone_set('America/Lima');

$action = $_POST['action'] ?? '';

switch ($action) {

    /* ========== OBTENER ========== */
    case 'obtener':
        $idCompra = (int)$_POST['idCompra'];
        $sql = "SELECT c.*, cli.cliRuc, cli.cliRazonSocial, cli.cliDomicilio,
                       co.compDescripcion, m.monSimbolo
                FROM compras c
                INNER JOIN clientes cli ON cli.idCliente = c.idProveedor
                INNER JOIN comprobante co ON co.idComprobante = c.idComprobante
                INNER JOIN moneda m ON m.idMoneda = c.idMoneda
                WHERE c.idCompra = $idCompra";
        $resultado = $cadena->query($sql);
        $cabecera = $resultado->fetch_assoc();

        $sqlDet = "SELECT cd.*, p.prodDescripcion, u.undDescipcion, u.undSunat, u.undCorto,
                          g.gravDescripcion
                   FROM compras_detalle cd
                   INNER JOIN productos p ON p.idProductos = cd.idProducto
                   INNER JOIN unidades u ON u.idUnidad = cd.idUnidad
                   INNER JOIN gravados g ON g.idGravado = cd.idGravado
                   WHERE cd.idCompra = $idCompra";
        $resultadoDet = $cadena->query($sqlDet);
        $detalle = [];
        while ($row = $resultadoDet->fetch_assoc()) {
            $detalle[] = $row;
        }
        echo json_encode(['cabecera' => $cabecera, 'detalle' => $detalle]);
        break;

    /* ========== ACTUALIZAR ========== */
    case 'update':
        $idCompra = (int)$_POST['idCompra'];
        $idComprobante = (int)$_POST['idComprobante'];
        $compFecha = $_POST['compFecha'];
        $serie = $_POST['serie'];
        $idMoneda = (int)$_POST['idMoneda'];
        $monedaCambio = (float)($_POST['monedaCambio'] ?? 0);
        $compObs = $_POST['compObs'];
        $sumExonerado = (float)$_POST['sumExonerado'];
        $sumSubtotal = (float)$_POST['sumSubtotal'];
        $sumIgv = (float)$_POST['sumIgv'];
        $sumTotal = (float)$_POST['sumTotal'];
        $ruc = $_POST['ruc'];
        $razonSocial = $_POST['razonSocial'];
        $domicilio = $_POST['domicilio'];
        $productos = $_POST['jsonProductos'];

        $sqlEProveedor = "SELECT * FROM clientes WHERE cliRuc = '$ruc' AND esProveedor = 1";
        $resultadoEProveedor = $cadena->query($sqlEProveedor);
        if ($resultadoEProveedor->num_rows >= 1) {
            $rowEProveedor = $resultadoEProveedor->fetch_assoc();
            $idProveedor = $rowEProveedor['idCliente'];
        } else {
            $sqlInsProveedor = "INSERT INTO clientes (idCliente, cliRuc, cliRazonSocial, cliComercial, cliDomicilio, cliTelefono, cliActivo, esProveedor)
                                VALUES (null, '$ruc', '$razonSocial', '', '$domicilio', '', 1, 1)";
            $esclavo->query($sqlInsProveedor);
            $idProveedor = $esclavo->insert_id;
        }

        $sql = "UPDATE compras SET
                    idComprobante = $idComprobante,
                    compFecha = '$compFecha',
                    compSerie = '$serie',
                    idMoneda = $idMoneda,
                    compCambioMoneda = $monedaCambio,
                    idProveedor = $idProveedor,
                    comObs = '$compObs',
                    compExonerado = $sumExonerado,
                    compSubTotal = $sumSubtotal,
                    compIgv = $sumIgv,
                    compTotal = $sumTotal,
                    editado = NOW()
                WHERE idCompra = $idCompra";
        $cadena->query($sql);

        $cadena->query("DELETE FROM compras_detalle WHERE idCompra = $idCompra");

        $sqlProd = '';
        for ($i = 0; $i < count($productos); $i++) {
            $idProd = (int)$productos[$i]['idProd'];
            $cantidad = (float)$productos[$i]['cantidad'];
            $precUnit = (float)$productos[$i]['precUnit'];
            $afecto = (int)$productos[$i]['afecto'];
            $unidad = $productos[$i]['unidad'];
            $subTotal = $cantidad * $precUnit;

            $sqlProd .= "INSERT INTO compras_detalle (idCompra, idProducto, comdCantidad, comdPrecioUnit, comdSubTotal, idGravado, idUnidad, editado)
                         SELECT $idCompra, $idProd, $cantidad, $precUnit, $subTotal, $afecto, u.idUnidad, NOW()
                         FROM unidades u WHERE undSunat = '$unidad' AND undActivo = 1;";
        }
        $cadena->multi_query($sqlProd);
        echo 'ok';
        break;

    /* ========== ELIMINAR ========== */
    case 'borrar':
        $idCompra = (int)$_POST['idCompra'];
        $sql = "UPDATE compras SET compActivo = 0 WHERE idCompra = $idCompra";
        echo $cadena->query($sql) ? 'ok' : 'Error al eliminar';
        break;

    default:
        echo 'Accion no valida';
        break;
}
