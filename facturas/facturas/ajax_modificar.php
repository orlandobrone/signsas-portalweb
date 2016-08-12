<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if( empty($_POST['num_factura']) || empty($_POST['retencion']) ){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	$letters = array(',');
	$fruit   = array('');
	
	/*modificar el registro*/
	$sql = sprintf("UPDATE ordencompra SET num_factura='%s', retencion='%s' WHERE id=%d;",
		fn_filtro($_POST['num_factura']),
		fn_filtro(str_replace($letters, $fruit,$_POST['retencion'])),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la factura:\n$sql";
		
	exit;
?>