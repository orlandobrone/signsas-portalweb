<?php
include '../../conexion.php';

$total = 0;
$resultado = mysql_query("SELECT * FROM orden_trabajo WHERE id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos']." ") or die(mysql_error());
$total = mysql_num_rows($resultado);




if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):
	//Only cell's with named keys and matching columns are order independent.
	$entry[] = array(
				'id'=>$row['id_proyecto'],
				'orden'=>utf8_encode($row['orden_trabajo'])
				//'cliente'=>"SELECT * FROM orden_trabajo WHERE id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos']." "
			);
	endwhile;
	
endif;

echo json_encode($entry); 