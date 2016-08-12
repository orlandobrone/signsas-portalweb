<?php
	//Version excel 1.0.1
	//Ultima actualizacion 08/03/2016
	
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Legalizaciones_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php"; 

	
	setlocale(LC_MONETARY, 'en_US');


	$query = "SELECT * 
			  FROM legalizacion
			  WHERE fecha BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."' ORDER BY id DESC";   

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	echo 'Reporte legalizaciones desde '.$_GET['fecini'].' hasta '.$_GET['fecfin'];	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID Legalizaci&oacute;n</strong></td>

            <td align="center"><strong>Responsable</strong></td>
            
            <td align="center"><strong>Beneficiario</strong></td>

            <td align="center"><strong>Fecha</strong></td>

            <td align="center"><strong>ID Anticipo</strong></td>
            
            <td align="center"><strong>Estado Anticipo</strong></td>
            
            <td align="center"><strong>Total Anticipo</strong></td>

            <td align="center"><strong>ID Vinculado</strong></td>

            <td align="center"><strong>Estado</strong></td>

            <td align="center"><strong>Valor Fondo</strong></td>

            <td align="center"><strong>Valor Legalizado</strong></td>

            <td align="center"><strong>Valor Pagar</strong></td>

            <td align="center"><strong>Reintegro</strong></td>

            <td align="center"><strong>Coordinador</strong></td>

            <td align="center"><strong>TECNICO O AUXILIAR</strong></td>

            <td align="center"><strong>PROYECTO - OT</strong></td>

            <td align="center"><strong>Id Hito</strong></td>

            <td align="center"><strong>HITO - SITIO </strong></td>

            <td align="center"><strong>Concepto</strong></td>

            <td align="center"><strong>Cantidad de Recibidos</strong></td>

            <td align="center"><strong>Pagado</strong></td>

            

            <!--<td align="center"><strong>Beneficiario</strong></td>

            <td align="center"><strong>Banco</strong></td>

            <td align="center"><strong>Valor Giro</strong></td>

            <td align="center"><strong>Hito</strong></td>

            <td align="center"><strong>Valor ACPM</strong></td>

            <td align="center"><strong>Valor Transp</strong></td>

            <td align="center"><strong>TOES</strong></td>-->

        </tr>

	

