<?php
include '../conexion.php';

$resultado = mysql_query("SELECT * FROM uploads WHERE id=".$_GET['id']) or die(mysql_error());
$row = mysql_fetch_assoc($resultado);

$dir = "../archivos/".$row['file'];

$sql = "DELETE FROM uploads WHERE id=".$_GET['id'];
if(!mysql_query($sql)):
	echo json_encode(array('status'=>'error', 'mensaje'=>"Error al insertar la nueva asosaci&oacute;n:\n$sql"));
else:
	if(file_exists($dir)){ 
		unlink($dir); 
	} 
	echo json_encode(array('status'=>'success',"mensaje"=>$dir));
endif;