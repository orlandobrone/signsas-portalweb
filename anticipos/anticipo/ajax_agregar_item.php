<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;	

	/*verificamos si las variables se envian*/
	if(empty($_POST['id']) || empty($_POST['hitos'])){
		echo json_encode(array('estado'=>false, 'message'=>"No han llegado todos los campos"));
		exit;
	}
	
	/*valida que el id hito este en estado superior a cotizado o pendiente */
	if(!empty($_POST['hitos'])):
		if($obj->getValidateEstadoHito($_POST['hitos'])):
			echo json_encode(array('estado'=>false, 'message'=>'Señor Coordinador no se le pueden cargar anticipos ha este hito ya que está en estado Cotizado o Pendiente, por favor ingrese las fechas respectivas para pasar el hito ha estado En Ejecución.'));
			exit;
		endif;	
	endif;
	
	
	/*valida que el id hito este en la orden de servicio */
	if(!empty($_POST['id_os'])):
		if(!$obj->getValidateHitoByOrdenservicio($_POST['hitos'],$_POST['id_os'])):
			echo json_encode(array('estado'=>false, 'message'=>"Por favor validar el ID hitos #".$_POST['hitos']." ya que no corresponden a los cargados en la Orden de Servicio #".$_POST['id_os']));
			exit;
		endif;	
	endif;
	
	
	$letters = array('.');
	$fruit   = array('');

	$acpm = 0;
	$toes = 0;
	$valor_transporte = 0;	
	$total_acpm = 0;
	$total_transporte = 0;
	$total_toes = 0;
	$total_viaticos = 0;
	$total_mular = 0;
	$total_hito = 0;
	$total_hito_sinimp = 0;	

	//impuestos de acpm
	$array_imp_acpm = '';
	if($_POST['acpm_totalconimpuesto'] > 0):
		$array_imp_acpm = array(	'valor_neto'=>$_POST['acpm_valor_neto_total'],
									'tipoimp'=>$_POST['acpm_tipoimp'],
									'iva'=>$_POST['acpm_iva'],
									'ica'=>$_POST['acpm_ica'],
									'rtefuente'=>$_POST['acpm_rtefuente'],
									'total'=>$_POST['acpm_totalconimpuesto']
		);
		
		$acpm = $_POST['acpm_totalconimpuesto'];
		$total_acpm += $acpm;
		$total_hito_sinimp += $_POST['acpm_valor_neto_total'];
	endif;

	//impuestos de transporte
	$array_imp_transporte = '';
	if($_POST['transporte_totalconimpuesto'] > 0):
		$array_imp_transporte = array(	'valor_neto'=>$_POST['transporte_valor_neto_total'],
										'tipoimp'=>$_POST['transporte_tipoimp'],
										'iva'=>$_POST['transporte_iva'],
										'ica'=>$_POST['transporte_ica'],
										'rtefuente'=>$_POST['transporte_rtefuente'],
										'total'=>$_POST['transporte_totalconimpuesto']
		);
		
		$valor_transporte = $_POST['transporte_totalconimpuesto'];
		$total_transporte += $valor_transporte;	
		$total_hito_sinimp += $_POST['transporte_valor_neto_total'];
	endif;

	//impuestos de toes
	$array_imp_toes = '';
	if($_POST['toes_totalconimpuesto'] > 0):
		$array_imp_toes = array(	'valor_neto'=>$_POST['toes_valor_neto_total'],
									'tipoimp'=>$_POST['toes_tipoimp'],
									'iva'=>$_POST['toes_iva'],
									'ica'=>$_POST['toes_ica'],
									'rtefuente'=>$_POST['toes_rtefuente'],
									'total'=>$_POST['toes_totalconimpuesto']
		);
		
		$toes = $_POST['toes_totalconimpuesto'];
		$total_toes += $toes;	
		$total_hito_sinimp += $_POST['toes_valor_neto_total'];	
	endif;
	
	//impuestos de viaticos
	$array_imp_viaticos = '';
	if($_POST['viaticos_totalconimpuesto'] > 0):
		$array_imp_viaticos = array(	'valor_neto'=>$_POST['viaticos_valor_neto_total'],
										'tipoimp'=>$_POST['viaticos_tipoimp'],
										'iva'=>$_POST['viaticos_iva'],
										'ica'=>$_POST['viaticos_ica'],
										'rtefuente'=>$_POST['viaticos_rtefuente'],
										'total'=>$_POST['viaticos_totalconimpuesto']
		);
		$viaticos = $_POST['viaticos_totalconimpuesto'];
		$total_viaticos += $viaticos;	
		$total_hito_sinimp += $_POST['viaticos_valor_neto_total'];
	endif;
									
	//impuestos de mular
	$array_imp_mular = '';
	if($_POST['mular_totalconimpuesto'] > 0):
		$array_imp_mular = array(	'valor_neto'=>$_POST['mular_valor_neto_total'],
									'tipoimp'=>$_POST['mular_tipoimp'],
									'iva'=>$_POST['mular_iva'],
									'ica'=>$_POST['mular_ica'],
									'rtefuente'=>$_POST['mular_rtefuente'],
									'total'=>$_POST['mular_totalconimpuesto']
		);
		$mular = $_POST['mular_totalconimpuesto'];
		$total_mular += $mular; 
		$total_hito_sinimp += $_POST['mular_valor_neto_total'];
	endif;
	
	//con impuestos el total del hito
	$total_hito += ($total_acpm+$total_transporte+$total_toes+$total_viaticos+$total_mular);
	
	//Consulta si el hito esta en opcion de carga ilimitada de ingresos	
	$sqlhito = mysql_query("SELECT ilimitado, estado, valor_cotizado_hito, factor, closed_ot, ot_cliente
							FROM hitos WHERE id =".$_POST['hitos']) or die('error:'.$sqlhito.' '.mysql_error());
	$rowshito = mysql_fetch_assoc($sqlhito);
	

	// 1 abierto, 0 cerrado	 
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
	
	//Verificar si el hito es pendiente
	/*if($rowshito['ot_cliente'] == 'PENDIENTE' ||  $rowshito['ot_cliente'] == ''):
		//Valida si el hito tiene la ot cerrado
		//0 = cerrado no puede ingresar
		//1 = puede ingresar sin importar si esta PENDIENTE 
		
		if($rowshito['closed_ot'] == 0):
			echo json_encode(array('estado'=>false, 'message'=>"Señor usuario no se puede cargar anticipos a este hito porque no tiene la OT CLIENTE, por favor solicite autorizaci&oacute;n a GERENCIA para HABILITAR EL HITO"));
			exit;
		endif;
	endif;	*/ 

	
	/*valida que el id hito no exceda los costo de la orden de servicio */
	if(!empty($_POST['id_os'])):
		$value = $obj->getValidateValorByOrdenservicio($_POST['id_os'],$_POST['hitos'],$total_hito_sinimp);
		if($value['estado']):
			echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a la orden de servicio.\n El valor Total OS:".$value['valor_os']." es mayor al Valor Total Hito: ".$value['valor_hito']." + $".number_format($total_hito_sinimp)));
			exit;
		endif;		
	endif;
	
	if($entra): 		
		$estadoCosto = true;		
		if(!empty($_POST['centro_costo_item']) || !empty($_POST['hitos'])):	
			$objeto = $obj->getTotalHito($_POST['hitos'],$_POST['centro_costo_item'],$total_hito_sinimp);
			$estadoCosto = $objeto['estado'];				
		endif;		
		if(!$estadoCosto):
			echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a este hito, solicite autorización de Gerencia.\n Los siguiente costos son:\n".$objeto['valores']));
			exit;
		endif;
	endif;
	
	
	$obj->setPitagoraHito('Agrego',$_POST['hitos'],$total_hito,$_POST['id'],$_SESSION['id']);
	
	//si es un reintegro
	if(!empty($_REQUEST['reintegro'])):
		//$valor_concepto = $obj->getValorConceptoFinanciero(14);
		$valor_concepto = $rowshito['factor'];
		$valor_galon = $_POST['acpm_valor_galon'];
		
		$neto = (int)$_POST['acpm_galones'] * $valor_galon;
		$retencion = ($neto * $valor_concepto) / 100;
		
		$_POST['acpm_valor_neto_total'] = $neto - $retencion;
		
		$total_hito = $_POST['acpm_valor_neto_total']+$_POST['transporte_valor_neto_total']+$_POST['toes_valor_neto_total']+$_POST['viaticos_valor_neto_total']+$_POST['mular_valor_neto_total'];
		
	/*else:
		$valor_galon = $_POST['acpm_valor_galon'];
		$valor_galon = str_replace($letters, $fruit, $valor_galon[0] );	
		
		$valor_concepto = $obj->getValorConceptoFinanciero(14);
		$neto = (int)$_POST['acpm_galones'] * (int)$valor_galon;
		$retencion = $neto * $valor_concepto;
		$acpm = $neto - $retencion;*/
	endif;
	
	
	//si es un vinculado
	if(!empty($_REQUEST['vinculado'])):
	
		$valor_galon = $_POST['acpm_valor_galon'];
		$neto = (int)$_POST['acpm_galones'] * $valor_galon;
		$_POST['acpm_valor_neto_total'] = $neto;
		
		$total_hito = $_POST['acpm_valor_neto_total']+$_POST['transporte_valor_neto_total']+$_POST['toes_valor_neto_total']+$_POST['viaticos_valor_neto_total']+$_POST['mular_valor_neto_total'];
	
	endif;
	
	
 	//07/03/2016 no se aplicara el valor concepto de los items
	/*if(!empty($_POST['toes'])):
		$valor_concepto = $obj->getValorConceptoFinanciero(15);
		
		$valor_toes = explode(',00',$_POST['toes']);
		
		$toesCal = str_replace($letters, $fruit, $valor_toes[0]);
		$_POST['toes'] = (int)( $toesCal - ($toesCal * $valor_concepto));
	endif;
	
	if(!empty($_POST['valor_transporte'])):
		$valor_concepto = $obj->getValorConceptoFinanciero(15);
		
		$valor_trans = explode(',00',$_POST['valor_transporte']);
		
		$toesCal = str_replace($letters, $fruit, $valor_trans[0]);
		$_POST['valor_transporte'] = (int)( $toesCal - ($toesCal * $valor_concepto));
	endif;*/

	
   $sql = sprintf("INSERT INTO `items_anticipo` VALUES ('',%d, %d, %d, %d, %d, %d, %d, %d, NULL, 2, %d, NOW(), %d, %d, %d, %d, '%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['id']),
		fn_filtro($_POST['hitos']),
		fn_filtro($_POST['acpm_valor_neto_total']),// sin Impuesto
		fn_filtro($_POST['transporte_valor_neto_total']),// sin Impuesto
		fn_filtro($_POST['toes_valor_neto_total']),// sin Impuesto
		fn_filtro($_POST['viaticos_valor_neto_total']),// sin Impuesto
		fn_filtro($_POST['mular_valor_neto_total']),// sin Impuesto
	    fn_filtro($total_hito), // con Impuesto
		fn_filtro($_SESSION['id']),
		fn_filtro($_POST['acpm_galones']),
		fn_filtro($valor_galon),
		fn_filtro($retencion),
		fn_filtro($_POST['id_os']),
		fn_filtro(serialize($array_imp_acpm)),
		fn_filtro(serialize($array_imp_viaticos)),
		fn_filtro(serialize($array_imp_transporte)),
		fn_filtro(serialize($array_imp_toes)),
		fn_filtro(serialize($array_imp_mular))		
        //fn_filtro(str_replace('.','',$_POST['valor_hito']))	
	);
	
	if(!mysql_query($sql)){
		//echo "Error al insertar un nuevo item:\n$sql";
		echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item:\n$sql"));
		exit;
		
	}else{

		$reintegro = 0;
		$acpm = 0;
		$valor_transporte = 0;
		$toes = 0;
		$total_acpm = 0;
		$total_transporte = 0;
		$total_toes = 0;
		$total_viaticos = 0;
		$total_mular = 0;
		$total_anticipo = 0;

		$resultado = mysql_query("SELECT SUM(total_hito) AS total FROM items_anticipo WHERE estado = 2 AND id_anticipo =".$_POST['id']) or die(mysql_error());
        $rows = mysql_fetch_assoc($resultado);
		$sum_total_itemsAnticipo = $rows['total'];
		
		$giro = 0;
		if($_POST['giro'] != 0){
			$giro = explode(',00',$_POST['giro']);
			$giro = str_replace($letters, $fruit, $giro[0] );
		}

		$total_anticipo = $sum_total_itemsAnticipo + $giro;	
		$total_anticipo = number_format($total_anticipo, 2, '.', ',');	

		/*----------------- Actualizar Anticipo --------------------------*/
		$sql = sprintf("UPDATE `anticipo` SET						
								giro='%s',
								total_anticipo='%s'				
						WHERE id=%d;",
						
			fn_filtro($_POST['giro']),
			fn_filtro($total_anticipo), //Sin impuesto
			fn_filtro((int)$_POST['id']) 
		);

		if(!mysql_query($sql)){

			echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el anticipo:\n$sql"));

			exit;

		}

		/*----------------- Actualizar Legalizacion --------------------------*/

		$sql = sprintf("UPDATE `legalizacion` SET						
								valor_fa='%s'				
						WHERE id_anticipo=%d;",
			fn_filtro($total_anticipo),
			fn_filtro((int)$_POST['id']) 
		);
		
		if(!mysql_query($sql)){
			echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar legalización:\n$sql"));
			exit;
		}

		echo json_encode(array('estado'=>true, 'total_anticipo'=>$total_anticipo));
		exit;
	}

?>