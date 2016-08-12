<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	$sql = sprintf("UPDATE `items_ordenservicio` SET `estado` = 1 WHERE id = %d",
		(int)$_POST['id']
	);
	
	if(!mysql_query($sql)){

		echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el anticipo:\n$sql"));
		exit;

	}
	
	echo json_encode(array('estado'=>true));
	exit;
?>