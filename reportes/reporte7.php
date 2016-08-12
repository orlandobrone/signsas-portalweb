<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <script src="js/amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var lineChartData = [{
                date: new Date(2013, 1, 2),
                value: 50000
            }, {
                date: new Date(2013, 1, 3),
                value: 150000
            }, {
                date: new Date(2013, 2, 4),
                value: 130000
            }, {
                date: new Date(2013, 2, 5),
                value: 170000
            }, {
                date: new Date(2013, 3, 6),
                value: 150000
            }, {
                date: new Date(2013, 3, 9),
                value: 190000
            }, {
                date: new Date(2013, 3, 10),
                value: 210000
            }, {
                date: new Date(2013, 4, 11),
                value: 200000
            }, {
                date: new Date(2013, 5, 12),
                value: 200000
            }, {
                date: new Date(2013, 5, 13),
                value: 190000
            }, {
                date: new Date(2013, 5, 16),
                value: 250000
            }, {
                date: new Date(2013, 5, 17),
                value: 240000
            }, {
                date: new Date(2013, 6, 18),
                value: 260000
            }, {
                date: new Date(2013, 6, 19),
                value: 270000
            }, {
                date: new Date(2013, 7, 20),
                value: 250000
            }, {
                date: new Date(2013, 8, 23),
                value: 290000
            }, {
                date: new Date(2013, 8, 24),
                value: 280000
            }, {
                date: new Date(2013, 9, 25),
                value: 300000
            }, {
                date: new Date(2013, 9, 26),
                value: 720000,
                customBullet: "images/redstar.png"   // note, one line has a custom bullet defined
            }, 
             {
                date: new Date(2013, 10, 27),
                value: 430000
            }, {
                date: new Date(2013, 10, 30),
                value: 310000
            }, {
                date: new Date(2013, 11, 1),
                value: 300000
            }, {
                date: new Date(2013, 11, 2),
                value: 290000
            }, {
                date: new Date(2013, 11, 3),
                value: 270000
            }, {
                date: new Date(2013, 11, 4),
                value: 260000
            }];

            AmCharts.ready(function () {
                var chart = new AmCharts.AmSerialChart();
                chart.dataProvider = lineChartData;
                chart.pathToImages = "images/";
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
                graph.customBullet = "images/star.gif"; // bullet for all data points
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
    </head>
    
    <body>
		<div style="position: relative;">
			<div id="chartdiv" style="position:absolute;width:600px;height:400px;top:30px;"></div>
			<div style="position:absolute;width:300px;height:50px;background-color:white;">
				<h2>Utilidades Año 2013</h2>
			</div>
		</body>

</html>