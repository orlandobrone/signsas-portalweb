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
		
		//utiulidad acumulada
		$proyecto = (isset($_POST['proyecto'])) ? $_POST['proyecto'] : '';
		
		$vowels = array(",");
		$costosNew = 0;	
	
		if ($proyecto != '*' && $proyecto != ''):
	
			$sql = "SELECT *, proyect.nombre AS nombre, proyect.descripcion AS description					
					FROM proyectos AS proyect
					LEFT JOIN cotizacion AS coti ON coti.id = proyect.id_cotizacion
					WHERE proyect.id = {$proyecto} ";
					
			$qrCostos = mysql_query($sql); 
			$rowsCostos = mysql_fetch_array($qrCostos);	
			
			$costosNew     =  (int)str_replace($vowels, "", $rowsCostos['transportes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['ica2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero2']) 
							+ (int)str_replace($vowels, "", $rowsCostos['acarreos2'] )							
							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones2'])
							+ (int)str_replace($vowels, "", $rowsCostos['profesionales2'])
							+ (int)str_replace($vowels, "", $rowsCostos['seguros2'])
							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2'])
							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2'])
							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios2'])
							+ (int)str_replace($vowels, "", $rowsCostos['combustible2'])
							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2'])
							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje2'])
							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['papeleria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['internet2'])
							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses2'])
							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor2'])
							+ (int)str_replace($vowels, "", $rowsCostos['peajes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['polizas2'])
							+ (int)str_replace($vowels, "", $rowsCostos['materiales2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOD2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOI2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['TOES2']);
			
		
		else:
			
			if($proyecto == '*'):
				
				$costosNew = 0;
				
			    $sql = "SELECT *, proyect.nombre AS nombre, proyect.descripcion AS description					
						FROM proyectos AS proyect
						LEFT JOIN cotizacion AS coti ON coti.id = proyect.id_cotizacion
						WHERE 1 ";
				
				$qrCostos = mysql_query($sql); 
				
				while($rowsCostos = mysql_fetch_assoc($qrCostos)):	
				
				   $costosNew  += (int)str_replace($vowels, "", $rowsCostos['transportes2'])
								+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2'])
								+ (int)str_replace($vowels, "", $rowsCostos['imprevistos2'])
								+ (int)str_replace($vowels, "", $rowsCostos['ica2'] )
								+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero2']) 
								+ (int)str_replace($vowels, "", $rowsCostos['acarreos2'] )							
								+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos2'] )
								+ (int)str_replace($vowels, "", $rowsCostos['reparaciones2'])
								+ (int)str_replace($vowels, "", $rowsCostos['profesionales2'])
								+ (int)str_replace($vowels, "", $rowsCostos['seguros2'])
								+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2'])
								+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2'])
								+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2'])
								+ (int)str_replace($vowels, "", $rowsCostos['envios_correos2'])
								+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios2'])
								+ (int)str_replace($vowels, "", $rowsCostos['combustible2'])
								+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2'])
								+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje2'])
								+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2'])
								+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2'])
								+ (int)str_replace($vowels, "", $rowsCostos['papeleria2'])
								+ (int)str_replace($vowels, "", $rowsCostos['internet2'])
								+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses2'])
								+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos2'])
								+ (int)str_replace($vowels, "", $rowsCostos['caja_menor2'])
								+ (int)str_replace($vowels, "", $rowsCostos['peajes2'])
								+ (int)str_replace($vowels, "", $rowsCostos['polizas2'])
								+ (int)str_replace($vowels, "", $rowsCostos['materiales2'])	
								+ (int)str_replace($vowels, "", $rowsCostos['MOD2'])	
								+ (int)str_replace($vowels, "", $rowsCostos['MOI2'])	
								+ (int)str_replace($vowels, "", $rowsCostos['TOES2']);
				
				endwhile;				
			
			endif;
		
		endif;
		
	
		if ($proyecto != '*' && $proyecto != ''):
	
			$sql = "SELECT proyect.nombre AS nombre, 
						   proyect.descripcion AS description,  
						   SUM( costo.valor ) AS SumaCostos,
						   SUM( ingre.valor ) AS SumaUtilidad
					FROM proyectos AS proyect
					LEFT JOIN proyecto_ingresos AS ingre ON proyect.id = ingre.id_proyecto
					LEFT JOIN proyecto_costos AS costo ON proyect.id = costo.id_proyecto
					WHERE proyect.id = {$proyecto}";
					
			$qrCostos = mysql_query($sql); 
			$rowsCostos = mysql_fetch_array($qrCostos);
			
			$vowels = array(",");	
			
			$nombreProyecto = $rowsCostos['nombre'];			
			$descriptionProyect = $rowsCostos['description'];
			
			
			$sqlU = "SELECT proyect.nombre AS nombre, 
						   proyect.descripcion AS description,  
						   SUM( ingre.valor ) AS SumaUtilidad
					FROM proyectos AS proyect
					LEFT JOIN proyecto_ingresos AS ingre ON proyect.id = ingre.id_proyecto
					WHERE proyect.id = {$proyecto}";
			
			$qrUtili = mysql_query($sqlU); 
			$rowsUtili = mysql_fetch_array($qrUtili);
			
			$costos = (int)$rowsCostos['SumaCostos'];
			$ingresos = (int)$rowsUtili['SumaUtilidad'];
			
			if(($ingresos - $costos)<0)
				$utilidad = 0;
			else
				$utilidad = $costos; //FGR Nueva Variable utilidad
		
		else:
			
			if($proyecto == '*'):
				
				$costos = 0;
				$ingresos = 0;
				
				$sql = "SELECT proyect.nombre AS nombre, 
							   proyect.descripcion AS description,  
							   SUM( costo.valor ) AS SumaCostos,
							   SUM( ingre.valor ) AS SumaUtilidad
						FROM proyectos AS proyect
						LEFT JOIN proyecto_ingresos AS ingre ON proyect.id = ingre.id_proyecto
						LEFT JOIN proyecto_costos AS costo ON proyect.id = costo.id_proyecto
						WHERE 1";
				
				$qrCostos = mysql_query($sql); 
				
				while($rowsCostos = mysql_fetch_assoc($qrCostos)):	
				
					$costos += (int)$rowsCostos['SumaCostos'];
					$ingresos += (int)$rowsCostos['SumaUtilidad'];
				
				endwhile;	
				
				if(($ingresos - $costos)<0)
					$utilidad = 0;
				else
					$utilidad = $ingresos - $costos; //FGR Nueva Variable utilidad
				
				$nombreProyecto = ' Todos los Proyectos ';			
				$descriptionProyect = 'Detalles de todos los proyectos';
				
			else:
		
				$nombreProyecto = '';			
				$descriptionProyect = '';
			
			endif;
		
		endif;
		
		?> 
        
        
    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        <script src="../js/amcharts.js" type="text/javascript"></script> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>        
        <script type="text/javascript">
            var chart;

            var chartData = [{
                year: "Ingresos",
                costos: <?=$costos?>,  
                utilidad: <?=$costosNew?>
            }];

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";

                // sometimes we need to set margins manually
                // autoMargins should be set to false in order chart to use custom margin values
                chart.autoMargins = false;
                chart.marginLeft = 0;
                chart.marginRight = 0;
                chart.marginTop = 30;
                chart.marginBottom = 40;
				chart.depth3D = 25;
                chart.angle = 30;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridPosition = "start";

                // value				                
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = "100%"; // this line makes the chart 100% stacked
                valueAxis.gridAlpha = 0;
                valueAxis.axisAlpha = 0;
                valueAxis.labelsEnabled = false;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph                          
                var graph = new AmCharts.AmGraph();
                graph.title = "Costos";
                graph.labelText = "[[percents]]%";
                graph.balloonText = "[[value]] ([[percents]]%)";
                graph.valueField = "costos";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = "#C72C95";
                chart.addGraph(graph);

                // second graph              
                var graph = new AmCharts.AmGraph();
                graph.title = "Utilidad";
                graph.labelText = "[[percents]]%";
                graph.balloonText = "[[value]] ([[percents]]%)";
                graph.valueField = "utilidad";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = "#69A55C";
                chart.addGraph(graph);

                // LEGEND                  
                var legend = new AmCharts.AmLegend();
                legend.borderAlpha = 0.2;
                legend.horizontalGap = 10;
                legend.autoMargins = false;
                legend.marginLeft = 20;
                legend.marginRight = 20;
                legend.switchType = "v";
                chart.addLegend(legend);

                // WRITE                  
                chart.write("chartdiv");
				$("tspan:contains('chart by amcharts.com')").remove();
            });
        </script>
        
        <form id="formPry" name="formPry" action="reporte4.php?tab=<?=$_GET['tab']?>" method="post">
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
				<h2><?php echo $nombreProyecto?></h2>
                <p style="margin-bottom:20px;"><?php echo $descriptionProyect ?></p>
			</div>
			<div id="chartdiv" style="position:relative;width:600px;height:400px;"></div>
			
       </div>
        <?php require_once "../../tpl_bottom.php"; ?>