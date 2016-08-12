<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	/*if(empty($_POST['natjur']) || empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['percon']) || empty($_POST['telefo']) || empty($_POST['celula']) || empty($_POST['email'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}*/
	
	/*modificar el registro*/ 

	$sql = sprintf("UPDATE proveedor SET 
						natural_juridico='%s',
						nombre='%s', 
						nit='%s', 
						regimen='%s', 
						descripcion='%s', 
						persona_contacto='%s', 
						plazo_pago='%s', 
						banco='%s', 
						cuenta_banco='%s', 
						tipo_cuenta='%s', 
						ciudad='%s', 
						direccion='%s', 
						telefono='%s', 
						celular='%s', 
						fax='%s', 
						email='%s', 
						otro_email='%s'						
					where id=%d;",
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
		fn_filtro($_POST['otro_correo']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el cliente:\n$sql";
	exit;
?>