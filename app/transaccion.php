<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Transacciones</title>
        <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="../css/estilos.css" rel='stylesheet' type='text/css' />
        <link href="../css/font-awesome.min.css" rel="stylesheet"> 
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
        <script language="javascript">        
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
            		if (bandera&&document.getElementById('valor').value!='') {
            			procesar();
            		}else{
                        swal("Campo vacio", "Ingrese el valor", "error");
                    }
            }
        </script>
    </head>

    <body>
    <?php include"menu.php"; ?>
   <form action="" method="post" name="partidas" id="partidas">
    <div class="imagenFlotante">
        <a  name="add" id="add" data-toggle="modal" href="#fecha1" class="btn btn-primary">Procesar</a>
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
   
        <div class="container">
      
            <div class="row">

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading text-center"><h1>Partida <?php
                            include("../config/conexion.php");
                           $query_s = pg_query($conexion, "select count(idtransaccion) from transacciones ");
                            while ($fila = pg_fetch_array($query_s)) {
                                $num = $fila[0] + 1;
                                echo " $num";
                                 }
                            ?></h1></div>
                        <div class="panel-body" id="partida"> 
                           
                            <div class="row">
                                <div class="col-md-6">Cuenta</div>
                                <div class="col-md-3">Debe</div>
                                <div class="col-md-3">Haber</div>
                            </div>
                            
                                <?php include"fila.php"; ?>
                        </div>
                        <div class="panel-footer">
				        <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor..." required>
                        </div>
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
  		 include("../config/conexion.php");
                            $result = pg_query($conexion, "insert into transacciones(fecha, valor) values('$fecha', trim('$valor'))");
                                                          
                            if(!$result){
				pg_query("rollback");
				echo "<script language='javascript'>";
				echo "swal('Uuuuuuyyyyiiii','Datos no almacenados', 'error');";
				echo "</script>";
				}else{
					pg_query("commit");
				
					}
					$id;
   					 $query_s = pg_query($conexion, "select idtransaccion from transacciones order by idtransaccion desc limit 1");
                            while ($fila = pg_fetch_array($query_s)) {
							$id=$fila[0];
                            }
                            $bandera=true;
   			for ($i=0; $i < sizeof($codigo); $i++) { 
   				$cod=cortar($codigo[$i]);
   				if ($debe[$i]!=0) {
   					 $result = pg_query($conexion, "insert into cuentas(codigo, idtransaccion, monto, c_a) values('$cod','$id', $debe[$i], 1)");
   					 if(!$result){
				pg_query("rollback");
				$bandera=false;
				echo "<script language='javascript'>";
				echo "swal('Uuuuuuyyyyiiii','Datos no almacenados', 'error');";
				echo "</script>";
				break;
				}else{
					pg_query("commit");
				
					}
   				}else{
   					if ($haber!=0) {
   						 $result = pg_query($conexion, "insert into cuentas(codigo, idtransaccion, monto, c_a) values('$cod','$id', $haber[$i], 2)");
   					 if(!$result){
				pg_query("rollback");
				$bandera=false;
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
   			if ($bandera) {
   				echo "<script language='javascript'>";
				echo "swal('Hey...','Datos Almacenados', 'success');";
				//echo "location.href='transaccion.php';";
				echo "</script>";
   			}



    }

    	 function cortar($palabra){

		$parte = explode(" ",$palabra); 

		return $parte[0];
    	}
  
?>