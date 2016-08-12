<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['estado']) || empty($_POST['fecestado'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$campo = '';
	
	switch($_POST['estado']):
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
	endswitch;
	

	$sql = sprintf("UPDATE hitos SET estado='%s' ".$campo." WHERE id=%d;",
		fn_filtro($_POST['estado']),  
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el hito:\n$sql";
	exit;
?>