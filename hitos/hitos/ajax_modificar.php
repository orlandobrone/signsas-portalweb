<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);	
		$dias++; //Lógica de Iván	
		return $dias; 
	}
	
	$obj = new TaskCurrent;

	/*verificamos si las variables se envian*/

	if(empty($_POST['proyec']) || empty($_POST['nombre']) 

	   || empty($_POST['fecini']) || empty($_POST['fecfin']) || empty($_POST['descri']) || empty($_POST['ot_cliente']) 
	   ){

		echo "Usted no a llenado todos los campos";

		exit;
	}
	
	
	
	//Valida los dias transcurridos con validacion mayor a 30 dias2015-09-12 - 2016-02-18	
	if((int)$_SESSION['perfil'] != 5 && (int)$_SESSION['id'] != 71):
		
		$diasV = $obj->getValorConceptoFinanciero(19);
	
		$sql = sprintf("SELECT fecha_liquidacion FROM hitos where id=%d",
			(int)$_POST['ide_per']
		);
		$per = mysql_query($sql);	
		$rs_per = mysql_fetch_assoc($per);
	
	
		if($rs_per['fecha_liquidacion'] == '0000-00-00'):
				
			$dias = dias_transcurridos($_POST['fecha_create'],$_POST['fecha_liquidacion']);
			if($dias > (int)$diasV):
				echo json_encode(array("estado"=>false,'msj'=>'Señor coordinador la fecha de liquidado no puede ser mayor a '.(int)$diasV.' días'));
				exit;	
			endif; 
		endif;
	endif;
	
	 
	/*if($_REQUEST['ot_cliente'] != 'PENDIENTE'):	
		if(!$obj->omitirOTByClienteProyecto($_POST['proyec'])):
			if( $obj->existOTinHito($_REQUEST['ot_cliente'],$_REQUEST['id']) ):
				echo json_encode(array("estado"=>false,"msj"=>"La OT Cliente Ingresado ya existe"));
				exit;
			endif;
		endif;
	endif;*/

	/*modificar el registro*/

	$fecini = explode("/", $_POST['fecini']);

	$fecini = date('Y-m-d', strtotime($fecini[2] . "-" . $fecini[1] . "-" . $fecini[0]));

	$fecfin = explode("/", $_POST['fecfin']);
	$fecfin = date('Y-m-d', strtotime($fecfin[2] . "-" . $fecfin[1] . "-" . $fecfin[0]));
	
	$campo = '';
	$estado = '';
	$mjs_estado = '';
	$alert_estado = false;
	 
	$fecha_inicio_ejecucion = (!empty($_POST['fecha_inicio_ejecucion']))? $_POST['fecha_inicio_ejecucion']:'0000-00-00';
	$fecha_ejecutado = 		(!empty($_POST['fecha_ejecutado']))? $_POST['fecha_ejecutado']:'0000-00-00';
	$fecha_informe = 		(!empty($_POST['fecha_informe']))? $_POST['fecha_informe']:'0000-00-00';
	$fecha_liquidacion = 	(!empty($_POST['fecha_liquidacion']))? $_POST['fecha_liquidacion']:'0000-00-00';
	$fecha_facturacion = 	(!empty($_POST['fecha_facturacion']))? $_POST['fecha_facturacion']:'0000-00-00';
	$fecha_facturado = 		(!empty($_POST['fecha_facturado']))? $_POST['fecha_facturado']:'0000-00-00';
	
	//validacon del perfil facturacion
	if((int)$_SESSION['perfil'] == 19):
		if($fecha_facturado != '0000-00-00'):
			if($fecha_liquidacion == '0000-00-00'):
				echo json_encode(array("estado"=>false,"msj"=>"Señora usuaria debe validar con el coordinador para pasar el hito a Liquidado"));
				exit;
			endif;		
		endif;
	endif; 
	
	if(	$fecha_ejecutado != '0000-00-00' || 
		$fecha_informe != '0000-00-00' || 
		$fecha_liquidacion != '0000-00-00' ):
		//echo 'entra a validar estados';
		if($fecha_inicio_ejecucion == '0000-00-00'):
			$alert_estado = true;
			$mjs_estado .= 'Debe ingresar la fecha de inicio ejecución ';
		endif;		
		
		if($fecha_informe != '0000-00-00'):
			if($fecha_ejecutado == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de ejecutado,';
			endif;
		endif;
		
		if($fecha_liquidacion != '0000-00-00'):
			if($fecha_ejecutado == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de ejecutado,';
			endif;
			if($fecha_informe  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de Informe enviado,';
			endif;
		endif;
		
		if($_POST['fecha_facturacion'] != '0000-00-00'):
			/*if($_POST['fecha_ejecutado']  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de ejecutado,';
			endif;
			if($_POST['fecha_informe']  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de Informe enviado,';
			endif;
			if($_POST['fecha_liquidacion']  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= '  falta la fecha de liquidaci&oacute;n,';
			endif;*/
		endif;
		
		if($_POST['fecha_facturado'] != '0000-00-00'):
			/*if($_POST['fecha_ejecutado'] == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de ejecutado,';
			endif;
			if($_POST['fecha_informe']  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta la fecha de Informe enviado,';
			endif;
			if($_POST['fecha_liquidacion'] == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= '  falta la fecha de liquidaci&oacute;n,';
			endif;
			if($_POST['fecha_facturacion']  == '0000-00-00'):
				$alert_estado = true;
				$mjs_estado .= ' falta lafecha de facturaci&oacute;n,';
			endif;*/
		endif;				
	endif;
	if($_SESSION['perfil'] != 5 && $_SESSION['perfil'] != 19):
		/*if(	$fecha_liquidacion == '0000-00-00'):		
			if($fecha_facturado != '0000-00-00'): // si existe una fecha de liquidacion
				//$_POST['fecha_facturacion'] = $_POST['fecha_liquidacion'];
				$fecha_liquidacion = $_POST['fecha_facturado'];
			endif;	
		endif;*/
		
		if($alert_estado):
			echo json_encode(array("estado"=>false,'msj'=>$mjs_estado));
			exit;
		endif;
	endif;
	
	
	if($fecha_facturado != '0000-00-00'):
		$estado = 'FACTURADO';
	elseif($fecha_facturacion != '0000-00-00' ):
		$estado = 'EN FACTURACION';
	elseif($fecha_liquidacion != '0000-00-00'):
		$estado = 'AUTORIZADO';
	elseif($fecha_informe != '0000-00-00'):
		$estado = 'INFORME ENVIADO';
	elseif($fecha_ejecutado != '0000-00-00'):
		$estado = 'EJECUTADO';
	elseif($fecha_inicio_ejecucion != '0000-00-00'):
		$estado = 'EN EJECUCION';
	elseif(!empty($_POST['estadofgr'])):
		$estado = $_POST['estadofgr']; 
	else:
		$estado = 'PENDIENTE';
	endif;

	if(!empty($_POST['estadofgr']))	
		$estado = $_POST['estadofgr']; 
		
	$arrayEstado = array('AUTORIZADO','LIQUIDADO','FACTURADO','EN FACTURACION');	
		
	if(in_array($estado,$arrayEstado)):
	
		if(empty($_POST['ot_cliente']) || $_POST['ot_cliente'] == 'N/A' || $_POST['ot_cliente'] == 'PENDEINTE'):
			echo json_encode(array("estado"=>false,'msj'=>'Señor coordinador diligencie el campo ot-cliente'));
			exit;
		endif;
		
		if($_SESSION['perfil'] != 5 || $_SESSION['perfil'] != 19):
			if(in_array($estado,$arrayEstado)):
				if(empty($_POST['liquidacion_final']) || $_POST['liquidacion_final'] == 0):
					echo json_encode(array("estado"=>false,'msj'=>'Señor coordinador por favor ingresar el valor al campo Liquidación Final'));
					exit;
				endif;
			endif;
		endif;
		
	endif;
		
	
	/* Modificado 22/05/2015 
		selecciona la ultima fecha ingresada de las  fechas facturadas 1 2 3 4
		*/
	/*if(!empty($_POST['fecha_facturado_1']) && $_POST['fecha_facturado_1'] != '0000-00-00')
		$fecha_facturado = $_POST['fecha_facturado_1'];
	if(!empty($_POST['fecha_facturado_2']) && $_POST['fecha_facturado_2'] != '0000-00-00')
		$fecha_facturado = $_POST['fecha_facturado_2'];
	if(!empty($_POST['fecha_facturado_3']) && $_POST['fecha_facturado_3'] != '0000-00-00')
		$fecha_facturado = $_POST['fecha_facturado_3'];
	if(!empty($_POST['fecha_facturado_4']) && $_POST['fecha_facturado_4'] != '0000-00-00')
		$fecha_facturado = $_POST['fecha_facturado_4'];*/
		
	$fechas = array($_POST['fecha_facturado'], $_POST['fecha_facturado_1'],$_POST['fecha_facturado_2'],$_POST['fecha_facturado_3'],$_POST['fecha_facturado_4']);
	$fecha_max =  max($fechas);		
	
	// seleccionar la mayor fecha si no ingresar la fecha facturado	
	if($fecha_max  != $fecha_facturado ):	
		$fecha_facturado =  $fecha_max;
	endif;
	if($_POST['fecha_facturado'] == '0000-00-00' || empty($_POST['fecha_facturado'])):		
		$fecha_facturado = max($fechas);		
	endif;
	

	$campo .= ' ,fecha_facturado = "'.$fecha_facturado.'"'; 

	$campo .= ' ,fecha_facturacion = "'.$fecha_facturacion.'"'; 

	$campo .= ' ,fecha_liquidacion = "'.$fecha_liquidacion.'"'; 

	$campo .= ' ,fecha_informe = "'.$fecha_informe.'"';

	$campo .= ' ,fecha_ejecutado = "'.$fecha_ejecutado.'"';

	$campo .= ' ,fecha_inicio_ejecucion = "'.$fecha_inicio_ejecucion.'"';
	
	//echo 'Estado:'.$estado.' fecha->'.$_POST['fecha_facturado'].'<br/>';
	/*echo $campo;
	exit;*/ 
	
	$dias_hito = dias_transcurridos($_POST['fecini'],$_POST['fecfin']);
	
	if(empty($_POST['dias_para_facturar']))
		$dias_para_facturar = 'NULL';
	else
		$dias_para_facturar = $_POST['dias_para_facturar'];
		
	$po = (!empty($_POST['po']))?$_POST['po']:'PENDIENTE';
	$po2 = (!empty($_POST['po2']))?$_POST['po2']:'PENDIENTE';
	
	
	$po3 = (!empty($_POST['po3']))?$_POST['po3']:'PENDIENTE';
	$po4 = (!empty($_POST['po4']))?$_POST['po4']:'PENDIENTE';
	
	$gr3 = (!empty($_POST['gr3']))?$_POST['gr3']:'PENDIENTE';
	$gr4 = (!empty($_POST['gr4']))?$_POST['gr4']:'PENDIENTE';
	
	$factura3 = (!empty($_POST['factura3']))?$_POST['factura3']:'PENDIENTE';
	$factura4 = (!empty($_POST['factura4']))?$_POST['factura4']:'PENDIENTE';
	
	$fecha_facturado3 = (!empty($_POST['fecha_facturado_3']))?$_POST['fecha_facturado_3']:'0000-00-00';
	$fecha_facturado4 = (!empty($_POST['fecha_facturado_4']))?$_POST['fecha_facturado_4']:'0000-00-00';
	
	
	$array_data  = array(
						'proyec'=>$_POST['proyec'],
						'nombre'=>$_POST['nombre'],
						'fecini'=>$_POST['fecini'],
						'fecfin'=>$_POST['fecfin'],
						'descri'=>$_POST['descri'],
						'ot_cliente'=>trim($_POST['ot_cliente']),
						'sitios'=>$_POST['sitios'],  
						'estado'=>$estado,  
						'po'=>$po,
						'gr'=>$_POST['gr'],
						'factura'=>$_POST['factura'],
						'po2'=>$po2,
						'gr2'=>$_POST['gr2'],
						'factura2'=>$_POST['factura2'],
						'dias_hito'=>$dias_hito,
						'valor_cotizado_hito'=>$_POST['valor_cotizado_hito'],
						'dias_para_facturar'=>$dias_para_facturar,
						'valorfactura'=>$_POST['valorfactura'],
						'valorfactura2'=>$_POST['valorfactura2'],
						'fecha_facturado_1'=>$_POST['fecha_facturado_1'],
						'fecha_facturado_2'=>$_POST['fecha_facturado_2'],
						'po3'=>$po3,
						'gr3'=>$gr3,
						'factura3'=>$factura3,
						'fecha_facturado3'=>$fecha_facturado3,
						'po4'=>$po4,		
						'gr4'=>$gr4,		
						'factura4'=>$factura4,		
						'fecha_facturado4'=>$fecha_facturado4,
						'valorfacturado3'=>$_POST['valorfacturado3'],		
						'valorfacturado4'=>$_POST['valorfacturado4'],
						'departamento'=>(int)$_POST['departamento'],
						'cant_galones_h'=>(int)$_POST['cant_galones_h'],
						'observaciones' => $_POST['observaciones'],
						'liquidacion_final' => $_POST['liquidacion_final'],
						'autorizar' => $_POST['autorizar']
	);
	
	if(!empty($_POST['estadofgr'])):
		if(	$_POST['estadofgr'] != 'CANCELADO' && 
			$_POST['estadofgr'] != 'CANCELAR' && 
			$_POST['estadofgr'] != 'DUPLICADO' && 
			$_POST['estadofgr'] != 'ELIMINADO'
		):
			if(!$obj->setCronHito((int)$_POST['id'],$_POST['estadofgr'])):
				echo json_encode(array("estado"=>false,"msj"=>"No puede cambiar el estado del hito de nuevo."));
				exit;
			endif;
		endif;
	endif;
	
	//guarda en el log los cambios hechos en el hito
	$obj->setLogEventoHito('Hito',(int)$_POST['id'],'Modificado',$array_data);
	
	//guarda el estado del hito
	if(!empty($_POST['estadofgr']))
		$obj->setLogEventoHito('Hito',(int)$_POST['id'],$_POST['estadofgr'],'');
	


	$sql = sprintf('UPDATE hitos SET id_proyecto=%s, nombre="%s", 

									 fecha_inicio="%s", fecha_final="%s", 

									 descripcion="%s", ot_cliente = "%s", id_sitios="%s",

									 estado="%s", 

									 po="%s", gr="%s" , factura="%s", 

									 po2="%s", gr2="%s" , factura2="%s", dias_hito = "%s", valor_cotizado_hito = %d,
									 
									 dias_para_facturar = "%s", 
									 
									 valor_facturado = "%s", valor_facturado2 = "%s", fecha_facturado1 = "%s", fecha_facturado2 = "%s",
									 
									 po3="%s", gr3="%s", factura3="%s", fecha_facturado3="%s",
									 
									 po4="%s", gr4="%s", factura4="%s", fecha_facturado4="%s", valorfacturado3 = %d, valorfacturado4 = %d, id_ps_state = %d,
									 
									 cant_galones_h= %d,
									 
									 observaciones = "%s",
									 
									 liquidacion_final = %d,
									 
									 autorizado = %d

									 '.$campo.'

		WHERE id=%d;',

		fn_filtro($_POST['proyec']),

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['fecini']),

		fn_filtro($_POST['fecfin']),

		fn_filtro($_POST['descri']),

		fn_filtro(trim($_POST['ot_cliente'])),

		fn_filtro($_POST['sitios']),  

		fn_filtro($estado),  

		fn_filtro($po),

		fn_filtro($_POST['gr']),

		fn_filtro($_POST['factura']),

		fn_filtro($po2),

		fn_filtro($_POST['gr2']),

		fn_filtro($_POST['factura2']),
		
		fn_filtro($dias_hito),
		
		fn_filtro($_POST['valor_cotizado_hito']),
		
		fn_filtro($dias_para_facturar),
		
		fn_filtro($_POST['valorfactura']),
		
		fn_filtro($_POST['valorfactura2']),
		
		fn_filtro($_POST['fecha_facturado_1']),
		fn_filtro($_POST['fecha_facturado_2']),
		
		fn_filtro($po3),
		fn_filtro($gr3),
		fn_filtro($factura3),
		fn_filtro($fecha_facturado3),
		
		fn_filtro($po4),		
		fn_filtro($gr4),		
		fn_filtro($factura4),		
		fn_filtro($fecha_facturado4),
		
		fn_filtro($_POST['valorfacturado3']),		
		fn_filtro($_POST['valorfacturado4']),
		
		fn_filtro((int)$_POST['departamento']),
		fn_filtro((int)$_POST['cant_galones_h']),
		fn_filtro($_POST['observaciones']),
		
		fn_filtro($_POST['liquidacion_final']),
		fn_filtro($_POST['autorizar']),

		fn_filtro((int)$_POST['id'])
	);
	
	if(!mysql_query($sql)):
		echo "Error al actualizar el hito:\n$sql";
	else:		
		echo json_encode(array("estado"=>true));
	endif;
	
	exit;

?>