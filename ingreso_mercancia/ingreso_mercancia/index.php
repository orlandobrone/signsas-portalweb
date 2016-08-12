<?php  
	include "../../restrinccion.php";   
	require_once "../../config.php"; 

	define('URL_SECCION', URL_INGRESO_MERCANCIA);

	define('SECCION', INGRESO_MERCANCIA); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <style>
		.jqx-widget-content-bootstrap{
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
					 { name: 'id_despacho', type: 'number'},
					 { name: 'totalitems', type: 'number'},
					 { name: 'fecha', type: 'date'},
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
				var id_parent = record['id'];			
				
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
					url: 'ajax_list_items.php?id_parent='+id_parent,
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
						  { text: 'Costo', datafield: 'costo', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2'  },
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
                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal', columntype: 'textbox' },
                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:90},
				  { text: 'ID Despacho', datafield: 'id_despacho', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'Total Items', datafield: 'totalitems', filtertype: 'none'},
				  { text: 'Fecha Registro', datafield: 'fecha', filtertype: 'date', filtercondition: 'equal', width: 90, cellsformat: 'yyyy-MM-dd'} 
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
				window.open("/ingreso_mercancia/ingreso_mercancia/export_excel.php");
			});
			
			
			$('#eventWindow').jqxWindow({
                minHeight: 550, minWidth: 680,
                resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
            });
    });
	
		
    </script>

    <div id="cuerpo">
    		
           

            <h1>INGRESO DE MERCANCIA</h1> 

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(92,$_SESSION['permisos'])): ?>
             <input value="Agregar Ingreso Mercancia" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->
             
             <input type="button" value="Exportar a Excel Todo" id="excelExport2" class="btn_table" />

            </div>

            

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>
            
            <div id="eventWindow">
               <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Ingreso Mercancia
                </div>
                <div id="content_form">
                    <div>
                        Please click "OK", "Cancel" or the close button to close the modal window. The dialog
                        result will be displayed in the events log.
                    </div>
                    <div>
                        <div style="float: right; margin-top: 15px;">
                            <input type="button" id="ok" value="OK" style="margin-right: 10px" />
                            <input type="button" id="cancel" value="Cancel" />
                        </div>
                    </div>
                </div>
            </div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->