<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$sql = sprintf("delete from solicitud_despacho where id=%d AND estado = 'draft' ",
		(int)$_POST['id_despacho']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error anticipo\n$sql";	
		
	$sql = sprintf("delete from materiales where id_despacho=%d",
		(int)$_POST['id_despacho']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error anticipo\n$sql";		
	
	exit;
?>