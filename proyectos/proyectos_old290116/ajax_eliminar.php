<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$qrCot = mysql_query("select id_cotizacion from proyectos where id=" . ((int)$_POST['id']));
	$rowCot = mysql_fetch_array($qrCot);
	$sql = sprintf("UPDATE cotizacion SET estado='%s' where id=%d;",
		'pendiente',
		((int)$rowCot['id_cotizacion'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la cotización:\n$sql";
	
	$sql = sprintf("delete from proyectos where id=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	$sql = sprintf("delete from orden_trabajo where id_proyecto=%d",
		(int)$_POST['id']
	);
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	
	
	exit;
?>