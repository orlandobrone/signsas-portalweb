<?php

	header("Pragma: public");
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Costos_Hitos_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	
   
	include "../../conexion.php";

	include "../../anticipos/extras/php/basico.php";

	$where = "";
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){
	
		$where = "WHERE h.fecha_inicio BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."'";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}

	$query = "SELECT COUNT(*) AS totalRows
				FROM hitos AS h ".$where; 
  
			   
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	   
	 //ahora dividimos el conteo por el numero de registros que queremos por pagina.
    $max_num_paginas = intval($row['totalRows']/300); //en esto caso 100	
	mysql_free_result($result);
	
	
	?>
    
	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>HITO</strong></td>
            <td align="center"><strong>Nombre Hito</strong></td>
            <td align="center"><strong>Estado</strong></td>
            <td align="center"><strong>Fecha Creacion Hito</strong></td>
            <td align="center"><strong>Valor Cotizado Hito</strong></td>
            <td align="center"><strong>OT</strong></td>
            <td align="center"><strong>Cliente</strong></td>
            <td align="center"><strong>Anticipo</strong></td>
            <td align="center"><strong>Total Legalizado</strong></td>
            <td align="center"><strong>Suministro ACPM</strong></td>
            <td align="center"><strong>Servicio TOES</strong></td>
            <td align="center"><strong>Transporte TOES</strong></td>
            <td align="center"><strong>Trasiegos Mulares</strong></td>
            <td align="center"><strong>Compra Materiales</strong></td>
            <td align="center"><strong>Viaticos</strong></td>
            <td align="center"><strong>Servicio Ayudante</strong></td>
            <td align="center"><strong>Combustible Camionetas</strong></td>
            <td align="center"><strong>Peajes</strong></td>
            <td align="center"><strong>Taxi Buses</strong></td>
            <td align="center"><strong>Otros Movilidad</strong></td>
            <td align="center"><strong>Recarga Celulares</strong></td>
            <td align="center"><strong>Otros Gastos</strong></td>
            <td align="center"><strong>Reintegro</strong></td>
            <td align="center"><strong>Gastos Administrativos</strong></td>
            <td align="center"><strong>Otros Conceptos</strong></td>
            <td align="center"><strong>Vehiculo</strong></td>
            <td align="center"><strong>Tecnico</strong></td>
            <td align="center"><strong>Fecha Facturado</strong></td>
            <td align="center"><strong>Valor Facturado</strong></td>
        </tr>
    
    <?
 	 
	for($i=1; $i <= $max_num_paginas+1; $i++):		
		getListar($i,$where);
		//sleep(5);
	endfor;
	

	function getListar($pag,$where){

				$query = "SELECT h.id AS HITO, 
									h.nombre AS nomhito, 
								   (SELECT nombre 
								      FROM proyectos 
									 WHERE id = h.id_proyecto) AS OT, 
								    h.estado AS estadohito,
									h.fecha AS fechacreacion,
								    h.valor_facturado AS valorhito,
									h.fecha_facturado AS fechafacturado,
									h.valor_cotizado_hito AS valor_hito,
								   (SELECT y.nombre 
									  FROM proyectos AS x, cliente AS y 
									 wHERE x.id = h.id_proyecto AND x.id_cliente = y.id) AS cliente, 
								   (SELECT SUM(g.total_hito) 
									  FROM `items_anticipo` AS g, anticipo AS a 
									 WHERE g.id_hitos = h.id AND g.id_anticipo = a.id AND a.estado = 1 GROUP BY(g.id_hitos)) AS anticipo, 
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 1 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS suministro_acpm, 
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 2 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS servicios_toes,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 3 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS transporte_toes,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 4 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS trasiegos_mulares,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 5 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS compra_materiales,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 6 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS viaticos,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 7 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS servicio_ayudante,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l
									 WHERE i.id_hito = h.id AND i.concepto = 8 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS combustible_camionetas,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 9 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS peajes,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 10 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS taxis_buses,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 11 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS otros_movilidad,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 12 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS recarga_celulares,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 13 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS otros_gastos,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 14 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS reintegro,
								   (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 15 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS gastos_administrativos,
									 (SELECT SUM(i.pagado) 
									  FROM items AS i, legalizacion AS l 
									 WHERE i.id_hito = h.id AND i.concepto = 16 AND i.`id_legalizacion` = l.`id` AND l.`estado` = 'APROBADO'
									 GROUP BY (i.id_hito)) AS otros_conceptos,
								   (SELECT SUM((SELECT w.valor_hora FROM vehiculos AS w WHERE w.id = z.id_vehiculo)*(TIME_TO_SEC(TIMEDIFF(`hora_final`,`hora_inicio`))/3600)) 
									  FROM `asignacion` AS z
									 WHERE z.id_hito = h.id) AS vehiculos,
								   (SELECT SUM((SELECT t.valor_hora FROM tecnico AS t WHERE t.id = s.id_tecnico)*(TIME_TO_SEC(TIMEDIFF(`hora_final`,`hora_inicio`))/3600)) 
									  FROM `asignacion` AS s 
									 WHERE s.id_hito = h.id) AS tecnico
								FROM hitos AS h ".$where." ORDER BY h.id DESC LIMIT ".(($pag-1)*300).", 300";
		
		$letters = array('-');	
		$fruit   = array('/');	
		
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
		
			$total_legalizado = (int)$row['suministro_acpm']+(int)$row['servicios_toes']+(int)$row['transporte_toes']+(int)$row['trasiegos_mulares']+(int)$row['compra_materiales']+(int)$row['viaticos']+(int)$row['servicio_ayudante']+(int)$row['combustible_camionetas']+(int)$row['peajes']+(int)$row['taxis_buses']+(int)$row['otros_movilidad']+(int)$row['recarga_celulares']+(int)$row['otros_gastos']+(int)$row['reintegro']+(int)$row['gastos_administrativos']+(int)$row['otros_conceptos'];

?>
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['HITO']?></td>
                    <td><?=$row['nomhito']?></td>
                    <td><?=$row['estadohito']?></td>
                    <td><?=$row['fechacreacion']?></td>
                    <td><?=$row['valor_hito']?></td>
                    <td><?=$row['OT']?></td>
                    <td><?=$row['cliente']?></td>
                    <td><?='$'.$row['anticipo']?></td>
                    <td><?='$'.$total_legalizado?></td>
                    <td><?='$'.$row['suministro_acpm']?></td>
                    <td><?='$'.$row['servicios_toes']?></td>
                    <td><?='$'.$row['transporte_toes']?></td>
                    <td><?='$'.$row['trasiegos_mulares']?></td>
                    <td><?='$'.$row['compra_materiales']?></td>
                    <td><?='$'.$row['viaticos']?></td>
                    <td><?='$'.$row['servicio_ayudante']?></td>
                    <td><?='$'.$row['combustible_camionetas']?></td>
                    <td><?='$'.$row['peajes']?></td>
                    <td><?='$'.$row['taxis_buses']?></td>
                    <td><?='$'.$row['otros_movilidad']?></td>
                    <td><?='$'.$row['recarga_celulares']?></td>
                    <td><?='$'.$row['otros_gastos']?></td>
                    <td><?='$'.$row['reintegro']?></td>
                    <td><?='$'.$row['gastos_administrativos']?></td>
                    <td><?='$'.$row['otros_conceptos']?></td>
                    <td><?='$'.(int)$row['vehiculo']?></td>
                    <td><?='$'.(int)$row['tecnico']?></td>
                    <td><?=$row['fechafacturado']?></td>   
                    <td><?='$'.$row['valorhito']?></td>                 

<?		
		endwhile;
		mysql_free_result($result);
	}
?>
</table>