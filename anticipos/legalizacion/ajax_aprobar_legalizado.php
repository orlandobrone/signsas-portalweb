<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
/*verificamos si las variables se envian  $_POST['coordinador'] === 0 || $_POST['id_tecnico'] === 0
 $_POST['coordinador'] === 0 || $_POST['id_tecnico'] === 0

*/
	if(empty($_POST['id'])){
		echo json_encode(array('estado'=>false,'mensaje'=>"Para APROBAR la Legalización debe ingresar el Coordinador y Técnico"));
		exit;
	}
	
	/*modificar el registro*/
	$sql = sprintf("UPDATE `legalizacion` SET estado = 'APROBADO' WHERE id=%d;",	
		fn_filtro((int)$_POST['id'])
	);	
	
	if(!mysql_query($sql))
		echo json_encode(array('estado'=>false,'mensaje'=>"Error de SQL :".$sql));
		
	echo json_encode(array('estado'=>true));		
	exit;
?>