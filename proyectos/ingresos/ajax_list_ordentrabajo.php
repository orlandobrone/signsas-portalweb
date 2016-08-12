<?
	include "../../conexion.php";
	
	$sqlMat = sprintf("SELECT *, p.id AS idproyecto
					   FROM items_po AS ip
					   LEFT JOIN  proyectos AS p ON p.id = ip.id_proyecto
					   WHERE ip.id_po = ".$_GET['id_po']);
    $perMat = mysql_query($sqlMat);
	$num_row = mysql_num_rows($perMat);
	
    while ($row = mysql_fetch_assoc($perMat)):
			$entry[] = array(
				'value'=>$row['idproyecto'],
				'label'=>utf8_encode($row['nombre'])
			);
	endwhile;
	

echo json_encode($entry); 
?>