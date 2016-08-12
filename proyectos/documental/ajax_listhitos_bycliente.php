<?php

session_start();

include '../../conexion.php';

$sql = "SELECT id FROM proyectos WHERE id_cliente = ".$_REQUEST['idcliente'];
$resultado = mysql_query($sql) or die(mysql_error());
$total = mysql_num_rows($resultado);

if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):
	
		$resultado2 = mysql_query("SELECT id, nombre FROM hitos WHERE id_proyecto = ".$row['id']) or die(mysql_error());
		
		while( $row2 = mysql_fetch_assoc($resultado2) ):
		
			$entry[] = array('id'=>$row2['id'],'nombre'=>utf8_encode($row2['nombre']));
			
		endwhile;
	endwhile;

endif;



echo json_encode($entry); 