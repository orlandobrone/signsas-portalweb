<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	

	/*verificamos si las variables se envian*/ 
	if(empty($_POST['nombre'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}

	

	/*modificar el registro*/

	$sql = sprintf("UPDATE coordinadores SET nombre='%s', estado=%d WHERE id=%d;",
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['cambio_estado']),
		fn_filtro((int)$_POST['id'])
	);



	if(!mysql_query($sql) or die(mysql_error()))
		echo "Error al actualizar el usuario:\n$sql";

	exit;

?>