<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Documento sin título</title>
    </head>

    <body>
        <form name="formBC" method="post" action="" name="formBC">
            <input type="hidden" name="bandera" id="bandera"/>
            backup
            <input type="button" name="backup" id="backup" value="HACER BACKUP">
        </form>
    </body>
    <script type="text/javascript">
        function cambioEstado() {
            document.getElementById('bandera').value = "ok";
            document.formBC.submit();

        }
    </script>
</html>
<?php
if (isset($_REQUEST["bandera"])) {
    include ("../config/conexion.php");
    $AcutalizarEstado = pg_query($conexion, "UPDATE cuentas SET estado = 2");

    while ($resultEmpresa = pg_fetch_array($consultaEmpresa)) {
        $rnombre = $resultEmpresa[0];
        $rPeriodo = $resultEmpresa[1];
        $rNit = $resultEmpresa[2];
        $rCrn = $resultEmpresa[3];
    }
}
?>

