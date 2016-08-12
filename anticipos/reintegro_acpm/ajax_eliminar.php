<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	// Consulta si el hito esta en opcion de carga ilimitada de ingresos
	$sql2 = mysql_query("SELECT SUM(salida_acpm) AS salidaAcpm FROM inventario_acpm WHERE id_inventario_acpm =".$_POST['id']) or die(mysql_error());
	$rows = mysql_fetch_assoc($sql2);
	
	if($rows['salidaAcpm'] == 0){
	
		$sql = sprintf("UPDATE `inventario_acpm` SET estado = 1 WHERE id_inventario_acpm = %d",
			fn_filtro($_POST['id'])	
		);	
		if(!mysql_query($sql)){
			echo "Ocurrio un error\n$sql";
		}
		
		$sql = sprintf("UPDATE `reintegros_acpm` SET estado = 1 WHERE id = %d",
			fn_filtro($_POST['id'])	
		);	
		if(!mysql_query($sql)){
			echo "Ocurrio un error\n$sql";
		}
	}else{
		echo 'No se puede eliminar el reintegro ACPM';
	}		
	exit;
?>