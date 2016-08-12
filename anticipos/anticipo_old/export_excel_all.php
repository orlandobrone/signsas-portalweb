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
	
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){		
		$where = " AND (s.fecha_creacion BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."') ";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}

	

	/*$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo 

			  FROM anticipo AS s 

			  LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id 

			  WHERE s.publicado != 'draft' ORDER BY s.id DESC";*/

	$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo, c.codigo AS codigo, (SELECT c.nombre 
																 FROM cliente AS c, proyectos AS p
																WHERE s.id_ordentrabajo = p.id AND p.id_cliente = c.id) AS nomcliente 

			  FROM anticipo AS s 

			  LEFT JOIN linea_negocio AS c ON  s.id_centroscostos = c.id 
			  
			  WHERE  s.publicado <> 'draft' AND s.estado != 4 ".$where." 

			  ORDER BY s.id DESC";

			//s.id BETWEEN 29800 AND 30500 AND  

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
            
            <td align="center"><strong>Fecha Aprobado</strong></td>     
            
            <td align="center"><strong>Cliente</strong></td>  

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
			
			
			$sql50 = " SELECT SUM(total_hito) AS total
					  FROM  `items_anticipo` 
					  WHERE  estado = 1 AND id_anticipo = ".$row['ID'];
			$pai50 = mysql_query($sql50);	
			$rs_pai50 = mysql_fetch_assoc($pai50);
			$total = $rs_pai50['total'];

			

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
				
				
				$giro = explode(',00',$row['giro'])

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

                    <td>$<?=$total + $giro[0]?></td>

                    <td><?=$row['beneficiario']?></td>

                    <td><?=$row['banco']?></td>

                    <td><?=$row['observaciones']?></td>

                    <td>$<?=$row['giro']?></td>
                    
                    <td><?=$row['fecha_aprobado']?></td>
                    
                    <td><?=$row['nomcliente']?></td>


                </tr>

<?		

		  	endwhile;


?>

	</table>

    

