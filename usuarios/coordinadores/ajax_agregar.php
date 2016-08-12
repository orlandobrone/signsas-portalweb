<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	
	/*verificamos si las variables se envian*/
	if(empty($_POST['nombre'])  ){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO `coordinadores` (nombre, estado, fecha_create) VALUES ('%s', 0, NOW());",
		fn_filtro($_POST['nombre'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar al nuevo usuario:\n$sql";

	exit;

?>