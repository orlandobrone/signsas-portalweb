<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	print_r($_REQUEST['data']);

	/*verificamos si las variables se envian*/
	if(empty($_REQUEST['data'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	
	foreach($_REQUEST['data'] as $row):
	
		$cantTotalGal = (int)$row['cant_galones']-(int)$row['reintegro'];
			
		$sql = sprintf("UPDATE items_anticipo SET cant_galones='%d' WHERE id=%d;",
			fn_filtro($cantTotalGal),	
			fn_filtro((int)$row['iditem'])
		);
		
		if(!mysql_query($sql))
			echo "Error al actualizar el beneficiario:\n$sql";				
		
	endforeach;
	
	
	exit;
?>