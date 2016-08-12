<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	
	/*verificamos si las variables se envian*/

	if(empty($_POST['regional']) || empty($_POST['nombre']) || empty($_POST['cedula']) ){
		echo "Usted no a llenado todos los campos";
		exit;
	}


	$sql = sprintf("INSERT INTO `responsables` (id_regional, nombre, cedula, estado, fecha_creado) VALUES (%d, '%s', '%s', 0, NOW() );",

		fn_filtro($_POST['regional']),

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['cedula'])
	);



	if(!mysql_query($sql))

		echo "Error al insertar al nuevo usuario:\n$sql";



	exit;

?>