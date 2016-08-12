<?php
include "conexion.php";

/*
$query = "UPDATE hitos INNER JOIN proyectos ON hitos.id_proyecto = proyectos.id 
SET hitos.estado =  'LIQUIDADO', hitos.fecha_inicio_ejecucion = NOW(), hitos.fecha_ejecutado = NOW(), hitos.fecha_informe = NOW(), hitos.fecha_liquidacion = NOW()
WHERE proyectos.id_centroscostos =6";*/
//Cambio de estado de un hito admin a estado CERRADO
$query = "UPDATE hitos INNER JOIN proyectos ON hitos.id_proyecto = proyectos.id 
SET hitos.estado = 'CERRADO', hitos.fecha_inicio_ejecucion = NOW(), hitos.fecha_ejecutado = NOW(), hitos.fecha_informe = NOW(), hitos.fecha_liquidacion = NOW()
WHERE proyectos.id_centroscostos = 6";
  
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

$sql = "SELECT id
		FROM proyectos 
		WHERE estado IN('E','P')";
$result = mysql_query($sql); 	

while($row = mysql_fetch_assoc($result)):

	$sqlr = "SELECT COUNT(*) AS total_facturados, 
			(SELECT COUNT(*) FROM hitos WHERE estado NOT IN('ELIMINADO') AND id_proyecto = ".$row['id'].") AS total_hitos,
			(SELECT COUNT(*) FROM hitos WHERE estado IN('LIQUIDADO') AND id_proyecto = ".$row['id'].") AS total_hitos_liquidados  
			FROM hitos WHERE estado IN('FACTURADO') AND id_proyecto = ".$row['id'];
	$pair = mysql_query($sqlr); 	
	$rs_pair = mysql_fetch_assoc($pair);
	
	$estado = 'E';
	
	if($rs_pair['total_facturados'] == $rs_pair['total_hitos']):
		$estado = 'F';	
	elseif($row['total_hitos_liquidados'] > 0):
		$estado = 'P';	
	endif;
	
	if($estado != 'E' && $rs_pair['total_hitos'] > 0):
	
		$queryU = "UPDATE proyectos 
				   SET estado = '".$estado."'
				   WHERE id = ".$row['id'];
				  
		mysql_query($queryU) or die("SQL Error 1: " . mysql_error());
	endif;
	
endwhile;

?> 