<?php
include '../conexion.php';

$total = 0;
$resultado = mysql_query("SELECT * FROM inventario ORDER BY nombre_material ASC") or die(mysql_error());
$total = mysql_num_rows($resultado);

header("Content-type: application/json");

if($total > 0):

	while($row = mysql_fetch_assoc($resultado)):
		//Only cell's with named keys and matching columns are order independent.
		$array[] = array("label"=>utf8_encode($row['nombre_material']), "id"=>$row['id']); 
	endwhile;

endif;

echo json_encode($array);