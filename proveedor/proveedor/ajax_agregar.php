<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	/*if(empty($_POST['natjur']) || empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['percon']) || empty($_POST['telefo']) || empty($_POST['celula']) || empty($_POST['email'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}*/

	$sql = sprintf("INSERT INTO `proveedor` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['natjur']),
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['nit']),
		fn_filtro($_POST['regimen']),
		fn_filtro($_POST['actividad']),
		fn_filtro($_POST['percon']),
		fn_filtro($_POST['plazo']),
		fn_filtro($_POST['banco']),
		fn_filtro($_POST['cuenta']),
		fn_filtro($_POST['tipo_cuenta']),
		fn_filtro($_POST['ciudad']),
		fn_filtro($_POST['direccion']),
		fn_filtro($_POST['telefono']),
		fn_filtro($_POST['celular']),
		fn_filtro($_POST['fax']),
		fn_filtro($_POST['email']),
		fn_filtro($_POST['otro_correo'])		
	);

	if(!mysql_query($sql))
		echo "Error al insertar al nuevo proveedor:\n$sql";

	exit;
?>