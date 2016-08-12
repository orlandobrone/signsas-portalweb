<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	$sql = sprintf("INSERT INTO `items` VALUES ('',  '',  '',  '',  '', '%s', '%s', '%s', '%s', '%s', '%s',0);",

		fn_filtro($_POST['concepto']),

		fn_filtro(str_replace('.','',$_POST['pagado'])),		

		fn_filtro($_POST['id_legalizacion']),

		fn_filtro($_POST['id_proyecto']),

		fn_filtro($_POST['id_hito']), 

		fn_filtro($_POST['cantidad']) 

	);



	if(!mysql_query($sql)){

		//echo "Error al insertar un nuevo item:\n$sql";

		echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item:\n$sql"));

		exit;



	}else{

		

		$letters = array('.','$',',');

		$fruit   = array('');		

		

		$reintegro = 0;

		$valor_pagar = 0;

		$valor_reintegro = 0;

		$valor_legalizado = 0;

		

		$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".$_POST['id_legalizacion']) or die(mysql_error());

		$total = mysql_num_rows($resultado);

		while ($rows = mysql_fetch_assoc($resultado)):

			if($rows['pagado'] != ''):

				/*$valor = substr($rows['pagado'],0, -3);

				$valor2 = str_replace($letters, $fruit, $valor);

				$valor_legalizado += $valor2;*/
				
				$valor_legalizado += (int)$rows['pagado'];

			endif;

		endwhile;

		

		//$rest = substr("abcdef", 0, -1);  // devuelve "abcde"

		

		$sql = sprintf("SELECT valor_fa FROM legalizacion WHERE id=%d",

				(int)$_POST['id_legalizacion']

		);

			

		$per = mysql_query($sql);
		$rs_per = mysql_fetch_assoc($per);
		

		$valor = substr($rs_per['valor_fa'],0, -3);
		$valor_fondo = str_replace($letters, $fruit, $valor);		


		if($valor_legalizado != 0 ):

			$reintegro = $valor_fondo - $valor_legalizado;

		endif;

		

		if($valor_legalizado > $valor_fondo):			

			$valor_pagar = $valor_legalizado - $valor_fondo;

			$reintegro = 0;

		endif;

		setlocale(LC_MONETARY, 'en_US');

		//number_format($total_anticipo, 2, '.', ',');		

		$valor_pagar = money_format('%(#1n',$valor_pagar);

		$valor_reintegro = money_format('%(#1n',$reintegro);

		$valor_legalizado = money_format('%(#1n',$valor_legalizado);
			

		echo json_encode(array('estado'=>true, 'valor_legalizado'=>$valor_legalizado, 'valor_reintegro'=>$valor_reintegro, 'valor_pagar'=>$valor_pagar));

		exit;

	}



	

?>