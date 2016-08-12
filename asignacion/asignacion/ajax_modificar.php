<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	

	/*verificamos si las variables se envian*/
	if(empty($_POST['hitos']) || empty($_POST['tecnicos']) || empty($_POST['fecini']) || empty($_POST['fecfin'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}


	$obj = new TaskCurrent;	
	
	/*modificar el registro*/
	$vehiculo = ($_POST['vehiculos']!='')? $_POST['vehiculos']:'';
	
	
	//valida si el hito fue cambiado
	if($_POST['hitos'] != $_POST['hito_actual']):
	
		$manoObra = $obj->getCostoManobraByhito($_POST['hito_actual']);
		$costoVechiculo = $obj->getCostoVehiculoByhito($_POST['hito_actual']);
		$costoAsignacion = $manoObra + $costoVechiculo;
		
		$objeto = $obj->getTotalHito($_POST['hitos'],0,$costoAsignacion);
		
		if(!$objeto['estado']):
			echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a este hito, solicite autorización de Gerencia.\n Los siguiente costos son:\n".$objeto['valores']));
		else:
			$obj->setPitagoraHito('Transferencia de la Asignación #'.$_POST['id'].' con el Hito #'.$_POST['hito_actual'].' al #'.$_POST['hitos'].'.',$_POST['hito_actual'],$_POST['hitos'],$_POST['id'],$_SESSION['id']);
		endif;
	endif;
	
	
	if($_POST['hora_inicio'] != '00:00:00' && $_POST['hora_final'] != '00:00:00'):
	
		$horastrab = $obj->calcular_horas($_POST['hora_final'],$_POST['hora_inicio']);

		$sql = sprintf("UPDATE `asignacion` SET 

					id_hito='%s', 

					id_tecnico='%s', 

					id_vehiculo='%s',

					id_ordentrabajo='%s', 

					observacion='%s',

					fecha_ini='%s', 

					fecha_fin='%s',

					hora_inicio='%s',

					hora_final='%s', 
					
					horas_trabajadas='%s' 

				   WHERE id=%d;",

		fn_filtro($_POST['hitos']),

		fn_filtro($_POST['tecnicos']),

		fn_filtro($vehiculo),

		fn_filtro($_POST['id_ordonetrabajo']), 

		fn_filtro($_POST['observacion']),

		fn_filtro($_POST['fecini']),

		fn_filtro($_POST['fecfin']),

		fn_filtro($_POST['hora_inicio']),

		fn_filtro($_POST['hora_final']),
		
		fn_filtro($horastrab),

		fn_filtro((int)$_POST['id'])

	);

	else:
	
		$sql = sprintf("UPDATE `asignacion` SET 

					id_hito='%s', 

					id_tecnico='%s', 

					id_vehiculo='%s', 

					id_ordentrabajo='%s',

					observacion='%s',

					fecha_ini='%s', 

					fecha_fin='%s'

				   WHERE id=%d;",

		fn_filtro($_POST['hitos']),

		fn_filtro($_POST['tecnicos']),

		fn_filtro($vehiculo),

		fn_filtro($_POST['id_ordonetrabajo']),

		fn_filtro($_POST['observacion']),

		fn_filtro($_POST['fecini']),

		fn_filtro($_POST['fecfin']),

		fn_filtro((int)$_POST['id'])

	);

	endif;



	if(!mysql_query($sql)):
		echo json_encode(array('estado'=>false, 'message'=>"Ocurrio un error al cambio de estado\n$sql"));
		exit;
	endif;
		
		
	if(isset($_POST['cambio_estado'])):
		$sql = sprintf("UPDATE `asignacion` SET estado = %d WHERE id=%d",
			(int)$_POST['cambio_estado'],
			(int)$_POST['id']
		);
		if(!mysql_query($sql)):
			echo json_encode(array('estado'=>false, 'message'=>"Ocurrio un error al cambio de estado\n$sql"));
			exit;
		endif;
	endif;
	
	echo json_encode(array('estado'=>true));

	exit;

?>