<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['IdDelete'])){
		echo "Ingrese un ID";
		exit;
	}

	$sql = "DELETE FROM `materiales` WHERE id =".$_POST['IdDelete'];	
	
	if(!mysql_query($sql))
		echo "Error al eliminar la mercancia. test101041\n";
		
		
?>