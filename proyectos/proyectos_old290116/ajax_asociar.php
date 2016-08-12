<?  header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$query = "SELECT * FROM orden_trabajo WHERE id_proyecto = 0";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$vowels = array("-"); 
		$orden = str_replace($vowels, " - ", $row['orden_trabajo']);
		
		$query2 = "SELECT * FROM proyectos WHERE nombre = '".$row['orden_trabajo']."'";
	    $result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error()); 
		$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
		
		if($row2['id'] != ''){
		
			echo "Orden Trabajo: ".$orden." | Proyecto ID :".$row2['id']."<br/>";
			
			$orden = str_replace(' ', '', $_POST['nombre']);		
			$sql = sprintf("UPDATE `orden_trabajo` SET id_proyecto='%s' WHERE id=%d;",
				fn_filtro($row2['id']),
				fn_filtro($row['id'])
			);
			if(!mysql_query($sql))
				echo "Error al actualizar la cotización:\n$sql";
			
		}
	}
	
?>

