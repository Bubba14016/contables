<?php
$server="localhost";
$puerto="5432";
$database="contables";
$usuario="postgres";
$clave="root";

$conexion=pg_connect("host=$server port=$puerto dbname=$database user=$usuario password=$clave");
if(!$conexion){
	echo"Error de conexion a la Base de Datos";
	exit;
	}
?>