<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	session_start();
	$obj = new TaskCurrent;	
	
	if(empty($_POST['hitos'])){
		echo json_encode(array('estado'=>false, 'message'=>"Debe seleccionar un hito"));
		exit;
	}
	
	
	// Consulta si el hito esta en opcion de carga ilimitada de ingresos
	$sqlhito = mysql_query("SELECT ilimitado, estado, valor_cotizado_hito
							FROM hitos WHERE id =".$_POST['hitos']) or die(mysql_error());
	$rowshito = mysql_fetch_assoc($sqlhito);		

	// 1 cerrado, 0 abierto	 
	//@reintegro si es un reintegro no pasa para validar los costos del hito 23/02/2015
	$entra = true;
	if(isset($_REQUEST['reintegro']))
		$entra = false;
	if((int)$rowshito['ilimitado'] == 1)
		$entra = false;
	if($rowshito['estado'] == 'ADMIN')
		$entra = false;	
	if($rowshito['valor_cotizado_hito'] == '1.00')
		$entra = false;	
	
	if($rowshito['estado'] == 'LIQUIDADO' || $rowshito['estado'] == 'EN FACTURACION' || $rowshito['estado'] == 'FACTURADO'):
		echo json_encode(array('estado'=>false, 'message'=>"No puede ingresar carga a este hito, su estado es ".$rowshito['estado']));
		exit;
	endif; 
	
	
	if(!is_array($_POST['datos'])):
		echo json_encode(array('estado'=>false, 'message'=>"Debe ingresar la cantidad de galones de salida"));
		exit;
	endif;
	
	$total_hito = 0;
	foreach($_POST['datos'] as $item):			
		$total_hito = $item['cant_salida_gal'] * $item['costo_unitario'];
	endforeach;
	
	//$obj->setPitagoraHito('Salio Inv. ACPM',$_POST['hitos'],$total_hito,$_POST['id'],$_SESSION['id']);
	if($entra): 		
			$estadoCosto = true;		
			if(!empty($_POST['centro_costo_item']) || !empty($_POST['hitos'])):	
				$objeto = $obj->getTotalHito($_POST['hitos'],$_POST['centro_costo_item'],$total_hito);
				$estadoCosto = $objeto['estado'];				
			endif;		
			if(!$estadoCosto):
				echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a este hito, solicite autorización de Gerencia.\n Los siguiente costos son:\n".$objeto['valores']));
				exit;
			endif;
	endif;
	
	$sql = "SELECT cantidad FROM inventario WHERE id = 1539";
	$per = mysql_query($sql);
	$rs_per = mysql_fetch_assoc($per);
	$cantidad_inv = $rs_per['cantidad'];	
	$totalAnticipo = 0;
	
	foreach($_POST['datos'] as $item):		
		//echo $item['idhito'];
		$totalAcpm = 0;		
		$salida_acpm = 0;
		$retencion = 0;
		
		$totalAcpm = $item['cant_salida_gal'] * $item['costo_unitario'];
		$totalAnticipo += $totalAcpm;
		
		$sql2 = sprintf("INSERT INTO `items_anticipo` VALUES ('', '%s', '%s', '%s', '%s', '%s', %s, NULL, 1, %d, NOW(), %d, %d, %d);",
			fn_filtro($_POST['idanticipo']),
			fn_filtro($_POST['hitos']),
			fn_filtro((int)$totalAcpm.',00'),
			fn_filtro(0),
			fn_filtro(0),
			fn_filtro($totalAcpm),
			fn_filtro($_SESSION['id']),
			fn_filtro($item['cant_salida_gal']),
			fn_filtro($item['costo_unitario']),
			fn_filtro($retencion)	
		);	
		
		if(!mysql_query($sql2)):
			echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item ACPM:\n$sql"));
			exit;
		else:	
			$id_items_anticipo = mysql_insert_id(); 		
			//Actualiza la salida de ACPM en el inventario
			//$total_galones = $item['cant_galones'] - $item['cant_salida_gal'];			
			/*$sql3 = sprintf("UPDATE `inventario_acpm` SET cant_galones = %d, salida_acpm = %d WHERE id = %d",
				fn_filtro($total_galones),
				fn_filtro($item['cant_salida_gal']),
				fn_filtro($item['id'])	
			);
			if(!mysql_query($sql3)):
				echo "Error al acutalizar el acpm:\n$sql";
				exit;
			else:*/
				$obj->setOutInvACPM($id_items_anticipo, $item['id'],$item['cant_salida_gal']);
				$salida_acpm += $item['cant_salida_gal'];
			//endif;	
		endif;	
		
	endforeach;	
	
	$total_galones = $cantidad_inv - $salida_acpm;
	$sql = sprintf("UPDATE inventario SET cantidad=%d WHERE id=1539",
		fn_filtro($total_galones)
	);
	mysql_query($sql);
	
	/*----------------- Acttualizar Anticipo --------------------------*/
	$sql = sprintf("UPDATE `anticipo` SET total_anticipo='%s' WHERE id=%d;",
		fn_filtro($totalAnticipo),
		fn_filtro((int)$_POST['idanticipo']) 

	);
	mysql_query($sql);
	
	$letters = array('.');
	$fruit   = array('');

	$reintegro = 0;
	$acpm = 0;
	$valor_transporte = 0;
	$toes = 0;
	$total_acpm = 0;
	$total_transporte = 0;
	$total_toes = 0;
	$total_anticipo = 0;

	$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 1 AND id_anticipo =".$_POST['idanticipo']) or die(mysql_error());

	$total = mysql_num_rows($resultado);

	while ($rows = mysql_fetch_assoc($resultado)):

		if($rows['acpm'] != 0):
			$acpm = explode(',00',$rows['acpm']);
			$acpm = str_replace($letters, $fruit, $acpm[0] );
			$total_acpm += $acpm;
		endif;

		if($rows['valor_transporte'] != 0):
			$valor_transporte = explode(',00',$rows['valor_transporte']);
			$valor_transporte = str_replace($letters, $fruit, $valor_transporte[0] );
			$total_acpm += $valor_transporte;
		endif;
		
		if($rows['toes'] != 0):
			$toes = explode(',00',$rows['toes']);
			$toes = str_replace($letters, $fruit, $toes[0] );
			$total_anticipo += $toes;
		endif;

	endwhile;

	$giro = 0;

	if($_POST['giro'] != 0){
		$giro = explode(',00',$_POST['giro']);
		$giro = str_replace($letters, $fruit, $giro[0] );
	}

	$total_anticipo = $total_acpm + $total_toes + $total_anticipo + $giro;	
	$total_anticipo = number_format($total_anticipo, 2, '.', ',');	
	
	echo json_encode(array('estado'=>true, 'total_anticipo'=>$total_anticipo));

	exit;

	
?>