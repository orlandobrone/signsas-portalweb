<?

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$sql = sprintf("UPDATE hitos SET ilimitado = 0 WHERE 1");

	if(!mysql_query($sql))
		echo "Error al actualizar el hito:\n$sql";

	exit;

?>