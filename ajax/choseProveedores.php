<?php
include '../conexion.php';

$total = 0;
$resultado = mysql_query("SELECT * FROM proveedor ORDER BY nombre ASC") or die(mysql_error());
$total = mysql_num_rows($resultado);

header("Content-type: application/json");

if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):   
		//Only cell's with named keys and matching columns are order independent.
		$array[] = array("label"=>utf8_encode($row['nombre']), "id"=>$row['id']); 
	endwhile;

endif;

echo json_encode($array);