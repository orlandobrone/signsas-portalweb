<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	setlocale(LC_MONETARY, 'en_US');		
	
	/*verificamos si las variables se envian*/
	if(	empty($_POST['id_ingreso']) || 
		empty($_POST['id_hitos']) || 
		empty($_POST['descripcion_hito']) || 
		empty($_POST['valor']) || 
	   	empty($_POST['fecha_term_hito'])
	   ){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	
	$letters = array(',','$','.',' ');
	$fruit   = array('');
	
	$valor = substr($_POST['valor'],0, -3);
	$valor = str_replace($letters, $fruit, $valor);

	$saldo_mt = substr($_POST['saldo_mt'],0, -3);
	$saldo_sm = substr($_POST['saldo_sm'],0, -3);	
	$saldo_mt = str_replace($letters, $fruit, $saldo_mt);
	$saldo_sm = str_replace($letters, $fruit, $saldo_sm);
	
	/*if($saldo_sm == 0 || $saldo_mt == 0):
		echo json_encode(array('estado'=>false,'mensaje'=>'El Saldo es 0, NO puede agregar'));	
		exit;
	endif;*/
	
	$resultado = mysql_query(" SELECT id_centroscostos
							   FROM orden_trabajo
							   WHERE id_proyecto =".$_POST['id_proyecto']) or die(mysql_error());
	$rows = mysql_fetch_assoc($resultado);
	$id_centroscostos = $rows['id_centroscostos'];
	
	if($id_centroscostos == 3 && $saldo_mt == 0):
		echo json_encode(array('estado'=>false,'mensaje'=>'El Saldo es 0, NO puede agregar'));	
		exit;
	endif;
	
	if($id_centroscostos == 4 && $saldo_sm == 0):
		echo json_encode(array('estado'=>false,'mensaje'=>'El Saldo es 0, NO puede agregar'));	
		exit;
	endif;
	
	
	switch($id_centroscostos):
		case 3://MT
			if($saldo_mt >= $valor):
				$saldo_mt = $saldo_mt - $valor;			
				$saldo_mt = trim(money_format('%(#1n',$saldo_mt));
				$saldo_sm = trim(money_format('%(#1n',$saldo_sm));
			else:
				echo json_encode(array('estado'=>false,'mensaje'=>'El Saldo no puede ser mayor a Saldo MT'));	
				exit;
			endif;
		break;
		case 4://SM
			if($saldo_sm >= $valor):
				$saldo_sm = $saldo_sm - $valor;			
				$saldo_sm = trim(money_format('%(#1n',$saldo_sm));
				$saldo_mt = trim(money_format('%(#1n',$saldo_mt));
			else:
				echo json_encode(array('estado'=>false,'mensaje'=>'El Saldo no puede ser mayor a Saldo SM'));	
				exit;
			endif;
		break;
	endswitch;
	 
		
	$sql = sprintf("INSERT INTO `items_ingresos` (id_ingresos, id_hitos, descripcion_hito, fecha_term_hito, valor,id_centroscostos) 
					VALUES ('%s', '%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['id_ingreso']),
		fn_filtro($_POST['id_hitos']),
		fn_filtro($_POST['descripcion_hito']),
		fn_filtro($_POST['fecha_term_hito']),
		fn_filtro($_POST['valor']),	
		fn_filtro($id_centroscostos)		
	);

	if(!mysql_query($sql)){
		echo "Error al insertar un nuevo item:\n$sql";
		exit;
	}
		
		
	echo json_encode(array('estado'=>true,'saldo_mt'=>trim($saldo_mt),'saldo_sm'=>trim($saldo_sm)));	
	exit;
?>