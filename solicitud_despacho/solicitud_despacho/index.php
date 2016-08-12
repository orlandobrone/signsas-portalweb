<?php  
	include "../../restrinccion.php"; 
	require_once "../../config.php"; 

	define('URL_SECCION', URL_SOLICITUD_DESPACHO);

	define('SECCION', SOLICITUD_DESPACHO); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script type="text/javascript">
	
    $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'nombre_responsable', type: 'string'},

					 { name: 'id_proyecto', type: 'string'},

					 { name: 'direccion_entrega', type: 'string'},

					 { name: 'nombre_recibe', type: 'string'},

					 { name: 'fecha_solicitud', type: 'date'},

					 { name: 'fecha_entrega', type: 'date'},

					 { name: 'fecha', type: 'date'},

					 { name: 'celular', type: 'string'},

					 { name: 'acciones', type: 'string'},
					 { name: 'id_hito', type: 'string'}

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

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width: 40 },

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true},

				  { text: 'Nombre Responsable', datafield: 'nombre_responsable', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'OT', datafield: 'id_proyecto', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },
				  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },


                  { text: 'Dirección Entrega', datafield: 'direccion_entrega', filtertype: 'textbox',cellsalign: 'center',width: 130},

				  { text: 'Nombre Recibe', datafield: 'nombre_recibe', filtertype: 'textbox',cellsalign: 'left'},

				  { text: 'PBX/Celular', datafield: 'celular', filtertype: 'textbox',cellsalign: 'left', width: 90},

				  { text: 'Fecha Solicitud',datafield: 'fecha_solicitud' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},

				  { text: 'Fecha Entrega',  datafield: 'fecha_entrega' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},

				  { text: 'Fecha Registro', datafield: 'fecha' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90}

                ]

            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Solicitud Despacho');           

            });

			$('#excelExport2').click(function(){

				window.open("/solicitud_despacho/solicitud_despacho/export_excel.php");

			});

        });

  	</script>

    

    <div id="cuerpo">

           <h1>SOLICITUD DE DESPACHO <span style="color:#F00; display:none;">- EN MANTENIMIENTO</span></h1>
           
           <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(101,$_SESSION['permisos'])): ?>
             <input value="Agregar Despacho" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->

             <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" /> 

           </div>

            
           <div id="jqxgrid"></div>
            

           <div id="div_oculto" style="display: none;"></div>

           <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->