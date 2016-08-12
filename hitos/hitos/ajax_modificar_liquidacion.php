<?
	session_start();
	
	include "../../conexion.php";
	include "../extras/php/basico.php";

	

	if(empty($_POST['liquidacion_final'])){
		echo json_encode(array("estado"=>false,"msj"=>"Ud no a ingresado el Campo de liquidacion final"));
		exit;
	}
	 
	$sql = sprintf('UPDATE hitos SET liquidacion_final = %d WHERE id=%d;',
		fn_filtro($_POST['liquidacion_final']),
		fn_filtro((int)$_POST['id'])
	);
	
	if(!mysql_query($sql)):
		echo "Error al actualizar el hito:\n$sql";
	else:		
		echo json_encode(array("estado"=>true));
	endif;
	
	exit;

?>