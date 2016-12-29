<?php
	$id=$_REQUEST["iddatos"];
	$num=$_REQUEST["num"];
?>
<?php
$per;
                            include("../config/conexion.php");
                           $query_s = pg_query($conexion, "select * from empresa ");
                            while ($fila = pg_fetch_array($query_s)) {
                                $per = $fila[2] ;
                               
                                 }
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
					document.getElementById('bandera').value="edit";
                    document.partidas.submit();

                }else{
                     swal("Revisar Cuentas", "Cargo y abono diferentes", "error");
                }
            }
			function validar(){
            	var bandera=true;
            	for (var i = 1; i <= 10; i++) {
            		if (document.getElementById('codigo'+i).value==''&&(document.getElementById('haber'+i).value!=''
            			||document.getElementById('haber'+i).value!='')) {
            			 swal("Campo vacio", "Ingrese el nombre de una cuenta", "error");
            			bandera=false;
            			break;
            		};            	
            		};
					if(document.getElementById('fecha').value.substring(0,4)!=document.getElementById('per').value){
						bandera=false;
						 swal("Error", "Ingrese una fecha valida", "error");
						 return;
						};
            		if (bandera&&document.getElementById('valor').value!='') {
            			procesar();
            		}else{
                        swal("Campo vacio", "Ingrese el valor", "error");
                    }
            }
        </script>
	<title>Modificar Partida</title>
</head>
<body>
<div class="container-fluid"><?php include"menu.php"; ?></div>

	 <div class="imagenFlotante">
        <a  name="add" id="add" data-toggle="modal" href="#fecha1" class="btn btn-primary">Procesar</a>
    </div>
	<div class="container">
      <form action="" method="post" name="partidas" id="partidas">
       <input type="hidden" name="per" id="per" value="<?php echo $per; ?>">
      <input type="hidden" name="bandera" id="bandera">
       <input type="hidden" name="baccion" id="baccion" value="<?php echo $id; ?>">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-tittle text-center">
				Partida <?php echo $num; ?>
			</h2>
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
								$cont++;
                            }
                            ?>
                            <?php
                            for($i=$cont;$i<=10;$i++){
								?>
								<div class="row">
<div class="col-md-6">
    <input type="text" name="codigo<?php echo $i ?>" id="codigo<?php echo $i ?>"  class="form-control"  placeholder="codigo..." list="listaCodigo" autocomplete="off">
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
    <input type="text" name="debe<?php echo $i ?>"  id="debe<?php echo $i ?>" class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" placeholder="0.00" >
    </div>
    <div class="col-md-3">
    <input type="text" name="haber<?php echo $i ?>"  class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" id="haber<?php echo $i ?>" placeholder="0.00"> 
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
	
<div id="fecha1" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="basicModal">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3>Fecha de la Transaccion <i class="fa fa-calendar" aria-hidden="true"></i></h3>
     </div>
     <div class="modal-body">
         <input type="date" name="fecha" id="fecha" class="form-control" required value="<?php echo date("Y-m-d"); ?>">              
    </div>
    <div class="modal-footer">
        <a onClick="validar()" class="btn btn-success">Guardar</a>
        <a href="#" data-dismiss="modal" class="btn">Cerrar</a>
    </div>
    </div>
    </div>
</div>
</form>
	 <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
  	if(isset($_REQUEST['fecha'])){
  	$fecha=$_REQUEST['fecha'];
    $valor=$_REQUEST['valor'];
    $bandera=$_REQUEST['bandera'];	
	 $baccion=$_REQUEST['baccion'];
	$debe;
	$haber;
	$codigo;
	
    for($i=0;$i<10;$i++){
    	if (isset($_POST['codigo'.($i+1)])&&$_POST['codigo'.($i+1)]!="") {
            $codigo[]=$_REQUEST['codigo'.($i+1)];
            
        }
        if (isset($_POST['debe'.($i+1)])&&$_POST['debe'.($i+1)]!="") {
            $debe[]=$_REQUEST['debe'.($i+1)];
            $haber[]=0;
            
        }
       if(isset($_POST['haber'.($i+1)])&&$_POST['haber'.($i+1)]!=""){
        	$haber[]=$_REQUEST['haber'.($i+1)];
        	$debe[]=0;
       
}
    }
	if($bandera=="edit"){
		
		pg_query("BEGIN");
			$result=pg_query($conexion,"delete from cuentas where idtransaccion='$baccion'");
			
			if(!$result){
				pg_query("rollback");
				}else{
					pg_query("commit");
					}
					$result=pg_query($conexion,"delete from transacciones where idtransaccion='$baccion'");
			if(!$result){
				pg_query("rollback");
				}else{
					pg_query("commit");
					
					}
  		 include("../config/conexion.php");
                            $result = pg_query($conexion, "insert into transacciones(idtransaccion,fecha, valor, numeroc) values('$baccion','$fecha', trim('$valor'), $num)");
                                                          
                            if(!$result){
				pg_query("rollback");
				echo "<script language='javascript'>";
				echo "swal('Uuuuuuyyyyiiii','Datos no almacenados', 'error');";
				echo "</script>";
				}else{
					pg_query("commit");
				
					}
                    $bandera1=true;       
   			for ($i=0; $i < sizeof($codigo); $i++) { 
   				$cod=cortar($codigo[$i]);
   				if ($debe[$i]!=0) {
   					 $result = pg_query($conexion, "insert into cuentas(codigo, idtransaccion, monto, c_a, estado) values('$cod','$baccion', $debe[$i], 1,1)");
   					 if(!$result){
				pg_query("rollback");
				$bandera1=false;
				echo "<script language='javascript'>";
				echo "swal('Uuuuuuyyyyiiii','Datos no almacenados', 'error');";
				echo "</script>";
				break;
				}else{
					pg_query("commit");
				
					}
   				}else{
   					if ($haber!=0) {
   						 $result = pg_query($conexion, "insert into cuentas(codigo, idtransaccion, monto, c_a, estado) values('$cod','$id', $haber[$i], 2, 1)");
   					 if(!$result){
				pg_query("rollback");
				$bandera1=false;
				echo "<script language='javascript'>";
				echo "swal('Uuuuuuyyyyiiii','Datos no almacenados', 'error');";
				echo "</script>";
				break;
				}else{
					pg_query("commit");
				
					}
   					}
   				}
   				
   			}
   			if ($bandera1) {
   				echo "<script language='javascript'>";
				echo "swal('Hey...','Datos Modificados', 'success');";
				echo "location.href='partidas.php';";
				echo "</script>";
   			}

	}

    }

    	 function cortar($palabra){

		$parte = explode(" ",$palabra); 

		return $parte[0];
    	}
  
?>