<?php
	include "../../conexion.php";
	
	if(isset($_GET['idvehi']))
		
		$sql = "SELECT h.nombre AS nombre_hito, a.id, a.fecha_ini, a.fecha_fin, v.placa 
				FROM asignacion AS a 
				LEFT JOIN hitos AS h ON h.id = a.id_hito
				LEFT JOIN vehiculos AS v ON v.id = a.id_vehiculo
				WHERE a.id_vehiculo = ".$_GET['idvehi'];
				
		$qrPry = mysql_query($sql);
		
		if(mysql_num_rows($qrPry) > 0)
	
			$year = date('Y');
			$month = date('m');
			
			$data = array();
			
			while($row = mysql_fetch_assoc($qrPry)):
				
				array_push($data,array('id' => $row['id'],
									   'title' => $row['nombre_hito'].', Placa:'.$row['placa'],
									   'start' => $row['fecha_ini'],
									   'end' =>	$row['fecha_fin']					  
								 ));
				
			endwhile;
		
			
			
			echo json_encode($data);

?>
