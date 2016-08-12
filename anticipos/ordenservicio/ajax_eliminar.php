<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	/*verificamos si las variables se envian*/
	if(empty($_POST['id'])){
		echo "Debe Ingresar la ID";
		exit;
	}
	
	$sql = sprintf("SELECT * FROM orden_servicio WHERE id=%d",
		(int)$_POST['id']
	);
	$per = mysql_query($sql);
	$rows = mysql_fetch_assoc($per);
	
	if( $rows['aprobado'] == 1 ):
		echo json_encode(array('estado'=>false, 'message'=>"No se puede eliminar esta OS se encuentra aprobada"));
		exit;
	endif;
	
	//Cambia a estado 4-> Eliminado en Anticipo
	$sql = sprintf("UPDATE `orden_servicio` SET aprobado = 2 WHERE id = %d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql)):
		echo json_encode(array('estado'=>false, 'message'=>"Ocurrio un error al cambiar el estado"));
		exit;
	endif;
	
	//cambia los hitos del la OS
	$sql = sprintf("UPDATE `items_ordenservicio` SET  estado = 1 WHERE id_ordenservicio = %d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql)):
		echo json_encode(array('estado'=>false, 'message'=>"Ocurrio un error el estado a los items de la OS #".(int)$_POST['id']));
		exit;
	endif;
	
	$obj = new TaskCurrent();
	$obj->setLogEvento('OS',$_POST['id'],'Eliminado');
	
	echo json_encode(array('estado'=>true));
				
	exit;

?>