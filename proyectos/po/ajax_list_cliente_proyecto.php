<?
	include "../../conexion.php";
	
	$sqlMat = sprintf("SELECT * FROM proyectos
					   WHERE id_cliente = ".$_GET['id_cliente']);
    $perMat = mysql_query($sqlMat);
	$num_row = mysql_num_rows($perMat);
	
	if($num_row > 0):
		while ($row = mysql_fetch_assoc($perMat)):
				$entry[] = array(
					'value'=>$row['id'],
					'label'=>utf8_encode($row['nombre'])					
				);
		endwhile;
		$data = array('estate' => 'true','rows'=>$entry);
	else:
		$data = array('estate' => 'false','mensaje'=>'No se encontro ninguna coincidencia');
	endif;

echo json_encode($data); 
?>