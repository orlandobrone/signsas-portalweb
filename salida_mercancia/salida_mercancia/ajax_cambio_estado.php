<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	/*verificamos si las variables se envian*/

	if(empty($_POST['id']) || empty($_POST['cambio_estado'])){
		$data = array('estado'=>false,"msj"=>"Usted no a llenado todos los campos");
		echo json_encode($data);
		exit;
	}

	/*modificar el registro*/
	$sql = sprintf("UPDATE `solicitud_despacho` SET 
					estado='%s'
					WHERE id=%d;",
				
		fn_filtro($_POST['cambio_estado']),
		fn_filtro((int)$_POST['id'])		

	);
	
	if(!mysql_query($sql))
		$data = array('estado'=>false,'msj'=>"Error al actualizar la salida:\n$sql");
	else
		$data = array('estado'=>true);
	
	
	echo json_encode($data);
	exit;

?>