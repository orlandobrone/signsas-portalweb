<?

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;

	/*$sql = sprintf("insert into hitos_eliminados select * from hitos where id = %d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql)){

		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	$sql = sprintf("delete from hitos where id=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error\n$sql";

	exit;*/
	
	$sql = sprintf("UPDATE `hitos`, (SELECT estado FROM hitos WHERE id = %d) AS estado1 
					SET `estado_anterior` = estado1.estado, hitos.estado = 'ELIMINADO'
					WHERE `id` = %d", 
		(int)$_POST['id'], 
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	$obj->setLogEventoHito('Hito',$_POST['id'],'ELIMINADO',$sql);
	exit;
	
	//echo "En Mantenimiento\n";
?>

