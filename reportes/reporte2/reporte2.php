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
		$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';		
	
		if ($usuario != '*' && $usuario != 0) {
						
			$otorgado = 0;
			$noOtorogado = 0;
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE id_usuario = {$usuario} AND otorgado = 'Si' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$otorgado = mysql_num_rows($qrCostos);
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE id_usuario = {$usuario} AND otorgado = 'No' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$noOtorogado = mysql_num_rows($qrCostos);
			
			
		}else if($usuario == 0){
			
			$otorgado = 0;
			$noOtorogado = 0; 
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE otorgado = 'Si' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$otorgado = mysql_num_rows($qrCostos);
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE otorgado = 'No' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$noOtorogado = mysql_num_rows($qrCostos);
			
		}
		
		
		?>
    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        <script src="../reporte6/amcharts.js" type="text/javascript"></script> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>        
        <script type="text/javascript">
            var chart;
            var legend;   

            var chartData = [{
                country: "Cotizaciones Otorgadas",
                litres: <?=$otorgado?>
            },{
                country: "Cotizaciones Rechazadas",
                litres: <?=$noOtorogado?>
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
				
				$("tspan:contains('chart by amcharts.com')").remove();
            });
        </script>
        <form id="formPry" name="formPry" action="reporte2.php?tab=<?=$_GET['tab']?>" method="post">
        	Usuarios Comerciales:
        	<select name="usuario" id="usuario" onchange="document.formPry.submit();">
            	<option value="">Seleccione</option>
                <option value="0" <?php if($usuario == 0){  echo 'selected="selected"'; $nombrePry = 'Todos los usuarios'; } ?>>Todos los usuarios</option>
            	<?
					$sql = "SELECT DISTINCT `id_usuario`, u.nombres 
							FROM comercial AS c
							LEFT JOIN usuario AS u ON c.id_usuario = u.id";
					$qrPry = mysql_query($sql);
					$nombrePry = "";
					while($rs_pry = mysql_fetch_assoc($qrPry)){
				?>
					<option value="<?=$rs_pry['id_usuario']?>" <? if ($usuario == $rs_pry['id_usuario']){ echo 'selected="selected"'; $nombrePry = $rs_pry['nombres']; } ?>><?=$rs_pry['nombres']?></option>
				<? } ?>
            </select>
        </form>
		<div style="position: relative;">
			
			<h2><?=$nombrePry?></h2>
            
            <div id="chartdiv" style="position:relative;width:600px;height:400px; margin-bottom:30px;"></div>
        </div>
        <?php require_once "../../tpl_bottom.php"; ?>