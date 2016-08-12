<?

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	$resultadot = mysql_query("SELECT * FROM  `tecnico` WHERE id = 224 ") or die(mysql_error());
	$row = mysql_fetch_array($resultadot, MYSQL_ASSOC);
	

	$sueldo = $row['sueldo'];
	$valor_plan = $row['valor_plan'];
	
	$resultado = mysql_query("SELECT concepto, valor FROM prestaciones") or die(mysql_error());
	$conceptos = array();
	while ($row_item = mysql_fetch_array($resultado, MYSQL_ASSOC))
		$conceptos[$row_item['concepto']] = $row_item['valor']; 
	
	print_r($conceptos);	
	
	echo '<br>';
		
	if($sueldo<=($conceptos['SALARIO BASICO']*2)):
		$valor_hora = (((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan) + $conceptos['SUBSIDIO DE TRANSPORTE'])/25)/8;
	else:
		$valor_hora = ((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan)/25)/8;
	endif;
?>