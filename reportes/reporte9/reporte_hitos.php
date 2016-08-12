<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");
 
	include "../../conexion.php";
	include "../extras/php/basico.php";	

	
	if(!empty($_GET['idHito']))
		$where = ' WHERE id = '.(int)$_GET['idHito'];
	
	
	$query = "SELECT * FROM hitos ".$where." ORDER BY id DESC";			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Proyecto</strong></td>

            <td align="center"><strong>Nombre Hito</strong></td>

            <td align="center"><strong>Estado</strong></td>

            <td align="center"><strong>Descripci&oacute;n</strong></td>

            <td align="center"><strong>OT Cliente</strong></td>
            
            <td align="center"><strong>Cliente</strong></td>

            <td align="center"><strong>PO</strong></td>
            <td align="center"><strong>GR</strong></td>
            <td align="center"><strong>PO2</strong></td>
            <td align="center"><strong>GR2</strong></td>
            <td align="center"><strong>PO3</strong></td>
            <td align="center"><strong>GR3</strong></td>
            <td align="center"><strong>PO4</strong></td>
            <td align="center"><strong>GR4</strong></td>
            
            <td align="center"><strong>#Factura 1</strong></td>
            <td align="center"><strong>#Factura 2</strong></td>
            <td align="center"><strong>#Factura 3</strong></td>
            <td align="center"><strong>#Factura 4</strong></td>

            <td align="center"><strong>Fecha Inicio</strong></td>

            <td align="center"><strong>Fecha Final</strong></td>

            <td align="center"><strong>Fecha Inicio Ejecuci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Ejecuci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Informe</strong></td>

            <td align="center"><strong>Fecha Liquidaci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Facturaci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Facturado</strong></td>            
            <td align="center"><strong>Fecha Facturado 2</strong></td>
            <td align="center"><strong>Fecha Facturado 3</strong></td>
            <td align="center"><strong>Fecha Facturado 4</strong></td>
            
            <td align="center"><strong>Valor Cotizado</strong></td>
            
            <td align="center"><strong>Valor Facturado</strong></td>            
            <td align="center"><strong>Valor Facturado 2</strong></td>
            <td align="center"><strong>Valor Facturado 3</strong></td>
            <td align="center"><strong>Valor Facturado 4</strong></td>
            
            <td align="center"><strong>Fecha Pagado</strong></td>
            
            <td align="center"><strong>Fecha Pagado 2</strong></td>
            
            <td align="center"><strong>D&iacute;as Hito</strong></td>
            
            <td align="center"><strong>Total Anticipos</strong></td>
            
            <td align="center"><strong>Total Compra</strong></td>
            
            <td align="center"><strong>Fecha Facturado 1</strong></td>
            <td align="center"><strong>Departamento</strong></td>
            
            <td align="center"><strong>Fecha Eliminado</strong></td>            
            <td align="center"><strong>Fecha Cancelado</strong></td>            
            <td align="center"><strong>Fecha Duplicado</strong></td>
            
            <td align="center"><strong>Hist&oacute;rico Cotizado</strong></td>

        </tr>
