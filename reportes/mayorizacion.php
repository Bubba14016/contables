<?php
include ("../config/conexion.php");
$consultaEmpresa = pg_query($conexion, "SELECT"
        . " empresa.nombre,empresa.periodo,empresa.nit,empresa.crn "
        . "FROM empresa "
        . "WHERE idempresa = 1 ");

while ($resultEmpresa = pg_fetch_array($consultaEmpresa)) {
    $rnombre = $resultEmpresa[0];
    $rPeriodo = $resultEmpresa[1];
    $rNit = $resultEmpresa[2];
    $rCrn = $resultEmpresa[3];
}
?>


<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Mayorizacion</title>
    </head>

    <body>
        <form name="form1" method="post" action="">
            <table width="%100" border="0" >
                <tr>
                    <td width="127" rowspan="3"><img src="../imagenes/unnamed.png" width="100" height="125"></td>
                    <td width="910" align="center"><h1><b>EMPRESA: <?php echo $rnombre; ?></b></h1></td>
                </tr>
                <tr>
                    <td height="28" align="center"><h2><b>LIBRO MAYOR DEL PERIODO <?php echo $rPeriodo; ?> </b></h2></td>
                </tr>
                <tr>
                    <td height="46" align="center"><h3><b>CON NIT: <?php echo $rNit . " "; ?> Y CRN <?php echo $rCrn; ?> </b></h3></td>
                </tr>
                <?php
                include ("../config/conexion.php");
                $consultaCuentaMayor = pg_query($conexion, "SELECT nombre,codigo,tiposaldo FROM catalogo WHERE length(catalogo.codigo) = 4 ORDER BY codigo");
                while ($resulCuentaMayor = pg_fetch_array($consultaCuentaMayor)) {
                    $codigoCuenta = $resulCuentaMayor[1];
                    ?>
                </table>

                <p ><?php
                    if ($resulCuentaMayor[2] == 0) {
                        $TipoSaldo = " (CUENTA ACREEDORA)";
                    } else {
                        $TipoSaldo = " (CUENTA DUEDORA)";
                    }
                    echo "<b>$resulCuentaMayor[0] $TipoSaldo </b> ";
                    ?> </p>
                <table width="100%" border="1" rules = "all">
                    <tr>
                        <th width="141" align="center">FECHA </th>
                        <th width="140" align="center">CODIGO</th>
                        <th width="237" align="center"><p>DESCRIPCION</p></th>
                    <th width="40" align="center"><p>N-C</p></th>
                    <th width="148" align="center">DEBE</th>
                    <th width="148" align="center">HABER </th>
                    <th width="117" align="center">SALDO</th>
                    </tr>
                    <?php
                    include ("../config/conexion.php");
                    $saldo = 0;
                    $cargo_Abono;
                    $consultaTransaccion = pg_query($conexion, "SELECT
                    transacciones.fecha,catalogo.codigo,transacciones.valor,transacciones.numeroc,
                    cuentas.monto,cuentas.c_a,empresa.idempresa,cuentas.estado,catalogo.tiposaldo
                    FROM catalogo
                    INNER JOIN cuentas ON cuentas.codigo = catalogo.codigo
                    INNER JOIN transacciones ON cuentas.idtransaccion = transacciones.idtransaccion
                    INNER JOIN empresa ON catalogo.idempresa = empresa.idempresa
                    WHERE estado = 1 and catalogo.idempresa = 1 
                    AND cuentas.codigo LIKE '$codigoCuenta%' ORDER BY catalogo.tiposaldo");

                    while ($resulTransaccion = pg_fetch_array($consultaTransaccion)) {

                        if ($resulTransaccion[8] == 0) {
                            if ($resulTransaccion[5] == 2) {
                                $saldo -= $resulTransaccion[4];
                            } else {
                                $saldo += $resulTransaccion[4];
                            }
                        }


                        if ($resulTransaccion[8] == 1) {
                            if ($resulTransaccion[5] == 1) {
                                $saldo -= $resulTransaccion[4];
                            } else {
                                $saldo += $resulTransaccion[4];
                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo $resulTransaccion[0]; ?></td>
                            <td>&nbsp;<?php echo $resulTransaccion[1]; ?></td>
                            <td>&nbsp;<?php echo $resulTransaccion[2]; ?></td>
                            <td align="center">&nbsp;<?php echo $resulTransaccion[3]; ?></td>
                            <?php
                            if ($resulTransaccion[5] == '1') {
                                $cargo_Abono = '1';
                                ?>   
                                <td align="right">&nbsp;<?php echo "$ " . $resulTransaccion[4]; ?></td>
                            <?php } else { ?>
                                <td  align="center">&nbsp;<?php echo "----------"; ?></td>
                            <?php } ?>


                            <?php
                            if ($resulTransaccion[5] == '2') {
                                $cargo_Abono = '2';
                                ?>   
                                <td align="right">&nbsp;<?php echo "$ " . $resulTransaccion[4]; ?></td>
                            <?php } else { ?>
                                <td width="17" align="center">&nbsp;<?php echo "----------"; ?></td>
                            <?php } ?>


                            <td width="1" align="right">&nbsp;<?php echo $saldo ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" align="center"><strong>TOTAL</strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <?php
                        include ("../config/conexion.php");
                        $consultaTotal = pg_query($conexion, "SELECT
                            Sum(cuentas.monto)
                            FROM cuentas
                            INNER JOIN catalogo ON cuentas.codigo = catalogo.codigo
                            WHERE catalogo.idempresa = 1 AND cuentas.estado =1 
                            AND cuentas.c_a = 1
                            AND catalogo.codigo LIKE '$codigoCuenta%' ");

                        while ($resultTotal = pg_fetch_array($consultaTotal)) {
                            ?>    
                            <td align="right"><strong>&nbsp;<?php echo "$ " . (0 + $resultTotal[0]); ?></strong></td>
                        <?php } ?>

                        <?php
                        include ("../config/conexion.php");
                        $consultaTotal = pg_query($conexion, "SELECT
                            Sum(cuentas.monto)
                            FROM cuentas
                            INNER JOIN catalogo ON cuentas.codigo = catalogo.codigo
                            WHERE catalogo.idempresa = 1 AND cuentas.estado =1 
                            AND cuentas.c_a = 2
                            AND catalogo.codigo LIKE '$codigoCuenta%' ");

                        while ($resultTotal = pg_fetch_array($consultaTotal)) {
                            ?>    
                            <td align="right"><strong>&nbsp;<?php echo "$ " . (0 + $resultTotal[0]); ?></strong></td>
                        <?php } ?>


                        <td>&nbsp;</td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </body>
</html>