<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['regional']) || empty($_POST['departamento']) || empty($_POST['ciudad']) || empty($_POST['nombre_rb']) || empty($_POST['direccion']) || empty($_POST['tipo_rb'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("INSERT INTO `sitios` (regional,departamento,ciudad,nombre_rb, direccion, tipo_rb) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['regional']),
		fn_filtro($_POST['departamento']),
		fn_filtro($_POST['ciudad']),
		fn_filtro($_POST['nombre_rb']),
		fn_filtro($_POST['direccion']),
		fn_filtro($_POST['tipo_rb'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar un nuevo sitio:\n$sql";
	exit;
?>