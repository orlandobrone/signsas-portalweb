<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['proyecto']) || empty($_POST['concepto']) || empty($_POST['descripcion']) || empty($_POST['fecha_ingreso']) || empty($_POST['valor']) || empty($_POST['id'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/
	$fecha_ingreso = explode("/", $_POST['fecha_ingreso']);
	$fecha_ingreso = date('Y-m-d', strtotime($fecha_ingreso[2] . "-" . $fecha_ingreso[1] . "-" . $fecha_ingreso[0]));

	$sql = sprintf("UPDATE proyecto_ingresos SET id_proyecto='%s', concepto='%s', descripcion='%s', fecha_ingreso='%s', valor='%s' where id=%d;",
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['concepto']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['fecha_ingreso']),
		fn_filtro(str_replace(",","",$_POST['valor'])),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el ingreso del proyecto:\n$sql";
	exit;
?>