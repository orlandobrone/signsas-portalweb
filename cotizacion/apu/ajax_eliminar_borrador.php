<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$sql = sprintf("delete from anticipo where id=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error anticipo\n$sql";
		
	
	$sql = sprintf("delete from legalizacion where id_anticipo=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error legalizacion\n$sql";	
		
		
	$sql = sprintf("delete from items_anticipo where id_anticipo=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error Items Anticipo\n$sql";		
		
	exit;
?>