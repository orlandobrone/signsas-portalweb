<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <script src="js/amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var chart;

            var chartData = [{
                year: "Transportes",
                income: 500000,
                expenses: 400000
            }, {
                year: "Alquiler Vehiculos",
                income: 1500000,
                expenses: 1400000
            }, {
                year: "Imprevistos",
                income: 50000,
                expenses: 4000
            }, {
                year: "ICA",
                income: 500000,
                expenses: 400000
            }, {
                year: "Coste Financiero",
                income: 500000,
                expenses: 400000
            }, {
                year: "Acarreos",
                income: 500000,
                expenses: 400000
            }, {
                year: "Arrendamientos",
                income: 500000,
                expenses: 400000
            }, {
                year: "Reparaciones",
                income: 500000,
                expenses: 400000
            }, {
                year: "Servicios Profesionales",
                income: 500000,
                expenses: 400000
            }, {
                year: "Seguros",
                income: 500000,
                expenses: 400000
            }, {
                year: "Comunicacion Celular",
                income: 500000,
                expenses: 400000
            }, {
                year: "Aseo y Vigilancia",
                income: 500000,
                expenses: 400000
            }, {
                year: "Asistencia Tecnica",
                income: 500000,
                expenses: 400000
            }, {
                year: "Envio Correspondencia",
                income: 500000,
                expenses: 400000
            }, {
                year: "Otros Servicios",
                income: 500000,
                expenses: 400000
            }, {
                year: "Combustible",
                income: 500000,
                expenses: 400000
            }, {
                year: "Lavado Vehiculo",
                income: 500000,
                expenses: 400000
            }, {
                year: "Gatos de Viaje",
                income: 500000,
                expenses: 400000
            }, {
                year: "Tiquetes Aereos",
                income: 500000,
                expenses: 400000
            }, {
                year: "Servicio de Cafeteria",
                income: 500000,
                expenses: 400000
            }, {
                year: "Papeleria",
                income: 500000,
                expenses: 400000
            }, {
                year: "Internet",
                income: 500000,
                expenses: 400000
            }, {
                year: "Taxis-Buses",
                income: 500000,
                expenses: 400000
            }, {
                year: "Parqueaderos",
                income: 500000,
                expenses: 400000
            }, {
                year: "Caja Menor",
                income: 500000,
                expenses: 400000
            }, {
                year: "Peajes",
                income: 500000,
                expenses: 400000
            }, {
                year: "Polizas",
                income: 500000,
                expenses: 400000
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
            });
        </script>
    </head>
    
    <body>
		<div style="position: relative;">
			<div id="chartdiv" style="position:absolute;width:600px;height:2600px;top:36px;"></div>
			<div style="position:absolute;width:600px;height:50px;background-color:white;">
				<h2>Proyecto Aguas Capital</h2>
			</div>
		</body>

</html>