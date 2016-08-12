<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['id_item']) || empty($_POST['campo']) || empty($_POST['valor'])){
		echo json_encode(array('estado'=>false, 'mensaje'=>'No han llegado todos los campos.'));
		exit;
	}
	
	/*modificar el registro*/

	$sql = sprintf("UPDATE `items` SET ".$_POST['campo']."= '%s' WHERE id=%d;",
		fn_filtro($_POST['valor']),
		fn_filtro((int)$_POST['id_item'])
	);
	if(!mysql_query($sql))
		echo json_encode(array('estado'=>true));
	exit;
?>