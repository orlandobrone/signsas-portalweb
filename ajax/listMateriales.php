<?php
include '../conexion.php';

$total = 0;
$resultado = mysql_query("	SELECT m.id, m.cantidad, m.costo, i.nombre_material, m.aprobado 
							FROM materiales as m
							INNER JOIN inventario as i ON  i.id = m.id_material
							WHERE m.id_despacho =".$_GET['id']) or die(mysql_error());
$total = mysql_num_rows($resultado);



$query = isset($_POST['query']) ? $_POST['query'] : false;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';

$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

header("Content-type: application/json");

$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());

if($total > 0):

	while ($row = mysql_fetch_assoc($resultado)):
		//Only cell's with named keys and matching columns are order independent.
		//if($row['aprobado']==1 || $row['aprobado']==2): $aprobado = 'Aprobado'; else: $aprobado = 'No Aprobado'; endif;
		
		switch($row['aprobado']):
			case 0:
				 $aprobado = 'No Aprobado';
			break;
			case 1:
			case 2:
			 	$aprobado = 'Aprobado';
			break;
			case 3:
				 $aprobado = 'Pendiente';
			break;
		
		endswitch;
		
		$entry = array('id'=>$row['id'],
			'cell'=>array(
				'id'=>$row['id'],
				'material'=>utf8_encode($row['nombre_material']),
				'cantidad'=>$row['cantidad'],
				'costo'=>'$'.number_format($row['costo']),
				'estado'=>$aprobado			
			),
		);
		
		$jsonData['rows'][] = $entry;
		
	endwhile;

endif;

echo json_encode($jsonData);