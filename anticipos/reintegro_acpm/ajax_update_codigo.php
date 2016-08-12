<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	
	/*verificamos si las variables se envian*/
	if(empty($_POST['valueacpm'])){
		echo "Usted no a llenado todos los campos";
		exit;
	} 
	
	$sql = "select valor from prestaciones where id=17";
	$per = mysql_query($sql);
	$rs_per = mysql_fetch_assoc($per);
	
	$sql = sprintf("UPDATE inventario SET codigo='%d' WHERE codigo = ".$rs_per['valor'],
		fn_filtro($_POST['valueacpm'])
	);
	mysql_query($sql);
	
	$sql = sprintf("UPDATE prestaciones SET valor='%d' WHERE id=17",
		fn_filtro($_POST['valueacpm'])
	);
	
	if(!mysql_query($sql))
		echo "Error al actualizar el codigo de ACPM:\n$sql";				
	exit;
	
	
?>