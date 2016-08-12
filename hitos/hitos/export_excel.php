<?php

    header("Content-type:   application/x-msexcel; charset=utf-8");
    header("Pragma: no-cache");
    header("Expires: 0");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

    header('Content-Type: application/vnd.ms-excel charset=utf-8');
    header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");

	include "../../conexion.php";
	include "../extras/php/basico.php";	 
	
	$fechas = '';
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin']) && $_GET['fecini'] != 'undefined' && $_GET['fecfin'] != 'undefined'){
		$fechas = " AND (fecha BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."')"; 
    }

	$query = "SELECT * FROM hitos WHERE 1 ".$fechas." ORDER BY id DESC";			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head> 
	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Proyecto</strong></td>

            <td align="center"><strong>Nombre Hito</strong></td>

            <td align="center"><strong>Estado</strong></td>
            
            <td align="center"><strong>Autorizado</strong></td>

            <td align="center"><strong>Descripci&oacute;n</strong></td>

            <td align="center"><strong>PO / TT</strong></td>
            
            <td align="center"><strong>Galones Pagados</strong></td>
            
            <td align="center"><strong>Cliente</strong></td>

            <td align="center"><strong>PO</strong></td>
            <td align="center"><strong>GR</strong></td>
            <td align="center"><strong>#Factura 1</strong></td>            
            <td align="center"><strong>Valor Facturado</strong></td> 
            <td align="center"><strong>Fecha Facturado 1</strong></td>           
            
            <td align="center"><strong>PO2</strong></td>
            <td align="center"><strong>GR2</strong></td>
            <td align="center"><strong>#Factura 2</strong></td>
            <td align="center"><strong>Valor Facturado 2</strong></td>
            <td align="center"><strong>Fecha Facturado 2</strong></td>
            
            <td align="center"><strong>P3</strong></td>
            <td align="center"><strong>G3</strong></td>
            <td align="center"><strong>#Factura 3</strong></td>
            <td align="center"><strong>Valor Facturado 3</strong></td>
            <td align="center"><strong>Fecha Facturado 3</strong></td>
            
            <td align="center"><strong>P4</strong></td>
            <td align="center"><strong>G4</strong></td>
            <td align="center"><strong>#Factura 4</strong></td>
            <td align="center"><strong>Valor Facturado 4</strong></td>
            <td align="center"><strong>Fecha Facturado 4</strong></td>           
            
            <td align="center"><strong>Sumatoria Factura</strong></td> 
            
            <td align="center"><strong>Liquidaci&oacute;n Final</strong></td>
          
            <td align="center"><strong>Fecha Inicio</strong></td>

            <td align="center"><strong>Fecha Final</strong></td>

            <td align="center"><strong>Fecha Inicio Ejecuci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Ejecuci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Informe</strong></td>

            <td align="center"><strong>Fecha Liquidaci&oacute;n</strong></td>

            <td align="center"><strong>Fecha Facturaci&oacute;n</strong></td>

            <td align="center"><strong>Fecha gran Facturado</strong></td>            
            
            <td align="center"><strong>Valor Cotizado</strong></td>
            
            <td align="center"><strong>Departamento</strong></td>
            
            <td align="center"><strong>Direcci&oacute;n</strong></td>
            
            <td align="center"><strong>Observaciones</strong></td>
            
            <td align="center"><strong>Fecha Creado</strong></td>
          
            <td align="center"><strong>Hist&oacute;rico Cotizado</strong></td>

        </tr>

	

<?php	

	$letters = array('-');
	$fruit   = array('/');	
	
	
	$obj = new TaskCurrent; //../../objetos/init.php

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	

		/*$sqlfgr = "";
		$paifgr = mysql_query($sqlfgr); 
		$rs_paifgr = mysql_fetch_assoc($paifgr);*/
		
		//if($rs_paifgr['estado'] != 'ELIMINADO') {

		$sql2 = "SELECT p.nombre AS nombre, 
				(SELECT c.nombre FROM cliente AS c where c.id = p.id_cliente) AS nomcliente,
				(SELECT name FROM ps_state WHERE id = ".$row['id_ps_state'].") AS departamento
				FROM proyectos p where p.id = ".$row['id_proyecto'];
		$pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);
		
		$sumatoriafactura = $obj->clearInt($row['valor_facturado']) + $obj->clearInt($row['valor_facturado2']) + $obj->clearInt($row['valorfacturado3']) + $obj->clearInt($row['valorfacturado4']);
		
		$sqls = "SELECT ciudad, direccion FROM sitios WHERE id = ".$row['id_sitios'];
		$pais = mysql_query($sqls);
		$rs_pais = mysql_fetch_assoc($pais);
		
		//log eventos
		/*$sqle = "SELECT estado, fecha_cambio
				 FROM log_eventos WHERE estado IN('ELIMINADO','CANCELADO','DUPLICADO') AND modulo = 'Hito' AND ref_id = ".$row['id']." ORDER BY id DESC LIMIT 1";
		$paie = mysql_query($sqle);
		
		$fechaEliminado = '';
		$fechaCancelado = '';
		$fechaDuplicado = '';
		
		//while( $rs_paie = mysql_fetch_assoc($paie) ):
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
		//endwhile;*/
?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$rs_pai2['nombre']?></td>

                    <td><?=$row['nombre']?></td>

                    <td><?=$row['estado']?></td>
                    
                    <td><?=($row['autorizado'])?'Si':'No'?></td>

                    <td><?=$row['descripcion']?></td>

                    <td><?=$row['ot_cliente']?></td>
                    <td><?=$row['cant_galones_h']?></td>
                    
                    <td><?=$rs_pai2['nomcliente']?></td>

                    <td><?=$row['po']?></td>
                    <td><?=$row['gr']?></td>
                    <td><?=$row['factura']?></td>                    
                    <td><?=$obj->clearInt($row['valor_facturado'])?></td>
                    <td><?=$row['fecha_facturado1']?></td>
                    
                    <td><?=$row['po2']?></td>
                    <td><?=$row['gr2']?></td>
                    <td><?=$row['factura2']?></td> 
                    <td><?=$obj->clearInt($row['valor_facturado2'])?></td>
                    <td><?=$row['fecha_facturado2']?></td>
                    
                    <td><?=$row['po3']?></td>
                    <td><?=$row['gr3']?></td>
                    <td><?=$row['factura3']?></td> 
                    <td><?=$row['valorfacturado3']?></td> 
                    <td><?=$row['fecha_facturado3']?></td> 
                    
                    <td><?=$row['po4']?></td>
                    <td><?=$row['gr4']?></td>
                    <td><?=$row['factura4']?></td> 
                    <td><?=$row['valorfacturado4']?></td> 
                    <td><?=$row['fecha_facturado4']?></td> 
                    
                    <td><?=$sumatoriafactura?></td>
                    
                    <td><?=$row['liquidacion_final']?></td>
                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_final'])?></td>
                  
                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio_ejecucion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_ejecutado'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_informe'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_liquidacion'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_facturacion'])?></td>

                    <td><?=$row['fecha_facturado']?></td>
                    
                    <td><?=$obj->clearInt($row['valor_cotizado_hito'])?></td> 
                    
                    <td><?=$rs_pai2['departamento']?></td>
                    
                    <td><?=$rs_pais['direccion'].', '.$rs_pais['ciudad']?></td>
                    
                    <td><?=$row['observaciones']?></td> 
                    
                    <td><?=$row['fecha']?></td> 
 
                    <td><?=$row['historico_cotizado']?></td>

                </tr>

<?		
		//}
	endwhile;

?>

	</table>

    