<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Libro Diario</title>

<style type="text/css">
td {
	text-align: center;
}
td {
	text-align: left;
}
#diario {
	font-size: 16px;
}
</style>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td width="177" rowspan="2"><img src="../imagenes/logo.png" width="180" height="88"></td>
    <td width="925" height="36">SISTEMA CONTABLE</td>
  </tr>
  <tr>
    <td>LIBRO DIARIO</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" height="97" border="0">

	<tr>
    <td scope="col"><b>FECHA</b>
      <hr></td>
    <td scope="col"><b>CUENTAS</b>
      <hr></td>
    <td scope="col"><b>DEBE</b>
      <hr></td>
    <td scope="col"><b>HABER</b>
      <hr></td>
  </tr>
  
	<?php 
			include("../config/conexion.php");
		 $cont=1;
		  $query_s = pg_query($conexion, "select * from transacciones order by idtransaccion");
                            while ($fila2 = pg_fetch_array($query_s)) {
								
  echo '<tr>
    <td scope="col"><b>'.$fila2[1].'</b></td>
    <td scope="col"><b>PARTIDA '.$cont++.'</b></td>
    <td scope="col"><b>&nbsp;</b></td>
    <td scope="col"><b>&nbsp;</b></td>
  </tr>';
  
  $query_2 = pg_query($conexion, "select cu.codigo, ca.nombre, cu.monto, cu.c_a FROM public.catalogo ca, public.cuentas cu, public.transacciones t WHERE t.idtransaccion='$fila2[0]' and cu.idtransaccion= t.idtransaccion and cu.codigo=ca.codigo");
                            	while ($fila3 = pg_fetch_array($query_2)) {
  
  echo '<tr>
    <td>&nbsp;</td>
    <td>'.$fila3[0].' '.$fila3[1].'</td>'
	?>
      <td>
      <?php if($fila3[3]==1){echo $fila3[2];}?>
      </td>
    <td>
      <?php if($fila3[3]==2){echo $fila3[2];}?>
    </td>
  </tr>
  <?php
								}
				echo '<tr>
				<td>&nbsp;</td>
					<td><h3> v/ '.$fila2[2].'</h3></td>
				</tr>';
							}
							?>
  
</table>
<p>&nbsp;</p>
</body>
</html>