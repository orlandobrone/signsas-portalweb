<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['entidad']) || empty($_POST['num_cuenta']) || empty($_POST['tipo_cuenta']) || empty($_POST['beneficiario']) 
	|| empty($_POST['identificacion'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("INSERT INTO `beneficiarios` (entidad,num_cuenta,tipo_cuenta,beneficiario, identificacion) VALUES ('%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['entidad']),
		fn_filtro($_POST['num_cuenta']),
		fn_filtro($_POST['tipo_cuenta']),
		fn_filtro($_POST['beneficiario']),
		fn_filtro($_POST['identificacion'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar un nuevo beneficiario:\n$sql";
	exit;
?>