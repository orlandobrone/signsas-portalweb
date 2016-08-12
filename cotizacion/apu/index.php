<?php  

	include "../../restrinccion.php";  

	include "../../conexion.php";

	$resultado = mysql_query("SELECT * FROM centros_costos WHERE id = 1 OR id = 2 OR id = 3 OR id = 5 OR id = 6  OR id = 4") or die(mysql_error());

	$total = mysql_num_rows($resultado);

	

	if($total > 0):

		while($row = mysql_fetch_assoc($resultado)):

			$list .= "'".$row['id'].'.'.utf8_encode($row['nombre'])."',";

		endwhile;

	endif;	

	



?>

    <?php require_once "../../config.php"; 

		 

	define('URL_SECCION', URL_ANTICIPOS); 

	define('SECCION', ANTICIPO); ?>   

	<?php require_once "../../tpl_top.php"; 

		$query = "SELECT COUNT(*) AS Total FROM apu" ;

		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

		$rows = mysql_fetch_assoc($result);

	?>

    

    <script src="/js/jquery.printarea.js" type="text/javascript"></script> 

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
	<link href="/excel/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="/excel/css/excel.css">

    <link rel="stylesheet" href="/js/chosen/chosen.css">

	<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
    
	<style>
		.jqx-widget-content{ z-index:300 !important; }
	</style>

    <script type="text/javascript">

    $(document).ready(function () {   

			var url = "/ajax/ajax_list_hitos.php";
			// prepare the data
			var source =
			{

				datatype: "json",

				datafields: [

					{ name: 'id' },

					{ name: 'orden' }

				],

				url: url,

				async: false

			};

			var dataAdapter = new $.jqx.dataAdapter(source);

            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'descripcion', type: 'string'},
					 { name: 'acciones', type: 'string'}
                ],
				cache: false,
				async: false,
			    url: 'ajax_data.php',
				root: 'Rows',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()
				{// update the grid and send a request to the server.
					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'sort');

				},

				root: 'Rows',

				beforeprocessing: function(data)

				{		

					if (data != null)

					{

						source.totalrecords = data[0].TotalRows;					

					}

				}

				};		

				var dataadapter = new $.jqx.dataAdapter(source, {
					loadError: function(xhr, status, error)
					{
						alert(error);
					}
				}

			);

            var ordersSource =
            {
				datatype: "json",
                datafields: [
					  { name: 'id', type: 'number'},
					  { name: 'tipo_costos', type: 'number'},
					  { name: 'valor_a_la_fecha', type: 'string'},
					  { name: 'fecha_ingreso', type: 'string'},
					  { name: 'costo_id', type: 'string'}			
                ],
				cache: false, 
				async: false,			    
				url: 'ajax_list_items.php',
				root: 'Rows',
                sortcolumn: 'id',
                sortdirection: 'desc'
            };

            var ordersDataAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

			

            orders = ordersDataAdapter.records;

            var nestedGrids = new Array();

            // create nested grid.

            var initrowdetails = function (index, parentElement, gridElement, record) {
				

                var id = record.uid.toString();
				var id_apu = record['id'];			
				
                var grid = $($(parentElement).children()[0]);               

			    nestedGrids[index] = grid;				

                var ordersSource =
				{

					datatype: "json",
					datafields: [						
						 { name: 'id', type: 'number'},
						 { name: 'tipo_costos', type: 'string'},
						 { name: 'valor_a_la_fecha', type: 'string'},
						 { name: 'fecha_ingreso', type: 'date'},
						 { name: 'costo_id', type: 'string'}				 
					],
					cache: false,
					url: 'ajax_list_items.php?id_apu='+id_apu,
					root: 'Rows',
					sortcolumn: 'id',
					sortdirection: 'desc'
				};

                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, width: '75%', height: 200,

                        columns: [

						 // { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

						  { text: 'ID Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 80,  columntype: 'textbox', editable: false },

						  { text: 'Tipo Costo', datafield: 'tipo_costos', columntype: 'dropdownlist', filtertype: 'textbox', editable: false },

						  { text: 'Valor a la Fecha', datafield: 'valor_a_la_fecha', filtertype: 'none', width: 130, cellsalign: 'right' },

						  { text: 'Fecha Ingreso', datafield: 'fecha_ingreso', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

						  { text: 'Costo ID', datafield: 'costo_id', filtertype: 'none', width: 130, cellsalign: 'right' }

						]

                    });

                }

            }

			

           // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(

            {

                width: '100%',

				height: 500,

                source: dataadapter,

                showfilterrow: true,

                pageable: true,

                filterable: true,

                theme: theme,

				sortable: true,

                columnsresize: true,

				virtualmode: true,	

				pagesize: 20,

				pagesizeoptions: ['<?=$rows['Total']?>', 10, 20, 50, 100, 150, 250, 500],

				

				rowdetails: true,

				initrowdetails: initrowdetails,

                rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true },

				

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                  

                columns: [

				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox' },

                  { text: 'Acciones', datafield: 'acciones', filtertype: 'none', width:100, pinned: true, cellsalign: 'center' },

				  { text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 }


			    ]

            });

			$(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

					$('#jqxgrid').jqxGrid('hidecolumn', 'acciones'); 

					$('#jqxgrid').jqxGrid('showcolumn', 's.valor_giro');  

				setTimeout(function(){    

                	$("#jqxgrid").jqxGrid('exportdata', 'xls', 'APUS_<?=date('m-d-Y')?>');   

				},1000);

				setTimeout(function(){

					$('#jqxgrid').jqxGrid('showcolumn', 'acciones');

					/*$('#jqxgrid').jqxGrid('hidecolumn', 'prioridad_text');  

					$('#jqxgrid').jqxGrid('hidecolumn', 's.valor_giro'); */  

				},3000);

				

            });

			

			// builds and applies the filter.

            var applyFilter = function (datafield) {

                //$("#jqxgrid").jqxGrid('clearfilters');

               

				 var filtergroup = new $.jqx.filter();

				 var filter_or_operator = 1;

				 var filtervalue = datafield;

				 var filtercondition = 'equal';

				 var filter1 = filtergroup.createfilter('numericfilter', filtervalue, filtercondition);

				

				 filtergroup.addfilter(filter_or_operator, filter1);

				 // add the filters.

				 $("#jqxgrid").jqxGrid('addfilter', 's.total_anticipo', filtergroup);

				 // apply the filters.

				 $("#jqxgrid").jqxGrid('applyfilters');

            }

			

			

			/*$('#jqxWidget').on('change', function (event) { 

                var dataField = $("#jqxWidget").jqxDropDownList('getSelectedItem').value;

                applyFilter(dataField);

            });*/

			

			$('#excelExport2').click(function(){

				window.open("/anticipos/anticipo/export_excel.php");

			});

			

        });

    </script>

    	

        

    

    	<div id="cuerpo">

            <h1>APU</h1>          

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

                 <input value="Agregar APU" type="button" id="btn_add_anticipo" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table"/>

                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" /> 

                 <input type="button" value="Exportar Todo a Excel" id="excelExport2" class="btn_table" />                  

                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

            </div>

            

            <div id="jqxgrid"></div>

           

            <div id="div_oculto" style="display: none;"></div>

            

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>