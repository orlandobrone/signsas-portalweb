<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['region']) || empty($_POST['sigla'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO `regional` (region, sigla) VALUES ('%s', '%s');",
		fn_filtro($_POST['region']),
		fn_filtro($_POST['sigla'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar al nuevo usuario:\n$sql";

	exit;
?>