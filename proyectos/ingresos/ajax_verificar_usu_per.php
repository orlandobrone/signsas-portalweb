<?
	include "../../conexion.php";
	$usu_per = $_GET['nombre_rb'];
	$sql = "select * from proyectos where nombre_rb='$usu_per'"; 
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if($num_rs_per == 0)
		echo "true";
	else
		echo "false";
?>