<?php

	header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Anticipo_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo 

			  FROM anticipo AS s 

			  LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id 

			  WHERE s.publicado != 'draft' ORDER BY s.id DESC";*/

	$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo 

			  FROM anticipo AS s 

			  LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id 

			  ORDER BY s.id DESC";

			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Estado</strong></td>

            <td align="center"><strong>Fecha</strong></td>

            <td align="center"><strong>Prioridad</strong></td>

            <td align="center"><strong>OT</strong></td>

            <td align="center"><strong>Nombre Responsable</strong></td>

            <td align="center"><strong>Cedula Responsable</strong></td>

            <td align="center"><strong>Centro Costo</strong></td>

            <td align="center"><strong>Valor Cotizado</strong></td>

            <td align="center"><strong>Total Anticipo</strong></td>

            <td align="center"><strong>Beneficiario</strong></td>

            <td align="center"><strong>Banco</strong></td>

            <td align="center"><strong>Observaciones</strong></td>

            <td align="center"><strong>Valor Giro</strong></td>

            <td align="center"><strong>ID Hito</strong></td>

            <td align="center"><strong>Hito</strong></td>

            <td align="center"><strong>OT Hito</strong></td>

            <td align="center"><strong>Valor ACPM</strong></td>

            <td align="center"><strong>Valor Transp</strong></td>

            <td align="center"><strong>TOES</strong></td>

            <td align="center"><strong>Valor Giro Promedio</strong></td>

            <td align="center"><strong>Total Anticipo Hito</strong></td>

            <td align="center"><strong>Valor Cotizado</strong></td>

        </tr>

	

<?php	

    $letters = array('-');

	$fruit   = array('/');	

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

		$estado = '';

		$editado = '';

		$aprobar = '';

		$eliminar = '';

		switch($row['estado']):

				case 0:

					$estado = "No Revisado";

				break;

				case 1:

					$estado = "Aprobado";

				break;

				case 2:

					$estado = "Rechazado";

				break;

				case 3:

					$estado = "Revisado";

				break;

		endswitch;

				

						

		$sql4 = "SELECT orden_trabajo FROM `orden_trabajo` WHERE id_proyecto = ".$row['id_ordentrabajo'];

        $pai4 = mysql_query($sql4); 

		$rs_pai4 = mysql_fetch_assoc($pai4);

		

		

		$sql5 = "SELECT * FROM `items_anticipo` AS i 

				 LEFT JOIN hitos AS h ON h.id = i.id_hitos

				 WHERE i.id_anticipo = ".(int)$row['ID']." ORDER BY i.id DESC";

        $pai5 = mysql_query($sql5); 

		

		$sql6 = "SELECT count(*) as cuenta, `id_anticipo` FROM `items_anticipo` WHERE id_anticipo = ".(int)$row['ID']." 

		         group by `id_anticipo`";

        $pai6 = mysql_query($sql6); 

		

		

		

			while($items = mysql_fetch_assoc($pai5)):

			

			

			$letters = array(',');

			$fruit   = array('.');	

			

			$total_anticipo = substr($row['total_anticipo'],0, -3);

			$total_anticipo = str_replace($letters, $fruit, $total_anticipo); 	

			

			$total_giro = substr($row['giro'],0, -3);

			$total_giro = str_replace($letters, $fruit, $total_giro);

			$total_giro = str_replace('.', '', $total_giro);

			$hitoss = mysql_fetch_assoc($pai6);

			$total_hitos = (int)$hitoss['cuenta'];

			if($total_hitos > 0)
				$valor_promedio = round($total_giro / $total_hitos,2);	
			else 
				$valor_promedio = 0;

			

			//$total_anticipo_hito = str_replace('.', '', $items['total_hito']);

			$total_anticipo_hito = 0;

			$total_anticipo_hito += str_replace('.', '', $items['acpm']);

			$total_anticipo_hito += str_replace('.', '', $items['valor_transporte']);

			$total_anticipo_hito += str_replace('.', '', $items['toes']);

			$total_anticipo_hito += $valor_promedio;

			

			$sql7 = "SELECT nombre FROM `proyectos`

				 	 WHERE id = ".(int)$items['id_proyecto']." LIMIT 1";

        	$pai7 = mysql_query($sql7);

			$row_proyecto = mysql_fetch_assoc($pai7) 

		

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['ID']?></td>

                    <td><?=$estado?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha'])?></td>

                    <td><?=$row['prioridad']?></td>

                    <td><?=$rs_pai4['orden_trabajo']?></td>

                    <td><?=$row['nombre_responsable']?></td>

                    <td><?=$row['cedula_responsable']?></td>

                    <td><?=$row['centro_costo']?></td>

                    <td><?=$row['v_cotizado']?></td>

                    <td>$<?=$total_anticipo?>,00</td>

                    <td><?=$row['beneficiario']?></td>

                    <td><?=$row['banco']?></td>

                    <td><?=$row['observaciones']?></td>

                    <td>$<?=$row['giro']?></td>

                    <td><?=$items['id_hitos']?></td>                    

                    <td><?=$items['nombre']?></td>

                    

                    <td><?=$row_proyecto['nombre']?></td>

                    

                    <td>$<?=$items['acpm']?></td>

                    <td>$<?=$items['valor_transporte']?></td>

                    <td>$<?=$items['toes']?></td>

                    <td>$<?=$valor_promedio?></td>

                    <td>$<?=$total_anticipo_hito?></td>

                    <td>$<?=$items['valor_hito']?></td>

                </tr>

<?		

		  	endwhile;

	endwhile;

?>

	</table>

    

