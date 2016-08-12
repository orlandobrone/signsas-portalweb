<?
include "../../conexion.php";
include "../extras/php/basico.php";

$obj = new TaskCurrent;

/*verificamos si las variables se envian*/
if( empty($_REQUEST['id_hito']) || empty($_REQUEST['id_anticipo_select']) || empty($_REQUEST['id_hito_transferir']) ){
  echo "Usted no a llenado todos los campos";
  exit;
}


$calcular = false;

/*--------------------- Validar los costos del HITO --------------------*/
if(!$obj->ValidateHitoIlimitado($_REQUEST['id_hito_transferir'])):

	$iditem = $obj->getIDItemAnticipo($_REQUEST['id_anticipo_select'],$_REQUEST['id_hito']);

	$item = $obj->getImpuestoByAnticipoItem($iditem);
	
	if(is_array($item)):
		//Suma el costo del hito con el anticipo
		$totalHitoSinImpuestos = 0;
		foreach($item as $value):
			if(is_array($value))
				$totalHitoSinImpuestos += $value['valor_neto'];
		endforeach;
		
		$objeto = $obj->getTotalHito($_REQUEST['id_hito_transferir'],0,$totalHitoSinImpuestos);
		
		if(!$objeto['estado']):
			echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a este hito, solicite autorización de Gerencia.\n Los siguiente costos son:\n".$objeto['valores']));
			exit;
		//Se hace la transferencia del hito
		elseif($obj->updateTrasnferenciaHito($iditem,$_REQUEST['id_hito_transferir'])):
		
			/*---------------------Actualiza el estado del hito --------------------*/
			$sql = sprintf("UPDATE `hitos` SET estado = 'TRANSFERIDO'			
							WHERE id = %d;",
				fn_filtro((int)$_REQUEST['id_hito']) 
			);
			
			if(!mysql_query($sql)){
				echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el estado del hito:\n$sql"));
				exit;
			}		
			
			//registra en pitagora el evento de agregar por transferencia
			$obj->setPitagoraHito('Transferencia',$_REQUEST['id_hito'],$totalHitoSinImpuestos,$_REQUEST['id_hito_transferir'],$_SESSION['id']);
			
			// se borra los items de la legalizacion que tenga el id hito
			if($obj->deleteItemsLegalizacionByAnticipo($_REQUEST['id_anticipo_select'],$_REQUEST['id_hito'])):
				//eliminar los items de anticipo por el id hito
				if($obj->deleteItemsAnticipoByHito($_REQUEST['id_anticipo_select'],$_POST['id_hito'])):
					$calcular = true;
				else:
					echo json_encode(array('estado'=>false, 'message'=>"Error: no se logro eliminar los items de la legalizacion"));
					exit;		
				endif;
			
			else:
				echo json_encode(array('estado'=>false, 'message'=>"Error: no se logro eliminar los items de la legalización"));
				exit;	
			endif;
		else:
			echo json_encode(array('estado'=>false, 'message'=>"Error: no se logro hacer la transferencia consulte con el area de sistemas"));
			exit;	
		endif;	
					
	endif;		

endif;
	
	
if($calcular):

	$letters = array('.');
	$fruit   = array('');		
	
	$acpm = 0;
	$valor_transporte = 0;
	$toes = 0;
	
	$total_acpm = 0;
	$total_transpornte = 0;
	$total_toes = 0;
	$total_anticipo = 0;	
	
	$sql = "SELECT *, (SELECT giro FROM anticipo WHERE id = ".$_REQUEST['id_anticipo_select'].") AS giro
			FROM items_anticipo 
			WHERE estado = 1 AND id_anticipo = ".$_REQUEST['id_anticipo_select'];
	$resultado = mysql_query($sql) or die(mysql_error());
	
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
	
	if($rows['giro'] != 0){
		$giro = explode(',00',$rows['giro']);
		$giro = str_replace($letters, $fruit, $giro[0]);
	}
	
	$total_anticipo = $total_acpm + $total_toes + $total_anticipo + $giro;	
	$total_anticipo = number_format($total_anticipo, 2, '.', ',');


	/*----------------- Actualizar Anticipo --------------------------*/

	$sql = sprintf("UPDATE `anticipo` SET total_anticipo='%s'				
					WHERE id=%d;",
		fn_filtro($total_anticipo),
		fn_filtro((int)$_REQUEST['id_anticipo_select']) 
	);

	if(!mysql_query($sql)){
		echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el anticipo:\n$sql"));
		exit;
	}

	/*----------------- Actualizar Legalizacion --------------------------*/

	$sql = sprintf("UPDATE `legalizacion` SET valor_fa='%s', estado = 'NO REVISADO'			
					WHERE id_anticipo=%d;",
		fn_filtro($total_anticipo),
		fn_filtro((int)$_REQUEST['id_anticipo_select']) 
	);
	
	if(!mysql_query($sql)){
		echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar legalización:\n$sql"));
		exit;
	}	
		
	echo json_encode(array("estado"=>true));

	exit;
	
endif;

?>