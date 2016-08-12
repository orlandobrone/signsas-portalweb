<?php

	header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=pagos_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	setlocale(LC_MONETARY, 'en_US');



	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	//$query = "SELECT * FROM tecnico WHERE 1 ORDER BY id DESC";

	$query = "SELECT * FROM tecnico WHERE region = ".$_GET['region']." ORDER BY id DESC";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

	

	$array_mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiempre','Octubre','Noviembre','Diciembre');

	

	function dias_transcurridos($fecha_i,$fecha_f)

	{

		$dias = (strtotime($fecha_i)-strtotime($fecha_f))/86400;

		$dias = abs($dias); $dias = floor($dias);

		return $dias;

	}

	

	

	function hourdiff($hour_1 , $hour_2 , $formated=false){

			$h1_explode = explode(":" , $hour_1);

			$h2_explode = explode(":" , $hour_2);

		

			$h1_explode[0] = (int) $h1_explode[0];

			$h1_explode[1] = (int) $h1_explode[1];

			$h2_explode[0] = (int) $h2_explode[0];

			$h2_explode[1] = (int) $h2_explode[1];

			

		

			$h1_to_minutes = ($h1_explode[0] * 60) + $h1_explode[1];

			$h2_to_minutes = ($h2_explode[0] * 60) + $h2_explode[1];

		

			

			if($h1_to_minutes > $h2_to_minutes){

			$subtraction = $h1_to_minutes - $h2_to_minutes;

			}

			else

			{

			$subtraction = $h2_to_minutes - $h1_to_minutes;

			}

		

			$result = $subtraction / 60;

		

			if(is_float($result) && $formated){

			

			$result = (string) $result;

			  

			$result_explode = explode(".",$result);

		

			return $result_explode[0].":".(($result_explode[1]*60)/10);

			}

			else

			{

			return $result;

			}

	}

	

	

?>

	<h2>Reporte Mes:(<?=$array_mes[$_GET['mes']-1]?>) | Regi&oacute;n: <?=$_GET['region']?> </h2>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Nombre</strong></td>

            <td align="center"><strong>Cedula</strong></td>

            <td align="center"><strong>ARP</strong></td>

            <td align="center"><strong>EPS</strong></td>

            <td align="center"><strong>Celular</strong></td>

            <td align="center"><strong>Regi&oacute;n</strong></td>

            <td align="center"><strong>Cargo</strong></td>

            <td align="center"><strong>Valor Hora</strong></td>

          	<td align="center"><strong>Dias Trabajados</strong></td>

            <td align="center"><strong>Horas Trabajadas</strong></td>

            <td align="center"><strong>Valor Total</strong></td>

        </tr>

	

<?php	

	$year = date('Y');

	$total = 0;

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

	

		$suma_dias = 0;

		$suma_horas = 0;

		$valor_total = 0;

		$valor_hora = 0;

	

		$query2 = "SELECT * FROM asignacion WHERE id_tecnico = ".$row['id']."					

				   ORDER BY id DESC";

		$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());

		

		while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)):

		

			$mes = explode('-',$row2['fecha_fin']);

			

			if($mes[1] == $_GET['mes'] && $mes[0] == $year):

			

				$dias = dias_transcurridos($row2['fecha_ini'], $row2['fecha_fin']) + 1;

				$horas_trabajas = hourdiff($row2['hora_inicio'], $row2['hora_final']) * ($dias+1);

				

				$suma_dias +=$dias;

				$suma_horas +=$horas_trabajas;

		

			endif;

			

			$valor_hora = ($row['valor_hora'] == '')? 0 : $row['valor_hora'];

			$valor_total = $valor_hora * round($suma_horas,0, PHP_ROUND_HALF_UP);

			

		endwhile;

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=utf8_decode($row['nombre'])?></td>

                    <td><?=$row['cedula']?></td>

                    <td><?=$row['ARP']?></td>

                    <td><?=$row['EPS']?></td>

                    <td><?=$row['celular']?></td>

                    <td><?=$row['region']?></td>

                    <td><?=$row['cargo']?></td>

                    <td>$<?=$valor_hora?></td>

                    

                    <td><?=$suma_dias?></td>

                    <td><?=round($suma_horas,0, PHP_ROUND_HALF_UP)?></td>

                    <td><?=money_format('%(#1n',($valor_total))?></td>

                </tr>

<?		

		$total += $valor_total;

		  	

	endwhile;0

?>

		<tr>

        	<td colspan="10">&nbsp;</td>

        	<td align="center"><strong>Total</strong></td>

            <td align="center"><?=money_format('%(#1n',($total))?></td>

        </tr>        

	

	</table>

    

