<?php  include "../../restrinccion.php";  ?>


    <?php require_once "../../config.php";

	define('URL_SECCION', URL_ASIGNACION); 

	define('SECCION', VEHICULOS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    

    <!-- JavaScript Includes

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

    <script src="/js/upload/assets/js/jquery.knob.js"></script>

    

    <!-- jQuery File Upload Dependencies -->

    <script src="/js/upload/assets/js/jquery.ui.widget.js"></script>

    <script src="/js/upload/assets/js/jquery.iframe-transport.js"></script>

    <script src="/js/upload/assets/js/jquery.fileupload.js"></script>

        

    <script type="text/javascript">

    $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'placa', type: 'string'},

					 { name: 'marca', type: 'string'},

					 { name: 'soat', type: 'date'},

					 { name: 'tm', type: 'date'},

					 { name: 'aceite', type: 'date'},

					 { name: 'region', type: 'string'},

					 { name: 'valor_hora', type: 'number'},

					 { name: 'estado', type: 'string'},

					 { name: 'planillas', type: 'string'},

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

				}

				);



            // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(

            {

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

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},              

                columns: [

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox' },

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:50},

				  { text: 'Placa', datafield: 'placa', filtertype: 'number', filtercondition: 'starts_with'},

                  { text: 'Marca', datafield: 'marca', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Fecha vencimiento SOAT', datafield: 'soat', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },

				  { text: 'Fecha revisión TM', datafield: 'tm', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },

				  { text: 'Fecha Último Cambio Aceite', datafield: 'aceite', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },

				  { text: 'Región', datafield: 'region', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Valor Hora', datafield: 'valor_hora', filtertype: 'textbox', filtercondition: 'starts_with',cellsformat: 'c2',cellsalign: 'right' }, 

				  { text: 'Estado', datafield: 'estado', filtertype: 'checkedlist', filtercondition: 'equal', filteritems: ['ACTIVO', 'NO ACTIVO', 'MANTENIMIENTO'] },

				  { text: 'Planillas', datafield: 'planillas', filtertype: 'none' }

                ]

            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Beneficiarios');           

            });

			$('#excelExport2').click(function(){

				window.open("/asignacion/vehiculos/export_excel.php");

			});

        });

    </script>

    

    

    	<div id="cuerpo">

            <h1>CREACIÓN DE VEHÍCULOS</h1>

            

             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(283,$_SESSION['permisos'])): ?>
             <input value="Agregar Vehículo" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->

             <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />

            </div>

            

            <div id="jqxgrid"></div>

            

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->