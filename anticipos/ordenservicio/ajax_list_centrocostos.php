<?php

include '../../conexion.php';

/*if(($_SESSION['id'] == 87 && $_GET['id_regional'] == 7) || ($_SESSION['id'] == 21 && $_GET['id_regional'] == 2)):
	$sqlPry = "SELECT * FROM centros_costos WHERE  id = 3 ORDER BY sigla ASC"; 
else:
	$sqlPry = "SELECT * FROM centros_costos WHERE id = 1 OR id = 2 OR id = 3 OR id = 5 OR id = 6 OR id = 4 ORDER BY sigla ASC"; 
endif;*/

$sqlPry = "SELECT * FROM linea_negocio WHERE 1 ORDER BY id ASC"; 

$resultado = mysql_query($sqlPry);
$total = mysql_num_rows($resultado);

if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):

		//Only cell's with named keys and matching columns are order independent.

		$entry[] = array('id'=>$row['id'],
						 'sigla'=>utf8_encode($row['codigo']),
						 'nombre'=>utf8_encode($row['nombre']) );

	endwhile;

endif;

echo json_encode($entry); 