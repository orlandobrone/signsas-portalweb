<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(	   empty($_POST['nombre']) 

		|| empty($_POST['cedula']) 
		
		|| empty($_POST['id']) 

		|| empty($_POST['arp']) 

		|| empty($_POST['eps']) 

		|| empty($_POST['celular'])

		|| empty($_POST['region'])
		
		|| empty($_POST['cargo'])
		
		){

		echo "Usted no a llenado todos los campos";

		exit;

	}
	
	if($_POST['sueldo'] != 0):
	
		$sueldo = (int)str_replace('.','',$_POST['sueldo']);
		if($_POST['valor_plan'] != 0)
			$valor_plan = (int)str_replace('.','',$_POST['valor_plan']);
		else
			$valor_plan = 0;
		
		$resultado = mysql_query("SELECT concepto, valor FROM prestaciones") or die(mysql_error());
		
		$conceptos = array();
		
		while ($row_item = mysql_fetch_array($resultado, MYSQL_ASSOC))
			$conceptos[$row_item['concepto']] = $row_item['valor']; 
		
		/*if($sueldo<=($conceptos['1']*2))
			$valor_hora = (($sueldo+$conceptos['3']+$conceptos['4']+($sueldo*$conceptos['5'])+(($valor_plan/25)/8))/25)/8;
		else
			$valor_hora =((($sueldo*$conceptos['5'])+$sueldo+$conceptos['4']+(($valor_plan/25)/8))/25)/8;*/
			
		if($sueldo<=($conceptos['SALARIO BASICO']*2)):
			$valor_hora = (((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan) + $conceptos['SUBSIDIO DE TRANSPORTE'])/25)/8;
		else:
			$valor_hora = ((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan)/25)/8;
		endif;
		
	else:
		$sueldo = $_POST['sueldo'];
		$valor_hora = 0;
		$valor_plan = (int)str_replace('.','',$_POST['valor_plan']);
	endif;

	
	 

	/*modificar el registro*/



	$sql = sprintf("UPDATE `tecnico` SET nombre='%s', cedula='%s', ARP='%s', EPS='%s', celular='%s', region='%s', cargo='%s', valor_hora=%s, estado = %s, sueldo = %s, valor_plan = %s 

					WHERE id=%d;",

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['cedula']),

		fn_filtro($_POST['arp']),

		fn_filtro($_POST['eps']),

		fn_filtro($_POST['celular']),

		fn_filtro($_POST['region']),	

		fn_filtro($_POST['cargo']),

		fn_filtro($valor_hora),
		
		fn_filtro($_POST['estado']),

		fn_filtro($sueldo),
		
		fn_filtro($valor_plan),

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))
		echo "Error al actualizar el funcionario:\n$sql";
		
		
	if(isset($_POST['cambio_estado'])):
		$sql = sprintf("UPDATE `tecnico` SET estado_registro = %d WHERE id=%d",
			(int)$_POST['cambio_estado'],
			(int)$_POST['id']
		);
		if(!mysql_query($sql))
			echo "Ocurrio un error al cambio de estado\n$sql";
	endif;

	exit;

?>