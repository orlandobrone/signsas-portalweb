<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <script src="js/amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var chart;
            var legend;

            var chartData = [{
                country: "Tiempo Ejecutado",
                litres: 34
            },{
                country: "Tiempo Restante",
                litres: 50
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
    </head>
    
    <body>
		<div style="position: relative;">
			<div id="chartdiv" style="position:absolute;width:600px;height:400px;top:30px;"></div>
			<div style="position:absolute;width:600px;height:50px;background-color:white;">
				<h2>Proyecto Aguas Capital</h2>
			</div>
		</body>

</html>