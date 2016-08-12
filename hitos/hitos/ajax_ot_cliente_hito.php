<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$obj = new TaskCurrent;	
	
	$condicion = '';
	if($_POST['type']=='unlock'):	
		$limitado = 1;
	else:
		$ilimitado = 0;		
	endif;
	
	$sql = sprintf("UPDATE `hitos` SET `closed_ot` = %d WHERE `id` = %d", 
		(int)$limitado,
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	
	exit;
	//echo "En Mantenimiento\n";
?>

