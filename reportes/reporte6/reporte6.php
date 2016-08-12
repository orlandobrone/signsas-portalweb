<?php  include "../../restrinccion.php";  ?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin t?tulo</title>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery-1.3.2.min.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery.blockUI.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery.validate.1.5.2.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/mask.js"></script>
        <link href="../extras/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="../extras/php/PHPPaging.lib.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="index.js"></script>
    </head>
    <body>-->
	<?php //header('Content-type: text/html; charset=iso-8859-1');
	require_once "../../config.php"; ?>
		<?php require_once "../../tpl_top.php"; ?>
        <?php include "../../conexion.php"; ?>
		<?php 
        
        $proyecto = (isset($_POST['proyecto'])) ? $_POST['proyecto'] : '';
		
		$fechaactual = Date("Y-m-d");
		
    
        if ($proyecto != '*' && $proyecto != '' ) {
            $qrCostos = mysql_query("SELECT * FROM proyectos WHERE id = '" . $proyecto . "'"); 
            $rowsCostos = mysql_fetch_array($qrCostos);
            
            $fecha_inicial = $rowsCostos['fecha_inicio'];
			$fecha_final = $rowsCostos['fecha_final'];
			
			if($fechaactual>$fecha_final){
				$tiempoejecutado = diferenciaEntreFechas($fecha_final,$fecha_inicial,"DIAS",TRUE);
				$tiemporestante = 0;
			}
			else{
				$tiempoejecutado = diferenciaEntreFechas($fechaactual,$fecha_inicial,"DIAS",TRUE);
				$tiemporestante = diferenciaEntreFechas($fecha_final,$fechaactual,"DIAS",TRUE); 
			}
        }
		
		if($proyecto == '*'):
		
			$qrCostos = mysql_query("SELECT * FROM proyectos WHERE 1"); 
            $rowsCostos = mysql_fetch_array($qrCostos);
            
            $fecha_inicial = $rowsCostos['fecha_inicio'];
			$fecha_final = $rowsCostos['fecha_final'];
			
			if($fechaactual>$fecha_final){
				$tiempoejecutado = diferenciaEntreFechas($fecha_final,$fecha_inicial,"DIAS",TRUE);
				$tiemporestante = 0;
			}
			else{
				$tiempoejecutado = diferenciaEntreFechas($fechaactual,$fecha_inicial,"DIAS",TRUE);
				$tiemporestante = diferenciaEntreFechas($fecha_final,$fechaactual,"DIAS",TRUE); 
			}
		
		endif;
		
        ?>
    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        <script src="amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var chart;
            var legend;

            var chartData = [{
                country: "Tiempo Ejecutado (d\u00EDas):",
                litres: <?=$tiempoejecutado?>,
				backgroundColor: "#FFFFFF"
            },{
                country: "Tiempo Restante (d\u00EDas):",
                litres: <?=$tiemporestante?>,
				backgroundColor: "#2A0CD0"
            }];
            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "litres";
				chart.depth3D = 20;
                chart.angle = 30;
				chart.labelRadius = -30;
                chart.labelText = "[[percents]]%";

                // LEGEND
                legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.markerType = "circle";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartdiv");
            });
        </script>
        <form id="formPry" name="formPry" action="reporte6.php?tab=<?=$_GET['tab']?>" method="post">
        	Proyectos:
        	<select name="proyecto" id="proyecto" onchange="document.formPry.submit();">
            	<option value="">Seleccione</option>
                 <option value="*" <? if ($proyecto == '*'){ echo 'selected="selected"'; $nombrePry = 'Todos los proyectos'; } ?>>Todos los proyectos</option>
            	<?
					$sql = "select * from proyectos order by id asc";
					$qrPry = mysql_query($sql);
					$nombrePry = "";
					while($rs_pry = mysql_fetch_assoc($qrPry)){
				?>
					<option value="<?=$rs_pry['id']?>" <? if ($proyecto == $rs_pry['id']){ echo 'selected="selected"'; $nombrePry = $rs_pry['nombre']; } ?>><?=$rs_pry['nombre']?></option>
				<? } ?>
            </select>
        </form>
		<div style="position: relative;">
        	<div style="position:relative;width:600px;height:50px;background-color:white;">
				<h2><?=$nombrePry?></h2>
			</div>
			<div id="chartdiv" style="position:relative;width:600px;height:400px;"></div>
			
        </div>
        <?php require_once "../../tpl_bottom.php"; ?>
<?php
function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){
   $f0 = strtotime($fecha_principal);
   $f1 = strtotime($fecha_secundaria);
   if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
   $resultado = ($f0 - $f1);
   switch ($obtener) {
       default: break;
       case "MINUTOS"   :   $resultado = $resultado / 60;   break;
       case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
       case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
       case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
   }
   if($redondear) $resultado = round($resultado);
   return $resultado;
}
?>