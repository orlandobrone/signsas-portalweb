<?php

	/*header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");*/

	setlocale(LC_MONETARY, 'en_US');

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	$query = "	SELECT * FROM asignacion WHERE id_tecnico = ".$_GET['ide_per']."					

			  	ORDER BY id DESC";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

	$sql3 = "SELECT * FROM tecnico WHERE id = ".$_GET['ide_per'];

	$pai3 = mysql_query($sql3); 

	$rs_pai3 = mysql_fetch_assoc($pai3);

	

	

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





	

   $html= '

    <img src=http://proyecto.signsas.com/images/logo_sign.png  style="float:left;"/>

	<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE FUNCIONARIO / T&Eacute;CNICO </h2> 

	<div style="clear:both"></div>

	<br />

   

    <table rules="all" border="1">

    	<tr>

        	<td align="center"><strong>Nombre</strong></td>

            <td align="center">'.$rs_pai3['nombre'].'</td>

        

        	<td align="center"><strong>Cedula</strong></td>

            <td align="center">'.$rs_pai3['cedula'].'</td>

        </tr>

        

        <tr>

        	<td align="center"><strong>ARP</strong></td>

            <td align="center">'.$rs_pai3['ARP'].'</td>       

        	<td align="center"><strong>EPS</strong></td>

            <td align="center">'.$rs_pai3['EPS'].'</td>

        </tr>

        

        

        <tr>

        	<td align="center"><strong>Celular</strong></td>

            <td align="center">'.$rs_pai3['celular'].'</td>       

        	<td align="center"><strong>Regi&oacute;n</strong></td>

            <td align="center">'.$rs_pai3['region'].'</td>

        </tr>

        

        <tr>

        	<td align="center"><strong>Cargo</strong></td>

            <td align="center">'.$rs_pai3['cargo'].'</td>       

        	<td align="center"><strong>Valor Hora</strong></td>

            <td align="center">$'.$rs_pai3['valor_hora'].'</td>

        </tr>

    </table>

    

	<br />

    

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Hito</strong></td>

            <td align="center"><strong>Fecha Inicio</strong></td>

            <td align="center"><strong>Fecha Final</strong></td>

            <td align="center"><strong>Hora</strong></td>

            <td align="center"><strong>Dias Trabajados</strong></td>

            <td align="center"><strong>Horas Trabajadas</strong></td>

        </tr>';





	$letters = array('-');

	$fruit   = array('/');	

	

	$suma_dias = 0;

	$suma_horas = 0;

	$year = date('Y');

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

		

		$mes = explode('-',$row['fecha_fin']);

		

		if($mes[1] == $_GET['mes'] && $mes[0] == $year):

		

			$sql2 = "SELECT nombre FROM hitos WHERE id = ".$row['id_hito'];

			$pai2 = mysql_query($sql2); 

			$rs_pai2 = mysql_fetch_assoc($pai2);

			 

			$dias = dias_transcurridos($row['fecha_ini'],$row['fecha_fin']) + 1;

			$horas_trabajas = hourdiff($row['hora_inicio'] , $row['hora_final']) * ($dias+1);

			

			$suma_dias +=$dias;

			$suma_horas +=$horas_trabajas;



			$html .= '<tr>

						<td bgcolor="#CCCCCC">'.$row['id'].'</td>

						<td>'.$rs_pai2['nombre'].'</td>                    

						<td>'.str_replace($letters, $fruit,$row['fecha_ini']).'</td>

						<td>'.str_replace($letters, $fruit,$row['fecha_fin']).'</td>

						<td>'.$row['hora_inicio'].' - '.$row['hora_final'].'</td>

						<td align="center">'.$dias.'</td>

						<td align="center">'.$horas_trabajas.'</td>

					</tr>';



		endif;	

	endwhile;

	

   $valor_total =  $suma_horas * $rs_pai3['valor_hora'];	

	//FGR Nuevo Cálculo de Horas
	$sqlFGR = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600) AS horas, 
					  (SELECT COUNT(1) FROM asignacion AS x WHERE x.id_tecnico = t.id AND MONTH(x.fecha_ini) = ".$_GET['mes'].") AS dias,
					  SUM(CAST(REPLACE(REPLACE((t.`valor_hora`),'$',''),'.','') AS SIGNED)*(TIME_TO_SEC(TIMEDIFF(s.`hora_final`,s.`hora_inicio`))/3600)) AS costo
			     FROM `tecnico` AS t, `asignacion` AS s 
				WHERE t.id = ".$_GET['ide_per']." AND s.id_tecnico = t.id AND MONTH(s.fecha_ini) = ".$_GET['mes'];
						 
	$paiFGR = mysql_query($sqlFGR); 
	$rs_paiFGR = mysql_fetch_assoc($paiFGR);

   $html.= '

    	<tr>

        	<td align="center"><strong>Total Dias</strong></td>

            <td align="center">'.$rs_paiFGR['dias'].'</td>

        </tr>

        <tr>

        	<td align="center"><strong>Total Horas</strong></td>

            <td align="center">'.$rs_paiFGR['horas'].'</td>

        </tr>

        <tr>

        	<td align="center"><strong>Valor Total</strong></td>

            <td align="center">'. money_format('%(#1n',($rs_paiFGR['costo'])).'</td>

        </tr>

    

	</table>';

    

 

	require_once('/home/operacionsign/public_html/anticipos/anticipo/html2pdf.class.php');

	try

    {

		

        $html2pdf = new HTML2PDF('P', 'A4', 'es');

        //$html2pdf->setModeDebug();

        $html2pdf->setDefaultFont('Arial');

        $html2pdf->WriteHTML($html);

        $html2pdf->Output('Pago_'.$rs_pai3['cedula'].'_'.(int)$_GET['mes'].'.pdf');

		

		echo json_encode(array('estado'=>true, 'file'=>'Anticipo_ID_'.(int)$_GET['ide_per'].'.pdf'));

		exit;

		

    }

    catch(HTML2PDF_exception $e) {

		echo json_encode(array('estado'=>false, 'message'=>$e));

        exit;

    }



?>  

