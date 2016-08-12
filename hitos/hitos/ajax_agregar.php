<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;
	
	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);	
		$dias++; //Lógica de Iván	
		return $dias;
	}
	
	

	/*verificamos si las variables se envian*/
	if(empty($_POST['proyec']) || empty($_POST['nombre']) || empty($_POST['fecini']) || empty($_POST['fecfin']) || empty($_POST['descri']) || empty($_POST['ot_cliente'])  || empty($_POST['departamento']) ){

		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	/*if($_REQUEST['ot_cliente'] != 'PENDIENTE'):
		if(!$obj->omitirOTByClienteProyecto($_POST['proyec'])):
			if($obj->existOTinHito($_POST['ot_cliente'],0)):
				echo "El OT Cliente ".$_POST['ot_cliente']." ya existe en otro hito";
				exit;
			endif;
		endif;
	endif;*/
	
	$factor = $obj->getFactorByProyecto((int)$_POST['proyec']);
	
	
	$fecini = explode("/", $_POST['fecini']);
	$fecini = date('Y-m-d', strtotime($fecini[2] . "-" . $fecini[1] . "-" . $fecini[0]));

	$fecfin = explode("/", $_POST['fecfin']);
	$fecfin = date('Y-m-d', strtotime($fecfin[2] . "-" . $fecfin[1] . "-" . $fecfin[0]));
	
	$dias_hito = dias_transcurridos($_POST['fecini'],$_POST['fecfin']);
	
	$po = (!empty($_POST['po']))?$_POST['po']:'N/A';
	$po2 = (!empty($_POST['po2']))?$_POST['po2']:'N/A';
	
	$po3 = (!empty($_POST['po3']))?$_POST['po3']:'N/A';
	$po4 = (!empty($_POST['po4']))?$_POST['po4']:'N/A';
	
	$gr3 = (!empty($_POST['gr3']))?$_POST['gr3']:'N/A';
	$gr4 = (!empty($_POST['gr4']))?$_POST['gr4']:'N/A';
	
	$factura3 = (!empty($_POST['factura3']))?$_POST['factura3']:'N/A';
	$factura4 = (!empty($_POST['factura4']))?$_POST['factura4']:'N/A';
	
	$fecha_facturado3 = (!empty($_POST['fecha_facturado_3']))?$_POST['fecha_facturado_3']:'0000-00-00';
	$fecha_facturado4 = (!empty($_POST['fecha_facturado_4']))?$_POST['fecha_facturado_4']:'0000-00-00';
	
	$valorfacturado3 = (!empty($_POST['valorfacturado3']))?$_POST['valorfacturado3']:0;
	$valorfacturado4 = (!empty($_POST['valorfacturado4']))?$_POST['valorfacturado4']:0;
 

	$sql = sprintf('INSERT INTO hitos (id,
						id_proyecto,
						nombre,
						fecha_inicio,
						fecha_final,
						descripcion,
						id_sitios,
						fecha,
						fecha_real,
						estado,
						ot_cliente,
						po,
						gr,
						factura,
						po2,
						gr2,
						factura2,
						dias_hito,
						valor_cotizado_hito,
						po3,
						po4,
						gr3,
						gr4,
						factura3,
						factura4,
						fecha_facturado3,
						fecha_facturado4,
						valorfacturado3,
						valorfacturado4,						
						id_ps_state,
						factor,
						cant_galones_h,
						observaciones,
						historico_cotizado
						
						) VALUES ("",

							"%s", 

							"%s", 

							"%s",

							"%s", 

							"%s", 

							"%s", 

							now(),

						 	now(),

							"%s",

							"%s",

							"%s",

							"%s",

							"%s",

							"%s",

							"%s",

							"%s",
							
							"%s",
							
							"%s",
							
							"%s",
							"%s",
							"%s",
							"%s",
							"%s",
							"%s",
							"%s",
							"%s",
							%d,
							%d,
							%d,
							"%s",
							0,
							"%s",
							%d);',

		fn_filtro($_POST['proyec']),

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['fecini']),

		fn_filtro($_POST['fecfin']),		

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['sitios']),
		
		fn_filtro($_POST['estado']),		
		
		fn_filtro($_POST['ot_cliente']),

		fn_filtro($po),

		fn_filtro($_POST['gr']),

		fn_filtro($_POST['factura']),

		fn_filtro($po2),

		fn_filtro($_POST['gr2']),

		fn_filtro($_POST['factura2']),
		
		fn_filtro($dias_hito),
		
		fn_filtro($_POST['valor_cotizado_hito']),
		
		fn_filtro($po3),
		fn_filtro($po4),
		fn_filtro($gr3),
		fn_filtro($gr4),
		fn_filtro($factura3),
		fn_filtro($factura4), 
		fn_filtro($fecha_facturado3),
		fn_filtro($fecha_facturado4),
		fn_filtro($valorfacturado3),
		fn_filtro($valorfacturado4),
		fn_filtro((int)$_POST['departamento']),
		fn_filtro($factor),
		fn_filtro($_POST['observaciones']),
		
		fn_filtro($_POST['valor_cotizado_hito'])//guar el valor cotizar al crear el hito
	);

	if(!mysql_query($sql)){
		echo "Error al insertar un nuevo hito:\n$sql";
		exit;
	}else{
		$obj->setLogEventoHito('Hito',mysql_insert_id(),'Creado',$sql);
		exit;
	}

?>