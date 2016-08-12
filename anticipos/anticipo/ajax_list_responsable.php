<?php

session_start();

include '../../conexion.php';

$total = 0;

if($_SESSION['id'] == 87 && $_GET['id_regional'] == 7):// exepciones del usuario jose beltran
	$resultado = mysql_query("SELECT * FROM responsables WHERE id = 61") or die(mysql_error());
elseif($_SESSION['id'] == 21 && $_GET['id_regional'] == 2):// excepcion del usuario oscar hernandez
	$resultado = mysql_query("SELECT * FROM responsables WHERE id = 62") or die(mysql_error());
elseif($_SESSION['id'] == 20 && $_GET['id_regional'] == 14):// excepcion del usuario Maria Isabel Alfaro
	$resultado = mysql_query("SELECT * FROM responsables WHERE id = 63") or die(mysql_error());
else:
	$resultado = mysql_query("SELECT * FROM responsables WHERE id_regional = ".$_GET['id_regional']) or die(mysql_error());
endif;

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