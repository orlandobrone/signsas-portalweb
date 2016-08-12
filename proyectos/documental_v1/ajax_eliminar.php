<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	$sql = sprintf("UPDATE documental SET estado = 1 WHERE id=%d;",
		((int)$_REQUEST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al eliminar el documento:\n$sql";
	
	exit;
?>