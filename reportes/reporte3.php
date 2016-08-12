<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <script src="js/amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var chart;

            var chartData = [{
                year: "Ingresos",
                costos: 3000000,
                utilidad: 1000000
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
            });
        </script>
    </head>
    
    <body>
		<div style="position: relative;">
			<div id="chartdiv" style="position:absolute;width:600px;height:400px;top:30px;"></div>
			<div style="position:absolute;width:600px;height:50px;background-color:white;">
				<h2>Proyecto Aguas Capital</h2>
			</div>
		</body>

</html>