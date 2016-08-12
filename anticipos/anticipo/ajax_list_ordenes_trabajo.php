<?php

include '../../conexion.php';
session_start();

$total = 0;

if($_SESSION['id'] == 87 && $_GET['id_regional'] == 7):
	$sql = "SELECT * FROM orden_trabajo WHERE id_proyecto = 606 AND id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos'];
elseif($_SESSION['id'] == 21 && $_GET['id_regional'] == 2):
	$sql = "SELECT * FROM orden_trabajo WHERE id_proyecto = 318 AND id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos'];
elseif($_SESSION['id'] == 29 && $_GET['id_regional'] == 6 && $_GET['id_centroscostos'] == 6):
	$sql = "SELECT * FROM orden_trabajo WHERE id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos']." OR id_proyecto = 715";
else :
	$sql = "SELECT * FROM orden_trabajo WHERE id_regional = ".$_GET['id_regional']." AND id_centroscostos = ".$_GET['id_centroscostos'];
	
endif;
	
$resultado = mysql_query($sql) or die(mysql_error());
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


//excepcion de la regiona id 15

if($_GET['id_regional'] == 15):
	$sql = "SELECT * FROM orden_trabajo WHERE id = 644 AND id_regional = 13 AND id_centroscostos = ".$_GET['id_centroscostos'];
	$resultado = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($resultado);
	
	$entry[] = array(
				'id'=>$row['id_proyecto'],
				'orden'=>utf8_encode($row['orden_trabajo'])
			);
endif;



echo json_encode($entry); 