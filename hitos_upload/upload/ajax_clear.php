<?
    include "../../restrinccion.php";
	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";	
	
	$query = "TRUNCATE hitos_upload";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	echo json_encode(array('estado'=>true));

	exit;
?>