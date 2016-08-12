<?php

include '../../conexion.php';


//OT-CB-36

$total = 0;


$resultado = mysql_query("SELECT * FROM hitos  						  
						  WHERE id_proyecto = ".$_GET['id_proyecto']." AND estado IN('PENDIENTE','EN EJECUCION','ADMIN','COTIZADO','EJECUTADO','INFORME ENVIADO', 'LIQUIDADO')") or die(mysql_error()); 
						  
/*$resultado = mysql_query("SELECT * FROM hitos WHERE id_proyecto  = ".$_GET['id_proyecto']) or die(mysql_error());*/

$total = mysql_num_rows($resultado);


if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):
			$entry[] = array(
				'id'=>$row['id'],
				'orden'=>utf8_encode($row['id'].'-'.$row['nombre']).'-'.$row['fecha_inicio'],
				'estado'=>utf8_encode($row['estado']),
				'ot_cliente'=>(!empty($row['ot_cliente']))?utf8_encode($row['ot_cliente']):'PENDIENTE',
				'descripcion'=>(!empty($row['descripcion']))?utf8_encode($row['descripcion']):'PENDIENTE'
			);
	endwhile;

endif;

echo json_encode($entry); 