<?php	

	$letters = array('-');
	$fruit   = array('/');	
	
	$letters2 = array('$','.');
	$fruit2   = array('');	
	
	$obj = new TaskCurrent;	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	

		$sqlfgr = "	SELECT SUM(total_hito) AS total_anticipos, (SELECT name FROM ps_state WHERE id = ".$row['id_ps_state']." ) AS departamento
					FROM `items_anticipo` 
					WHERE id_hitos = ".$row['id'];

		$paifgr = mysql_query($sqlfgr); 
		$rs_paifgr = mysql_fetch_assoc($paifgr);
		
		
		/*$sql3 = "	SELECT SUM( tmp.valor_adjudicado * tmp.cantidade) AS total_compras
					FROM `solicitud_despacho` AS sd
					LEFT JOIN TEMP_MERCANCIAS AS tmp ON tmp.id_despacho = sd.id
					WHERE sd.id_hito = ".$row['id'];
		$pai3 = mysql_query($sql3); 
		$rs_pai3 = mysql_fetch_assoc($pai3);*/
		
		$totalCompra = $obj->getTotalCompraByhito($row['id'])-$obj->getTotalReintegroByhito($row['id']);
		
		//log eventos
		/*$sqle = "SELECT estado, fecha_cambio
				 FROM log_eventos WHERE modulo = 'Hito' AND ref_id = ".$row['id'];
		$paie = mysql_query($sqle);
		
		$fechaEliminado = '';
		$fechaCancelado = '';
		$fechaDuplicado = '';
		
		while( $rs_paie = mysql_fetch_assoc($paie) ):
			switch( $rs_paie['estado'] ):
				case 'ELIMINADO':
					$fechaEliminado = $rs_paie['fecha_cambio'];
				break;
				
				case 'CANCELADO':
					$fechaCancelado = $rs_paie['fecha_cambio'];
				break;
				
				case 'DUPLICADO':
					$fechaDuplicado = $rs_paie['fecha_cambio'];
				break;
				
			endswitch;
		endwhile;*/
		
		if($row['estado'] != 'ELIMINADO') {

			$sql2 = "select p.nombre AS nombre, (SELECT c.nombre FROM cliente AS c where c.id = p.id_cliente) AS nomcliente from proyectos p where p.id = ".$row['id_proyecto'];	
			$pai2 = mysql_query($sql2);	
			$rs_pai2 = mysql_fetch_assoc($pai2);
			
			if($row['dias_hito'] != '')
				$dias_hito = $row['dias_hito'];
			else
				$dias_hito = 0;
			
			if($row['valor_facturado'] != '')	
				$valorfacturado =  $obj->clearInt($row['valor_facturado']);
			else
				$valorfacturado = 0;			
			
			if($row['valor_facturado2'] != '')	
				$valorfacturado2 = $obj->clearInt($row['valor_facturado2']);
			else
				$valorfacturado2 = 0;
				 
			if(!empty($rs_paifgr['total_anticipos']))
				$totalAnticipo =  $obj->clearInt($rs_paifgr['total_anticipos']);
			else
				$totalAnticipo  = 0;
				
?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$rs_pai2['nombre']?></td>

                    <td><?=$row['nombre']?></td>

                    <td><?=$row['estado']?></td>

                    <td><?=$row['descripcion']?></td>

                    <td><?=$row['ot_cliente']?></td>
                    
                    <td><?=$rs_pai2['nomcliente']?></td>

                    <td><?=$row['po']?></td>
                    <td><?=$row['gr']?></td>
                    <td><?=$row['po2']?></td>
                    <td><?=$row['gr2']?></td>
                    <td><?=$row['po3']?></td>
                    <td><?=$row['gr3']?></td>
                    <td><?=$row['po4']?></td>
                    <td><?=$row['gr4']?></td>
                    
                    <td><?=($row['factura'] == 'N/A' || $row['factura']=='')? 'N/A': $row['factura']?></td>
                    <td><?=($row['factura2'] == 'N/A' || $row['factura2']=='')? 'N/A': $row['factura2']?></td> 
                    <td><?=($row['factura3'] == 'N/A' || $row['factura3']=='')? 'N/A': $row['factura3']?></td> 
                    <td><?=($row['factura4'] == 'N/A' || $row['factura4']=='')? 'N/A': $row['factura4']?></td> 

                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio'])?></td>
                    <td><?=str_replace($letters, $fruit,$row['fecha_final'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio_ejecucion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_ejecutado'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_informe'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_liquidacion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_facturacion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado'])?></td>                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado2'])?></td>
                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado3'])?></td>
                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado4'])?></td>
                    
                    
                    <td><?= $obj->clearInt($row['valor_cotizado_hito'])?></td>
                    
                    <td><?=$valorfacturado?></td>
                    
                    <td><?=$valorfacturado2?></td>
                    
                    <td><?=$row['valorfacturado3']?></td>
                    
                    <td><?=$row['valorfacturado4']?></td>
                    
                    <td><?=$dias_hito?></td>
                     
                    <td><?=$totalAnticipo?></td>
                    
                    <td><?=$totalCompra?></td>
                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado'])?></td>
                    <td><?=$rs_paifgr['departamento']?></td>
                    
                    <td><?=$fechaEliminado?></td>                     
                    <td><?=$fechaCancelado?></td>                    
                    <td><?=$fechaDuplicado?></td> 
                    
                    <td><?=$row['historico_cotizado']?></td>
                    
                </tr>
<?		
		}
	endwhile;

