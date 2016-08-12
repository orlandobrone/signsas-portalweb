<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	/*verificamos si las variables se envian*/

	if(empty($_POST['entidad']) || empty($_POST['num_cuenta']) || empty($_POST['tipo_cuenta']) || empty($_POST['beneficiario'])

	|| empty($_POST['identificacion'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}
	
	$obj = new TaskCurrent();
	
	if($obj->existeCedulaNit((int)$_POST['identificacion'])):
		echo 'Esta cedula o NIT ya esta registrada';
		exit;
	endif;
	
	
	// 0 es la opcion si 	
	$fecha_clinton = '0000-00-00';
	if($_POST['clinton'] == 0)
		$fecha_clinton = date('Y-m-d');
		
	$fecha_sgss = '0000-00-00';
	if($_POST['sgss'] == 0)
		$fecha_sgss = date('Y-m-d');
		
	
	$sql = sprintf("INSERT INTO `beneficiarios` (entidad,num_cuenta,tipo_cuenta,nombre,identificacion, contacto, telefono,direccion,regimen, correo,num_contrato,tipo_persona,fecha_creacion, estado,clinton,sgss,tipo_trabajo,tipos_trabajos,fecha_clinton,fecha_sgss) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW(),0, %d, %d, %d, '%s', '".$fecha_clinton."','".$fecha_sgss."');",

		fn_filtro($_POST['entidad']),
		fn_filtro($_POST['num_cuenta']),
		fn_filtro($_POST['tipo_cuenta']),
		fn_filtro($_POST['beneficiario']),
		fn_filtro($_POST['identificacion']),
		fn_filtro($_POST['contacto']),
		fn_filtro($_POST['telefono']),
		fn_filtro($_POST['direccion']),
		fn_filtro($_POST['regimen']),
		fn_filtro($_POST['correo']),
		fn_filtro($_POST['contrato']),
		fn_filtro($_POST['tipo_persona']),
		fn_filtro($_POST['clinton']),
		fn_filtro($_POST['sgss']),	
		fn_filtro($_POST['tipo_trabajo']),	
		fn_filtro(serialize($_POST['check_tipo_trabajo']))		
	);



	if(!mysql_query($sql))

		echo "Error al insertar un nuevo beneficiario:\n$sql";

	exit;

?>