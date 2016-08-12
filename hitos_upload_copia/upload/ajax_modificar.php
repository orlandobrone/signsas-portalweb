<?
    //include "../../restrinccion.php";
	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";	
	
	$query = "SELECT * FROM hitos_upload WHERE 1 ORDER BY id ASC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	//$row = mysql_fetch_array($result, MYSQL_ASSOC);
	 
	$cadena = '';
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)):
			
		$cadena = '';
		$query2 = "SELECT * FROM hitos WHERE id = ".$row['id_hito'];
		$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());
		$row_h = mysql_fetch_array($result2, MYSQL_ASSOC);
		
		//cantidad de galones 
		if($row_h['cant_galones_h'] == 0):
			$cadena .= ' cant_galones_h = '.$row['cant_galones'].',';
		endif;
		
		//validacion de PO
		if($row_h['factura'] == 'N/A' || $row_h['factura'] == 'PENDIENTE' || empty($row_h['factura'])):
			$cadena .= 'po = "'.$row['po'].'", 
						gr = "'.$row['gr'].'", 
						factura = "'.$row['factura'].'", 
						valor_facturado = "'.$row['valor_facturado'].'", 
						fecha_facturado1 = "'.$row['fecha_facturado'].'",';
						 
		elseif($row_h['factura2'] == 'N/A' || $row_h['factura2'] == 'PENDIENTE' || empty($row_h['factura2'])):
			$cadena .= 'po2 = "'.$row['po'].'", 
						gr2 = "'.$row['gr'].'", 
						factura2 = "'.$row['factura'].'", 
						valor_facturado2 = "'.$row['valor_facturado'].'", 
						fecha_facturado2 = "'.$row['fecha_facturado'].'",';
						
		elseif($row_h['factura3'] == 'N/A' || $row_h['factura3'] == 'PENDIENTE' || empty($row_h['factura3'])):
			$cadena .= 'po3 = "'.$row['po'].'", 
						gr3 = "'.$row['gr'].'", 
						factura3 = "'.$row['factura'].'", 
						valorfacturado3 = "'.$row['valor_facturado'].'", 
						fecha_facturado3 = "'.$row['fecha_facturado'].'",';
			
		elseif($row_h['factura4'] == 'N/A' || $row_h['factura4'] == 'PENDIENTE' || empty($row_h['factura4'])):
			$cadena .= 'po4 = "'.$row['po'].'",
						gr4 = "'.$row['gr'].'", 
						factura4 = "'.$row['factura'].'",
						valorfacturado4 = "'.$row['valor_facturado'].'", 
						fecha_facturado4 = "'.$row['fecha_facturado'].'",';
		endif;	
		
	
		$cadena = substr($cadena,0, -1);
		$query_update = "UPDATE hitos SET ".$cadena." WHERE id = ".$row['id_hito'];
		
		if(!empty($cadena)):
		
			//actualizo el hito
			if(!mysql_query($query_update)):
				echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el hito 1", 'query'=>$query_update));
				exit;
			endif;		
		
			// seleccionar la mayor fecha
			$query2 = "SELECT * FROM hitos WHERE id = ".$row['id_hito'];
			$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());
			$row_h = mysql_fetch_array($result2, MYSQL_ASSOC);
			
			$fechas = array($row_h['fecha_facturado1'],$row_h['fecha_facturado2'],$row_h['fecha_facturado3'],$row_h['fecha_facturado4']);		
			$fecha_facturado =  max($fechas); 
			
			
			//cambiar estado de las fechas
			$estado = 'FACTURADO';			
			/*if($row_h['fecha_facturado'] != '0000-00-00'):
				$estado = 'FACTURADO';
			elseif($row_h['fecha_facturacion'] != '0000-00-00' ):
				$estado = 'EN FACTURACION';
			elseif($row_h['fecha_liquidacion'] != '0000-00-00'):
				$estado = 'LIQUIDADO';
			elseif($row_h['fecha_informe'] != '0000-00-00'):
				$estado = 'INFORME ENVIADO';
			elseif($row_h['fecha_ejecutado'] != '0000-00-00'):
				$estado = 'EJECUTADO';
			elseif($row_h['fecha_inicio_ejecucion'] != '0000-00-00'):
				$estado = 'EN EJECUCION';
			else:
				$estado = 'PENDIENTE';
			endif;*/
			
			$cadena2 = '';
			if($row_h['fecha_liquidacion'] == '0000-00-00'):
				$cadena2 =  ' fecha_liquidacion = "'.$row_h['fecha_facturado1'].'", ';  
			endif;
		 
			
			//volver actualizar el hito por la fecha facturado
			$query_update = "UPDATE hitos SET ".$cadena2." fecha_facturado = '".$fecha_facturado."', estado = '".$estado."' WHERE id = ".$row['id_hito'];
			if(!mysql_query($query_update)):
				echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar el hito 2"));
				exit;
			endif;	
			
		
		endif;	
				
	endwhile;
	
	
	$query = "TRUNCATE hitos_upload";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	
	echo json_encode(array('estado'=>true));
		
	exit;

	
	//$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());
	/*$sql = sprintf("UPDATE prestaciones SET concepto='%s', valor='%s' where id=%d;", 
		fn_filtro($_POST['concepto']),
		fn_filtro(str_replace(",","",$_POST['valor'])),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql)):
		echo "Error al actualizar el concepto:\n$sql";
	endif;*/

?>