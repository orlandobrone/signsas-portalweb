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

    <?php require_once "../../config.php"; 

	define('URL_SECCION', URL_FACTURAS);

	define('SECCION', FACTURAS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <style>
	.jqx-widget-content jqx-widget-content-bootstrap{
		z-index:1 !important;
	}
	</style>

    <script type="text/javascript">

    $(document).ready(function () {
				
            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'orden_compra', type: 'string'},
					 { name: 'num_factura', type: 'string'},
					 { name: 'valor', type: 'number'},
					 { name: 'iva', type: 'string'},
					 { name: 'pagado', type: 'string'},
					 { name: 'fecha', type: 'date'},
					 { name: 'retencion', type: 'number'},
					 { name: 'total', type: 'number'},
					 { name: 'acciones', type: 'string'}
                ],
				cache: false,
			    url: 'ajax_data.php',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');

				},

				sort: function()

				{

					// update the grid and send a request to the server.

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

			});
				
			var ordersSource = {
				datatype: "json",
                datafields: [
					  { name: 'id', type: 'number'},
					  { name: 'material', type: 'string'},
					  { name: 'cantidad', type: 'string'},
					  { name: 'costo', type: 'number'},
					  { name: 'orden_compra', type: 'string'},
					  { name: 'iva', type: 'string'},
					  { name: 'total', type: 'number'},
					  { name: 'fecha', type: 'string'}		
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
				var orden_compra = record['orden_compra'];			
				
                var grid = $($(parentElement).children()[0]);               

			    nestedGrids[index] = grid;				

                var ordersSource = {
					datatype: "json",
					datafields: [
						  { name: 'codigo', type: 'string'},
						  { name: 'material', type: 'string'},
						  { name: 'cantidad', type: 'number'},
						  { name: 'costo', type: 'number'},
						  { name: 'orden_compra', type: 'string'},
						  { name: 'iva', type: 'string'},
						  { name: 'fecha', type: 'string'}			
					],
					cache: false,
					url: 'ajax_list_items.php?orden_compra='+orden_compra,
					root: 'Rows',
					sortcolumn: 'id',
					sortdirection: 'desc'
				};

                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, width: '85%', height: 200,

                        columns: [
						 // { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },
						  { text: 'Código', datafield: 'codigo', filtertype: 'textbox', filtercondition: 'equal', width: 80,  columntype: 'textbox', editable: false },
						  { text: 'Material', datafield: 'material', filtertype: 'textbox', editable: false },
						  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', width: 60, cellsalign: 'right' },
						  { text: 'Costo', datafield: 'costo', filtertype: 'none', width: 130, cellsalign: 'right' },
						  { text: 'IVA', datafield: 'iva', filtertype: 'none', width: 40, cellsalign: 'right' },
						  { text: 'Orden Compra', datafield: 'orden_compra', filtertype: 'textbox', editable: false },
						  { text: 'Fecha Ingreso', datafield: 'fecha', filtertype: 'date', filtercondition: 'equal', width: 105, cellsformat: 'yyyy-MM-dd' } 

						]
                    });
             }};

            // var dataadapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid").jqxGrid({
                width: '100%',
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				autorowheight: true,
                autoheight: true,
				sortable: true,
                autoheight: true,
                columnsresize: true,
				virtualmode: true,
				rendergridrows: function(obj){
					 return obj.data;      
				},   
				rowdetails: true,
				initrowdetails: initrowdetails,
                rowdetailstemplate: { 
					rowdetails: "<div id='grid' style='margin: 10px;'></div>", 
					rowdetailsheight: 220, 
					rowdetailshidden: true 
				},
				rendergridrows: function(obj){
					 return obj.data;      
				},                             
                columns: [
                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:80},
				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 80,  columntype: 'textbox', editable: false },
				  { text: 'Orden Compra', datafield: 'orden_compra', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'No. Factura', datafield: 'num_factura', filtertype: 'textbox', filtercondition: 'starts_with',width: 80},
				  { text: 'Fecha Registro', datafield: 'fecha', filtertype: 'date', filtercondition: 'equal', width: 90, cellsformat: 'yyyy-MM-dd'}, 
				 
				  { text: 'Valor', datafield: 'valor', filtertype: 'UnitPrice', filtercondition: 'starts_with', cellsformat: 'c2'},
				  { text: 'Pagado', datafield: 'pagado', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'IVA', datafield: 'iva', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'Retención', datafield: 'retencion', filtertype: 'textbox', filtercondition: 'starts_with',cellsformat: 'c2'},
				  { text: 'Total', datafield: 'total', filtertype: 'textbox', filtercondition: 'starts_with', cellsformat: 'c2'}
                ]
            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Ingreso_mercancia');           
            });
			
			$('#excelExport2').click(function(){
				//window.open("/ingreso_mercancia/ingreso_mercancia/export_excel.php");
			});
			
		
        });
    </script>

    <div id="cuerpo">

            <h1>FACTURAS</h1>       

            

             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
             
             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />
             
             <input type="button" value="Exportar a Excel Todo" id="excelExport2" class="btn_table" />

            </div>

            

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->