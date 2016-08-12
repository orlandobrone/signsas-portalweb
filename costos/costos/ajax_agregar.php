<?
	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['proyecto']) || empty($_POST['concepto']) || empty($_POST['descripcion']) || empty($_POST['fecha_ingreso']) || empty($_POST['valor']) || empty($_POST['proveedor'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$fecha_ingreso = explode("/", $_POST['fecha_ingreso']);
	$fecha_ingreso = date('Y-m-d H:i:s', strtotime($fecha_ingreso[2] . "-" . $fecha_ingreso[1] . "-" . $fecha_ingreso[0] . date("H:i:s", time())));
	
	$sql = sprintf("INSERT INTO `proyecto_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['proveedor']),
		fn_filtro($_POST['tecnico']),
		fn_filtro($_POST['concepto']), 
		fn_filtro($_POST['descripcion']),
		fn_filtro($fecha_ingreso),
		fn_filtro((str_replace(",","",$_POST['valor'])))
	);

	if(!mysql_query($sql)):
		echo "Error al insertar al nuevo cliente:\n$sql";
	else:
		alertaCostos($_POST['proyecto']);
	endif;

	exit;
?>