<?php

session_start();
include '../../conexion.php';

$entry = [];
 

$sqlPry = "	SELECT * FROM actividad
			WHERE linea_negocio_id = ".$_GET['id']."
			ORDER BY codigo ASC ";
	
$qrPry = mysql_query($sqlPry);
$total = mysql_num_rows($qrPry);

while($row = mysql_fetch_assoc($qrPry)):
	
	$entry[] = array(	'id'=>$row['id'],
						'nombre'=>utf8_encode($row['codigo'].'-'.$row['nombre']),
						'codigo'=>$row['codigo']						
	);	

endwhile;

echo json_encode($entry); 


?>
