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
	
	if ($proyecto != '*' && $proyecto != ''):
	
		$sql = "SELECT *, proyect.nombre AS nombre, proyect.descripcion AS description,  
				SUM( costo.valor ) AS SumaTotal
				FROM proyectos AS proyect
				LEFT JOIN cotizacion AS coti ON coti.id = proyect.id_cotizacion
				LEFT JOIN proyecto_costos AS costo ON proyect.id = costo.id_proyecto
				WHERE proyect.id = {$proyecto} ";
				
		$qrCostos = mysql_query($sql); 
		$rowsCostos = mysql_fetch_array($qrCostos);
		
		$vowels = array(",");	
		
	    $nombreProyecto = $rowsCostos['nombre'];
	    $costoReal = (int)$rowsCostos['SumaTotal'];
		$descriptionProyect = $rowsCostos['description'];
		
	    $costoPresu =       + (int)str_replace($vowels, "", $rowsCostos['transportes'])
							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos'])
							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos'])
							+ (int)str_replace($vowels, "", $rowsCostos['ica'] )
							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero']) 
							+ (int)str_replace($vowels, "", $rowsCostos['acarreos'] )							
							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos'] )
							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones'])
							+ (int)str_replace($vowels, "", $rowsCostos['profesionales'])
							+ (int)str_replace($vowels, "", $rowsCostos['seguros'])
							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia'])
							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica'])
							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos'])
							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios'])
							+ (int)str_replace($vowels, "", $rowsCostos['combustible'])
							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo'])
							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje'])
							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria'])
							+ (int)str_replace($vowels, "", $rowsCostos['papeleria'])
							+ (int)str_replace($vowels, "", $rowsCostos['internet'])
							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses'])
							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos'])
							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor'])
							+ (int)str_replace($vowels, "", $rowsCostos['peajes'])
							+ (int)str_replace($vowels, "", $rowsCostos['polizas'])
							+ (int)str_replace($vowels, "", $rowsCostos['materiales'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOD'])	
			 				+ (int)str_replace($vowels, "", $rowsCostos['MOI'])	
							+ (int)str_replace($vowels, "", $rowsCostos['TOES']);
		
	else:
	
		if($proyecto == '*'):
			
			$vowels = array(",");	
			$costoReal = 0;
			$costoPresu = 0;
			$nombreProyecto = 'Todos los Proyectos';
			$descriptionProyect = 'todo los proyectos presentados';
		
			$sql = "SELECT *, proyect.nombre AS nombre, proyect.descripcion AS description,  
					SUM( costo.valor ) AS SumaTotal
					FROM proyectos AS proyect
					LEFT JOIN cotizacion AS coti ON coti.id = proyect.id_cotizacion
					LEFT JOIN proyecto_costos AS costo ON proyect.id = costo.id_proyecto
					WHERE 1 ";
					
			$qrCostos = mysql_query($sql); 
			
			while($rowsCostos = mysql_fetch_assoc($qrCostos)):	
				 
				 $costoPre = 0;
				 $costoReal += (int)$rowsCostos['SumaTotal'];				 
				 $costoPre = + (int)str_replace($vowels, "", $rowsCostos['transportes'])
								+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos'])
								+ (int)str_replace($vowels, "", $rowsCostos['imprevistos'])
								+ (int)str_replace($vowels, "", $rowsCostos['ica'] )
								+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero']) 
								+ (int)str_replace($vowels, "", $rowsCostos['acarreos'] )							
								+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos'] )
								+ (int)str_replace($vowels, "", $rowsCostos['reparaciones'])
								+ (int)str_replace($vowels, "", $rowsCostos['profesionales'])
								+ (int)str_replace($vowels, "", $rowsCostos['seguros'])
								+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular'])
								+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia'])
								+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica'])
								+ (int)str_replace($vowels, "", $rowsCostos['envios_correos'])
								+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios'])
								+ (int)str_replace($vowels, "", $rowsCostos['combustible'])
								+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo'])
								+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje'])
								+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos'])
								+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria'])
								+ (int)str_replace($vowels, "", $rowsCostos['papeleria'])
								+ (int)str_replace($vowels, "", $rowsCostos['internet'])
								+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses'])
								+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos'])
								+ (int)str_replace($vowels, "", $rowsCostos['caja_menor'])
								+ (int)str_replace($vowels, "", $rowsCostos['peajes'])
								+ (int)str_replace($vowels, "", $rowsCostos['polizas'])
								+ (int)str_replace($vowels, "", $rowsCostos['materiales'])	
								+ (int)str_replace($vowels, "", $rowsCostos['MOD'])	
			 					+ (int)str_replace($vowels, "", $rowsCostos['MOI'])	
								+ (int)str_replace($vowels, "", $rowsCostos['TOES']);;
								
					$costoPresu += $costoPre;	
			
			endwhile;
		
		else:
			$nombreProyecto = '';
			$descriptionProyect = '';	
			
		endif;
		
	endif;
	

	/*if ($proyecto != '*') {
		$qrCostos = mysql_query("SELECT * FROM cotizacion WHERE id = '" . $proyecto . "'"); 
		$rowsCostos = mysql_fetch_array($qrCostos);
		
		$sum = 0;
		for ($i=3;$i<=29;$i++) {
			$sum += (float)$rowsCostos[$i];
		}
		
		$qrCostos = mysql_query("SELECT pc.* FROM proyectos AS p, proyecto_costos AS pc WHERE p.id_cotizacion = '" . $proyecto . "' AND p.id = pc.id_proyecto"); 
		$rowsCostos = mysql_fetch_array($qrCostos);
		$sum2 = 0;
		if (mysql_num_rows($qrCostos) > 0) {
			foreach ($rowsCostos as $data) {
		
				$sum2 += (float)$data['valor'];
			}
		}
	}else{
		$qrCostos1 = mysql_query("SELECT * FROM cotizacion WHERE estado = 'otorgado'"); 
		while ($rowsCostos1 = mysql_fetch_array($qrCostos1)) {
		
			$sum = 0;
			for ($i=3;$i<=29;$i++) {
				$sum += (float)$rowsCostos1[$i];
			}
			
			$qrCostos = mysql_query("SELECT pc.* FROM proyectos AS p, proyecto_costos AS pc WHERE p.id_cotizacion = '" . $rowsCostos1['id'] . "' AND p.id = pc.id_proyecto"); 
			$rowsCostos = mysql_fetch_array($qrCostos);
			$sum2 = 0;
			if (mysql_num_rows($qrCostos) > 0) {
				foreach ($rowsCostos as $data) {
			
					$sum2 += (float)$data['valor'];
				}
			}	
		}
	}
	/*foreach ($rowsCostos as $data) {
		$sum += $data;
	}*/
	?>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script src="../js/amcharts.js" type="text/javascript"></script> 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript">
			
			//$('#chartdiv text').hide();
			
            var chart;

            var chartData = [{
                country: "Costos Presupuestados",
                visits: <?=$costoPresu?>,
                color: "#FF0F00"
            }, chartData = {
                country: "Costos Reales",
                visits: <?= $costoReal; ?>,
                color: "#FF6600"
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "country";
                // the following two lines makes chart 3D
                chart.depth3D = 20;
				chart.angle = 30;
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 45; // this line makes category values to be rotated
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = "#FAFAFA";
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 5;
                valueAxis.title = "Costos"
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.colorField = "color";
                graph.balloonText = "[[category]]: [[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // WRITE
                chart.write("chartdiv");
				
				$("tspan:contains('chart by amcharts.com')").remove();
		
            });
        </script>
        <form id="formPry" name="formPry" action="reporte1.php?tab=<?=$_GET['tab']?>" method="post">
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