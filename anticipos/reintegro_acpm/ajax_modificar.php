<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['entidad']) || empty($_POST['num_cuenta']) || empty($_POST['tipo_cuenta']) || empty($_POST['beneficiario'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("UPDATE beneficiarios SET identificacion='%s', entidad='%s', num_cuenta='%s', tipo_cuenta='%s', beneficiario='%s' WHERE id=%d;",
		fn_filtro($_POST['identificacion']),
		fn_filtro($_POST['entidad']),
		fn_filtro($_POST['num_cuenta']),
		fn_filtro($_POST['tipo_cuenta']),
		fn_filtro($_POST['beneficiario']),
		fn_filtro((int)$_POST['id'])
	);
	
	if(!mysql_query($sql))
		echo "Error al actualizar el beneficiario:\n$sql";				
	exit;
?>