<?php	

    $letters = array('.','$',',');
	$fruit   = array('');	
	
	function item_legalizacion($idLegalizacion){
		
		$resultado = mysql_query("SELECT COUNT(*) AS total FROM items  WHERE estado = 0 AND id_legalizacion =".$idLegalizacion) or die(mysql_error());
		
		$rows = mysql_fetch_assoc($resultado);
		return $rows['total'];
	}
	
	$obj = new TaskCurrent;
	
	while ($row_legalizacion = mysql_fetch_array($result, MYSQL_ASSOC)):

		$valor_legalizado = '';
		$valor_fondo = '';
		$valor_fondo2 = '';
		$valor_pagar = '';
		$valor_reintegro = '';
		$name_hito = '';
		$beneficiario_anticipo = '';


		$valorFondo = substr($row_legalizacion['valor_fa'],0, -3);
		$valor_fondo = str_replace($letters, $fruit, $valorFondo);	
		
		
		$resultadoAnticipo = mysql_query("SELECT estado FROM anticipo WHERE id =".$row_legalizacion['id_anticipo']) or die(mysql_error());
					
		$rowAnticipo = mysql_fetch_assoc($resultadoAnticipo);
		
		$totalAnticipo = 0;
			
		switch($rowAnticipo['estado']):

			case 0:
				$estadoAnticipo = "No Revisado";
			break;
			case 1:
				$estadoAnticipo = "Aprobado";
				if($row_legalizacion['estado'] == 'NO REVISADO'){
					$items = item_legalizacion($row_legalizacion['id']);
					$totalAnticipo = (int)$obj->total_anticipo($row_legalizacion['id_anticipo']);
				}
			break;
			case 2:
				$estadoAnticipo = "Rechazado";
			break;
			case 3:
				$estadoAnticipo = "Revisado";
			break;
			default:
				$estadoAnticipo = '';
			break;

		endswitch;
		
		
		/* Si es una legalizacion vinculada */
		if($row_legalizacion['id'] != ''):
			$sql10 = "SELECT * FROM anticipo WHERE estado != 4 AND prioridad = 'VINCULADO' AND id_legalizacion =".$row_legalizacion['id']; 
			$resultado_anticipo = mysql_query($sql10) or die(mysql_error());
			$total_anticipo = mysql_num_rows($resultado_anticipo);
			$row_anticipo = mysql_fetch_assoc($resultado_anticipo);
			
			if($row_anticipo['beneficiario'] != '')
				$beneficiario_anticipo = $row_anticipo['beneficiario'];
			else
				$beneficiario_anticipo = '';

			if($total_anticipo > 0):
				$otro_anticipo = $row_anticipo['id'];
				/*$total_anticipo2 = substr($row_anticipo['total_anticipo'],0, -3);
				$total_anticipo2 = str_replace($letters, $fruit, $total_anticipo2);
				$valor_pagar = $valor_pagar - $total_anticipo2;*/
			else:
				$otro_anticipo = '';

			endif;

		endif;

		/*------------------------------------------*/

		

		/* Valot total del anticipo */

		$total_anticipos_vinculados = 0;
		$total_anticipo  = 0;

		$sql2 = sprintf("SELECT total_anticipo FROM anticipo WHERE id_legalizacion=%d",
			(int)$row_legalizacion['id']
		);

		$per2 = mysql_query($sql2);
		$num_rs_per2 = mysql_num_rows($per2);
		

		if ($num_rs_per2 > 0){

			while($rs_per2 = mysql_fetch_assoc($per2)){

				$valor = substr($rs_per2['total_anticipo'],0, -3);
				$valor = str_replace($letters, $fruit, $valor);				
				$total_anticipos_vinculados += $valor;

			}

			

		}else{

			$total_anticipo  = 0;

		}

		

		/* cambia el valor de fondo-*/

		//$valor_fondo = money_format('%(#1n',$valor_fondo  + $total_anticipos_vinculados ); //FGR

		

		/*-------------------------------------------------------*/

		

		

		/* varios datos para llenar la tabla */

		

		if($row_legalizacion['id_anticipo'] != ''):

			

			$resultado2 = mysql_query("	SELECT o.orden_trabajo AS ordentrabajo

										FROM anticipo AS a

										LEFT JOIN orden_trabajo AS o ON a.id_ordentrabajo = o.id_proyecto

										WHERE a.id =".$row_legalizacion['id_anticipo']) or die(mysql_error());

			$row2 = mysql_fetch_assoc($resultado2);

			

			

			$resultado3 = mysql_query("SELECT * FROM tecnico WHERE id = ".$row_legalizacion['id_tecnico']) or die(mysql_error());

			$row3 = mysql_fetch_assoc($resultado3);		

			



		endif;	

		

		/*----------------------------------------------*/

		$sql = "SELECT * FROM items WHERE estado = 0 AND id_legalizacion =".$row_legalizacion['id'];

		$resultado_items = mysql_query($sql) or die(mysql_error());

		$total_items = mysql_num_rows($resultado_items);

		

		if($total_items >= 1):

		

			while ($row_item = mysql_fetch_array($resultado_items, MYSQL_ASSOC)):

					$valor_legalizado = 0;
					$reintegro = 0;
					$valor_pagar = 0;
					$name_hito = '';
					
					///$estado_anticipo = $row_anticipo['estado'];
					
					$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".$row_item['id_legalizacion']) or die(mysql_error());

					$total = mysql_num_rows($resultado);

					while ($rows_1 = mysql_fetch_assoc($resultado)):

						if($rows_1['pagado'] != ''):

							$valor = explode(',00',$rows_1['pagado']);

							$valor2 = str_replace($letters, $fruit, $valor[0] );

							$valor_legalizado += $valor2;

						endif;

					endwhile;

					

					

					if($valor_legalizado != 0 ):			

						$reintegro = $valor_fondo - $valor_legalizado;

					endif;

					

					if($valor_legalizado > $valor_fondo):			

						$valor_pagar = $valor_legalizado - $valor_fondo;

						$reintegro = 0;

					endif;

					/*$valor_pagar = money_format('%(#1n',$valor_pagar);
					$valor_reintegro = money_format('%(#1n',$reintegro);
					$valor_legalizado =  money_format('%(#1n',$valor_legalizado);*/

					$sql4 = "SELECT o.orden_trabajo AS ot, h.nombre AS nombre_hito, h.id as id_de_hito,
							 (SELECT nombre FROM proyectos WHERE id = ".$row_item['id_proyecto'].") AS nombreproyecto
							 FROM  orden_trabajo AS o
					 		 INNER JOIN hitos AS h ON h.id = ".$row_item['id_hito']."
					 		 WHERE o.id_proyecto = ".$row_item['id_proyecto'];

					$pai4 = mysql_query($sql4); 
					$rs_pai4 = mysql_fetch_assoc($pai4);
					$num_rows = mysql_num_rows($pai4);
					
					if($num_rows > 0){	
						$name_hito = $rs_pai4['nombre_hito'];
						$id_de_hito = $rs_pai4['id_de_hito'];
						$nombreproyecto = $rs_pai4['nombreproyecto'];
					}else{
						$id_de_hito = '';
						$nombreproyecto = '';
					}

					

					//$valor_fondo = money_format('%(#1n',$valor_fondo); //FGR					

					//$valor_fondo2 = money_format('%(#1n',$valor_fondo);
					$valor_fondo2 = $valor_fondo;
					
					$sql7 = "SELECT concepto FROM `conceptos_legalizacion` WHERE id = ".$row_item['concepto'];
					
					$conceptofgr = '';

					if($pai7 = mysql_query($sql7)) {
						$rs_pai7 = mysql_fetch_assoc($pai7);
						$conceptofgr = $rs_pai7['concepto'];
					}
					
					
						

			?>

					  <tr>

						<td bgcolor="#CCCCCC"><?=$row_legalizacion['id']?></td>

						<td><?=$row_legalizacion['responsable']?></td>
                        
                        <td><?=$beneficiario_anticipo?></td>

						<td><?=$row_legalizacion['fecha']?></td>

						<td><?=$row_legalizacion['id_anticipo']?></td> 
                        
                        <td><?=$estadoAnticipo?></td> 
                        
                        <td>$<?=(int)$totalAnticipo?></td> 

						<td style="font-weight:bold;"><?=$otro_anticipo?></td>

						<td><?=$row_legalizacion['estado']?></td>

						<td>$<?=(int)$valor_fondo2?></td>

						<td>$<?=(int)$valor_legalizado?></td>

						<td>$<?=(int)$valor_pagar?></td>

						<td>$<?=(int)$valor_reintegro?></td>

						

						<td><?=$row_legalizacion['coordinador']?></td>

						<td><?=$row3['nombre']?></td>

                        <td><?=$nombreproyecto?></td>
						

						<td><?=$id_de_hito?></td> 

						<td><?=$name_hito?></td> 

						<td><?=$conceptofgr;?></td> 

						<td><?=$row_item['cantidad_recibida'];?></td>

						<td>$<?=(int)$row_item['pagado'];?></td> 

					</tr>

			<?

			endwhile;

		

		else:

					  //$valor_fondo = money_format('%(#1n',$valor_fondo); //FGR

			?>

					  <tr>

						<td bgcolor="#CCCCCC"><?=$row_legalizacion['id']?></td>

						<td><?=$row_legalizacion['responsable']?></td>
                        
                        <td><?=$beneficiario_anticipo?></td>

						<td><?=$row_legalizacion['fecha']?></td>

						<td><?=$row_legalizacion['id_anticipo']?></td>
                        
                        <td><?=$estadoAnticipo?></td> 
                        
                        <td>$<?=(int)$totalAnticipo?></td>  

						<td><?=$otro_anticipo?></td>

						<td><?=$row_legalizacion['estado']?></td>

						<td>$<?=(int)$valor_fondo?></td>

						<td>$<?=(int)$valor_legalizado?></td>

						<td>$<?=(int)$valor_pagar?></td>

						<td><?=$valor_reintegro?></td>

						

						<td><?=$row_legalizacion['coordinador']?></td>

						<td><?=$row3['nombre']?></td>
                        
                        <td></td>

						<td></td> 

						<td></td> 

						<td></td> 

						<td></td>

						<td></td> 

					</tr>

			<?

		endif;

		

	endwhile;

?>

	</table>

    

