<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	/*if(empty($_POST['po'])){

		echo "Usted no a llenado la P.O.";

		exit;

	}*/

	

	/*switch($_POST['estado']):

		case 'EN EJECUCIÓN':

			$campo = ' ,fecha_inicio_ejecucion = "'.$_POST['fecestado'].'"'; 

		break;

		case 'EJECUTADO':

			$campo = ' ,fecha_ejecutado = "'.$_POST['fecestado'].'"'; 

		break;

		case 'LIQUIDADO':

			$campo = ' ,fecha_liquidacion = "'.$_POST['fecestado'].'"'; 

		break;

		case 'INFORME ENVIADO':

			$campo = ' ,fecha_informe = "'.$_POST['fecestado'].'"'; 

		break;

		case 'EN FACTURACIÓN': 

			$campo = ' ,fecha_facturacion = "'.$_POST['fecestado'].'"'; 

		break;

		case 'FACTURADO':

			$campo = ' ,fecha_facturado = "'.$_POST['fecestado'].'"'; 

		break;

	endswitch;*/

	$campo = '';
	$estado = '';
	
	
	if($_POST['fecha_facturado'] != '0000-00-00'):

		$estado = 'FACTURADO';

	elseif($_POST['fecha_facturacion'] != '0000-00-00'):

		$estado = 'EN FACTURACIÓN';

	elseif($_POST['fecha_liquidacion'] != '0000-00-00'):

		$estado = 'LIQUIDADO';

	elseif($_POST['fecha_informe'] != '0000-00-00'):

		$estado = 'INFORME ENVIADO';

	elseif($_POST['fecha_ejecutado'] != '0000-00-00'):

		$estado = 'EJECUTADO';

	elseif($_POST['fecha_inicio_ejecucion'] != '0000-00-00'):

		$estado = 'EN EJECUCIÓN';

	endif;
	
	
	if(!empty($_POST['estadofgr'])){		
		$estado = $_POST['estadofgr'];
	}

	

	$campo .= ' ,fecha_facturado = "'.$_POST['fecha_facturado'].'"'; 

	$campo .= ' ,fecha_facturacion = "'.$_POST['fecha_facturacion'].'"'; 

	$campo .= ' ,fecha_liquidacion = "'.$_POST['fecha_liquidacion'].'"'; 

	$campo .= ' ,fecha_informe = "'.$_POST['fecha_informe'].'"';

	$campo .= ' ,fecha_ejecutado = "'.$_POST['fecha_ejecutado'].'"';

	$campo .= ' ,fecha_inicio_ejecucion = "'.$_POST['fecha_inicio_ejecucion'].'"';
	
	

	$sql = sprintf("UPDATE hitos SET po='%s', gr='%s', factura='%s', po2='%s', gr2='%s', factura2='%s', estado='%s' ".$campo." WHERE id=%d;",

		fn_filtro($_POST['po']),

		fn_filtro($_POST['gr']), 

		fn_filtro($_POST['factura']), 

		fn_filtro($_POST['po2']),

		fn_filtro($_POST['gr2']), 

		fn_filtro($_POST['factura2']), 

		fn_filtro($estado), 

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))

		echo "Error al actualizar el hito:\n$sql";

	exit;

?>