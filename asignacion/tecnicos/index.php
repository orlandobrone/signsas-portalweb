<?php  include "../../restrinccion.php";  ?>


    <?php require_once "../../config.php";

	define('URL_SECCION', URL_ASIGNACION); 

	define('SECCION', TECNICOS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script src="/js/masknoney/jquery.maskMoney.js" type="text/javascript"></script>

    <script type="text/javascript">

    $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'nombre', type: 'string'},

					 { name: 'cedula', type: 'string'},

					 { name: 'arp', type: 'string'},

					 { name: 'eps', type: 'string'},

					 { name: 'celular', type: 'string'},
					 
					 { name: 'estado', type: 'string'},

					 { name: 'region', type: 'string'},

					 { name: 'cargo', type: 'string'},
					 
					 { name: 'sueldo', type: 'string'},
					 
					 { name: 'valor_plan', type: 'string'},

					 { name: 'valor_hora', type: 'string'}, 

					 { name: 'acciones', type: 'string'},
					 
					 { name: 'fecha_creacion', type: 'date'},

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

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:80},

				  { text: 'Nombre', datafield: 'nombre', filtertype: 'number', filtercondition: 'starts_with'},

                  { text: 'Cedula', datafield: 'cedula', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'ARP', datafield: 'arp', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'EPS', datafield: 'eps', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Celular', datafield: 'celular', filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'checkedlist', filteritems: ['Activo', 'Inactivo', 'Vacaciones', 'Incapacitado','Operando'], filtercondition: 'equal' },

				  { text: 'Cargo', datafield: 'cargo', filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Sueldo', datafield: 'sueldo', filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Valor Plan', datafield: 'valor_plan', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Valor Hora', datafield: 'valor_hora', filtertype: 'none' },

				  { text: 'Región', datafield: 'region', filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Fecha Creación', datafield: 'fecha_creacion',filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },

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

				window.open("/asignacion/tecnicos/export_excel.php");

			});

        });

		

		function fn_reporte(ide_per){

			$("#div_oculto").load("ajax_form_reporte.php", {ide_per: ide_per}, function(){

				$.blockUI({

					message: $('#div_oculto'),

					css:{

						top: '20%'

					}

				}); 

			});

		};

		

		function fn_reporte_all(ide_per){

			$("#div_oculto").load("ajax_form_allreportes.php", function(){

				$.blockUI({

					message: $('#div_oculto'),

					css:{

						top: '20%'

					}

				}); 

			});

		};

    </script>

    <div id="cuerpo">

            <h1>CREACIÓN DE FUNCIONARIO / TÉCNICO</h1>

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">		
			 <? if(in_array(293,$_SESSION['permisos'])): ?>
             <input value="Agregar Funcionario/Técnico" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->

             <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />   

             <input type="button" value="Exportar Pagos" class="btn_table" onclick="fn_reporte_all()"/>                  



            </div>

            

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->