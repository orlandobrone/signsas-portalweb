<?php

	/*header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");*/

	include "../../conexion.php";
	include "../extras/php/basico.php";	

	$query = "SELECT *, (SELECT id_centroscostos FROM proyectos WHERE id = hitos.id_proyecto) AS centroscostos
			  FROM hitos ORDER BY id DESC";			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	
	
		if($row['centroscostos'] != 4):		
			echo 'ID hito ->'.$row['id'].' = centro costo ->'.$row['centroscostos'].'<br>';
			$sql2 = "UPDATE `hitos` SET factor = 1.5 WHERE id = ".(int)$row['id'];
			$result2 = mysql_query($sql2) or die("SQL Error 1: " . mysql_error());		
		endif;	
	endwhile;
?>

    