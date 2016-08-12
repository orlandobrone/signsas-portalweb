<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['usuario']) || empty($_POST['fecha_solicitud']) || empty($_POST['fecha_despacho']) || empty($_POST['fecha_entrega']) || empty($_POST['direccion_entrega']) || empty($_POST['nombre_recibe']) || empty($_POST['telefono']) || empty($_POST['celular']) || empty($_POST['proyecto'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$fecha_solicitud = explode("/", $_POST['fecha_solicitud']);
	$fecha_solicitud = date('Y-m-d H:i:s', strtotime($fecha_solicitud[2] . "-" . $fecha_solicitud[1] . "-" . $fecha_solicitud[0] . date("H:i:s", time())));
	
	$fecha_despacho = explode("/", $_POST['fecha_despacho']);
	$fecha_despacho = date('Y-m-d H:i:s', strtotime($fecha_despacho[2] . "-" . $fecha_despacho[1] . "-" . $fecha_despacho[0] . date("H:i:s", time())));
	
	$fecha_entrega = explode("/", $_POST['fecha_entrega']);
	$fecha_entrega = date('Y-m-d H:i:s', strtotime($fecha_entrega[2] . "-" . $fecha_entrega[1] . "-" . $fecha_entrega[0] . date("H:i:s", time())));
	
	$sql = sprintf("INSERT INTO `solicitud_despacho` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['fecha_solicitud']),
		fn_filtro($_POST['fecha_despacho']),
		fn_filtro($_POST['fecha_entrega']),
		fn_filtro($_POST['direccion_entrega']),
		fn_filtro($_POST['nombre_recibe']),
		fn_filtro($_POST['telefono']),
		fn_filtro($_POST['celular'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar la solicitud de despacho:\n$sql";

	exit;
?>