/*Hitos Eliminados desde acá*/

	$query = "SELECT * FROM hitos_eliminados ".$where." ORDER BY id DESC";			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	$letters = array('-');
	$fruit   = array('/');	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	

		$sqlfgr = "select estado from hitos_eliminados where id = ".$row['id'];
		$paifgr = mysql_query($sqlfgr);  
		$rs_paifgr = mysql_fetch_assoc($paifgr);
		
		$sql3 = "	SELECT SUM( tmp.valor_adjudicado * tmp.cantidade) AS total_compras
					FROM `solicitud_despacho` AS sd
					LEFT JOIN TEMP_MERCANCIAS AS tmp ON tmp.id_despacho = sd.id
					WHERE sd.id_hito = ".$row['id'];
		$pai3 = mysql_query($sql3); 
		$rs_pai3 = mysql_fetch_assoc($pai3);
		
		if($rs_paifgr['estado'] != 'ELIMINADO') {
			
			$totalAnticipo = 0;

			$sql2 = "select p.nombre AS nombre, (SELECT c.nombre FROM cliente AS c where c.id = p.id_cliente) AS nomcliente from proyectos p where p.id = ".$row['id_proyecto'];
	
			$pai2 = mysql_query($sql2);	
			$rs_pai2 = mysql_fetch_assoc($pai2);
			
			if($row['dias_hito'] != '')
				$dias_hito = $row['dias_hito'];
			else
				$dias_hito = 0;

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$rs_pai2['nombre']?></td>

                    <td><?=$row['nombre']?></td>

                    <td><?=$row['estado'].'-ELIMINADO'?></td>

                    <td><?=$row['descripcion']?></td>

                    <td><?=$row['ot_cliente']?></td>
                    
                    <td><?=$rs_pai2['nomcliente']?></td>

                    <td><?=$row['po']?></td>

                    <td><?=$row['gr']?></td>
                    
                     <td><?=($row['factura'] == 'N/A' || $row['factura']=='')? 'N/A': $row['factura']?></td>
                    
                    <td><?=$row['po2']?></td>

                    <td><?=$row['gr2']?></td>
                    
                    <td><?=($row['factura2'] == 'N/A' || $row['factura2']=='')? 'N/A': $row['factura2']?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_final'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio_ejecucion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_ejecutado'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_informe'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_liquidacion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_facturacion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado'])?></td>
                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_facturado2'])?></td>
                    
                    <td><?=$obj->clearInt($row['valor_facturado'])?></td>
                    
                    <td><?=$obj->clearInt($row['valor_facturado2'])?></td>
                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_pagado'])?></td>
                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_pagado2'])?></td>
                    
                    <td><?=$dias_hito?></td>
                     
                    <td><?=$obj->clearInt($totalAnticipo)?></td>
                    
                    <td><?=$obj->clearInt($totalCompra)?></td>
                    
                    <td><?=$fechaEliminado?></td> 
                    
                    <td><?=$fechaCancelado?></td> 
                    
                    <td><?=$fechaDuplicado?></td> 
                    
                    <td><?=$row['historico_cotizado']?></td>

                </tr>
<?		
		}
	endwhile;
?>

	</table> 