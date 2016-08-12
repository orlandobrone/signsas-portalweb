<?

	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";

	/*verificamos si las variables se envian*/
	if(empty($_POST['departamento']) || empty($_POST['value_acpm'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO valor_acpm VALUES ('', %d, %d, NOW());",
		fn_filtro($_POST['departamento']),
		fn_filtro($_POST['value_acpm'])
	);

	if(!mysql_query($sql)):
		echo "Error al insertar al nuevo cliente:\n$sql";
	endif;

	exit;

?>