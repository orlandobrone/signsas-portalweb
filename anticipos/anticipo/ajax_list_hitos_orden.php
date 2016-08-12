<?php

include '../../conexion.php';


//OT-CB-36

$total = 0;


$resultado = mysql_query("SELECT * FROM hitos  						  
						  WHERE id_proyecto = ".$_GET['id_proyecto']." AND estado in ('PENDIENTE','EN EJECUCION','ADMIN','COTIZADO','EJECUTADO','INFORME ENVIADO', 'LIQUIDADO')") or die(mysql_error()); 
						  
/*$resultado = mysql_query("SELECT * FROM hitos WHERE id_proyecto  = ".$_GET['id_proyecto']) or die(mysql_error());*/

$total = mysql_num_rows($resultado);


if($total > 0):



	while($row = mysql_fetch_assoc($resultado)):

		//if($row['estado'] == 'PENDIENTE' || $row['estado'] == 'EN EJECUCION' || $row['estado'] == 'ADMIN') //FGR Si se filtra arriba, este no será necesario.

			$entry[] = array(

						'id'=>$row['id'],

						'orden'=>utf8_encode($row['id'].'-'.$row['nombre']).'-'.$row['fecha_inicio'].'-'.$row['id'],
						
						'estado'=>utf8_encode($row['estado'])

					   );
					   
		//else
		
			/*$entry[] = array(

						'id'=>$row['id'],

						'orden'=>utf8_encode($row['nombre']).'-'.$row['fecha_inicio'],
						
						'estado'=>utf8_encode($row['estado']),
						
						'valido'=>0 

					   );*/
					   

	endwhile;

	

endif;



echo json_encode($entry); 