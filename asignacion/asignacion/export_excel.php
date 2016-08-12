<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Asignacion_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){		
		$where = " AND (fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."') ";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}
	
	session_start();
	if($_SESSION['asignacion_eliminar'])
		$estadosql = '1';
	else
		$estadosql = 'estado = 0';


	$query = "SELECT * FROM asignacion WHERE ".$estadosql." ".$where." ORDER BY id DESC";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>OT</strong></td>
            
            <td align="center"><strong>ID Hito</strong></td>

            <td align="center"><strong>Hito</strong></td>

            <td align="center"><strong>Estado Técnico</strong></td>
            
            <td align="center"><strong>Zona</strong></td>

            <td align="center"><strong>T&eacute;cnico</strong></td>

            <td align="center"><strong>Veh&iacute;culo</strong></td>

            <td align="center"><strong>Fecha Inicio</strong></td>

            <td align="center"><strong>Fecha Final</strong></td>

            <td align="center"><strong>Hora</strong></td>
            
            <td align="center"><strong>Horas Trabajadas</strong></td>

            <td align="center"><strong>Observaci&oacute;n</strong></td>
            
            <td align="center"><strong>Fecha Creaci&oacute;n</strong></td>

        </tr>

	

<?php	

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

	

		if($row['id_hito'] != 0):

		

			if($row['id_vehiculo'] != 0):

				$sql2 = "SELECT 

							h.nombre AS nombre_hitos,

							t.nombre AS nombre_tecnico,

							v.placa AS placa,
							
							t.region AS region_tecnico

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$row['id_tecnico']."

						 INNER JOIN  vehiculos AS v ON v.id = ".$row['id_vehiculo']."

						 WHERE h.id =".$row['id_hito'];

			else:

				$sql2 = "SELECT 

							h.nombre AS nombre_hitos,

							t.nombre AS nombre_tecnico,
							
							t.region AS region_tecnico

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$row['id_tecnico']."

						 WHERE h.id =".$row['id_hito'];

			endif;

		else:

			$sql2 = "SELECT nombre AS nombre_tecnico, region AS region_tecnico

					 FROM `tecnico` 

					 WHERE id =".$row['id_tecnico'];

		endif;

		

		$pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);
		

		//FGR desde acá

		$sql3 = "select orden_trabajo as OT from orden_trabajo where id_proyecto = ".$row['id_ordentrabajo'];

		$pai3 = mysql_query($sql3);

		$rs_pai3 = mysql_fetch_assoc($pai3);

		//FGR hasta acá

		

		if($row['hora_inicio'] == '00:00:00' && $row['hora_final'] == '00:00:00'):

			$hora_vehicular = 'N/A';

		else:

			$hora_vehicular = $row['hora_inicio'].' a '.$row['hora_final'];

		endif;

		

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$row['id_ordentrabajo']==0?'':$rs_pai3['OT']?></td>
                    
                    <td><?=$row['id_hito']?></td>

                    <td><?=$rs_pai2['nombre_hitos']?></td>

                    <td><?=strtoupper($row['libre'])?></td>
                    
                    <td><?=$rs_pai2['region_tecnico']?></td>

                    <td><?=$rs_pai2['nombre_tecnico']?></td>

                    <td><?=$rs_pai2['placa']?></td>

                    <td><?=$row['fecha_ini']?></td>

                    <td><?=$row['fecha_fin']?></td>

                    <td><?=$hora_vehicular?></td>
                    
                    <td>
						<? 	
							$num = explode('.',$row['horas_trabajadas']);							
							if(count($num) >= 2):
                    			echo (int)$row['horas_trabajadas'].','.$num[1];
							else:
								echo $row['horas_trabajadas'];
							endif;		
						?>
                    </td>

                    <td><?=$row['observacion']?></td>   
                    
                    <td><?=$row['fecha_creacion']?></td>                

                </tr>

<?		

		  	

	endwhile;

?>

	</table>

    