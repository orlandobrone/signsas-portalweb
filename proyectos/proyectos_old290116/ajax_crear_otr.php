<?  include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	$query2 = "SELECT * FROM proyectos WHERE id = '".$_POST['id_proyecto']."'";
	$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());
	$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
	
	
	$orden = str_replace(' ', '', $row2['nombre']);		
	$sql = sprintf("INSERT INTO `orden_trabajo` (orden_trabajo,cliente,id_regional,id_centroscostos, id_proyecto) VALUES ('%s', '', '%s', '%s', '%s');",
		fn_filtro($orden),
		fn_filtro($row2['id_regional']),
		fn_filtro($row2['id_centroscostos']),
		fn_filtro($_POST['id_proyecto'])
	); 

	if(!mysql_query($sql))
		echo "Error al insertar OTs\n$sql";
	exit;
	
?>

