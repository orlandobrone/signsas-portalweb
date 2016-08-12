<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['hito']) || empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin']) || empty($_POST['descripcion'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$fecha_inicio = explode("/", $_POST['fecha_inicio']);
	$fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_inicio[2] . "-" . $fecha_inicio[1] . "-" . $fecha_inicio[0] . date("H:i:s", time())));
	
	$fecha_final = explode("/", $_POST['fecha_fin']);
	$fecha_final = date('Y-m-d H:i:s', strtotime($fecha_final[2] . "-" . $fecha_final[1] . "-" . $fecha_final[0] . date("H:i:s", time())));

	$sql = sprintf("INSERT INTO `tareas` (id_hito, nombre, id_usuario, fecha_inicio, fecha_final, descripcion, fecha) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['hito']),
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['fecha_inicio']),
		fn_filtro($_POST['fecha_fin']),
		fn_filtro($_POST['descripcion'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar la nueva tarea:\n$sql";

	exit;
?>