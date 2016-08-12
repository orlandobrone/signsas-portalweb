<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['proyecto']) || empty($_POST['concepto']) || empty($_POST['descripcion']) || empty($_POST['fecha_ingreso']) || empty($_POST['valor'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$fecha_ingreso = explode("/", $_POST['fecha_ingreso']);
	$fecha_ingreso = date('Y-m-d', strtotime($fecha_ingreso[2] . "-" . $fecha_ingreso[1] . "-" . $fecha_ingreso[0]));
	
	$sql = sprintf("INSERT INTO `proyecto_ingresos` (id_proyecto, concepto, descripcion, fecha_ingreso, valor) VALUES ('%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['concepto']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['fecha_ingreso']),
		fn_filtro(str_replace(",","",$_POST['valor']))
	);

	if(!mysql_query($sql))
		echo "Error al insertar el ingreso del proyecto:\n$sql";

	exit;
?>