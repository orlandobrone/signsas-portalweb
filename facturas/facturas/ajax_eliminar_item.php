<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$sql = sprintf("delete from ingreso_mercancia where id=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	
	exit;
?>