<?
	include "../../conexion.php";
	include "../extras/php/basico.php";	
	
	$sql = sprintf("DELETE FROM ingreso_mercancia WHERE id=%d",
		(int)$_POST['id_ingreso']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	
	exit;
?>