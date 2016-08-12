<?
	include "../../conexion.php";
	$usu_per = $_GET['id'];
	$sql = "select * from tareas where id='$usu_per'";
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if($num_rs_per == 0)
		echo "true";
	else
		echo "false";
?>