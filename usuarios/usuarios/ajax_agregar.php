<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['codigo_perfil'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO `usuario` (usuario, email, password, nombres, codigo_perfil, fecha, id_regional) VALUES ('%s', '%s', '%s', '%s', '%s', now(), %d);",
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['email']),
		fn_filtro($_POST['password']),
		fn_filtro($_POST['nombres']),
		fn_filtro($_POST['codigo_perfil']),
		fn_filtro((int)$_POST['id_regional'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar al nuevo usuario:\n$sql";

	exit;
?>