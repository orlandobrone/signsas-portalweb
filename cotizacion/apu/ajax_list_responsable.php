<?php
include '../../conexion.php';

$total = 0;
$resultado = mysql_query("SELECT * FROM responsables WHERE id_regional = ".$_GET['id_regional']) or die(mysql_error());
$total = mysql_num_rows($resultado);




if($total > 0):

  /*/ $entry[] = array(
				'id'=>$row['9'],
				'nombre'=>utf8_encode('Andrea del Mar Rojas Martinez'),
				'cedula'=>utf8_encode('1016018336')
			);*/


	while($row = mysql_fetch_assoc($resultado)):
	//Only cell's with named keys and matching columns are order independent.
	$entry[] = array(
				'id'=>$row['id'],
				'nombre'=>utf8_encode($row['nombre']),
				'cedula'=>utf8_encode($row['cedula'])
			);
	endwhile;
	
endif;

echo json_encode($entry); 