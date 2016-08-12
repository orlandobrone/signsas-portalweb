<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;	

	/*verificamos si las variables se envian*/
	if(empty($_POST['id_os']) || empty($_POST['hitos'])){
		echo json_encode(array('estado'=>false, 'message'=>"No han llegado todos los campos"));
		exit;
	}
	
	$letters = array('.');
	$fruit   = array('');
	
	$_POST['valor_unitario'] = str_replace($letters, $fruit,$_POST['valor_unitario']);
	$total = (int)$_POST['cantidad'] * $_POST['valor_unitario'];
	
	//valida si el hito existe en otro OS
	if($_POST['validarhito']):
		if($obj->getValidateItemOSByHito((int)$_POST['hitos'],(int)$_POST['id_os'])):
		
			$idos = $obj->getIdOSByHito((int)$_POST['hitos'],(int)$_POST['id_os']);
		
			echo json_encode(array('estado'=>false, 'message'=>'El hito #'.$_POST['hitos'].', ya se encuentra registrado en la(s) OS #'.$idos));
			
			exit;
		endif;
	endif;
	
	
	//valida si el hito es ilimitado
	if(!$obj->ValidateHitoIlimitado($_POST['hitos'])):
	
		/*valida que el id hito no exceda los costo del hito */
		$objeto = $obj->getTotalHito($_POST['hitos'],$_POST['centro_costo_item'],$total);
		$estadoCosto = $objeto['estado'];				
			
		if(!$estadoCosto):
			echo json_encode(array('estado'=>false, 'message'=>"Esta excediendo los costos asociados a este hito, solicite autorización de Gerencia.\n Los siguiente costos son:\n".$objeto['valores']));
			exit;
		endif;
	endif;

	
    $sql = sprintf("INSERT INTO `items_ordenservicio` VALUES ('',%d, %d, '%s', '%s', %d, %d, %d,'%s',0,NOW());",
		fn_filtro($_POST['id_os']),
		fn_filtro($_POST['hitos']),
		fn_filtro($_POST['descripcion']),
		fn_filtro($_POST['po_ticket']),
	    fn_filtro((int)$_POST['cantidad']),
		fn_filtro($_POST['valor_unitario']),
		fn_filtro($total),
		fn_filtro($_POST['forma_pago'])
        //fn_filtro(str_replace('.','',$_POST['valor_hito']))	
	);
	

	if(!mysql_query($sql)){
		//echo "Error al insertar un nuevo item:\n$sql";
		echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item:\n$sql"));
		exit;
	}else{
		//obtiene todos los items
		$sql5 = "SELECT SUM(total) AS total
				 FROM `items_ordenservicio` 
				 WHERE estado IN(0,2) AND id_ordenservicio = ".$_POST['id_os'];				 
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);		
		$rs_pai5['total'] = (int)$rs_pai5['total'];		
		
		echo json_encode(array('estado'=>true,'total_neto'=>$rs_pai5['total']));
		exit;
	}


?>