<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Libro Diario</title>


</head>
<body>
<?php
include("../config/conexion.php");
$emp;
		  $query_s = pg_query($conexion, "select * from empresa where idempresa=1");
                            while ($fila = pg_fetch_array($query_s)) {
								$emp=$fila[1];
								}
?>
<table width="100%" border="0">
<tr>
  <td><div align="center">
    <table width="100%" border="0">
      <tr>
        <td width="177" rowspan="2"><img src="../imagenes/logo.png" width="180" height="88"></td>
        <td width="925" height="36"><div align="center">SISTEMA CONTABLE</div></td>
      </tr>
      <tr>
        <td><div align="center">EMPRESA <?php echo $emp; ?></div>
          <div align="center">LIBRO DIARIO</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
  </table>
  </div></td>
</tr>
</table>
<p>&nbsp;</p>
<table width="100%" height="97" border="0">

	<tr>
    <td width="9%" scope="col"><b>FECHA</b>
      <hr></td>
    <td width="55%" scope="col"><b>CUENTAS</b>
      <hr></td>
    <td width="18%" scope="col"><b>DEBE</b>
      <hr></td>
    <td width="18%" scope="col"><b>HABER</b>
      <hr></td>
  </tr>
  
	<?php 
			include("../config/conexion.php");
		  $query_s = pg_query($conexion, "select * from transacciones order by idtransaccion");
                            while ($fila2 = pg_fetch_array($query_s)) {
								
  echo '<tr>
    <td scope="col"><b>'.$fila2[1].'</b></td>
    <td scope="col"><b>PARTIDA '.$fila2[3].'</b></td>
    <td scope="col"><b>&nbsp;</b></td>
    <td scope="col"><b>&nbsp;</b></td>
	<td scope="col"><b>&nbsp;</b></td>
  </tr>';
  
  $query_2 = pg_query($conexion, "select cu.codigo, ca.nombre, cu.monto, cu.c_a FROM public.catalogo ca, public.cuentas cu, public.transacciones t WHERE t.idtransaccion='$fila2[0]' and cu.idtransaccion= t.idtransaccion and cu.codigo=ca.codigo");
                            	while ($fila3 = pg_fetch_array($query_2)) {
  ?>
  	<tr>
    <td>&nbsp;</td>
    <td><?php
    
		  echo $fila3[0].' - '.$fila3[1];
		 
	?></td>
	
        <td>
      <?php if($fila3[3]==1){
		  
		  echo $fila3[2];
		  
		  }
		  ?>
      </td>
    <td>
      <?php 
	  if($fila3[3]==2){
		
		  echo $fila3[2];
		  
		  }?>
    </td>
    <td width="0%">&nbsp;</td>
   
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