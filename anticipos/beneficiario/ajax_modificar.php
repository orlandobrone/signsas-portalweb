<?

	include "../../conexion.php";
	include "../extras/php/basico.php";

	/*verificamos si las variables se envian*/

	if(empty($_POST['entidad']) || empty($_POST['num_cuenta']) || empty($_POST['tipo_cuenta']) || empty($_POST['nombre']) ){
		echo "Usted no a llenado todos los campos";
		exit;

	}
	
	// 0 es la opcion si 	
	$fecha_clinton = '0000-00-00';
	if($_POST['clinton'] == 0 || $_POST['clinton'] == 1)
		$fecha_clinton = date('Y-m-d');
		
	$fecha_sgss = '0000-00-00';
	if($_POST['sgss'] == 0 || $_POST['sgss'] == 1)
		$fecha_sgss = date('Y-m-d');

	if($_POST['tipo_persona'] == 'contratista'):
	
		$sql = sprintf("UPDATE beneficiarios SET identificacion='%s', entidad='%s', num_cuenta='%s', tipo_cuenta='%s', nombre='%s', contacto='%s', telefono='%s', regimen='%s', correo='%s', num_contrato='%s', direccion='%s', estado=%d, clinton=%d, sgss=%d, tipo_trabajo=%d, tipos_trabajos='%s', fecha_clinton = '".$fecha_clinton."', fecha_sgss = '".$fecha_sgss."', actividad = '%s', tipo_persona ='%s' WHERE id=%d;",
	
			fn_filtro($_POST['identificacion']),
	
			fn_filtro($_POST['entidad']),
			fn_filtro($_POST['num_cuenta']),
			fn_filtro($_POST['tipo_cuenta']),
			fn_filtro($_POST['nombre']),			
			
			fn_filtro($_POST['contacto']),
			fn_filtro($_POST['telefono']),
			fn_filtro($_POST['regimen']),
			fn_filtro($_POST['correo']),
			fn_filtro($_POST['contrato']),
			fn_filtro($_POST['direccion']),
			
			fn_filtro($_POST['cambio_estado']),
			
			fn_filtro($_POST['clinton']),
			fn_filtro($_POST['sgss']),
			fn_filtro($_POST['tipo_trabajo']),
			fn_filtro(serialize($_POST['check_tipo_trabajo'])),
			fn_filtro($_POST['actividad']),
			fn_filtro($_POST['tipo_persona']),
	
			fn_filtro((int)$_POST['id'])
		);
	
	else:

		$sql = sprintf("UPDATE beneficiarios SET identificacion='%s', entidad='%s', num_cuenta='%s', tipo_cuenta='%s', nombre='%s', estado=%d, clinton=%d, sgss=%d, tipo_trabajo=%d, tipos_trabajos='%s', fecha_clinton = '".$fecha_clinton."', actividad='%s', tipo_persona ='%s' WHERE id=%d;",
	
			fn_filtro($_POST['identificacion']),
	
			fn_filtro($_POST['entidad']),
			fn_filtro($_POST['num_cuenta']),
			fn_filtro($_POST['tipo_cuenta']),
			fn_filtro($_POST['nombre']),
			fn_filtro($_POST['cambio_estado']),
			
			fn_filtro($_POST['clinton']),
			fn_filtro($_POST['sgss']),
			fn_filtro($_POST['tipo_trabajo']),
			fn_filtro(serialize($_POST['check_tipo_trabajo'])),
			fn_filtro($_POST['actividad']),
			fn_filtro($_POST['tipo_persona']),
	
			fn_filtro((int)$_POST['id'])
		);
	endif;
	

	if(!mysql_query($sql))
		echo "Error al actualizar el beneficiario:\n$sql";				

	exit;

?>