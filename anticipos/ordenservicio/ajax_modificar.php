<?

	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../../festivos.php";
	//$dias_festivos = new festivos(date("Y"));
	
	
	//validar el estado del OS hacia algun anticipo
	if($_POST['forze_estado'] == 2){
		$obj = new TaskCurrent;
		if( $obj->validarOSbyAnticipos((int)$_POST['id']) ):
			echo "No se puede anular la orden de servicio #".(int)$_POST['id'].", tiene un anticipo aprobado";
			exit;	
		endif;	
	}
	

	/*verificamos si las variables se envian*/
	if(empty($_POST['fecha_inicio']) || empty($_POST['fecha_terminado'])){
		echo "Debe ingresar la fecha de inicio de actividad y final.";
		exit;
	}
	

	if(empty($_POST['regional']) 
	
		|| empty($_POST['nombre_responsable']) 
		|| empty($_POST['cedula_responsable']) 
		
		|| empty($_POST['centros_costos'])
		//|| empty($_POST['orden_trabajo'])
	 //|| empty($_POST['centros_costos'])
		
		|| empty($_POST['cedula_consignar'])
		
		|| empty($_POST['nombre'])
		/*|| empty($_POST['telefono'])
		|| empty($_POST['direccion'])	
		|| empty($_POST['contacto'])
		|| empty($_POST['correo'])
		|| empty($_POST['banco'])
		|| empty($_POST['tipo_cuenta'])
		|| empty($_POST['regimen'])
		|| empty($_POST['num_cuenta'])*/
		//|| empty($_POST['observaciones'])
		//|| empty($_POST['opcionpoliza'])
		
		|| empty($_POST['id'])
	){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$impuesto_array = array([
		'valor_neto_total'=>$_POST['valor_neto_total'],
		'tipoimp'=>$_POST['tipoimp'],
		'iva'=>$_POST['iva'],
		'ica'=>$_POST['ica'],
		'rtefuente'=>$_POST['rtefuente'],
		'totalconimpuesto'=>$_POST['totalconimpuesto'],
	]);

	
	$sql = sprintf("UPDATE `orden_servicio` SET 
	
					fecha_inicio = '%s',
					fecha_terminado='%s',
										 
					id_regional='%s',
					id_centroscostos='%s',
					id_ordentrabajo='%s',
					
					nombre_responsable='%s', 
					cedula_responsable='%s',
					
					nombre_contratista='%s',
					cedula_contratista='%s',
					telefono_contratista='%s',
					direccion_contratista='%s',
					contacto_contratista='%s',
					correo_contratista='%s',
					
					regimen_contratista='%s',
					poliza_contratista='%s',
					
					banco_contratista='%s',
					tipocuenta_contratista='%s',
					numcuenta_contratista='%s',					
					observaciones_contratista='%s',		
					
					num_contrato_contratista='%s',
					usuario_id = %d,
					estado='publish',
					aprobado = %d,										
					impuesto_os = '%s'
					
		WHERE id=%d;",

		fn_filtro($_POST['fecha_inicio']),
		fn_filtro($_POST['fecha_terminado']),
		
		fn_filtro($_POST['regional']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro($_POST['orden_trabajo']),		

		fn_filtro($_POST['nombre_responsable']),
		fn_filtro($_POST['cedula_responsable']),		

		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['cedula_consignar']),
		fn_filtro($_POST['telefono']),
		fn_filtro($_POST['direccion']),
		fn_filtro($_POST['contacto']),
		fn_filtro($_POST['correo']),
		
		fn_filtro($_POST['regimen']),
		fn_filtro($_POST['opcionpoliza']),
		
		fn_filtro($_POST['banco']),
		fn_filtro($_POST['tipo_cuenta']),
		fn_filtro($_POST['num_cuenta']),
		fn_filtro($_POST['observaciones']),	
		
		fn_filtro($_POST['num_contrato']),	
		fn_filtro($_SESSION['id']),	
		fn_filtro($_POST['forze_estado']),
		
		fn_filtro(serialize($impuesto_array)),		

		fn_filtro((int)$_POST['id']) 

	);

	if(!mysql_query($sql)){

		echo "Error al actualizar el anticipo:\n$sql";

		exit;

	}else{
		
		$obj = new TaskCurrent();
		if(!(boolean)$_POST['excepcion']):
			$obj->setLogEvento('Orden Servicio',(int)$_POST['id'],'NO REVISADO');
		else:
			$_GET['id_orden'] = (int)$_POST['id'];
			require_once('ajax_aprobar_os.php'); 
			$obj->setLogEvento('Orden Servicio',(int)$_POST['id'],'APROBADO EXCEPCION');
		endif;
		
		exit;
	}

?>