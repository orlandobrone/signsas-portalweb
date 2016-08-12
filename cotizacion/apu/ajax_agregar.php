<?
	session_start();

	include "../../conexion.php";

	include "../extras/php/basico.php";

	
	/*verificamos si las variables se envian*/

	if(empty($_POST['id_apu']) 

	|| empty($_POST['descripcion']) ){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	
	$sql = sprintf("INSERT INTO `apu` VALUES ('', '%s', '%s');",

		fn_filtro($_POST['fecha']),

		fn_filtro($_POST['prioridad'])
	);



	if(!mysql_query($sql)){

		echo "Error al insertar la nueva asosaci&oacute;n:\n$sql"; 

		exit;

	}


	exit;

?>