<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
		
	echo $sql = sprintf("UPDATE `proyectos` SET estado = 'ELIMINADO' WHERE id=%d",
		(int)$_POST['id']
	);	
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		 
	$sql = sprintf("UPDATE `orden_trabajo` SET estado = 1 WHERE id_proyecto=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	
	
	exit;
?>