<?php
	for ($i=0; $i < 10; $i++) { 
		?>
			<div class="row">
<div class="col-md-6">
    <input type="text" name="codigo<?php echo $i+1 ?>" id="codigo<?php echo $i+1 ?>" class="form-control"  placeholder="codigo..." list="listaCodigo" autocomplete="off">
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
    <input type="text" name="debe<?php echo $i+1 ?>" id="debe<?php echo $i+1 ?>" class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" placeholder="0.00" >
    </div>
    <div class="col-md-3">
    <input type="text" name="haber<?php echo $i+1 ?>" class="form-control" onKeyPress="anular(event,this)" onClick="anular2(this)" id="haber<?php echo $i+1 ?>" placeholder="0.00"> 
</div>
</div>
<br>
		<?php
	}
?>