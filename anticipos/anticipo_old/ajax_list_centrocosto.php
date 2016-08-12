<?php
include '../../conexion.php';


//OT-CB-36
$total = 0;
$resultado = mysql_query("SELECT * FROM centros_costos WHERE 1") or die(mysql_error());
$total = mysql_num_rows($resultado);

if($total > 0):
	
	$list = '';
	
	while($row = mysql_fetch_assoc($resultado)):
		$list .= "'".$row['id'].'.'.utf8_encode($row['nombre'])."',";
	endwhile;
	
endif;

echo $list;