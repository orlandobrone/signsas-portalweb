<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	  

	/*verificamos si las variables se envian*/

	if(empty($_POST['natjur']) || empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['percon']) || empty($_POST['telefo']) || empty($_POST['celula']) || empty($_POST['email']) || empty($_POST['numero_amigable'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}



	$sql = sprintf("INSERT INTO `cliente` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now(), %s, %s, %s, %s);",

		fn_filtro($_POST['natjur']),

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['percon']),

		fn_filtro($_POST['telefo']),

		fn_filtro($_POST['celula']),

		fn_filtro($_POST['email']),
		
		fn_filtro($_POST['suministro']),
		
		fn_filtro($_POST['servicios']),
		
		fn_filtro($_POST['otros_servicios']),
		
		fn_filtro($_POST['dias_vencimiento_pago'])
	);



	if(!mysql_query($sql))

		echo "Error al insertar al nuevo cliente:\n$sql";



	exit;

?>