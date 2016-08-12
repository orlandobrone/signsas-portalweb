<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$sql = sprintf("UPDATE items SET estado = 1 WHERE id=%d",
		(int)$_POST['IdDelete']
	);
	if(!mysql_query($sql)){
		//echo "Error al insertar un nuevo item:\n$sql";
		echo json_encode(array('estado'=>false, 'message'=>"Error al elimar el item:\n$sql"));
		exit;

	}else{
		
		$letters = array('.','$',',');
		$fruit   = array('');		
		
		$reintegro = 0;
		$valor_pagar = 0;
		$valor_reintegro = 0;
		$valor_legalizado = 0;
		
		$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 1 AND  id_legalizacion =".$_POST['id_legalizacion']) or die(mysql_error());
		$total = mysql_num_rows($resultado);
		while ($rows = mysql_fetch_assoc($resultado)):
			if($rows['pagado'] != 0):
				$valor = explode(',00',$rows['pagado']);
				$valor2 = str_replace($letters, $fruit, $valor[0] );
				$valor_legalizado += $valor2;
			endif;
		endwhile;
		
		$sql = sprintf("select valor_fa from legalizacion where id=%d",
				(int)$_POST['id_legalizacion']
		);
			
		$per = mysql_query($sql);
		$rs_per = mysql_fetch_assoc($per);
		
		$valor = substr($rs_per['valor_fa'],0, -3);
		$valor_fondo = str_replace($letters, $fruit, $valor );		
		
		if($valor_legalizado != 0 ):
			$reintegro = $valor_fondo - $valor_legalizado;
		endif;
		
		if($valor_legalizado > $valor_fondo):			
			$valor_pagar = $valor_legalizado - $valor_fondo;
			$reintegro = 0;
		endif;
		
		$valor_pagar = '$'.number_format($valor_pagar).',00';
		$valor_reintegro = '$'.number_format($reintegro).',00';
		$valor_legalizado = '$'.number_format($valor_legalizado).',00';
			
		
		echo json_encode(array('estado'=>true, 'valor_legalizado'=>$valor_legalizado, 'valor_reintegro'=>$valor_reintegro, 'valor_pagar'=>$valor_pagar));
		exit;
	}
?>