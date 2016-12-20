<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Document</title>
	 <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="../css/estilos.css" rel='stylesheet' type='text/css' />
        <link href="../css/font-awesome.min.css" rel="stylesheet"> 
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
</head>
<body>
<div class="container-fluid"><?php include"menu.php"; ?></div>
		<div class="container">
		
		<div class="panel-group" id="acordion" role="tablist">
			<?php
		 include("../config/conexion.php");
		 $cont=1;
		  $query_s = pg_query($conexion, "select * from transacciones order by idtransaccion");
                            while ($fila = pg_fetch_array($query_s)) {
                             
                            
                                ?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading<?php echo $cont; ?>">
										<h4 class="panel-tittle"><a href="#collapse<?php echo $cont; ?>" data-toggle="collapse" data-parent="#acordion">
											Partida <?php echo $cont; ?>
										</a></h4>
									</div>
									<div id="collapse<?php echo $cont; ?>" class="panel-collapse collapse">
										<div class="panel-body">
											<?php
											 $query_2 = pg_query($conexion, "select cu.codigo, ca.nombre, cu.monto, cu.c_a FROM public.catalogo ca, public.cuentas cu, public.transacciones t WHERE t.idtransaccion='$fila[0]' and cu.idtransaccion= t.idtransaccion and cu.codigo=ca.codigo");
											 while ($fila2 = pg_fetch_array($query_2)) {
											 	if ($fila2[3]==2) {
											 		
											?>
											<?php echo " &nbsp; &nbsp;".$fila2[0]." - ".$fila2[1]."-".$fila2[2]."<br>"; ?>
											<?php
										}else{
											echo $fila2[0]." - ".$fila2[1]."-".$fila2[2]."<br>";
										}
											}
											
											?>

										</div>
										<div class="panel-footer">
											<?php echo $fila[2]; ?>
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