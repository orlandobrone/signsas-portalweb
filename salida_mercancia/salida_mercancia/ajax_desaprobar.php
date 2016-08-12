<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	$sql ="UPDATE materiales SET aprobado = 0 WHERE id = '" . $_POST['IdMaterial'] . "'";
		
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	exit;
?>