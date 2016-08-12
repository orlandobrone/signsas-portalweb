<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['regional']) || empty($_POST['departamento']) || empty($_POST['ciudad']) || empty($_POST['nombre_rb']) || empty($_POST['direccion']) || empty($_POST['tipo_rb'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("UPDATE sitios SET regional='%s', departamento='%s', ciudad='%s', nombre_rb='%s', direccion='%s', tipo_rb='%s' where id=%d;",
		fn_filtro($_POST['regional']),
		fn_filtro($_POST['departamento']),
		fn_filtro($_POST['ciudad']),
		fn_filtro($_POST['nombre_rb']),
		fn_filtro($_POST['direccion']),
		fn_filtro($_POST['tipo_rb']),
		fn_filtro((int)$_POST['id'])
	);
	
	
	
	if(!mysql_query($sql))
		echo "Error al actualizar el sitio:\n$sql";				
	exit;
?>