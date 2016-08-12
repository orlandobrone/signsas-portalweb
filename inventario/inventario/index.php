<?php  include "../../restrinccion.php";  ?>

    <?php require_once "../../config.php";

	define('URL_SECCION', URL_INVENTARIO);

	define('SECCION', INVENTARIO); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script type="text/javascript">

    $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'nombre_material', type: 'string'},

					 { name: 'descripcion', type: 'string'},

					 { name: 'cantidad', type: 'string'},

					 { name: 'costo_unidad', type: 'number'},

					 { name: 'fecha', type: 'date'},

					 { name: 'costo', type: 'number'},
					 
					 { name: 'total', type: 'number'},

					 { name: 'ubicacion', type: 'string'},

					 { name: 'codigo', type: 'string'},
					 
					 { name: 'linea', type: 'string'},
					 
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

                  { text: 'ID',datafield: 'id',filtertype: 'number',filtercondition: 'equal',columntype:'textbox', width: 50 },

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width: 50},

				  { text: 'Código', datafield: 'codigo',filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Linea', datafield: 'linea', filtertype: 'textbox', cellsalign: 'right'},

				  { text: 'Ubicación', datafield: 'ubicacion', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Nombre Material', datafield: 'nombre_material', filtertype: 'number', filtercondition: 'starts_with'},

                  { text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'number',cellsalign: 'right'},

                  { text: 'Costo Unitario', datafield: 'costo_unidad', filtertype: 'textbox',  cellsformat: 'c2',cellsalign: 'right', width: 100 },
				  
				  { text: 'Total', datafield: 'total', filtertype: 'textbox',  cellsformat: 'c2',cellsalign: 'right' ,width: 100 },

				  { text: 'Fecha Registro', datafield: 'fecha' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 100}

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
				window.open("/inventario/inventario/export_excel.php");
			});
			
			$('#excelExport3').click(function(){
				window.open("/inventario/inventario/export_excel_acpm.php");
			});


        });

   </script>


   <div id="cuerpo">

            <h1>INVENTARIO</h1>
           

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(83,$_SESSION['permisos'])): ?>
             <input value="Agregar Inventario" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->

             <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" /> 
             
             <input type="button" value="Exportar ACPM" id='excelExport3' class="btn_table" /> 

            </div>

            

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->