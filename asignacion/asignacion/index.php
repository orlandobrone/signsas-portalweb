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

		

	define('URL_SECCION', URL_ASIGNACION); 

	define('SECCION', ASIGNACION); ?>

	<?php require_once "../../tpl_top.php"; ?>
    
    
      <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

    

    <script type="text/javascript">

    $(document).ready(function () {         

            var source =

            {

                datatype: "json",

                datafields: [

					 { name: 'id', type: 'number'},

					 { name: 'id_ordentrabajo', type: 'string'}, /*FGR*/

					 { name: 'id_hito', type: 'string'},

					 { name: 'id_tecnico', type: 'string'},

					 { name: 'libre', type: 'string'},

					 { name: 'id_vehiculo', type: 'string'},

					 { name: 'fecha_ini', type: 'date'},

					 { name: 'acciones', type: 'string'},

					 { name: 'observacion', type: 'string'},

					 { name: 'hora_vehicular', type: 'string'},
					 
					 { name: 'horas_trabajadas', type: 'string'},
					 
					 { name: 'estado', type: 'string'},				 

                ],

				cache: false,

			    url: 'ajax_data.php',

				root: 'Rows',

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

				sortable: true,

                rowsheight: 40,

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                  

                columns: [

				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'starts_with',  width: 50,  columntype: 'textbox' },

                  { text: 'Acciones', datafield: 'acciones', filtertype: 'none', width:70, pinned: true, cellsalign: 'center' },

				  { text: 'OT', datafield: 'id_ordentrabajo', filtertype: 'none',  filtercondition: 'starts_with', width: 70 }, /*FGR*/

				  { text: 'Hito', datafield: 'id_hito', filtertype: 'none',  filtercondition: 'starts_with'},

				  { text: 'Libre', datafield: 'libre',filtertype: 'checkedlist', filteritems: ['Si', 'No'], width: 80 },

				  { text: 'Técnico', datafield: 'id_tecnico', filtertype: 'textbox',  filtercondition: 'starts_with'},

				  { text: 'Vehículo', datafield: 'id_vehiculo', filtertype: 'none',  filtercondition: 'starts_with', width: 70 },

                  { text: 'Fecha Inicio', datafield: 'fecha_ini', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },,

				  { text: 'Hora', datafield: 'hora_vehicular', filtertype: 'none', width: 110},

				  { text: 'Observación', datafield: 'observacion', filtertype: 'none', width: 130 },
				  
				  { text: 'Horas Trabajadas', datafield: 'horas_trabajadas', filtertype: 'none', width: 70},
				  { text: 'Estado', datafield: 'estado', filtertype: 'none', width: 50}

                ]
            });

			$(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Asignaciones');           
            });

			$('#excelExport2').click(function(){
				var fecini = $('#fecini_e').val();
				var fecfin = $('#fecfin_e').val();
				window.open("/asignacion/asignacion/export_excel.php?fecini="+fecini+"&fecfin="+fecfin);
			});

     });

    </script>

    	<div id="cuerpo">

           <h1>ASIGNACI&Oacute;N <span style="color:#C00; display:none;">En Mantenimiento</span></h1>

           <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
				 <? if(in_array(3003,$_SESSION['permisos'])): ?>
                 <input value="Agregar Asignación" type="button" onClick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
                 <? endif; ?>

                 <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->                 

                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
                 
                 <label style="margin-left:5px;">Exportar desde: </label>
                 <input name="fecini" type="text" id="fecini_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador_e" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <label>Hasta: </label>   
                 <input name="fecfin" type="text" id="fecfin_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2_e" />
     
                    <script type="text/javascript">
     
                        Calendar.setup({
    
                            inputField     :    "fecfin_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador2_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 

                 <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />                  

            </div>

            

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->