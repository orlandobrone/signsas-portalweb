<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	$sql = sprintf("delete from opciones_perfiles where id_perfil=%d",
		(int)$_POST['id']
	);

	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	

	$sql = sprintf("UPDATE perfiles SET estado = 1 WHERE id=%d",
		(int)$_POST['id']
	);

	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	exit;

?>