<?
	include "../../conexion.php";
	
	$sqlMat = sprintf("SELECT c.id AS idCliente, c.nombre AS nombreCliente
					   FROM proyectos AS p
					   LEFT JOIN cliente AS c
					   ON c.id = p.id_cliente
					   WHERE p.id = ".$_GET['id_proyecto']);
    $perMat = mysql_query($sqlMat);
	$num_row = mysql_num_rows($perMat);
	
	if($num_row > 0):
		while ($row = mysql_fetch_assoc($perMat)):
				$entry[] = array(
					'value'=>$row['idCliente'],
					'label'=>utf8_encode($row['nombreCliente'])					
				);
		endwhile;
		
		$data = array('estate' => 'true','rows'=>$entry);
	else:
		$data = array('estate' => 'false','mensaje'=>'No se encontro ninguna coincidencia');
	endif;
	

echo json_encode($data); 
?>