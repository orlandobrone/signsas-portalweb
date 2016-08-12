<?
	include "../../conexion.php";
	
	$sqlMat = sprintf("SELECT ip.id_po AS idPo, p.valor_mantenimiento AS mt, p.valor_suministro AS sm, p.no AS numero
					   FROM items_po AS ip
					   LEFT JOIN  po AS p 
					   ON p.id = ip.id_po
					   WHERE ip.id_proyecto = ".$_GET['id_proyecto']);
    $perMat = mysql_query($sqlMat);
	$num_row = mysql_num_rows($perMat);
	
	if($num_row > 0):
		while ($row = mysql_fetch_assoc($perMat)):
				$entry[] = array(
					'value'=>$row['idPo'],
					'label'=>utf8_encode($row['numero']),
					'mt'=>utf8_encode($row['mt']),
					'sm'=>utf8_encode($row['sm'])
				);
		endwhile;
		
		$data = array('estate' => 'true','rows'=>$entry);
	else:
		$data = array('estate' => 'false','mensaje'=>'No se encontro ninguna coincidencia');
	endif;
	

echo json_encode($data); 
?>