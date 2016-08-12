<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	/*$sql = sprintf("delete from anticipo where id=%d",

		(int)$_POST['id']

	);*/
	
	/*$sql = sprintf("update anticipo set publicado = 'draft' where id=%d", 

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error anticipo\n$sql";*/
		
	/*$sql = sprintf("insert into anticipos_eliminados select * from anticipo where id = %d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql)){

		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	$sql = sprintf("delete from anticipo where id=%d",

		(int)$_POST['id']

	);
	
	if(!mysql_query($sql)){

		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	$sql = sprintf("insert into legalizaciones_eliminadas select * from legalizacion where id_anticipo=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql)){

		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	$sql = sprintf("delete from legalizacion where id_anticipo=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error\n$sql";

	exit;
	

	/*$sql = sprintf("delete from legalizacion where id_anticipo=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error legalizacion\n$sql";	

		

		

	$sql = sprintf("delete from items_anticipo where id_anticipo=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error Items Anticipo\n$sql"; */
		
	
	
	
	$sql = sprintf("SELECT a.estado AS estado_anticipo, l.estado AS estado_legalizacion 
					FROM anticipo AS a 
					LEFT JOIN legalizacion AS l ON l.id_anticipo = a.id
					WHERE a.id=%d",
		(int)$_POST['id']
	);
	$per = mysql_query($sql);
	$rows = mysql_fetch_assoc($per);
	
	$update = true;
	
	$mensaje = 'No se puede eliminar este anticipo por las siguiente razones: ';
	
	if( $rows['estado_anticipo'] == 1 ):
		$update = false;
		$mensaje .= ' El anticipo esta Aprobado.';
	endif;
		
	if( $rows['estado_legalizacion'] == 'APROBADO' ):
		$update = false;
		$mensaje .= ' La legalización vinculada al anticipo selecionado esta aprobada.';
	endif;
	
	if($update):
		//Cambia a estado 4-> Eliminado en Anticipo
		$sql = sprintf("UPDATE `anticipo` SET estado=4 WHERE id = %d",
			(int)$_POST['id']
		);
		if(!mysql_query($sql)):
			echo "Ocurrio un error al cambiar estado eliminado Anticipo\n$sql";
			exit;
		endif;
		
		$obj = new TaskCurrent();
		$obj->setLogEvento('Anticipo',$_POST['id'],'Eliminado');
		
		//Cambia a estado 2-> Eliminado en Legalizacion
		$sql = sprintf("UPDATE `legalizacion` SET estado = 'ELIMINADO' WHERE id_anticipo = %d",
			(int)$_POST['id']
		);
		if(!mysql_query($sql)):
			echo "Ocurrio un error al cambiar estado eliminado Legalizado\n$sql";
			exit;
		endif;
		
		$obj->setLogEvento('Anticipo->Legalizacion',$_POST['id'],'Eliminado');
	else:
		echo $mensaje;
	endif;
				
	exit;

?>