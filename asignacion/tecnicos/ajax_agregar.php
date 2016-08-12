<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(	   empty($_POST['nombre']) 

		|| empty($_POST['cedula']) 

		|| empty($_POST['arp']) 

		|| empty($_POST['eps']) 

		|| empty($_POST['celular'])

		|| empty($_POST['region'])
		
		|| empty($_POST['cargo'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}
	
	$obj = new TaskCurrent;
	
	if($obj->existCedulaByTecnico($_POST['cedula'])):
		echo "La cedula ingresada ya fue registrada"; 
		exit;
	endif;
	
	
	if($_POST['sueldo'] != '0,00'):
	
		$sueldo = (int)str_replace('.','',$_POST['sueldo']);
		if($_POST['valor_plan'] != '0,00')
			$valor_plan = (int)str_replace('.','',$_POST['valor_plan']);
		else
			$valor_plan = 0;
	
		$resultado = mysql_query("SELECT concepto, valor FROM prestaciones") or die(mysql_error());
		
		$conceptos = array();
		
		while ($row_item = mysql_fetch_array($resultado, MYSQL_ASSOC))
			$conceptos[$row_item['concepto']] = $row_item['valor']; 
	
		if($sueldo<=($conceptos['SALARIO BASICO']*2)):
			$valor_hora = (((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan) + $conceptos['SUBSIDIO DE TRANSPORTE'])/25)/8;
		else:
			$valor_hora = ((($sueldo * $conceptos['FACTOR PRESTACIONAL']) + $conceptos['DOTACION'] + $valor_plan)/25)/8;
		endif;
		
	else:
		$sueldo = 0;
		$valor_hora = 0;
		$valor_plan = (int)str_replace('.','',$_POST['valor_plan']);
	endif;
	
	$sql = sprintf("INSERT INTO `tecnico` (`id`, `nombre`, `cedula`, `ARP`, `EPS`, `celular`, `region`, `cargo`, `estado`, `sueldo`, `valor_plan`, `valor_hora`, `estado_registro`, `fecha_creacion`) VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s, %s, %s, '%s', 0, NOW());",

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['cedula']),

		fn_filtro($_POST['arp']),

		fn_filtro($_POST['eps']),

		fn_filtro($_POST['celular']),

		fn_filtro($_POST['region']),

		fn_filtro($_POST['cargo']),
		
		fn_filtro($_POST['estado']),
		
		fn_filtro($sueldo),
		
		fn_filtro($valor_plan),
		
		fn_filtro($valor_hora)

	);



	if(!mysql_query($sql))

		echo "Error al insertar el nuevo tecnico:\n$sql"; 



	exit;

?>