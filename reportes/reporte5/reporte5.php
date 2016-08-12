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
		
		$transportes2  = 0;
		$alquileres_vehiculos2 = 0;
		$imprevistos2 = 0;
		$ica2 = 0;
		$coste_financiero2 = 0;
		$acarreos2 = 0;
		$arrendamientos2 = 0;
		$reparaciones2 = 0;
		$profesionales2 = 0;
		$seguros2 = 0;
		$comunicaciones_celular2 = 0;
		$aseo_vigilancia2 = 0;
		$asistencia_tecnica2 = 0;
		$envios_correos2 = 0;
		$otros_servicios2 = 0;
		$combustible2 = 0;
		$lavado_vehiculo2 = 0;
		$gastos_viaje2 = 0;
		$tiquetes_aereos2 = 0;
		$aseo_cafeteria2 = 0;
		$papeleria2 = 0;
		$internet2 = 0;
		$taxis_buses2 = 0;
		$parqueaderos2 = 0;
		$caja_menor2 = 0;
		$peajes2 = 0;
		$polizas2 = 0;
		//new
		$materiales  = 0;
		$materiales2 = 0;
		$MOD = 0;
		$MOD2 = 0;
		$MOI2 = 0;
		$TOES2 = 0;			
		$MOI = 0;	
		
		$nombreProyecto = '';			
		$descriptionProyect = '';
		
		$sqlConcepto = '';
		
		$imprevisto2s = ''; 
		
				
	
		if ($proyecto != '*' && $proyecto != ''):	
		
			$sql = "SELECT *, proyecto.id AS proyectoID
					FROM cotizacion AS cotizacion
					LEFT JOIN proyectos AS proyecto ON cotizacion.id =  proyecto.id_cotizacion 
					WHERE cotizacion.id = {$proyecto} ";
					
			$qrCostos = mysql_query($sql); 
			$rowsCostos = mysql_fetch_array($qrCostos);
					
			$idProyecto =  (int)$rowsCostos['proyectoID'];		
					
			$sqlConcepto = "SELECT concepto, valor FROM proyecto_costos WHERE id_proyecto = {$idProyecto} ";
			
			$nombreProyecto = $rowsCostos['nombre'];			
			$descriptionProyect = $rowsCostos['descripcion'];							
		
		else:	
		
			if($proyecto == '*' ):		
			
				$sql = "SELECT *, proyecto.id AS proyectoID
						FROM cotizacion AS cotizacion
						LEFT JOIN proyectos AS proyecto ON cotizacion.id =  proyecto.id_cotizacion 
						WHERE 1 ";
				
				$qrCostos = mysql_query($sql); 
				$rowsCostos = mysql_fetch_array($qrCostos);					
						
				$sqlConcepto = "SELECT concepto, valor FROM proyecto_costos WHERE 1 ";
				
				$nombreProyecto = 'Todos los proyectos';			
				$descriptionProyect ='';
				
			endif;							
		
		endif;	
			
			if($sqlConcepto != ''):
			
			$vowels = array(",");					
			
			$qrConcepto = mysql_query($sqlConcepto); 
			while($row = mysql_fetch_assoc($qrConcepto)):	
				
					switch($row['concepto']):
						case 1;
						    $transportes2  +=  (int)str_replace($vowels, "", $row['valor'] );							
						break;
						case 2;
							$alquileres_vehiculos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 3;
							$imprevisto2s +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 4;
							$ica2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 5;
							$coste_financiero2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 6;
							$acarreos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 7;
							$arrendamientos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 8;
							$reparaciones2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 9;
							$profesionales2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 10;
							$seguros2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 11;
							$comunicaciones_celular2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 12;
							$aseo_vigilancia2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 13;
							$asistencia_tecnica2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 14;
							$envios_correos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 15;
							$otros_servicios2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 16;
							$combustible2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 17;
							$lavado_vehiculo2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 18;
							$gastos_viaje2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 19;
							$tiquetes_aereos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 20;
							$aseo_cafeteria2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 21;
							$papeleria2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 22;
							$internet2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 23;
							$taxis_buses2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 24;
							$parqueaderos2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 25;
							$caja_menor2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 26;
							$peajes2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;						
						case 27;
							$polizas2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 28;
							$materiales2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 29;
							$MOD2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;
						case 30;
							$MOI2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;						
						case 31;
							$TOES2 +=  (int)str_replace($vowels, "", $row['valor'] );								
						break;						
						
					endswitch;
			
			endwhile;	
			
			
			$materiales =  (int)str_replace($vowels, "", $rowsCostos['materiales']);	
			$MOD =  (int)str_replace($vowels, "", $rowsCostos['MOD']);	
			$MOI =  (int)str_replace($vowels, "", $rowsCostos['MOI']);	
			$TOES =  (int)str_replace($vowels, "", $rowsCostos['TOES']);	
			
			$transportes =  (int)str_replace($vowels, "", $rowsCostos['transportes']);		
			$alquileres_vehiculos =(int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos']);
			$imprevistos =(int)str_replace($vowels, "", $rowsCostos['imprevistos']);
			$ica =(int)str_replace($vowels, "", $rowsCostos['ica']);
			$coste_financiero =(int)str_replace($vowels, "", $rowsCostos['coste_financiero']); 
			$acarreos =(int)str_replace($vowels, "", $rowsCostos['acarreos']);							
			$arrendamientos =(int)str_replace($vowels, "", $rowsCostos['arrendamientos']);
			$reparaciones =(int)str_replace($vowels, "", $rowsCostos['reparaciones']);
			$profesionales =(int)str_replace($vowels, "", $rowsCostos['profesionales']);
			$seguros =(int)str_replace($vowels, "", $rowsCostos['seguros']);
			$comunicaciones_celular =(int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular']);
			$aseo_vigilancia =(int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia']);
			$asistencia_tecnica =(int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica']);
			$envios_correos =(int)str_replace($vowels, "", $rowsCostos['envios_correos']);
			$otros_servicios =(int)str_replace($vowels, "", $rowsCostos['otros_servicios']);
			$combustible =(int)str_replace($vowels, "", $rowsCostos['combustible']);
			$lavado_vehiculo =(int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo']);
			$gastos_viaje =(int)str_replace($vowels, "", $rowsCostos['gastos_viaje']);
			$tiquetes_aereos =(int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos']);
			$aseo_cafeteria =(int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria']);
			$papeleria =(int)str_replace($vowels, "", $rowsCostos['papeleria']);
			$internet =(int)str_replace($vowels, "", $rowsCostos['internet']);
			$taxis_buses =(int)str_replace($vowels, "", $rowsCostos['taxis_buses']);
			$parqueaderos =(int)str_replace($vowels, "", $rowsCostos['parqueaderos']);
			$caja_menor =(int)str_replace($vowels, "", $rowsCostos['caja_menor']);
			$peajes =(int)str_replace($vowels, "", $rowsCostos['peajes']);
			$polizas =(int)str_replace($vowels, "", $rowsCostos['polizas']);
			
			endif;
			
			
			/*
			$transportes2 =  (int)str_replace($vowels, "", $rowsCostos['transportes2']);
			$alquileres_vehiculos2 =(int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2']);
			$imprevistos2 =(int)str_replace($vowels, "", $rowsCostos['imprevistos2']);
			$ica2 =(int)str_replace($vowels, "", $rowsCostos['ica2']);
			$coste_financiero2 =(int)str_replace($vowels, "", $rowsCostos['coste_financiero2']); 
			$acarreos2 =(int)str_replace($vowels, "", $rowsCostos['acarreos2']);							
			$arrendamientos2 =(int)str_replace($vowels, "", $rowsCostos['arrendamientos2']);
			$reparaciones2 =(int)str_replace($vowels, "", $rowsCostos['reparaciones2']);
			$profesionales2 =(int)str_replace($vowels, "", $rowsCostos['profesionales2']);
			$seguros2 =(int)str_replace($vowels, "", $rowsCostos['seguros2']);
			$comunicaciones_celular2 =(int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2']);
			$aseo_vigilancia2 =(int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2']);
			$asistencia_tecnica2 =(int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2']);
			$envios_correos2 =(int)str_replace($vowels, "", $rowsCostos['envios_correos2']);
			$otros_servicios2 =(int)str_replace($vowels, "", $rowsCostos['otros_servicios2']);
			$combustible2 =(int)str_replace($vowels, "", $rowsCostos['combustible2']);
			$lavado_vehiculo2 =(int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2']);
			$gastos_viaje2 =(int)str_replace($vowels, "", $rowsCostos['gastos_viaje2']);
			$tiquetes_aereos2 =(int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2']);
			$aseo_cafeteria2 =(int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2']);
			$papeleria2 =(int)str_replace($vowels, "", $rowsCostos['papeleria2']);
			$internet2 =(int)str_replace($vowels, "", $rowsCostos['internet2']);
			$taxis_buses2 =(int)str_replace($vowels, "", $rowsCostos['taxis_buses2']);
			$parqueaderos2 =(int)str_replace($vowels, "", $rowsCostos['parqueaderos2']);
			$caja_menor2 =(int)str_replace($vowels, "", $rowsCostos['caja_menor2']);
			$peajes2 =(int)str_replace($vowels, "", $rowsCostos['peajes2']);
			$polizas2 =(int)str_replace($vowels, "", $rowsCostos['polizas2']);*/
		
		
		
			
		?>
        
        <link rel="stylesheet" href="../css/style.css" type="text/css">
        <script src="../js/amcharts.js" type="text/javascript"></script> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>         
        <script type="text/javascript">
            var chart;

            var chartData = [{
                year: "Materiales",
                income: <?=$materiales?>,
                expenses: <?=$materiales2?>
            },{
                year: "MOD",
                income: <?=$MOD?>,
                expenses: <?=$MOD2?>
            },{
                year: "MOI",
                income: <?=$MOI?>,
                expenses: <?=$MOI2?>
            },{
                year: "TOES",
                income: <?=$TOES?>,
                expenses: <?=$TOES2?>
            },{
                year: "Transportes",
                income: <?=$transportes?>,
                expenses: <?=$transportes2?>
            }, {
                year: "Alquiler Vehiculos",
                income: <?=$alquileres_vehiculos?>,
                expenses: <?=$alquileres_vehiculos2?>
            }, {
                year: "Imprevistos",
                income: <?=$imprevistos?>,
                expenses: <?=$imprevistos2?>
            }, {
                year: "ICA",
                income: <?=$ica?>,
                expenses: <?=$ica2?>
            }, {
                year: "Coste Financiero",
                income: <?=$coste_financiero?>,
                expenses: <?=$coste_financiero2?>
            }, {
                year: "Acarreos",
                income: <?=$acarreos?>,
                expenses: <?=$acarreos2?>
            }, {
                year: "Arrendamientos",
                income: <?=$arrendamientos?>,
                expenses: <?=$arrendamientos2?>
            }, {
                year: "Reparaciones",
                income: <?=$reparaciones?>,
                expenses: <?=$reparaciones2?>
            }, {
                year: "Servicios Profesionales",
                income: <?=$profesionales?>,
                expenses: <?=$profesionales2?>
            }, {
                year: "Seguros",
                income: <?=$seguros?>,
                expenses: <?=$seguros2?>
            }, {
                year: "Comunicacion Celular",
                income: <?=$comunicaciones_celular?>,
                expenses: <?=$comunicaciones_celular2?>
            }, {
                year: "Aseo y Vigilancia",
                income: <?=$aseo_vigilancia?>,
                expenses: <?=$aseo_vigilancia2?>
            }, {
                year: "Asistencia Tecnica",
                income: <?=$asistencia_tecnica?>,
                expenses: <?=$asistencia_tecnica2?>
            }, {
                year: "Envio Correspondencia",
                income: <?=$envios_correos?>,
                expenses: <?=$envios_correos2?>
            }, {
                year: "Otros Servicios",
                income: <?=$otros_servicios?>,
                expenses: <?=$otros_servicios2?>
            }, {
                year: "Combustible",
                income: <?=$combustible?>,
                expenses: <?=$combustible2?>
            }, {
                year: "Lavado Vehiculo",
                income: <?=$lavado_vehiculo?>,
                expenses: <?=$lavado_vehiculo2?>
            }, {
                year: "Gatos de Viaje",
                income: <?=$gastos_viaje?>,
                expenses: <?=$gastos_viaje2?>
            }, {
                year: "Tiquetes Aereos",
                income: <?=$tiquetes_aereos?>,
                expenses: <?=$tiquetes_aereos2?>
            }, {
                year: "Servicio de Cafeteria",
                income: <?=$aseo_cafeteria?>,
                expenses: <?=$aseo_cafeteria2?>
            }, {
                year: "Papeleria",
                income: <?=$papeleria?>,
                expenses: <?=$papeleria2?>
            }, {
                year: "Internet",
                income: <?=$internet?>,
                expenses: <?=$internet2?>
            }, {
                year: "Taxis-Buses",
                income: <?=$taxis_buses?>,
                expenses: <?=$taxis_buses2?>
            }, {
                year: "Parqueaderos",
                income: <?=$parqueaderos?>,
                expenses: <?=$parqueaderos2?>
            }, {
                year: "Caja Menor",
                income: <?=$caja_menor?>,
                expenses: <?=$caja_menor2?>
            }, {
                year: "Peajes",
                income: <?=$peajes?>,
                expenses: <?=$peajes2?>
            }, {
                year: "Polizas",
                income: <?=$polizas?>,
                expenses: <?=$polizas2?>
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart          
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "Costos Presupuestados";
                graph1.valueField = "income";
                graph1.balloonText = "Costo Presupuestado:[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#ADD981";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);

                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "Costos Reales";
                graph2.valueField = "expenses";
                graph2.balloonText = "Costo Real:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "#81acd9";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                // WRITE
                chart.write("chartdiv");
				$("tspan:contains('chart by amcharts.com')").remove();
            });
        </script>
        
        <form id="formPry" name="formPry" action="reporte5.php?tab=<?=$_GET['tab']?>" method="post">
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
					<option value="<?=$rs_pry['id_cotizacion']?>" <? if ($proyecto == $rs_pry['id_cotizacion']){ echo 'selected="selected"'; $nombrePry = $rs_pry['nombre']; } ?>><?=$rs_pry['nombre']?></option>
				<? } ?>
            </select>
        </form>
        
        <div style="position:relative;width:600px;height:50px;background-color:white;">
				<h2><?=$nombreProyecto?></h2>
                <p style="margin-bottom:20px;"><?=$descriptionProyect ?></p>
	    </div>
   
		<div style="position: relative; overflow-y:scroll; min-height:405px; margin-top:20px;">
			<div id="chartdiv" style="position:absolute;width:600px;height:2600px;"></div>
			
        </div>
        
        
        <?php require_once "../../tpl_bottom.php"; ?>
