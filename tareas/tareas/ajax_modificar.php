<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['hito']) || empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin']) || empty($_POST['descripcion'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	$fechaIni = explode('/', $_POST['fecha_inicio']);
	$fechaIni = $fechaIni[2] . '-' . $fechaIni[1] . '-' . $fechaIni[0];
	
	$fechaFin = explode('/', $_POST['fecha_fin']);
	$fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
	/*modificar el registro*/

	$sql = sprintf("UPDATE tareas SET id_hito='%s', nombre='%s', descripcion='%s', id_usuario='%s', fecha_final='%s', fecha_inicio='%s' where id=%d;",
		fn_filtro($_POST['hito']),
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['fecha_fin']),
		fn_filtro($_POST['fecha_inicio']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el cliente:\n$sql";
	exit;
?>