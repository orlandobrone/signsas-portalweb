<?php
include '../../conexion.php';


//OT-CB-36
$total = 0;
$resultado = mysql_query("SELECT * FROM hitos  						  
						  WHERE id_proyecto = ".$_GET['id_proyecto']) or die(mysql_error());
$total = mysql_num_rows($resultado);

if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):
	
			$entry[] = array(
						'id'=>$row['id'],
						'orden'=>utf8_encode($row['nombre']).'-'.$row['fecha_inicio'] 
					   );
	endwhile;
	
endif;

echo json_encode($entry); 