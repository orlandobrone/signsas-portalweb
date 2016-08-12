<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if( empty($_POST['id']) ){
		echo "Usted no ha llenado todos los campos";
		exit;
	}

	/*pagado el registro*/
	$sql = sprintf("UPDATE ordencompra SET pagado=%d WHERE id=%d;",
		fn_filtro(1),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la factura:\n$sql";
		
	exit;
?>