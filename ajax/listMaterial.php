<?php
include '../conexion.php';

$total = 0;
$resultado = mysql_query("	SELECT * FROM inventario WHERE id =".$_GET['id']) or die(mysql_error());
$total = mysql_num_rows($resultado);


$search  = array(',', '$', ' ');
$replace = array('');



if($total > 0):

	$row = mysql_fetch_assoc($resultado);
	//Only cell's with named keys and matching columns are order independent.
	$entry = array(
				'id'=>$row['id'],
				'descripcion'=>utf8_encode($row['descripcion']),
				'cantidadInv'=>$row['cantidad'],
				'costoInv'=>str_replace($search, $replace, $row['costo_unidad']),
			);

endif;

echo json_encode($entry);