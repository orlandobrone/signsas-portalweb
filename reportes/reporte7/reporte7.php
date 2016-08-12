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
			
			$script = ''; 
			$i = 1;	
			$totalIngresos = 0;	
			$totalCostos = 0;	
			$vowels = array(",");	
			$qrCostos = '';	
			
			
			  /* $sqlPro = "SELECT   proyecto.nombre AS nombre, 
									proyecto.descripcion AS descripcion, 
									proyecto.fecha_final_real AS fechaFinalReal,
									SUM(ingresos.valor) AS sumIngresos,
									SUM(costos.valor) AS sumCostos
						   FROM proyectos AS proyecto
						   LEFT JOIN proyecto_ingresos AS ingresos ON ingresos.id_proyecto = proyecto.id
						   LEFT JOIN proyecto_costos AS costos ON costos.id_proyecto = proyecto.id
						   WHERE 1";*/
						   
						  $sqlPro = " SELECT id AS id, proyecto.nombre AS nombre, proyecto.descripcion AS descripcion, proyecto.fecha_final_real AS fechaFinalReal
FROM proyectos AS proyecto
WHERE 1 
LIMIT 0 , 30";
						   
			    $qrProyecto = mysql_query($sqlPro);  
				
				$valor = 0;				
				
				while($row = mysql_fetch_assoc($qrProyecto)):
				
				  if($row['fechaFinalReal'] != NULL):
				
					$dato = explode(' ',$row['fechaFinalReal']);	
					$date = explode('-',$dato[0]);
					$dia = $date[2];	
					$mes = $date[1];
					$year = $date[0];		
					
					
					$sqlU = 'SELECT SUM(valor) AS sumIngresos FROM proyecto_ingresos WHERE id_proyecto = '.$row['id'];
					$qrUtili = mysql_query($sqlU); 
					$rowsUtili = mysql_fetch_array($qrUtili);
							
					$totalIngresos = (int)str_replace($vowels, "", $rowsUtili['sumIngresos']);
					
					
					$sqlC = 'SELECT SUM(valor) AS sumCostos FROM proyecto_costos WHERE id_proyecto = '.$row['id'];
					$qrCostos = mysql_query($sqlC); 
					$rowsCostos = mysql_fetch_array($qrCostos);
					
					$totalCostos  = (int)str_replace($vowels, "", $rowsCostos['sumCostos']);
					
					$valor += $totalIngresos - $totalCostos;
					
					if($i < mysql_num_rows($qrProyecto)):				
				    	$script .= "{date: new Date({$year}, {$mes}, {$dia}),value: {$valor}},";
						$i++;
					else:
						$script .= "{date: new Date({$year}, {$mes}, {$dia}),value: {$valor}}";
					endif;
					
				  endif;			
				
				endwhile;
		
				/*$sql = "SELECT *
						FROM proyecto_ingresos
						WHERE 1";
						
				$qrCostos = mysql_query($sql); 
				//$rowsCostos = mysql_fetch_assoc($qrCostos);
				
				//print_r($rowsCostos);
				
				$vowels = array(",");
				
				while($row = mysql_fetch_assoc($qrCostos)):					
					
					$dato = explode(' ',$row['fecha_ingreso']);	
					$date =  explode('-',$dato[0]);
					$dia = $date[2];	
					$mes = $date[1];
					$year = $date[0];		
							
					$valor = (int)str_replace($vowels, "", $row['valor']);
					
					if($i < mysql_num_rows($qrCostos)):				
				    	$script .= "{date: new Date({$year}, {$mes}, {$dia}),value: {$valor}},";
						$i++;
					else:
						$script .= "{date: new Date({$year}, {$mes}, {$dia}),value: {$valor}}";
					endif;
				
				
				endwhile;*/
				
		
		?>
        
        <script src="../js/amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var lineChartData = [<?=$script?>];

            AmCharts.ready(function () {
                var chart = new AmCharts.AmSerialChart();
                chart.dataProvider = lineChartData;
                chart.pathToImages = "../images/";
                chart.categoryField = "date";

                // sometimes we need to set margins manually
                // autoMargins should be set to false in order chart to use custom margin values
                chart.autoMargins = false;
                chart.marginRight = 0;
                chart.marginLeft = 0;
                chart.marginBottom = 0;
                chart.marginTop = 0;

                // AXES
                // category                
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.inside = true;
                categoryAxis.gridAlpha = 0;
                categoryAxis.tickLength = 0;
                categoryAxis.axisAlpha = 0;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 4;
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.type = "line";
                graph.valueField = "value";
                graph.lineColor = "#D8E63C";
                graph.customBullet = "../images/star.gif"; // bullet for all data points
                graph.bulletSize = 14; // bullet image should be a rectangle (width = height)
                graph.customBulletField = "customBullet"; // this will make the graph to display custom bullet (red star)
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chart.addChartCursor(chartCursor);

                // WRITE
                chart.write("chartdiv");
            });
        </script>
		<div style="position: relative; padding-left: 10px;">
			<div id="chartdiv" style="position:absolute;width:600px;height:400px;top:30px;"></div>
			<div style="position:absolute;width:300px;height:50px;background-color:white;">
				<h2>Utilidades A&ntilde;o 2013</h2>
			</div>
        </div>
<?php require_once "../../tpl_bottom.php"; ?>