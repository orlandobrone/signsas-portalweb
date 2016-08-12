<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	if(!empty($_POST['id'])):	
		
		$sql = sprintf("UPDATE `reintegros` SET estado=0 WHERE id = %d",
			(int)$_POST['id']
		);
		if(!mysql_query($sql)):
			echo "Ocurrio un error al cambiar estado eliminado Reintegro\n$sql"; 
			exit;
		endif;
		
	endif;
?>