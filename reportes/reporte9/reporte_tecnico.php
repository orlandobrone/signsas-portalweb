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
	
	include "../../festivos.php";
	
	$dias_festivos = new festivos(date("Y"));
	
	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		return $dias;
	}

		$query = "SELECT COUNT(*) AS totalRows
					FROM `tecnico` AS t, `asignacion` AS s 
 				   WHERE s.id_tecnico = t.id AND MONTH(s.fecha_ini) = ".$_GET['mes']; 
  
			   
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	   
	 //ahora dividimos el conteo por el numero de registros que queremos por pagina.
    $max_num_paginas = intval($row['totalRows']/300); //en esto caso 300	
	mysql_free_result($result);
	
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){
		echo 'Reporte T&eacute;cnicos Entre '.$_GET['fecini'].' y '.$_GET['fecfin'];
		$where .= "AND s.fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."'";
		$where2 .= "AND x.fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."'";
		//$numdias = dias_transcurridos(date($_GET['fecini']),date($_GET['fecfin']))+1;
		$fecini1 = date($_GET['fecini']);
		$fecfin1 = date($_GET['fecfin']);
		$numdias = 0;
		while($fecini1 <= $fecfin1){
			if($dias_festivos->esHabilSabado($fecini1))
				$numdias++;
			$fecini1 = date("Y-m-d",strtotime($fecini1)+86400);
		}
	}
	else{
		echo 'Reporte T&eacute;cnicos Mes: '.$meses[(int)$_GET['mes']-1]; 
		$where .= "AND MONTH(s.fecha_ini) = ".$_GET['mes'];
		$where2 .= "AND MONTH(x.fecha_ini) = ".$_GET['mes'];
		$numdias = 26;
	}
	
		$horasdebio=$numdias*8;
	
	?>
	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>id</strong></td>
            <td align="center"><strong>Nombre</strong></td>
            <td align="center"><strong>C&eacute;dula</strong></td>
            <td align="center"><strong>Cargo</strong></td>
            <td align="center"><strong>Regional</strong></td>
            <td align="center"><strong>Valor Hora</strong></td>
            <td align="center"><strong>Horas Trabajadas</strong></td>
            <td align="center"><strong>Horas Debio Trabajar</strong></td>
            <td align="center"><strong>Horas No Trabajadas</strong></td>
            <td align="center"><strong>% Desocupaci&oacute;n</strong></td>
            <td align="center"><strong>U/P</strong></td>
            <td align="center"><strong>Costo</strong></td>
            <td align="center"><strong>Costo Compa&ntilde;&iacute;a</strong></td>
            <td align="center"><strong>Costo Per&iacute;odo</strong></td>
        </tr>
    
    <?php
 	 
	for($i=1; $i <= $max_num_paginas+1; $i++):		
		getListar($i,$where,$where2,$horasdebio);
		//sleep(5);
	endfor;

	function getListar($pag,$where,$where2,$horasdebio){

				$query = "SELECT t.`id` AS id, 
								t.`nombre` AS nombre, 
								t.`cedula` AS cedula, 
								t.`region` AS regional, 
								t.valor_hora AS valorhora,
								SUM(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600) AS horas, 
								(SUM((t.`valor_hora`)*(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600))) AS costo, 
								((t.`valor_hora`)*30*8) AS costocompania
						  FROM `tecnico` AS t, `asignacion` AS s 
						 WHERE s.id_tecnico = t.id ".$where."
						 GROUP BY (s.id_tecnico) ORDER BY t.id DESC LIMIT ".(($pag-1)*300).", 300";
						 
		
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
			$horasno = $horasdebio - str_replace('.',',',$row['horas']);
			
			$valor_hora = str_replace('.',',',$row['valorhora']);
			
			$costo = str_replace('.',',',$row['costo']);
			
			$costocompania = str_replace('.',',',$row['costocompania']);
?>
      
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['nombre']?></td>
                    <td><?=$row['cedula']?></td>
                    <td><?=$row['cargo']?></td>
                    <td><?=$row['regional']?></td>
                    <td><?=$valor_hora?></td>
                    <td><?=str_replace('.',',',$row['horas'])?></td>
                    <td><?=$horasdebio?></td>
                    <td><?=$horasno?></td>
                    <td><?=round(($horasno/$horasdebio)*100,2).'%'?></td>
                    <td><?=$horasno*$valor_hora?></td>
                    <td><?='$'.$costo?></td>
                    <td><?='$'.$costocompania?></td> 
                    <td><?='$'.$horasdebio*$valor_hora?></td>               

<?php		
		endwhile;
		mysql_free_result($result);
	}
	
	$query = "SELECT t.`id` AS id, 
								t.`nombre` AS nombre, 
								t.`cedula` AS cedula, 
								t.`region` AS regional, 
								t.valor_hora AS valorhora
						  FROM `tecnico` AS t 
						 WHERE t.id NOT IN (SELECT DISTINCT(x.id_tecnico) FROM `asignacion` AS x WHERE x.fecha_ini BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."')
						 ORDER BY t.id DESC";
		
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
		
		$valor_hora = str_replace('.',',',$row['valorhora']);
?>
      
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['nombre']?></td>
                    <td><?=$row['cedula']?></td>
                    <td><?=$row['regional']?></td>
                    <td><?=$valor_hora?></td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td> 
                    <td>0</td>               

<?php		
		endwhile;
		mysql_free_result($result);
?>
</table>