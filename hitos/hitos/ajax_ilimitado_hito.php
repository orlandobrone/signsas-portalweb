<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	$obj = new TaskCurrent;	
	
	$condicion = '';
	if($_POST['type']=='unlock'):	
		$limitado = 1;
		$condicion = ', factor = '.$_POST['factor'];
		$obj->setPitagoraHito('Abierto',$_POST['id'],0,0);
	else:
		$ilimitado = 0;
		$obj->setPitagoraHito('Cerrado',$_POST['id'],0,0);
	endif;
	
	$sql = sprintf("UPDATE `hitos`
					SET `ilimitado` = %d ".$condicion."
					WHERE `id` = %d", 
		(int)$limitado,
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	
	exit;
	
	//echo "En Mantenimiento\n";
?>

