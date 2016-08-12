<?php
	include "../../conexion.php";
	
	if(isset($_GET['iduser']))
		
		$sql = "SELECT h.nombre AS nombre_hito, a.id, a.fecha_ini, a.fecha_fin FROM asignacion AS a 
				LEFT JOIN hitos AS h ON h.id = a.id_hito
				WHERE a.id_tecnico = ".$_GET['iduser'];
				
		$qrPry = mysql_query($sql);
		
		if(mysql_num_rows($qrPry) > 0)
	
			$year = date('Y');
			$month = date('m');
			
			$data = array();
			
			while($row = mysql_fetch_assoc($qrPry)):
			
				if($row['nombre_hito'] != ''):
					$title = $row['nombre_hito'];
				else:
					$title = 'Disponible';
				endif;
				
				array_push($data,array('id' => $row['id'],
									   'title' => $title,
									   'start' => $row['fecha_ini'],
									   'end' =>	$row['fecha_fin']					  
								 ));
				
			endwhile;
		
			
			
			echo json_encode($data);

?>
