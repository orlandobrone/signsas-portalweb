<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['nombre']) || empty($_POST['descripcion']) || count($_POST['opcion']) == 0 || empty($_POST['id'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	/*modificar el registro*/
	$sql = sprintf("UPDATE perfiles SET nombre='%s', descripcion='%s', estado=%d WHERE id=%d;",
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['cambio_estado']),
		fn_filtro((int)$_POST['id'])
	);

	if(!mysql_query($sql))
		echo "Error al actualizar el perfil:\n$sql";


	$qrDeleteOpciones = mysql_query ("DELETE FROM opciones_perfiles WHERE id_perfil = '" . (fn_filtro((int)$_POST['id'])) . "'") or die(mysql_error());

	foreach ($_POST['opcion'] as $opcion) {

		$sql = sprintf("INSERT INTO `opciones_perfiles` VALUES ('', '%s', '%s', now());",

			fn_filtro($opcion),

			fn_filtro((int)$_POST['id'])

		);

		if(!mysql_query($sql))

			echo "Error al insertar las opciones del perfil:\n$sql";

	}

	

	exit;

?>