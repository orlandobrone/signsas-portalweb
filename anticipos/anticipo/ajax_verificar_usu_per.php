<?
	include "../../conexion.php";
	$usu_per = $_GET['nombre_material'];
	$sql = "select * from inventario where nombre_material='$usu_per'";
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if($num_rs_per == 0)
		echo "true";
	else
		echo "false";
?>