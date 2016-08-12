<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	

	/*verificamos si las variables se envian*/
	if(empty($_POST['regional']) || empty($_POST['nombre']) || empty($_POST['id']) || empty($_POST['cedula'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}

	

	/*modificar el registro*/
	$sql = sprintf("UPDATE responsables 
					SET nombre='%s', cedula='%s', id_regional=%d, estado=%d WHERE id=%d;",
			fn_filtro($_POST['nombre']),
			fn_filtro($_POST['cedula']),
			fn_filtro($_POST['regional']),
			fn_filtro($_POST['cambio_estado']),
			fn_filtro((int)$_POST['id'])
	);



	if(!mysql_query($sql) or die(mysql_error()))
		echo "Error al actualizar el usuario:\n$sql";

	exit;

?>