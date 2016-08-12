<?php

	header("Pragma: public");
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=General_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	
   
	include "../../conexion.php";

	include "../../anticipos/extras/php/basico.php";

		$query = "SELECT COUNT(*) AS totalRows
					FROM `vehiculos` AS v, `asignacion` AS s 
 				   WHERE s.id_vehiculo = v.id AND MONTH(s.fecha_ini) = ".$_GET['mes']; 
  
			   
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	   
	 //ahora dividimos el conteo por el numero de registros que queremos por pagina.
    $max_num_paginas = intval($row['totalRows']/30); //en esto caso 100	
	mysql_free_result($result);
	
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){
		echo 'Reporte T&eacute;cnicos Entre '.$_GET['fecini'].' y '.$_GET['fecfin'];
		$where .= "AND s.fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."'";
		$where2 .= "AND x.fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."'";
	}
	else{
		echo 'Reporte T&eacute;cnicos Mes: '.$meses[(int)$_GET['mes']-1]; 
		$where .= "AND MONTH(s.fecha_ini) = ".$_GET['mes'];
		$where2 .= "AND MONTH(x.fecha_ini) = ".$_GET['mes'];
	}
	
	?>
    
	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>id</strong></td>
            <td align="center"><strong>Placa</strong></td>
            <td align="center"><strong>Marca</strong></td>
            <td align="center"><strong>Regional</strong></td>
            <td align="center"><strong>Horas Trabajadas</strong></td>
            <td align="center"><strong>D&iacute;as Trabajados</strong></td>
            <td align="center"><strong>Costo</strong></td>
            <td align="center"><strong>Costo Compa&ntilde;&iacute;a</strong></td>
        </tr>
    
    <?
 	 
	for($i=1; $i <= $max_num_paginas+1; $i++):		
		getListar($i);
		//sleep(5);
	endfor;
	

	function getListar($pag){

				$query = "SELECT v.`id` AS id, 
								v.`placa` AS placa, 
								v.`marca` AS marca, 
								v.`region` AS regional, 
								SUM(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600) AS horas, 
								(SELECT COUNT(1) FROM asignacion AS x WHERE x.id_vehiculo = v.id ".$where2.") AS dias,
								SUM(CAST(REPLACE(REPLACE((v.`valor_hora`),'$',''),'.','') AS SIGNED)*(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600)) AS costo, 
								(CAST(REPLACE(REPLACE((v.`valor_hora`),'$',''),'.','') AS SIGNED)*30*8) AS costocompania
						  FROM `vehiculos` AS v, `asignacion` AS s 
						 WHERE s.id_tecnico = v.id ".$where."
						 GROUP BY (s.id_tecnico) ORDER BY v.id DESC LIMIT ".(($pag-1)*30).", 30";
		
		$letters = array('-');	
		$fruit   = array('/');	
		
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

?>
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['placa']?></td>
                    <td><?=$row['marca']?></td>
                    <td><?=$row['regional']?></td>
                    <td><?=str_replace('.',',',$row['horas'])?></td>
                    <td><?=$row['dias']?></td>
                    <td><?='$'.(int)$row['costo']?></td>
                    <td><?='$'.(int)$row['costocompania']?></td>                

<?		
		endwhile;
		mysql_free_result($result);
	}
?>
</table>