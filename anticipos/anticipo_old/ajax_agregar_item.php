<?
	session_start();
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;	

	/*verificamos si las variables se envian*/

	if(empty($_POST['id']) || empty($_POST['hitos'])){
		echo json_encode(array('estado'=>false, 'message'=>"No han llegado todos los campos"));
		exit;
	}


	$letters = array('.');
	$fruit   = array('');

	$acpm = 0;
	$valor_transporte = 0;
	$toes = 0;
	$total_acpm = 0;
	$total_transporte = 0;
	$total_toes = 0;
	$total_hito = 0;	

	$acpm = explode(',00',$_POST['acpm']);
	$acpm = str_replace($letters, $fruit, $acpm[0] );
	$total_acpm += $acpm;

	$valor_transporte = explode(',00',$_POST['valor_transporte']);
	$valor_transporte = str_replace($letters, $fruit, $valor_transporte[0] );
	$total_transporte += $valor_transporte;	

	$toes = explode(',00',$_POST['toes']);
	$toes = str_replace($letters, $fruit, $toes[0] );
	$total_toes += $toes;
	
	$total_hito += ($total_acpm+$total_transporte+$total_toes);
	
	// Consulta si el hito esta en opcion de carga ilimitada de ingresos	
	$sqlhito = mysql_query("SELECT ilimitado, estado, valor_cotizado_hito, factor, closed_ot, ot_cliente
							FROM hitos WHERE id =".$_POST['hitos']) or die('error:'.$sqlhito.' '.mysql_error());
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
	
	$obj->setPitagoraHito('Agrego',$_POST['hitos'],$total_hito,$_POST['id'],$_SESSION['id']);

	if(!empty($_REQUEST['reintegro']) ):
		//$valor_concepto = $obj->getValorConceptoFinanciero(14);
		$valor_concepto = $rowshito['factor'];
		$valor_galon = explode(',00',$_POST['valor_galon']);
		$valor_galon = str_replace($letters, $fruit, $valor_galon[0] );	
		
		//echo $neto = (int)$_POST['galones'].'*'.(int)$valor_galon;
		
		$neto = (int)$_POST['galones'] * (int)$valor_galon;
		$retencion = ($neto * $valor_concepto) / 100;
		$acpm = $neto - $retencion;
		
		//echo $neto.' - '.$retencion;
		
	else:
		$valor_galon = explode(',00',$_POST['valor_galon']);
		$valor_galon = str_replace($letters, $fruit, $valor_galon[0] );	
		
		$valor_concepto = $obj->getValorConceptoFinanciero(14);
		$neto = (int)$_POST['galones'] * (int)$valor_galon;
		$retencion = $neto * $valor_concepto;
		$acpm = $neto - $retencion;
	endif;
 	
	if(!empty($_POST['toes'])):
		$valor_concepto = $obj->getValorConceptoFinanciero(15);
		
		$valor_toes = explode(',00',$_POST['toes']);
		
		$toesCal = str_replace($letters, $fruit, $valor_toes[0]);
		$_POST['toes'] = (int)( $toesCal - ($toesCal * $valor_concepto)).',00';
	endif;
	
	if(!empty($_POST['valor_transporte'])):
		$valor_concepto = $obj->getValorConceptoFinanciero(15);
		
		$valor_trans = explode(',00',$_POST['valor_transporte']);
		
		$toesCal = str_replace($letters, $fruit, $valor_trans[0]);
		$_POST['valor_transporte'] = (int)( $toesCal - ($toesCal * $valor_concepto)).',00';
	endif;

	
   $sql = sprintf("INSERT INTO `items_anticipo` VALUES ('','%s', '%s', '%s', '%s', '%s', '%s', NULL, 2, %d, NOW(), %d, %d, %d);",
		fn_filtro($_POST['id']),
		fn_filtro($_POST['hitos']),
		fn_filtro((int)$acpm.',00'),
		fn_filtro($_POST['valor_transporte']),
		fn_filtro($_POST['toes']),
	    fn_filtro($total_hito),
		fn_filtro($_SESSION['id']),
		fn_filtro($_POST['galones']),
		fn_filtro($valor_galon),
		fn_filtro($retencion)
        //fn_filtro(str_replace('.','',$_POST['valor_hito']))	
	);
	

	if(!mysql_query($sql)){
		//echo "Error al insertar un nuevo item:\n$sql";
		echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item:\n$sql"));
		exit;
		
	}else{

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

		$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 2 AND id_anticipo =".$_POST['id']) or die(mysql_error());

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

		

		/*----------------- Acttualizar Anticipo --------------------------*/
		$sql = sprintf("UPDATE `anticipo` SET						

								giro='%s',

								total_anticipo='%s'				

						WHERE id=%d;",

			fn_filtro($_POST['giro']),

			fn_filtro($total_anticipo),

			fn_filtro((int)$_POST['id']) 

		);

		if(!mysql_query($sql)){

			echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el anticipo:\n$sql"));

			exit;

		}

		/*----------------- Acttualizar Legalizacion --------------------------*/

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