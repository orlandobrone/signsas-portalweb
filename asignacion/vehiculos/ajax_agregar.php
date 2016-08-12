<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['placa']) || empty($_POST['marca']) ){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	

	$sql = sprintf("INSERT INTO `vehiculos` VALUES ('', '%s', '%s','%s','%s','%s','%s','%s','%s',%d);",

		fn_filtro($_POST['placa']),

		fn_filtro($_POST['marca']),

		fn_filtro($_POST['soat']),

		fn_filtro($_POST['tm']),

		fn_filtro($_POST['aceite']),

		fn_filtro($_POST['region']),

		fn_filtro($_POST['valor_hora']),

		fn_filtro(serialize($_POST['plantillas'])),
		
		fn_filtro($_POST['estado']) 

	);



	if(!mysql_query($sql))

		echo "Error al insertar el nuevo vehiculo:\n$sql";



	exit;

?>