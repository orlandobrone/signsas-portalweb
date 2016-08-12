<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Anticipo_Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";

	/*$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo 

			  FROM anticipo AS s 

			  LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id 

			  WHERE s.publicado != 'draft' ORDER BY s.id DESC";*/
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){		
		$where = " AND (s.fecha_creacion BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."') ";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}

	$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo, c.codigo AS codigo
			  FROM anticipo AS s 
			  LEFT JOIN linea_negocio AS c ON  s.id_centroscostos = c.id 
			  WHERE s.publicado <> 'draft' ".$where." 
			  ORDER BY s.id DESC"; 

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Estado</strong></td>
            
            <td align="center"><strong>Banco Transacci&oacute;n</strong></td>

            <td align="center"><strong>Fecha</strong></td>

            <td align="center"><strong>Prioridad</strong></td>

            <td align="center"><strong>OT</strong></td>

            <td align="center"><strong>Nombre Responsable</strong></td>

            <td align="center"><strong>Cedula Responsable</strong></td>

            <td align="center"><strong>Centro Costo</strong></td>

            <td align="center"><strong>Valor Total Cotizado</strong></td>

            <td align="center"><strong>Total Anticipo</strong></td>

            <td align="center"><strong>Beneficiario</strong></td>

            <td align="center"><strong>Banco</strong></td>

            <td align="center"><strong>Observaciones</strong></td>

            <td align="center"><strong>Valor Giro</strong></td>

            <td align="center"><strong>ID Hito</strong></td>

            <td align="center"><strong>Hito</strong></td>
            <td align="center"><strong>Estado Hito</strong></td>

            <td align="center"><strong>OT Hito</strong></td>
            
            <td align="center"><strong>Galones ACPM</strong></td>
            <td align="center"><strong>Valor ACPM</strong></td>
            <td align="center"><strong>Retenci&oacute;n ACPM</strong></td>
            <td align="center"><strong>Total ACPM</strong></td>

            <td align="center"><strong>Valor Transp</strong></td>

            <td align="center"><strong>TOES</strong></td>

            <td align="center"><strong>Valor Giro Promedio</strong></td>

            <td align="center"><strong>Total Anticipo Hito</strong></td>

            <td align="center"><strong>Valor Cotizado</strong></td>
            
            <td align="center"><strong>Fecha Aprobado</strong></td>
            
            <td align="center"><strong>Cliente</strong></td>

        </tr>
 
	

<?php	

    $letters = array('-','.');
	$fruit   = array('/','');	
	

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

		$sql5 = "SELECT *, h.estado AS estado_hito FROM `items_anticipo` AS i
				 LEFT JOIN hitos AS h ON h.id = i.id_hitos 
				 WHERE i.estado = 1 AND i.id_anticipo = ".(int)$row['ID']." ORDER BY i.id DESC"; 

        $pai5 = mysql_query($sql5); 

		while($items = mysql_fetch_assoc($pai5)):
			
			$letters = array(',');
			$fruit   = array('.');	

			$total_anticipo = substr($row['total_anticipo'],0, -3);
			$total_anticipo = str_replace($letters, $fruit, $total_anticipo); 	

			$total_giro = substr($row['giro'],0, -3);
			$total_giro = str_replace($letters, $fruit, $total_giro);
			$total_giro = str_replace('.', '', $total_giro);
			
			$sql6 = "SELECT count(*) as cuenta, `id_anticipo` FROM `items_anticipo` WHERE id_anticipo = ".(int)$row['ID']." group by `id_anticipo`";
        	$pai6 = mysql_query($sql6); 
			$hitoss = mysql_fetch_assoc($pai6);

			$total_hitos = (int)$hitoss['cuenta'];

			$valor_promedio = 0;
			if($total_hitos > 0)
				$valor_promedio = round($total_giro / $total_hitos,2);
			
			//$total_anticipo_hito = str_replace('.', '', $items['total_hito']);
			$total_anticipo_hito = 0;
			$total_anticipo_hito += str_replace('.', '', $items['acpm']);
			$total_anticipo_hito += str_replace('.', '', $items['valor_transporte']);
			$total_anticipo_hito += str_replace('.', '', $items['toes']);
			if( (int)$total_anticipo_hito > 0 )
				$total_anticipo_hito += $valor_promedio;


			$sql7 = "SELECT nombre FROM `proyectos`
				 	 WHERE id = ".(int)$items['id_proyecto']." LIMIT 1";

        	$pai7 = mysql_query($sql7);

			$row_proyecto = mysql_fetch_assoc($pai7); 
			
			
			$sql8 = "SELECT nombre_banco FROM `bancos`
				 	 WHERE id = ".$row['banco_trans'];

        	if($pai8 = mysql_query($sql8)){
				$row_banco = mysql_fetch_assoc($pai8);
				$banco = $row_banco['nombre_banco'];
			}
			else
				$banco = 'No Identificado';	
		
				
			$sql9 = "SELECT c.nombre AS nomcliente 
					   FROM cliente AS c, proyectos AS p, hitos AS h
					  WHERE h.id = ".$items['id_hitos']." AND h.id_proyecto=p.id AND p.id_cliente = c.id";

        	
			if($pai9 = mysql_query($sql9)){
				$row_cliente = mysql_fetch_assoc($pai9);
				$cliente = $row_cliente['nomcliente'];
			}
			else
				$cliente = 'No Identificado';	
				
				
				
			$giro = explode(',00',$row['giro']);	
			
			$sql50 = " SELECT SUM(total_hito) AS total
					  FROM  `items_anticipo` 
					  WHERE  estado = 1 AND id_anticipo = ".$row['ID'];
			$pai50 = mysql_query($sql50);	
			$rs_pai50 = mysql_fetch_assoc($pai50);
			$total = (int)$rs_pai50['total'] + str_replace(".", "", $giro[0]);	

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['ID']?></td>

                    <td><?=$estado?></td>
                    
                    <td><?=$banco?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha'])?></td>

                    <td><?=$row['prioridad']?></td>

                    <td><?=$rs_pai4['orden_trabajo']?></td>

                    <td><?=$row['nombre_responsable']?></td>

                    <td><?=$row['cedula_responsable']?></td>

                    <td><?=$row['codigo']?>-<?=$row['centro_costo']?></td>

                    <td>$<?=$row['v_cotizado']?></td>

                    <td>$<?=$total?></td>

                    <td><?=$row['beneficiario']?></td>

                    <td><?=$row['banco']?></td>

                    <td><?=$row['observaciones']?></td>

                    <td>$<?=$row['giro']?></td>

                    <td><?=$items['id_hitos']?></td> 
                    <td><?=$items['nombre']?></td>
                    <td><?=$items['estado_hito']?></td>   

                    <td><?=$row_proyecto['nombre']?></td>

                    
					<td><?=$items['cant_galones']?></td>
                    <td>$<?=$items['valor_galon']?></td>
                    <td>$<?=$items['retencion']?></td>
                    <td>$<?=$items['acpm']?></td>

                    <td>$<?=$items['valor_transporte']?></td>

                    <td>$<?=$items['toes']?></td>

                    <td>$<?=$valor_promedio?></td>

                    <td>$<?=$total_anticipo_hito?></td>

                    <td>$<?=$items['valor_hito']?></td>
                    
                    <td><?=$row['fecha_aprobado']?></td>
                    
                    <td><?=$cliente?></td>

                </tr>

<?		

		  	endwhile;

	endwhile;

?>

	</table>

    

