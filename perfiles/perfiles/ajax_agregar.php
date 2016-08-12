<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['nombre']) || empty($_POST['descripcion']) || count($_POST['opcion']) == 0){

		echo "Usted no a llenado todos los campos";

		exit;

	}
 


	$sql = sprintf("INSERT INTO `perfiles` VALUES ('', '%s', '%s', now(), 0);",

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['descripcion'])

	);

	

	if(!mysql_query($sql))

		echo "Error al insertar al nuevo perfil:\n$sql";

	$idPerfil = mysql_insert_id($con);

	

	foreach ($_POST['opcion'] as $opcion) {

		$sql = sprintf("INSERT INTO `opciones_perfiles` VALUES ('', '%s', '%s', now());",

			fn_filtro($opcion),

			fn_filtro($idPerfil)

		);

		if(!mysql_query($sql))

			echo "Error al insertar las opciones del perfil:\n$sql";

	}



	exit;

?>