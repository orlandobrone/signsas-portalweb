<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$sql = sprintf("delete from po where id=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	$sql = sprintf("delete from items_po where id=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))	
		echo "Ocurrio un error\n$sql";
		
	exit;
?>