<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$sql = sprintf("delete from anticipo where id=%d AND publicado = 'draft' ",
		(int)$_POST['id_anticipo']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error anticipo\n$sql";	
	
	exit;
?>