<?php
	$id=$_REQUEST["iddatos"];
	$num=$_REQUEST["num"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="../css/estilos.css" rel='stylesheet' type='text/css' />
        <link href="../css/font-awesome.min.css" rel="stylesheet"> 
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
        <script type="text/javascript">
        		function anular(event, input) {
				for (var i = 1; i <= 10; i++) {
					
				
				if(input.name=='debe'+i){
					var debe = input.id;
					
					var res = debe.slice(4,5);
					break;
					
				}else{
					if(input.name=='haber'+i){
					var haber = input.id;
					var res = haber.slice(5,6);
					break;
				}
					}
					};
                if (input.id == 'debe'+res) {
                    document.getElementById('haber'+res).readOnly = true;
                 
                }
                if (input.id == 'haber'+res) {
                    document.getElementById('debe'+res).readOnly = true;
                   
                }
            }
            function anular2(input) {
            	for (var i = 1; i <=10; i++) {
            		

					if(input.name=='debe'+i){
					var debe = input.id;
					var res = debe.slice(4,5);
				}else{
					if(input.name=='haber'+i){
					var haber = input.id;
					var res = haber.slice(5,6);
				}
					}
						};
                if (input.id == 'debe'+res) {
                    if (document.getElementById('haber'+res).value == "") {
                        document.getElementById('debe'+res).readOnly = false;
                       
                    }
                }
                if (input.id == 'haber'+res) {
                    if (document.getElementById('debe'+res).value == "") {
                        document.getElementById('haber'+res).readOnly = false;
                       
                    }
                }
            }
            function sumarDebe() {
                var total=0;
                for (var i = 1; i <=10; i++) {
                    if (document.getElementById('debe'+i).value!="") {
                    total+=parseFloat(document.getElementById('debe'+i).value);
                	}
                }
                
                return total;
            }
            function sumarHaber() {
               var total=0;
                for (var i = 1; i <=10; i++) {
                    if (document.getElementById('haber'+i).value!="") {
                    total+=parseFloat(document.getElementById('haber'+i).value);
                }
                }
                return total;
            }
            function procesar() {
                var debe = sumarDebe();
                var haber = sumarHaber();
                if(debe-haber==0){
                    document.partidas.submit();

                }else{
                     swal("Revisar Cuentas", "Cargo y abono diferentes", "error");
                }
            }
        </script>
	<title>Modificar Partida</title>
</head>
<body>
<div class="container-fluid"><?php include"menu.php"; ?></div>
<form method="post" action="" name="frmod" id="frmod">
	<div class="imagenFlotante">
        <a  name="add" id="add" data-toggle="modal" href="#fecha1" class="btn btn-warning">Procesar</a>
    </div>
	<div class="container">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-tittle">
				Partida <?php echo $num; ?>
			</h4>
		</div>
		<br>
		<div class="panel-body">
			<?php 
			include("../config/conexion.php");
		 $cont=1;
		  $query_s = pg_query($conexion, "select * from transacciones where idtransaccion='$id' order by idtransaccion");
                            while ($fila2 = pg_fetch_array($query_s)) {
                            	$query_2 = pg_query($conexion, "select cu.codigo, ca.nombre, cu.monto, cu.c_a FROM public.catalogo ca, public.cuentas cu, public.transacciones t WHERE t.idtransaccion='$fila2[0]' and cu.idtransaccion= t.idtransaccion and cu.codigo=ca.codigo");
                            	while ($fila3 = pg_fetch_array($query_2)) {
                            	?>
						<div class="row">
<div class="col-md-6">
    <input type="text" name="codigo<?php echo $cont ?>" id="codigo<?php echo $cont ?>" value="<?php echo $fila3[0]." ".$fila3[1]; ?>" class="form-control"  placeholder="codigo..." list="listaCodigo" autocomplete="off">
    <datalist id="listaCodigo">
                <?php
                include("../config/conexion.php");
				$query_s=pg_query($conexion,"select * from catalogo order by codigo");
				while($fila=pg_fetch_array($query_s)){
					echo " <option value='$fila[1] - $fila[0]'>";
					}
				?>

    </datalist>
</div>
<div class="col-md-3">
    <input type="text" name="debe<?php echo $cont ?>" value="<?php if($fila3[3]==1){echo $fila3[2];} ?>"  id="debe<?php echo $cont ?>" class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" placeholder="0.00" >
    </div>
    <div class="col-md-3">
    <input type="text" name="haber<?php echo $cont ?>" value="<?php if($fila3[3]==2){echo $fila3[2];} ?>" class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" id="haber<?php echo $cont ?>" placeholder="0.00"> 
</div>
</div>
<br>
                            	<?php
                            }
                            ?>
                            </div>
							<div class="panel-footer">
								<input type="text" name="valor" id="valor" class="form-control" value="<?php echo $fila2[2]; ?>" placeholder="Valor..." required>
							</div>
                            <?php
                            }
		?>

		
		

		</div>

	</div>
	

</form>
	 <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
</body>
</html>