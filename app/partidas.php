<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Partidas</title>
	 <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="../css/estilos.css" rel='stylesheet' type='text/css' />
        <link href="../css/font-awesome.min.css" rel="stylesheet"> 
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

        <script>
        		function llamarPaginaModificar(id,cont){
				window.open("modpartida.php?iddatos="+id+"&num="+cont, '_parent');
			}

			function alertaEliminar(id){
					swal({title: "Cuidado?", text: "Desea Eliminar este registro!", type: "warning", showCancelButton: true, confirmButtonColor: "·DD6B55", confirmButtonText: "Si, Eliminar", closeOnConfirm: false}, function(){
						document.getElementById('bandera').value="borrar";
						document.getElementById('baccion').value=id;
						document.frmpartidas.submit();
						}
						);
					}
        </script>
</head>
<body>
<div class="container-fluid"><?php include"menu.php"; ?></div>
		<div class="container">
		<form action="" method="post" name="frmpartidas" id="frmpartidas">
			<input type="hidden" name="bandera" id="bandera"/>
                <input type="hidden" name="baccion" id="baccion" value="<?php echo $iddatos; ?>"/>
		</form>
		<div class="panel-group" id="acordion" role="tablist">
			<?php
		 include("../config/conexion.php");
		 $cont=1;
		  $query_s = pg_query($conexion, "select DISTINCT(t.idtransaccion), t.fecha, t.valor, t.numeroc  from transacciones as t, cuentas where cuentas.estado=1 and cuentas.idtransaccion=t.idtransaccion order by t.idtransaccion");
                            while ($fila = pg_fetch_array($query_s)) {
                             
                            
                                ?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading<?php echo $cont; ?>">
										<h4 class="panel-tittle">
										<a href="#collapse<?php echo $cont; ?>" data-toggle="collapse" data-parent="#acordion">
											Partida <?php echo $fila[3]; ?>
										</a>
										<div class="text-right">
										<a class="btn btn-warning" onClick="llamarPaginaModificar('<?php echo $fila[0]; ?>',<?php echo $cont; ?>)">Modificar</a>
										<a class="btn btn-danger" onClick="alertaEliminar('<?php echo $fila[0]; ?>')">Eliminar</a>
										</div>
										</h4>
									</div>
									<div id="collapse<?php echo $cont; ?>" class="panel-collapse collapse">
										<div class="panel-body">
										<div class="col-md-6 text-left"><b>CUENTAS</b></div><div class="col-md-3  text-right"><b>DEBE</b></div><div class="col-md-3  text-right"><b>HABER</b></div>
											<?php
											 $query_2 = pg_query($conexion, "select cu.codigo, ca.nombre, cu.monto, cu.c_a FROM public.catalogo ca, public.cuentas cu, public.transacciones t WHERE t.idtransaccion='$fila[0]' and cu.idtransaccion= t.idtransaccion and cu.codigo=ca.codigo and cu.estado=1");
											 while ($fila2 = pg_fetch_array($query_2)) {
											 	if ($fila2[3]==2) {
											 		
											?>
											<div class="row">
											<?php echo "<div class='col-md-6 text-left'>&nbsp;&nbsp;&nbsp;&nbsp;".$fila2[0]." - ".$fila2[1]."</div><div class='col-md-3 text-right'></div><div class='col-md-3 text-right'>".$fila2[2]."</div>"; ?>
											</div>

											<?php
										}else{
											echo "<div class='row'>";
											echo "<div class='col-md-6 text-left'>".$fila2[0]." - ".$fila2[1]."</div><div class='col-md-3  text-right'>".$fila2[2]."</div><div class='col-md-3  text-right'></div>"; 
											echo "</div>";
										}
											}
											
											?>

										</div>
										<div class="panel-footer">
											<b>v/ </b> <?php echo $fila[2]; ?>
										</div>
									</div>
								</div>
                                <?php	
                                $cont+=1;
                             
                                
                            }
		 
	?>

	</div>
</div>
	 <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
if(isset($_REQUEST["bandera"])){
$bandera=$_REQUEST["bandera"];
$baccion=$_REQUEST["baccion"];

include("../config/conexion.php");

if($bandera=="borrar"){
		pg_query("BEGIN");
			$result=pg_query($conexion,"delete from cuentas where idtransaccion='$baccion'");
			
			if(!$result){
				pg_query("rollback");
				echo "<script language='javascript'>";
				echo "alertaError('Uuuuuuyyyyiiii','Datos no eliminados', 'error');";
				echo "</script>";
				}else{
					pg_query("commit");
					
					}
					$result=pg_query($conexion,"delete from transacciones where idtransaccion='$baccion'");
			
			if(!$result){
				pg_query("rollback");
				echo "<script language='javascript'>";
				echo "alertaError('Uuuuuuyyyyiiii','Datos no eliminados', 'error');";
				echo "</script>";
				}else{
					pg_query("commit");
					
					}
					echo "<script language='javascript'>";
				echo "location.href='partidas.php';";
				echo "</script>";
					
	}
}
?>